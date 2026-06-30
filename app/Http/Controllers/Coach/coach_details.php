<?php

namespace App\Http\Controllers\Coach;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;
use App\Models\Adm_sports_master;
use App\Models\Adm_location_master;
use App\Models\Bmp_coach_details;
use App\Models\Bmp_coach_listing;
use App\Models\Bmp_sport_faqs_coach;
use App\Models\Bmp_sport_skill;
use App\Models\Bmp_review_coaches;
use App\Models\Bmp_about;

class coach_details extends BaseController
{
	protected function getDeviceType()
	{
		$agent = new Agent();
		if ($agent->isMobile()) {
			return 'm';
		} elseif ($agent->isTablet()) {
			return 't';
		} else {
			return 'd';
		}
	}

	use AuthorizesRequests, ValidatesRequests;


	public function coach_details(Request $request, $name, $sport, $city, $id)
	{
		$d = Bmp_coach_details::find($id);
		if (!$d) {
			return redirecturl($request->getRequestUri(), null);
		}

		Bmp_coach_details::where('id', $id)->increment('views');

		$sport = Adm_sports_master::find($d->sport_id);
		$location = Adm_location_master::find($d->loc_id);
		$popularcoaches = Bmp_coach_details::where('sport_id', $d->sport_id)->get();
		$coach_listing = Bmp_coach_listing::where('sport_id', $d->sport_id)->where('loc_id', $d->loc_id)->first();

		if (!$location) {
			$breadcrumbs = [
				(object) [
					'name' => "{$sport->name} Coaches in India",
					'link' => "https://www.bookmyplayer.com/",
				],
				(object) [
					'name' => "Coach {$d->name}",
					'link' => ''
				]
			];

		} else {

			$nullvar = $coach_listing->url ?? 'https://www.bookmyplayer.com/';
			$breadcrumbs = [
				(object) [
					'name' => "{$sport->name} Coaches in " . $location->locality_name,
					'link' => $nullvar
				],
				(object) [
					'name' => "Coach {$d->name}",
					'link' => ''
				]
			];
		}

		//Get FAQ
		$faqs = Bmp_sport_faqs_coach::where("user_id", $id)->get();
		$faqCount = $faqs->count();

		if ($faqCount < 10) {
			try {
				$additionalFaqs = collect(get_static_data('coach_faq.json', $d->sport_id, 10 - $faqCount));
				$faqs = $faqs->concat($additionalFaqs);
			} catch (\Exception $e) {
				\Log::error('Failed to load additional FAQs from JSON file: ' . $e->getMessage());
			}
		}
		$faqs = $faqs->take(10);
		$reviews = Bmp_review_coaches::where('object_id', $d->id)->where('status', 1)->orderBy('creation_date', 'desc')->get();
		$packages = array_filter(explode(";", $d->package), 'strlen');
		$logo = $d->profile_img ? env('AWS_S3_BASE_URL') . "/coach/{$d->id}/{$d->profile_img}" : env('AWS_S3_BASE_URL') . "/asset/images/register-image.jpg";
		$banner = !$d->phone || $d->phone == "" || $d->phone == null ? env('AWS_S3_BASE_URL') . "/default/coach_sport_banner.jpg" : env('AWS_S3_BASE_URL') . "/default/coach_sport_banner.jpg";
		$address = $location ? $location->locality_name : "location";
		$gender = $d->gender ?? null;

		$photos = [];
		$videos = [];

		$loc_nearby = [];

		$latitude = $d->lat;
		$longitude = $d->lng;
		$loc_nearby = bmp_coach_listing::selectRaw("
					 id, location as locality_name, url,
					 ( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance
			 ", [$latitude, $longitude, $latitude])
			->where('sport_id', $d->sport_id)
			->having("distance", "<", 20)
			->orderBy("distance")
			->take(10)
			->get()
			->toArray();

		if ($id == 92) {
			// dd($loc_nearby);

		}

		if (empty($d->skill)) {
			$skills = [];
		} else {
			$skills = explode(",", $d->skill);
		}
		$skillCount = count($skills);

		if ($skillCount < 10) {
			$default_skill = Bmp_sport_skill::where('sport_id', $d->sport_id)
				->where('status', 1)
				->select('skill')
				->take(10 - $skillCount)
				->get()
				->pluck('skill')
				->toArray();

			$skills = array_merge($skills, $default_skill);
		}

		$skills = array_slice($skills, 0, 10);


		if (empty($d->about)) {
			$defaultabout = Bmp_about::where('object', '2')->where('sport_id', $d->sport_id)->where('gender', $gender)->select('about')->first();
			$about = $defaultabout ? str_replace(['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'], [$d->name, $d->city, $location && $location->locality_name . "," . $location->state . "(" . $location->poscode . ")"], $defaultabout->about) : "";
		} elseif (strlen($d->about) < 500) {
			$defaultAbout = Bmp_about::where('object', '2')
				->where('sport_id', $d->sport_id)
				->where('gender', $gender)
				->select('about')
				->first();
			$about = $defaultAbout ? $d->about . "<br><br><b><u> Further information about the Coach: </b></u><br>" . str_replace(
				['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'],
				[$d->name, $d->city, $location ? $location->locality_name . ", " . $location->state . " (" . $location->postcode . ")" : ""],
				$defaultAbout->about
			) : "";
		} else {
			$about = $d->about;
			$about = nl2br($about, false);
		}

		$files = explode(',', $d->photos);
		foreach ($files as $file) {
			$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Normalize to lowercase
			if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'ico'])) {
				$photos[] = $file;
			} elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'mkv', 'flv', 'webm', '3gp', 'm4v', 'ts', 'mpeg', 'mpg'])) {
				$videos[] = $file;
			}
		}


		if ($d->sport_id == 32) {
			$sport->name = 'Yoga Instructor';
		}

		$data = array(
			"title" => ($d->name ?? 'Coach') . ' - ' . ($sport->name ?? 'Sport') . ', Coach in ' . ($location->locality_name ?? 'Unknown Location'),
			"des" => $d->heighlight,
			"url" => URL::current(),
			"logo" => $logo,
			"d" => $d,
			"about" => $about,
			"address" => $address,
			"skills" => $skills,
			"photos" => $photos,
			"videos" => $videos,
			"faqs" => $faqs,
			"reviews" => $reviews,
			"location" => $location,
			"packages" => $packages,
			"sport" => $sport ? $sport->name : "-",
			"breadcrumbs" => $breadcrumbs,
			"loc_nearby" => $loc_nearby
		);

		if ($request->ajax()) {
			return response()->json(['faqs' => $faqs, 'd' => $d, 'photos' => $photos, 'videos' => $videos, 'popularcoaches' => $popularcoaches, 'reviews' => $reviews, 'whatsapp_no' => env('WHATSAPP_LEAD_MOBILE')]);
		}
		return view("coach.coach_details")->with('data', $data);
	}

}
