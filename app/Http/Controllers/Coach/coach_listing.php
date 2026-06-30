<?php

namespace App\Http\Controllers\Coach;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;
use App\Models\Adm_sports_master;
use App\Models\Adm_location_master;
use App\Models\Bmp_sport_faqs;
use App\Models\Bmp_reviews;
use App\Models\Bmp_coach_details;
use App\Models\Bmp_coach_listing;

class coach_listing extends BaseController
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


  public function coach_listing(Request $request, $name, $id)
  {
    $d = Bmp_coach_listing::find($id);
    if (!$d) {
      return redirecturl($request->getRequestUri(), null);
    }

    DB::table('bmp_coach_listing')->where('id', $id)->increment('views', 1);
    $page = $request->input('page', 1); // Get the page number from the request, default to 1 if not provided
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    $sport = Adm_sports_master::find($d->sport_id);
    $location = Adm_location_master::find($d->loc_id);


    if ($d->loc_id == 0 || !$location) {
      $location = (object) [
        'locality_name' => 'India',
        'state' => ''
      ];
      $coachesQuery = Bmp_coach_details::where('sport_id', $d->sport_id)
        ->orderBy('views', 'desc');
      $nearbylocations = [];
    } else {
      $latitude = $location->lat;
      $longitude = $location->lng;
      $nearbyLocationIds = DB::table('adm_location_master')
        ->select('id', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(lat)))) AS distance'))
        ->having('distance', '<', 50)
        ->orderBy('distance')
        ->pluck('id')
        ->toArray();
      $coachesQuery = Bmp_coach_details::where('sport_id', $d->sport_id)
        ->whereIn('loc_id', $nearbyLocationIds)
        ->orderBy('views', 'desc');
      $nearbylocations = DB::table('bmp_coach_listing')
        ->select('id', 'location', 'url', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(lat)))) AS distance'))
        ->where('loc_id', '!=', 0)
        ->where('sport_id', '=', $d->sport_id)
        ->having('distance', '<', 30)
        ->orderBy('distance')
        ->get()
        ->toArray();
    }


    $totalCoaches = $coachesQuery->count();

    // Fetch coaches for the current page
    $coaches = $coachesQuery->skip($offset)
      ->take($perPage)
      ->get();

    // Determine pagination information
    $lastPage = ceil($totalCoaches / $perPage);

    $pagination = [
      ["name" => "previous", "value" => ($page > 1) ? $page - 1 : 0],
      ["name" => "current", "value" => $page],
      ["name" => "next", "value" => ($page < $lastPage) ? $page + 1 : null],
      ["name" => "is_last", "value" => ($page == $lastPage)],
    ];

    $breadcrumbs = ($d->sport_id == 34) ?
      [(object) ['name' => $sport->name . ' & Instructors in ' . $location->locality_name, 'link' => ""]] :
      [(object) ['name' => $sport->name . ' Coaches & Instructors in ' . $location->locality_name, 'link' => ""]];

    $data = array(
      'title' => $sport->name . ' Classes in ' . $location->locality_name . ', ' . $location->state . '. Fee ₹399/Hr',
      'des' => 'Find list of ' . $sport->name . ' classes near me. Book ' . $sport->name . ' lessons. Fee starting from 399 per hr. 3 days a week, 12 classes a month. Average charges ₹3500-3800. ' . $sport->name . ' Academies and Coaches.',
      "url" => URL::current(),
      'breadcrumbs' => $breadcrumbs,
      'sport' => $sport,
      'location' => $location,
      'nearbylocations' => $nearbylocations,
      'totalcoaches' => $totalCoaches,
      'd' => $d,
      'coaches' => $coaches,
      'pagination' => $pagination,
    );

    if ($request->ajax()) {
      return response()->json(['coaches' => $coaches, "pagination" => $pagination, 'whatsapp_no' => env('WHATSAPP_LEAD_MOBILE')]);
    }

    return view("coach.coach_listing")->with('data', $data);
  }

}
