<?php
namespace App\Http\Controllers\Academy;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;



class manage_this_business extends BaseController
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

  public function manage_business(Request $request, $name, $id)
  {
    $url              = 'https://www.bookmyplayer.com' . $request->getRequestUri();
    $agent            = new Agent();
    $mobile           = $agent->isMobile();
    $d                = get_data_row(null, 'bmp_academy_details', 'id', $id);
    if(!$d){
      return redirectUrl($request->getRequestUri(), null);
    }

    $sport = $d->sport ?? 'Sports';
    $about = $d->about ?? '';

    $reviews          = get_data_array(null, 'bmp_reviews', 'object_type', 'academy', 'object_id', $id, 'id', 'desc', 10);
    if ($mobile) {
      $banner         = ($d->banner == null || $d->banner == "") ? env('AWS_CF_BASE_URL') . "/default/{$sport}_banner.webp" : env('AWS_CF_BASE_URL') . "/academy/{$d->id}/{$d->banner}";
      $logo           = (is_null($d->logo) || $d->logo === "") ? env('AWS_CF_BASE_URL') . "/default/academy_default_logo.webp" : env('AWS_CF_BASE_URL') . "/academy/{$d->id}/{$d->logo}";
    } else {
      $banner         = ($d->banner == null || $d->banner == "") ? env('AWS_CF_BASE_URL') . "/default/{$sport}_banner.webp" : env('AWS_CF_BASE_URL') . "/academy/{$d->id}/{$d->banner}";
      $logo           = (is_null($d->logo) || $d->logo === "") ? env('AWS_CF_BASE_URL') . "/default/academy_default_logo.webp" : env('AWS_CF_BASE_URL') . "/academy/{$d->id}/{$d->logo}";
    }

    $address          = implode(', ', array_filter([$d->address1, $d->address2, $d->city, $d->state, $d->postcode]));

    $data = [
      "d"             => $d,
      "address"       => $address,
      "banner"        => $banner,
      "logo"          => $logo,
      "id"            => $d->id,
      "breadcrumbs"   => [],
      "page"          => "own_business",
      "title"         => "Own this Business : BookMyPlayer",
      "des"           => "",
      "url"           => url()->current()
    ];

    return view('academy.manage_business', compact('data'));
  }

}
