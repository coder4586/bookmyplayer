<?php

namespace App\Http\Controllers\Static;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;
use Intervention\Image\Facades\Image;



class Terms extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getDeviceType()
     {
         $agent = new Agent();
         if ($agent->isMobile()) {return 'm';} elseif ($agent->isTablet()) {return 't';} else {return 'd';}
     }

	public function terms(Request $request)
	{
        $name = 'terms';
		$url 			    = 'https://www.bookmyplayer.com' . $request->getRequestUri();
		$meta 			  	= get_data_row('bookmyplayer', 'xx_pages', 'route', $name);
		$breadcrumbs 		= [(object) ['name' => "Terms", 'link' => ""]];

		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(),$name);

		$data = [
			"title" 		=> $meta->title,
			"des" 			=> $meta->description,
			"url" 			=> $url,
			"keywords" 		=> $meta->keywords,
			"page" 			=> $name,
			"breadcrumbs"   => $breadcrumbs,
			"template" 		=> $name,
		];

		return view('static.terms', compact('data'));
	}


  }
