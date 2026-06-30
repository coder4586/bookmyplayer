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

class nearby_coach_listing extends BaseController
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

  public function nearby_coach_listing(Request $request, $lat, $lng)
  {

      createLog("", $request->ip(), $request->url(), URL::previous(), $this->getDeviceType());

      $page = $request->input('page', 1); // Get the page number from the request, default to 1 if not provided
      $perPage = 10;
      $offset = ($page - 1) * $perPage;
      $sport_id = 1;
      $loc_id = 3;

      $sport = Adm_sports_master::find($sport_id);
      $location = Adm_location_master::find($loc_id);


      $lat = floatval($lat); // Ensure $lat is a float
      $lng = floatval($lng); // Ensure $lng is a float

      $coachesQuery = Bmp_coach_details::select('*')
          ->selectRaw("
              (6371 * acos(
                  cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) +
                  sin(radians(?)) * sin(radians(lat))
              )) AS distance
          ", [$lat, $lng, $lat])
          ->orderBy('distance');

      $totalCoaches = $coachesQuery->count();

      $coaches = $coachesQuery->skip($offset)
                              ->take($perPage)
                              ->get();

      $lastPage = ceil($totalCoaches / $perPage);
      $pagination = [
          ["name" => "previous", "value" => ($page > 1) ? $page - 1 : 0],
          ["name" => "current", "value" => $page],
          ["name" => "next", "value" => ($page < $lastPage) ? $page + 1 : null],
          ["name" => "is_last", "value" => ($page == $lastPage)],
      ];

      $breadcrumbs = ($sport_id == 34) ?
          [(object) ['name' => $sport->name . ' & Instructors in ' . $location->locality_name, 'link' => ""]] :
          [(object) ['name' => $sport->name . ' Coaches & Instructors in ' . $location->locality_name, 'link' => ""]];

      $data = array(
          'title' => $sport->name . ' Coaches & Instructors in ' . $location->locality_name . ', ' . $location->state . '. Fee ₹399/Hr',
          'des' => 'Find top Coaching instructors near you in ' . $location->locality_name . ' .Book ' . $sport->name . ' lessons. Fee starting from 399 per hr. 3 days a week, 12 classes a month. Average price ₹3500-3800.',
          "url" => URL::current(),
          'breadcrumbs' => $breadcrumbs,
          'sport' => $sport,
          'location' => $location,
          'd' => [],
          'coaches' => $coaches,
          'pagination' => $pagination,
      );

      if ($request->ajax()) {
        return response()->json(['coaches' => $coaches, "pagination" => $pagination, 'whatsapp_no' => env('WHATSAPP_LEAD_MOBILE')]);
      }

      return view("coach.nearby_coach_listing")->with('data', $data);
  }

}
