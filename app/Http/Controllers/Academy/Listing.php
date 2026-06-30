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

class Listing extends BaseController
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

  public function show_sport_listing(Request $request, $name, $id)
  {
    $url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
    if (is_numeric($id) && $id >= 50) {
      return $this->sport_list($request, $id, $url);
    } else {
      return $this->core_sport_list($request, $id, $url);
    }
  }


  public function sport_list(Request $request, $id, $url)
  {
    $record = Bmp_sports::find($id);
    if (!$record) {
      return redirecturl($request->getRequestUri());
    }

    DB::table('bmp_sports')->where('id', $record->id)->increment('views', 1);
    $sportd = Adm_sports_master::find($record->sport_id);

    $location = null;
    $location = Adm_location_master::find($record->loc_id);
    $nearbyAcademies = getNearbyAcademy_vi('bmp_academy_details', $location->lat, $location->lng, 200, 300, $record->sport_id);
    $otherLocalities = getnearbylocations($location->lat, $location->lng, 100);

    $localityName = $location ? ucwords($location->locality_name) : '';
    $cityName = $location ? ucwords($location->city) : '';
    $sportName = ucwords($sportd->name);

    $breadcrumbs = [(object) ['name' => "{$sportName} Classes in {$localityName}", 'link' => '']];

    $localityAndCity = strtolower($localityName) !== strtolower($cityName) ? "{$localityName}, {$cityName}" : $localityName;
    $localityAndCityFormatted = ucwords($localityName) . ($localityName !== $cityName ? ', ' . ucwords($cityName) : '');

    $titleSuffix = "{$sportName} Classes in {$localityAndCityFormatted}";
    $title = ucwords($titleSuffix) . " | BookMyPlayer";
    $des = "Learn " . ucwords($sportName) . " in {$localityAndCityFormatted}".". Top " . ucwords($sportName) . " Classes with details of Academy, Coaches, Players with ratings, reviews, photos, charges & timings. Women, kids friendly options. Join today and start training.";

    $data = [
      "title" => $title,
      'des' => $des,
      "url" => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
      "d" => $nearbyAcademies,
      "record" => $record,
      "sports" => [],
      "city" => $localityAndCity,
      "otherLocalities" => $otherLocalities,
      "topAcademies" => [],
      "breadcrumbs" => $breadcrumbs,
      "page" => 'sdid_sport',
      "template" => "sdid_sport"
    ];

    return view('academy.sdid_listing', compact('data'));
  }


  public function core_sport_list(Request $request, $id, $url)
  {
    $record = get_data_row(NULL, 'bmp_sports', 'id', $id);
    if (!$record) {
      return redirecturl($request->getRequestUri());
    }

    //VG7June:- Collect Stats
    DB::table('bmp_sports')->where('id', $record->id)->increment('views', 1);
    $conditions = [
      'bmp_academy_details.sport' => $record->sport// specify the table alias for the sport column
    ];

    $d = get_data_array(NULL, 'bmp_academy_details', 'sport_id', $record->sport_id, null, null, 'views', 'desc', 300);
    $otherLocalities = get_data_array(NULL, 'bmp_sports', 'subtype', 'city', 'sport_id', $record->sport_id, 'views', 'desc');
    $sport = get_data_array(NULL, 'adm_sports_master');

    $localityName = ucwords($record->locality_name);
    $cityName = ucwords($record->city);
    $sportName = ucwords($record->sport);
    $breadcrumbs = [(object) ['name' => 'Top ' . ucwords($record->sport) . ' Academies in India', 'link' => '']];

    if ($record->sport_id == 31) {
      $title = "Find Top 10 Gym & Fitness Center in India - BookMyPlayer";
      $des = 'Discover your best fit gym and professional persoanl trainers. State-of-the-art facilities, 24/7 access, and a supportive community in Start today!';
      $keywords = 'Top Gym in India, Fitness Center near you, 24/7 Gym near me, Health Club, Best gym in my city, Fitness Membership, Gym with Personal Trainer';
    } else {
      $title = 'Top ' . $record->sport . ' Academies & Coaches Near You - BookMyPlayer';
      $des = 'Discover best ' . $record->sport . ' academies, coaches near you. Find list of top academies with reviews, rating, photos, price, charges, contact number, location, schedule, timings, with address.';
      $keywords = $record->sport . ' academies near me, ' . $record->sport . ' coaches near me, ' . $record->sport . ' training, ' . $record->sport . ' academies,  ' . $record->sport . ' events, ' . $record->sport . ' community , BookMyPlayer, ' . $record->sport . ' academy near me';
    }

    $data = array(
      "title" => $title,
      'des' => $des,
      "keywords" => $keywords,
      "url" => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
      "d" => $d,
      "record" => $record,
      "sports" => $sport,
      "city" => "India",
      "otherLocalities" => $otherLocalities,
      "topAcademies" => [],
      "page" => 'sdid_sport',
      "breadcrumbs" => $breadcrumbs,
      "template" => "sdid_sport"
    );
    return view('academy.sdid_listing', compact('data'));
  }

  //-locid-
  public function show_city_listing(Request $request, $city, $name, $id)
  {
    $record = get_data_row(null, 'adm_location_master', 'id', $id);
    if (!$record) {
      return redirecturl($request->getRequestUri());
    }
    //VG7June:- Collect Stats
    DB::table('adm_location_master')->where('id', $record->id)->increment('views', 1);

    $d = getNearbyAcademy_vg('bmp_academy_details', $record->lat, $record->lng, 60, 300);
    $city = (strtolower($record->locality_name) !== strtolower($record->city)) ? $record->locality_name . ", " . $record->city : $record->locality_name;
    $otherLocalities = get_data_array(NULL, 'adm_location_master', 'city', $record->city, null, null, 'views', 'desc', 150);
    $gyms = [];
    $nonGyms = [];
    $sports = [];
    $topAcademies = array_slice($d, 0, 10);

    if ($record->type == 'locality') {
      $city_url = get_data_row(null, 'adm_location_master', 'id', $record->city_id);
      $breadcrumbs = [(object) ['name' => $record->city, 'link' => $city_url->url], (object) ['name' => "Training Academies in $record->locality_name", 'link' => ""]];
    } else {
      $breadcrumbs = [(object) ['name' => $record->city, 'link' => ""], (object) ['name' => "Training Academies in $record->locality_name", 'link' => ""]];
    }



    foreach ($d as $item) {
      if ($item->sport == 'gym') {
        $gyms[] = $item;
      } else {
        $nonGyms[] = $item;
      }

      if (!in_array($item->sport, $sports)) {
        $sports[] = $item->sport;
      }
    }
    sort($sports);
    $d = array_merge($nonGyms, $gyms);

    if ($record->type == 'city') {
      $title = 'Top Sports Coaching in ' . ucfirst($record->city) . ', ' . ucfirst($record->state) . ' | BookMyPlayer';
      $des = 'Find Top Coaches, Academies for Sports training in ' . $record->city . ', ' . $record->state . '. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports academies and coaches.';
    } else {
      $title = 'Top Sports Coaching in ' . ucfirst($record->locality_name) . ', ' . ucfirst($record->city) . ' | BookMyPlayer';
      $des = 'Find Top Coaches, Academies for Sports training in ' . $record->locality_name . ', ' . $record->city . '. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports academies and coaches.';
    }


    $data = array(
      "title" => $title,
      'des' => $des,
      "url" => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
      "d" => $d,
      "record" => $record,
      "sports" => $sports,
      "city" => $city,
      "otherLocalities" => $otherLocalities,
      "topAcademies" => $topAcademies,
      "breadcrumbs" => $breadcrumbs,
      "page" => 'sdid_locality',
      "template" => "sdid_locality"
    );
    return view('academy.locid_listing', compact('data'));
  }

  public function show_nearby_academy_listing(Request $request, $lat, $lng)
  {
    $data = DB::select("
        SELECT
            *,
            ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance
        FROM adm_location_master
        HAVING distance < 50
        ORDER BY distance ASC
        LIMIT 0, 1
        ");

    if (!empty($data) && isset($data[0]->url)) {
      createLog($data[0]->id, $request->ip(), $data[0]->url, URL::previous(), $this->getDeviceType(), $lat . ',' . $lng, $data[0]->lat . ',' . $data[0]->lng);
      return redirect($data[0]->url);
    } else {
      return redirect('/');
    }
  }

  // New loc-id layout
  public function new_show_city_listing(Request $request, $city, $name, $id)
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

    $nearbyLocations = getNearbyAcademy_mm('bmp_academy_details', $record->lat, $record->lng, 60, 300, $conditions);
    $totalNearbyLocations = count($nearbyLocations);

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

    $otherLocalities = DB::table('adm_location_master')
      ->where('city', $record->city)
      ->orderBy('views', 'desc')
      ->take(150)
      ->get();

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

  // Api - Listing
  public function getEntitiesByLocation(Request $request)
	{

		try {
			$page = $request->input('page', 1);
			$id = $request->input('id', 1);
			$type = $request->input('type');
			$conditions = $request->input('conditions', []);
			$perPage = 10;
			$offset = ($page - 1) * $perPage;

			$record = DB::table('adm_location_master')->where('id', $id)->first();
			if (!$record) {
				return redirectUrl($request->getRequestUri(), null);
			}

			$city_id = $record->id;
			if ($record->city_id != 0) {
				$city_id = $record->city_id;
			}
			$latitude = $record->lat;
			$longitude = $record->lng;

			$nearbyCityListing = DB::table('adm_location_master')->where('city_id', $city_id)->orderBy('views', 'desc')->get();

			// Master Listing - Locid
			if ($type == 'academy') {
				$nearbyLocations = getNearbyAcademy_mm('bmp_academy_details', $latitude, $longitude, 60, 300, $conditions);
				$total = count($nearbyLocations);

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

				$otherLocalities = DB::table('adm_location_master')
					->where('city', $record->city)
					->orderBy('views', 'desc')
					->take(150)
					->get();

				$lastPage = ceil($totalLocations / $perPage);
				$hasMoreRecords = $page < $lastPage;
				$pagination = [
					["name" => "previous", "value" => ($page > 1) ? $page - 1 : 0],
					["name" => "current", "value" => $page],
					["name" => "next", "value" => ($page < $lastPage) ? $page + 1 : null],
					["name" => "is_last", "value" => ($page == $lastPage)],
				];

				$data = [
					"title" => "",
					'des' => "",
					'breadcrumbs' => [],
					"url" => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
					"locations" => array_slice($sortedLocations, $offset, $perPage),
					"record" => $record,
					"sports" => $sports,
					"city" => "",
					"count" => $total,
					"otherLocalities" => $otherLocalities,
					"pagination" => $pagination,
					"hasMoreRecords" => $hasMoreRecords,
				];

				if ($request->ajax()) {
					return response()->json(['status' => 1, 'message' => 'academies listing', 'data' => $data]);
				}
			} else if ($type == 'coach') {
				$d = Bmp_coach_listing::find($id);
				if (!$d) {
					return redirecturl($request->getRequestUri(), null);
				}
				DB::table('bmp_coach_listing')->where('id', $id)->increment('views', 1);
				
				$sport = Adm_sports_master::find($d->sport_id);
				$location = Adm_location_master::find($d->loc_id);

				if ($d->loc_id == 0 || !$location) {
					$location = (object) [
						'locality_name' => 'India',
						'state' => ''
					];
					$coachesQuery = Bmp_coach_details::where('sport_id', $d->sport_id)->orderBy('views', 'desc');
					$nearbylocations = [];
				} else {
					// $latitude = $location->lat;
					// $longitude = $location->lng;
					$nearbyLocationIds = DB::table('adm_location_master')
						->select('id', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(lat)))) AS distance'))
						->having('distance', '<', 10)
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
						->having('distance', '<', 10)
						->orderBy('distance')
						->get()
						->toArray();
				}


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

				$breadcrumbs = ($d->sport_id == 34) ?
					[(object) ['name' => $sport->name . ' & Instructors in ' . $location->locality_name, 'link' => ""]] :
					[(object) ['name' => $sport->name . ' Coaches & Instructors in ' . $location->locality_name, 'link' => ""]];

				$data = array(
					'title' => $sport->name . ' Coaches & Instructors in ' . $location->locality_name . ', ' . $location->state . '. Fee ₹399/Hr',
					'des' => 'Find top Coaching instructors near you in ' . $location->locality_name . ' .Book ' . $sport->name . ' lessons. Fee starting from 399 per hr. 3 days a week, 12 classes a month. Average price ₹3500-3800.',
					"url" => URL::current(),
					'breadcrumbs' => $breadcrumbs,
					'sport' => $sport,
					'location' => $location,
					'nearbylocations' => $nearbylocations,
					'count' => $totalCoaches,
					'd' => $d,
					'coaches' => $coaches,
					'pagination' => $pagination,
					'whatsapp_no' => env('WHATSAPP_LEAD_MOBILE')
				);

				if ($request->ajax()) {
					return response()->json(['status' => 1, 'message' => 'coach listing', 'data' => $data]);
				}
			} else if ($type == "player") {
				$d = Bmp_player_listing::find($id);
				if (!$d) {
					return redirectUrl($request->getRequestUri(), null);
				}

				$nearbyLocationIds = DB::table('adm_location_master')
					->select('id', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(lat)))) AS distance'))
					->having('distance', '<', 10)
					->orderBy('distance')
					->pluck('id')
					->toArray();
				$coachesQuery = Bmp_player_details::where('sport_id', $d->sport_id)
					->whereIn('loc_id', $nearbyLocationIds)
					->orderBy('id', 'desc');


				$totalCoaches = $coachesQuery->count();
				$coaches = $coachesQuery->skip($offset)
					->take($perPage)
					->get();


				$lastPage = ceil($totalCoaches / $perPage);
				$hasMoreRecords = $page < $lastPage;

				$pagination = [
					["name" => "previous", "value" => ($page > 1) ? $page - 1 : 0],
					["name" => "current", "value" => $page],
					["name" => "next", "value" => ($page < $lastPage) ? $page + 1 : null],
					["name" => "is_last", "value" => ($page == $lastPage)],
				];


				$data = array(
					"count" => $totalCoaches,
					'pagination' => $pagination,
					'player' => $coaches,
					'd' => $d,
				);

				if ($request->ajax()) {
					return response()->json([
						'status' => 1,
						'message' => 'players listing',
						'data' => $data
					]);
				}
			} else if ($type == "sports") {
				$sports = DB::table('bmp_sports')->where('type', 'core')->get();
				if ($request->ajax()) {
					return response()->json([
						'status' => 1,
						'message' => 'sport listing',
						'data' => $sports
					]);
				}
			} else if ($type == "cities") {
				if ($request->ajax()) {
					return response()->json([
						'status' => 1,
						'message' => 'city listing',
						'data' => $nearbyCityListing
					]);
				}
			}


		} catch (Exception $e) {
			if ($request->ajax()) {
				return response()->json(['status' => 0, 'message' => 'An error occurred while processing your request.']);
			}
		}
	}


}
