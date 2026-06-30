<?php

namespace App\Http\Controllers\Player;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\Bmp_player_details;

class Player_corn_emails extends BaseController
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
		$players = Bmp_player_details::select('id', 'name', 'email')
			->whereNotNull('email')
			->whereNotNull('name')
			->whereBetween('id', [1800, 1900])
			->where('email', '!=', '')
			->where('name', '!=', '')
			->limit(100) 
			->get();	
	
		$emailCount = 0; 

	
		foreach ($players as $player) {
			$url = "https://www.bookmyplayer.com/player/dashboard/edit-profile/{$player['id']}";
			sendPlayerPorfileUpdateEmail($player['email'], $player['name'], $url, $player['id'], 'corn-job');
			$emailCount++; 
		}
	
		return response()->json([
			'status' => 'success',
			'messages' => "Email sent successfully to {$emailCount} players"
		]);
	}
	




}
