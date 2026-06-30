<?php

namespace App\Http\Controllers\Player;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\Adm_sports_master;
use App\Models\Adm_location_master;
use App\Models\Bmp_review_player;
use App\Models\Bmp_player_details;
use App\Models\Bmp_player_listing;

class player_details extends BaseController
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


	public function player_details(Request $request, $name, $id)
	{

		if (!is_numeric($id) && strpos($request->getRequestUri(), '-player-profile-') !== false) {
			preg_match('/-player-profile-(\d+)$/', $request->getRequestUri(), $matches);
			$id = $matches[1] ?? null;
		}

		$d = Bmp_player_details::find($id);
		if (!$d) {
			return redirecturl($request->getRequestUri());
		}

		// DB::table('bmp_player_details')->where('id', $id)->increment('views', 1);
		$sport = Adm_sports_master::find($d->sport_id);
		$location = Adm_location_master::find($d->loc_id);
		$address = $location ? $location->locality_name : "location";
		$player_listing = Bmp_player_listing::where('sport_id', $d->sport_id)->where('loc_id', $d->loc_id)->first();
		$sport_name = $sport ? $sport->name : "sport";
		$age = $d->dob ? (\DateTime::createFromFormat('Y-m-d', $d->dob))->diff(new \DateTime())->y . " years" : "";
		$logo = $d->logo ? env('AWS_S3_BASE_URL') . "/player/{$d->id}/{$d->logo}" : env('AWS_S3_BASE_URL') . "/asset/images/register-image.jpg";
		$height = $d->height ? preg_replace('/(\d+);(\d+)/', '$1f $2inch', $d->height) : '-';
		$about = $d->about ?: '-';
		$base_url = env('AWS_S3_BASE_URL') . "/player/{$d->id}/";
		$reviews = Bmp_review_player::where('object_id', $id)->where('status', 1)->orderBy('creation_date', 'desc')->get();
		$other_players = DB::table('bmp_player_details as bpd')
			->leftJoin('adm_location_master as alm', 'bpd.loc_id', '=', 'alm.id')
			->leftJoin('bmp_review_players as brp', 'bpd.id', '=', 'brp.object_id')
			->select('bpd.id', 'bpd.url as player_url', 'bpd.name as player_name', 'bpd.logo as player_logo', 'alm.locality_name', DB::raw('AVG(brp.rating) as average_rating'))
			->where('bpd.sport_id', $d->sport_id)
			->where('bpd.id', '!=', $id)
			->groupBy('bpd.id', 'bpd.url', 'bpd.name', 'bpd.logo', 'alm.locality_name')
			->take(10)->get();
		$media = $d->photos ? array_filter(explode(",", $d->photos), 'strlen') : [];
		$skills = array_filter(explode(",", $d->skill), 'strlen');
		if (max(0, 10 - count($skills)) > 0) {
			$additional_skills = get_static_data('player_skill.json', $d->sport_id, max(0, 10 - count($skills)));
			$skills = array_merge($skills, array_column($additional_skills, 'skill'));
		}
		$awards = array_filter(explode(",", $d->awards), 'strlen');
		if (max(0, 5 - count($awards)) > 0) {
			$additional_awards = get_static_data('player_award.json', $d->sport_id, max(0, 5 - count($awards)));
			$awards = array_merge($awards, array_column($additional_awards, 'award'));
		}
		$default_specifications = get_static_data('player_specifications.json', $d->sport_id, 3);
		$default_intersest = get_static_data('player_interests.json', $d->sport_id, 5);
		$education = array_filter(explode(",", $d->education), 'strlen');
		$experience = array_filter(explode(",", $d->experience), 'strlen');

		$photos = [];
		$videos = [];
		foreach ($media as $item) {
			$full_url = $base_url . $item;
			$extension = strtolower(pathinfo($item, PATHINFO_EXTENSION)); // Normalize extension to lowercase
			if (in_array(strtolower($extension),['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'ico'])) {
				$photos[] = $full_url;
			} elseif (in_array(strtolower($extension), ['mp4', 'avi', 'mov', 'wmv', 'mkv', 'flv', 'webm', '3gp', 'm4v', 'ts', 'mpeg', 'mpg'])) {
				$videos[] = $full_url;
			}
		}

		$nullvar = $player_listing->url ?? 'https://www.bookmyplayer.com/';

		$breadcrumbs = [
			(object) [
				'name' => ($sport?->name ?? 'Sport') . ' Players in ' . ($location?->locality_name ?? 'Indi'),
				'link' => $nullvar
			],
			(object) [
				'name' => ($d->name ?? 'Player'),
				'link' => ''
			]
		];

		$data = array(
			"title" => ($d->name ?? 'Player') . ' - ' . ($sport->name ?? 'Sport') . ' Player in ' . ($location->locality_name ?? 'India'),
			"des" => $d->heighlight,
			"url" => URL::current(),
			"d" => $d,
			"location" => $location,
			"sport" => $sport_name,
			"age" => $age,
			"address" => $address,
			"logo" => $logo,
			"height" => $height,
			"about" => $about,
			"photos" => $photos,
			"videos" => $videos,
			"skills" => $skills,
			"awards" => $awards,
			"default_specifications" => $default_specifications,
			"default_intersest" => $default_intersest,
			"education" => $education,
			"experience" => $experience,
			"breadcrumbs" => $breadcrumbs,
		);

		if ($request->ajax()) {
			return response()->json(['photos' => $photos, 'videos' => $videos, 'reviews' => $reviews, 'other_players' => $other_players, 'whatsapp_no' => env('WHATSAPP_LEAD_MOBILE')]);
		}
		return view("player.player_details")->with('data', $data);
	}



}
