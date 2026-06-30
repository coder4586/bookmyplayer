<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\URL;

class Sitemap extends BaseController
{

  protected function getDeviceType()
  {
    $agent = new Agent();
    if ($agent->isMobile()) {
      return 'mobile';
    } elseif ($agent->isTablet()) {
      return 'tablet';
    } else {
      return 'desktop';
    }
  }

  public function sitemap(Request $request)
  {
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'sitemap');
    return response()->view('sitemap')->header('Content-Type', 'text/xml');
  }

  public function sitemap1(Request $request)
  {
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'sitemap1');
    $pages = get_data_array(NULL, 'xx_sitemap', NULL, NULL, NULL, NULL, NULL, NULL, '50000');
    return response()->view('sitemap_n', compact('pages'))->header('Content-Type', 'text/xml');
  }

  public function sitemap2(Request $request)
  {
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'sitemap2');
    $pages = get_data_array_skip(NULL, 'xx_sitemap', NULL, NULL, NULL, NULL, NULL, NULL, '50000', '50000');
    return response()->view('sitemap_n', compact('pages'))->header('Content-Type', 'text/xml');
  }

  public function sitemap3(Request $request)
  {
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'sitemap3');
    $pages = get_data_array_skip(NULL, 'xx_sitemap', NULL, NULL, NULL, NULL, NULL, NULL, '50000', '100000');
    return response()->view('sitemap_n', compact('pages'))->header('Content-Type', 'text/xml');
  }

  public function sitemap4(Request $request)
  {
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'sitemap4');
    $pages = get_data_array_skip(NULL, 'xx_sitemap', NULL, NULL, NULL, NULL, NULL, NULL, '50000', '150000');
    return response()->view('sitemap_n', compact('pages'))->header('Content-Type', 'text/xml');
  }

  public function sitemap5(Request $request)
  {
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'sitemap5');
    $pages = get_data_array_skip(NULL, 'xx_sitemap', NULL, NULL, NULL, NULL, NULL, NULL, '50000', '200000');
    return response()->view('sitemap_n', compact('pages'))->header('Content-Type', 'text/xml');
  }

  public function sitemap6(Request $request)
  {
      createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'sitemap6');
      $pages = get_data_array_skip(NULL, 'xx_sitemap', NULL, NULL, NULL, NULL, NULL, NULL, '50000', '250000');
      return response()->view('sitemap_n', compact('pages'))->header('Content-Type', 'text/xml');
  }
  
  public function semrush(Request $request)
  {
    createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'semrush sitemap');
    $pages = get_data_array(NULL, 'xx_sitemap', 'semrush', '1');
    return response()->view('sitemap_n', compact('pages'))->header('Content-Type', 'text/xml');
  }

}
