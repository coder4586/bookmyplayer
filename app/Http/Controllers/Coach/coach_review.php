<?php

namespace App\Http\Controllers\Coach;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\Bmp_review_coaches;
use App\Models\Bmp_coach_details;


class coach_review extends BaseController
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


	public function show_coach_review(Request $request, $id)
	{

		$d = Bmp_coach_details::find($id);
		// if(!$d){
		// 	session()->flash('error_message_add_review_academy', 'coach not found');
		// 	return redirect('/404');
		// }

		if($d){
			$reviews = Bmp_review_coaches::where('object_id', $d->id)->where('status', 1)->get();
			$logo = $d->profile_img ? env('AWS_S3_BASE_URL') . "/coach/{$d->id}/{$d->profile_img}" : env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
			$address = ($d->state ?? '') . ($d->city ? " - $d->city" : '') ?: ($d->address1 ?? ($d->address2 ?? ''));
		}else{
			$d = (object) [
				'id' => $id,
				'name' => 'Add Review',
				'sport' => 'Cricket',
				'url' => '#',
				'state' => '',
				'city' => 'India',
				'email' => ''
			];
			$reviews = 10;
			$logo = env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
			$address = "India";
		}


		$breadcrumbs = [
			(object) ['name' => $d->name . " (" . $d->sport . ")", 'link' => $d->url],
			(object) ['name' => "Add Review", 'link' => ""]
		];

		$data = array(
			"title" => "add review - " . $d->name,
			"des" => 'BookMyPlayer: test!',
			"url" => URL::current(),
			"logo" => $logo,
			"d" => $d,
			"address" => $address,
			"reviews" => $reviews,
			"breadcrumbs" => $breadcrumbs,
		);

		return view("coach.coach_review")->with('data', $data);
	}
}
