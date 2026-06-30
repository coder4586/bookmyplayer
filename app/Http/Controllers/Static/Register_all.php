<?php
namespace App\Http\Controllers\Static;

use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class Register_all extends BaseController
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

  protected function checkLoggedIn()
  {
      if (session()->has('userId')) {
          $userId = session()->get('userId');
          $user = get_data_row(null, 'bmp_user', "id", $userId, null, null);

          if (!$user) {
              return "https://www.bookmyplayer.com/profile/logout";
          }

          $type_id = $user->type_id;
          $parent_id = $user->parent_id;

          $typeMap = [1 => "coach", 2 => "academy", 3 => "player"];
          return "https://www.bookmyplayer.com/" . ($typeMap[$type_id] ?? '') . "/dashboard/" . $parent_id;
      }

      return null;
  }

  public function register()
  {
    $redirectUrl = $this->checkLoggedIn();
    if ($redirectUrl) {
        return redirect($redirectUrl);
    }
    
    $breadcrumbs = [
      (object) ['name' => "Register", 'link' => ""]
    ];

    $data = array(
      "title" => "Register for Free on BookMyPlayer - Your Sports Player Booking Platform",
      "des" => "Join BookMyPlayer today and unlock a world of sports player booking opportunities. Register for free to connect with sports players, coaches, and teams. Seamlessly book and hire sports talent online.",
      "keywords" => "Sports player registration, Athlete registration, Player booking platform, Sports talent registration, Register as a player, Free player registration, Book sports players, Connect with sports talent, Athlete sign-up, Online player booking",
      "url" => "https://www.bookmyplayer.com/register",
      "breadcrumbs" => $breadcrumbs,
      "template" => "home",
    );
    return view('static.register')->with('data', $data);
  }

  public function login(Request $request)
  {
    $redirectUrl = $this->checkLoggedIn();
    if ($redirectUrl) {
        return redirect($redirectUrl);
    }
    $name = 'login';
    $url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
    $meta = get_data_row('bookmyplayer', 'xx_pages', 'route', $name);
    $breadcrumbs = [(object) ['name' => "Login", 'link' => ""]];
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), $name);

    $data = [
      "title" => $meta->title,
      "des" => $meta->description,
      "keywords" => $meta->keywords,
      "url" => $url,
      "page" => $name,
      "breadcrumbs" => $breadcrumbs,
      "template" => $name,
    ];

    return view('static.login', compact('data'));
  }

  public function register_academy(Request $request)
  {
    $redirectUrl = $this->checkLoggedIn();
    if ($redirectUrl) {
        return redirect($redirectUrl);
    }

    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), null);
    $breadcrumbs = [(object) ['name' => "Register", 'link' => "/register"], (object) ['name' => "Create Your Academy Profile", 'link' => ""]];

    $data = [
      "page" => "register_academy",
      "title" => "Create Academy Profile | BookMyPlayer",
      "des" => "Register your Sports Academy today and start generating leads.",
      "breadcrumbs" => $breadcrumbs,
      "url" => 'https://www.bookmyplayer.com/register-as-a-coach-trainer'
    ];
    return view('static.register_academy', compact('data'));
  }

  public function register_coach(Request $request)
  {
    $redirectUrl = $this->checkLoggedIn();
    if ($redirectUrl) {
        return redirect($redirectUrl);
    }

    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), null);
    $breadcrumbs = [(object) ['name' => "Register", 'link' => "/register"], (object) ['name' => "Create Your Coach Profile", 'link' => ""]];

    $data = [
      "page" => "register_coach",
      "title" => "Create Coach Profile | BookMyPlayer",
      "des" => "Register as Coach Trainer today.",
      "breadcrumbs" => $breadcrumbs,
      "url" => 'https://www.bookmyplayer.com/register-as-a-coach-trainer'
    ];

    return view('static.register_coach', compact('data'));
  }

  public function register_player(Request $request)
  {
    $redirectUrl = $this->checkLoggedIn();
    if ($redirectUrl) {
        return redirect($redirectUrl);
    }
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), null);
    $breadcrumbs = [(object) ['name' => "Register", 'link' => "/register"], (object) ['name' => "Create Your Player Profile", 'link' => ""]];

    $data = [
      "page" => "register_player",
      "title" => "Create Player Profile | BookMyPlayer",
      "des" => "Register as Player today",
      "breadcrumbs" => $breadcrumbs,
      "url" => 'https://www.bookmyplayer.com/register-as-a-player'
    ];

    return view('static.register_player', compact('data'));
  }

  public function register_other(Request $request)
  {
    $redirectUrl = $this->checkLoggedIn();
    if ($redirectUrl) {
        return redirect($redirectUrl);
    }
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), null);
    $breadcrumbs = [(object) ['name' => "Register", 'link' => "/register"], (object) ['name' => "Create Your Bookmyplayer Profile", 'link' => ""]];

    $data = [
      "page" => "register_player",
      "title" => "Create Player Profile | BookMyPlayer",
      "des" => "Register as Player today",
      "breadcrumbs" => $breadcrumbs,
      "url" => 'https://www.bookmyplayer.com/register-as-a-player'
    ];

    return view('static.register_other', compact('data'));
  }

  public function register_tournament(Request $request)
  {
    $redirectUrl = $this->checkLoggedIn();
    if ($redirectUrl) {
        return redirect($redirectUrl);
    }
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), null);
    $breadcrumbs = [(object) ['name' => "Register", 'link' => "/register"], (object) ['name' => "Register your tournament", 'link' => ""]];

    $data = [
      "title" => "Register Your Tournament | BookMyPlayer",
      "des" => "Register your tournament",
      "breadcrumbs" => $breadcrumbs,
      "url" => 'https://www.bookmyplayer.com/register-tournaments'
    ];

    return view('static.register_tournament', compact('data'));
  }


}
