<?php
namespace App\Http\Controllers\Static;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Bmp_coach_details;
use App\Models\Bmp_academy_details;
use App\Models\Adm_location_master;
use App\Models\Adm_sports_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;



class Home extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

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

  public function home(Request $request)
  {
     $blogs  				= get_data_array('bookmyplayer', 'xx_blog', null, null,null,null, 'id', 'desc',5);
    // $blogs = [];

    createLog('Home-1', $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'home');
    $breadcrumbs = [];
    $coaches = Bmp_coach_details::whereNotNull('profile_img')->orderBy('views', 'desc')->limit(16)->get();
    $academies = Bmp_academy_details::whereNotNull('logo')->where('mobile_verified',1)->where('email_verified',1)->orderBy('views', 'desc')->limit(16)->get();
    $locations = Adm_location_master::where('menu', 1)->whereNotNull('image')->orderBy('locality_name')->get();
    $sports = Adm_sports_master::whereNotNull('image')->orderBy('name')->get();

    $data = array(
      "page" => 'home',
      "title" => 'BookMyPlayer: Your Source for Top Sports Academies and Coaches in India',
      "des" => 'Discover the finest sports academies and coaches on BookMyPlayer! Whether you need athletes, coaches, or sports academy, we connect you with top professionals. Join top sports academy and coach to elevate your game',
      "keywords" => 'Sports academies, sport coaches, sport trainers, join sport academies, hire sport coaches, find cheapest sport trainer',
      "breadcrumbs" => $breadcrumbs,
      "url" => 'https://www.bookmyplayer.com',
      "blogs" => $blogs,
      "coaches" => $coaches,
      "academies" => $academies,
      "locations" => $locations,
      "sports" => $sports,
      "template" => "home",
    );
    return view('static.home')->with('data', $data);
  }


}
