<?php
namespace App\Http\Controllers\Academy;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;
use App\Models\Adm_location_master;
use App\Models\Bmp_player_listing;
use App\Models\Bmp_coach_listing;
use App\Models\Bmp_coach_details;
use App\Models\Bmp_player_details;
use App\Models\Adm_sports_master;
use App\Models\Bmp_sports;

class listing_locid extends BaseController
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

  use AuthorizesRequests, ValidatesRequests;

public function listing_locid(Request $request, $city, $name, $id)
{
  $page = $request->input('page', 1);
  $conditions = $request->input('conditions', []);
  $perPage = 5;
  $offset = ($page - 1) * $perPage;

  $record = DB::table('adm_location_master')->where('id', $id)->first();
  if (!$record) {
    return redirectUrl($request->getRequestUri(), null);
  }

  DB::table('adm_location_master')->where('id', $id)->increment('views', 1);

  $cityName = strtolower($record->locality_name) !== strtolower($record->city)
    ? $record->locality_name . ", " . $record->city
    : $record->locality_name;

  //$nearbyLocations = getNearbyAcademy_mm('bmp_academy_details', $record->lat, $record->lng, 60, 300, $conditions);
  //$totalNearbyLocations = count($nearbyLocations);
  $nearbyLocations=[];
  $totalNearbyLocations = 73;

  $gyms = [];
  $nonGyms = [];
  $sports = [];

  foreach ($nearbyLocations as $item) {
    if ($item->sport == 'gym') {
      $gyms[] = $item;
    } else {
      $nonGyms[] = $item;
    }

    $sportsKey = $item->sport . '-' . $item->sport_id;
    if (!array_key_exists($sportsKey, $sports)) {
      $sports[$sportsKey] = [
        'sport' => $item->sport,
        'sport_id' => $item->sport_id
      ];
    }
  }

  $sports = array_values($sports);
  usort($sports, function ($a, $b) {
    return strcmp($a['sport'], $b['sport']);
  });

  $sortedLocations = array_merge($nonGyms, $gyms);
  $topAcademies = array_slice($sortedLocations, 0, 10);
  $totalLocations = count($sortedLocations);
  $otherLocalities = [];
  //$otherLocalities = DB::table('adm_location_master')
//    ->where('city', $record->city)
  //  ->orderBy('views', 'desc')
//    ->take(150)
    //->get();

  $title = $record->type == 'city'
    ? 'Top Sports Coaching in ' . ucfirst($record->city) . ', ' . ucfirst($record->state) . ' | BookMyPlayer'
    : 'Top Sports Coaching in ' . ucfirst($record->locality_name) . ', ' . ucfirst($record->city) . ' | BookMyPlayer';

  $description = $record->type == 'city'
    ? 'Find Top Coaches, Academies for Sports training in ' . $record->city . ', ' . $record->state . '. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports academies and coaches.'
    : 'Find Top Coaches, Academies for Sports training in ' . $record->locality_name . ', ' . $record->city . '. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports academies and coaches.';

  $lastPage = ceil($totalLocations / $perPage);
  $hasMoreRecords = $page < $lastPage;

  $pagination = [
    ["name" => "previous", "value" => ($page > 1) ? $page - 1 : 0],
    ["name" => "current", "value" => $page],
    ["name" => "next", "value" => ($page < $lastPage) ? $page + 1 : null],
    ["name" => "is_last", "value" => ($page == $lastPage)],
  ];

  $data = [
    "title" => $title,
    'des' => $description,
    'breadcrumbs' => [],
    "url" => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
    "locations" => array_slice($sortedLocations, $offset, $perPage),
    "record" => $record,
    "sports" => $sports,
    "city" => $cityName,
    "otherLocalities" => $otherLocalities,
    "topAcademies" => $topAcademies,
    "pagination" => $pagination,
    "hasMoreRecords" => $hasMoreRecords,
  ];

  if ($request->ajax()) {
    return response()->json([
      'locations' => $data['locations'],
      'total_records' => $totalNearbyLocations,
      'hasMoreRecords' => $hasMoreRecords,
      'pagination' => $pagination,
    ]);
  }

  return view('test_academy_listing', compact('data'));
}

}
