<?php

namespace App\Http\Controllers\Admin\admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;



class admin extends BaseController
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


    public function show_admin(Request $request, $id)
    {

        $data = array(
            "title" => "bookmyplayer - dashboard",
            "des" => "",
            "url" => URL::current(),
            "breadcrumbs" => [],
        );

        return view("admin.admin.admin")->with('data', $data);
    }

}
