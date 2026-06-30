<?php

namespace App\Http\Controllers\Coach;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\Bmp_coach_details;

class Coach_corn_emails extends BaseController
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


	public function corn_email(Request $request)
	{
		$coaches = Bmp_coach_details::select('id', 'name', 'email')
			->whereNotNull('email')
			->whereNotNull('name')
			->whereBetween('id', [200,300])
			->where('email', '!=', '')
			->where('name', '!=', '')
			->limit(100) 
			->get();
            // dd($coaches);
	
	
		$emailCount = 0; 

	
		foreach ($coaches as $coach) {
			$url = "https://www.bookmyplayer.com/coach/dashboard/edit-profile/{$coach['id']}";
			sendCoachPorfileUpdateEmail($coach['email'], $coach['name'], $url, $coach['id'], 'corn-job');
			$emailCount++; 
		}
	
		return response()->json([
			'status' => 'success',
			'messages' => "Email sent successfully to {$emailCount} players"
		]);
	}
	




}
