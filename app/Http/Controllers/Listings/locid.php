<?php
namespace App\Http\Controllers\Listings;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Bmp_sports;
use App\Models\Adm_location_master;
use App\Models\Bmp_academy_details;
use App\Models\Bmp_coach_details;
use App\Models\Bmp_player_details;
use App\Models\Bmp_leads;
use App\Models\Bmp_reviews;

class locid extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function show_locid(Request $request, $name, $id)
    {
        $record = Adm_location_master::find($id);
        if (!$record) {
            return redirectUrl($request->getRequestUri(), null);
        }

        DB::table('adm_location_master')->where('id', $id)->increment('views', 1);

        $entities = Adm_location_master::where('id', $id)->first();
        $total_academies_count = count(explode(',', $entities->academy));
        $total_coaches_count = count(explode(',', $entities->coach));
        $total_player_count = count(explode(',', $entities->player));
        $listing_count = $total_academies_count > 0 ? $total_academies_count : ($total_coaches_count > 0 ? $total_coaches_count : ($total_player_count > 0 ? $total_player_count : 100));

        $cityName = strtolower($record->locality_name) !== strtolower($record->city)
            ? $record->locality_name . ", " . $record->city
            : $record->locality_name;

        if ($record->city_id == '0') {
            $breadcrumbs[] = (object) ['name' => "Best Sports Academies, Coaches in $record->city, $record->state ({$listing_count}+ Listings)", 'link' => $record->url ?? 'https://www.bookmyplayer.com/',];
        } else {
            $city = Adm_location_master::find($record->city_id);
            $breadcrumbs[] = (object) ['name' => "Sports in $record->city, $record->state", 'link' => $city->url ?? 'https://www.bookmyplayer.com'];
            $breadcrumbs[] = (object) ['name' => "Best Sports Academies, Coaches $record->locality_name, $record->city ({$listing_count}+ Listings)", 'link' => ''];
        }


        $title = $record->city_id == '0'
            ? 'Best Sports Academies, Coaches in ' . ucfirst($record->city) . ', ' . ucfirst($record->state) . ' | BookMyPlayer'
            : 'Best Sports Academies, Coaches in ' . ucfirst($record->locality_name) . ', ' . ucfirst($record->city) . ' | BookMyPlayer';

        $description = $record->type == 'city'
            ? 'Find List of Top Coaches, Academies for Sports training in ' . $record->city . ', ' . $record->state . ' with reviews. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports.'
            : 'Find Top Coaches, Academies for Sports training in ' . $record->locality_name . ', ' . $record->city . '. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports.';


        $data = [
            "title" => $title,
            "des" => $description,
            "url" => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
            "record" => $record,
            "breadcrumbs" => $breadcrumbs
        ];

        return view('Listings.locid', compact('data'));
    }

    // Api
    public function show_locid_api(Request $request)
    {
        $id = $request->input('id', 1);
        $page = (int) $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $type = $request->input('type');

        $record = Adm_location_master::where('id', $id)->first();
        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $result = [];
        $totalItems = $counts[$type] ?? 0;
        $lastPage = ceil($totalItems / $perPage);

        if ($type === "academy") {
            $ids = array_filter(explode(',', $record->academy ?? '')); // Ensure no empty values
            $paginatedIds = array_slice($ids, $offset, $perPage);

            if (empty($paginatedIds)) {
                $result = collect(); // Return an empty collection
            } else {
                $result = Bmp_academy_details::whereIn('id', $paginatedIds)
                    ->select(
                        'id',
                        'photos',
                        'name',
                        'sport as adm_sport',
                        'fee',
                        'url',
                        'rating',
                        'reviews',
                        'address1',
                        'views',
                        'lat',
                        'lng',
                        'sport_id',
                        'loc_id',
                        'timing'
                    )
                    ->orderByRaw("FIELD(id, " . implode(',', $paginatedIds) . ")")
                    ->get();
            }
        } elseif ($type == "about") {
            $location_ai_info = collect(get_static_data_location_about('location_info_ai.json', $id));
            $reviews = Bmp_reviews::whereIn('object_id', explode(',', $record->academy))->where('status', 1)->where('rating', '>=', 3)->orderBy('rating', 'desc')->take(5)->select('comment', 'name', 'rating')->get();

            $filter_academies = [];
            $sports_records = Bmp_sports::where('loc_id', $id)
                ->where('type', 'listing')
                ->orderBy('views', 'desc')
                ->limit(6)
                ->get(['academy', 'coach', 'player']);

            $filter_academies = $sports_records->flatMap(function ($record) {
                $academies = Bmp_academy_details::whereIn('id', array_slice(array_filter(explode(',', $record->academy)), 0, 3))
                    ->select('id', 'sport_id', 'photos', 'name', 'rating', 'reviews', 'address1 as address', 'timing', 'sport', 'url', 'fee')
                    ->get()
                    ->map(fn($academy) => ['type' => 'academy', 'data' => $academy]);

                $coaches = Bmp_coach_details::whereIn('id', array_slice(array_filter(explode(',', $record->coach)), 0, 2))
                    ->select('id', 'name', 'url', 'profile_img', 'address', 'address1', 'views', 'sport')
                    ->get()
                    ->map(fn($coach) => ['type' => 'coach', 'data' => $coach]);

                $players = Bmp_player_details::whereIn('id', array_slice(array_filter(explode(',', $record->player)), 0, 2))
                    ->select('id', 'name', 'url', 'sport', 'logo', 'city as address')
                    ->get()
                    ->map(fn($player) => ['type' => 'player', 'data' => $player]);

                return $academies->concat($coaches)->concat($players);
            })
                ->groupBy(fn($item) => $item['data']->sport)
                ->toArray();
            $record = ["location_ai_info" => $location_ai_info, "reviews" => $reviews, "filter_academies" => $filter_academies];
        } else if ($type == "about_entity_backlinks") {
            $limit = 100;
            $academy_bklinks = empty($record->academy)
                ? collect()
                : Bmp_academy_details::whereIn('id', explode(',', $record->academy))
                    ->select('name', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', explode(',', $record->academy)) . ")")
                    ->take($limit)
                    ->get();

            $coach_bklinks = empty($record->coach)
                ? collect()
                : Bmp_coach_details::whereIn('id', explode(',', $record->coach))
                    ->select('name', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', explode(',', $record->coach)) . ")")
                    ->take($limit)
                    ->get();

            $player_bklinks = empty($record->player)
                ? collect()
                : Bmp_player_details::whereIn('id', explode(',', $record->player))
                    ->select('name', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', explode(',', $record->player)) . ")")
                    ->take($limit)
                    ->get();

            $sport_bklink = empty($record->sport)
                ? collect()
                : Bmp_sports::whereIn('sport_id', explode(',', $record->sport))
                    ->where('loc_id', $id)
                    ->select('id', 'sport', 'url', 'locality_name', 'city')
                    ->orderByRaw("FIELD(sport_id, " . implode(',', explode(',', $record->sport)) . ")")
                    ->take($limit)
                    ->get();

            $location_bklink = empty($record->location)
                ? collect()
                : Adm_location_master::whereIn('id', explode(',', $record->location))
                    ->select('id', 'locality_name', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', explode(',', $record->location)) . ")")
                    ->take($limit)
                    ->get();

            $record = ["sport_backlinks" => $sport_bklink, "location_backlinks" => $location_bklink, "academy_backlinks" => $academy_bklinks, "coach_backlinks" => $coach_bklinks, "player_backlinks" => $player_bklinks];
        } elseif ($type === "about_nearby_locations") {
            $locations = Adm_location_master::selectRaw('
            adm_location_master.id, 
            adm_location_master.locality_name,
            adm_location_master.url,
            GROUP_CONCAT(DISTINCT bmp_sports.sport ORDER BY bmp_sports.sport ASC SEPARATOR ", ") AS sport_names,
            LENGTH(adm_location_master.academy) - LENGTH(REPLACE(adm_location_master.academy, ",", "")) + 1 AS total_academies
        ')
                ->leftJoin('bmp_sports', function ($join) {
                    $join->whereRaw('FIND_IN_SET(bmp_sports.id, adm_location_master.sport) > 0');
                })
                ->whereIn('adm_location_master.id', explode(',', $record->location))
                ->groupBy('adm_location_master.id', 'adm_location_master.locality_name', 'adm_location_master.url', 'adm_location_master.academy')
                ->orderBy('adm_location_master.locality_name', 'asc')
                ->get();

            $record = ["nearby_locations" => $locations];
        } elseif ($type === "coach") {
            $ids = explode(',', $record->coach);
            $paginatedIds = array_slice($ids, $offset, $perPage);
            $result = Bmp_coach_details::leftJoin('adm_location_master', 'bmp_coach_details.loc_id', '=', 'adm_location_master.id')
                ->leftJoin('adm_sports_master', 'bmp_coach_details.sport_id', '=', 'adm_sports_master.id')
                ->whereIn('bmp_coach_details.id', $paginatedIds)
                ->select(
                    'bmp_coach_details.id',
                    'bmp_coach_details.profile_img',
                    'bmp_coach_details.url',
                    'bmp_coach_details.name',
                    'bmp_coach_details.sport',
                    'bmp_coach_details.views',
                    'bmp_coach_details.loc_id',
                    'bmp_coach_details.sport_id',
                    'adm_location_master.locality_name as loc_locality_name',
                    'adm_location_master.city as loc_city',
                    'adm_location_master.state as loc_state',
                    'adm_location_master.postcode as loc_postcode',
                    'adm_sports_master.sport as adm_sport'
                )
                ->get();
        } elseif ($type === "player") {
            $ids = explode(',', $record->player);
            $paginatedIds = array_slice($ids, $offset, $perPage);
            $result = Bmp_player_details::leftJoin('adm_location_master', 'bmp_player_details.loc_id', '=', 'adm_location_master.id')
                ->leftJoin('adm_sports_master', 'bmp_player_details.sport_id', '=', 'adm_sports_master.id')
                ->whereIn('bmp_player_details.id', $paginatedIds)
                ->select(
                    'bmp_player_details.*',
                    'adm_location_master.locality_name as loc_locality_name',
                    'adm_location_master.city as loc_city',
                    'adm_location_master.state as loc_state',
                    'adm_location_master.postcode as loc_postcode',
                    'adm_sports_master.sport as adm_sport'
                )
                ->get();
        } elseif ($type === "filters") {
            $ids = explode(',', $record->location);
            $locations = Adm_location_master::whereIn('id', $ids)->select('id', 'locality_name', 'url')->orderBy('locality_name', 'asc')->get();
            $record = [
                "location" => $locations,
            ];
        } elseif ($type === "sport") {
            $record = Bmp_sports::whereIn('sport_id', explode(',', $record->sport))->where('loc_id', $id)->select('id', 'sport', 'url', 'locality_name', 'city')->orderBy('sport', 'asc')->get();
        } elseif ($type === "location") {
            $ids = explode(',', $record->location);
            $record = Adm_location_master::whereIn('id', $ids)->select('id', 'locality_name', 'url')->orderBy('locality_name', 'asc')->get();
        } else if ($type == "counts") {
            return response()->json([
                'data' => [
                    "counts" => [
                        'academy' => !empty($record->academy) ? count(explode(',', $record->academy)) : 0,
                        'coach' => !empty($record->coach) ? count(explode(',', $record->coach)) : 0,
                        'player' => !empty($record->player) ? count(explode(',', $record->player)) : 0,
                        'location' => !empty($record->location) ? count(explode(',', $record->location)) : 0,
                        'sport' => !empty($record->sport) ? count(explode(',', $record->sport)) : 0
                    ]
                ]
            ]);

        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        $pagination = [
            ["name" => "previous", "value" => ($page > 1) ? $page - 1 : 0],
            ["name" => "current", "value" => $page],
            ["name" => "is_last", "value" => ($page == $lastPage)]
        ];
        if ($request->ajax()) {
            return response()->json([
                'data' => [
                    "record" => $record,
                    "details" => $result,
                    "pagination" => $pagination
                ]
            ]);
        }


    }

    public function locid_enqury_api(Request $request)
    {
        try {
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $message = $request->input('message');
            $sport_id = $request->input('sport_id');
            $loc_id = $request->input('loc_id');
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            $type = $request->input('type');
            $city = null;
            $state = null;
            $object_type = null;
            $object_id = null;
            $loc = null;

            $missingFields = array_filter(['name', 'email', 'phone', 'message', 'sport_id'], function ($field) use ($request) {
                return !$request->input($field);
            });

            if ($missingFields) {
                return response()->json([
                    'error' => 'Missing required fields: ' . implode(', ', $missingFields)
                ], 400);
            }

            $allowedTypes = ["sdid enquiry", "loc-id enquiry"];
            if (!in_array($type, $allowedTypes, true)) {
                return response()->json(['status' => 0, 'message' => 'invalid type']);
            }

            $sport_g = Bmp_sports::where('type', 'core')->where('id', $sport_id)->select('id', 'sport', 'locality_name')->first();
            if (!$sport_g) {
                return response()->json(['status' => 0, 'message' => 'invalid sport id']);
            }

            if ($type == "sdid enquiry") {
                $object_id = preg_match('/-sdid-(\d+)/', url()->previous(), $matches) ? $matches[1] : null;
                $object_type = "sdid";
                $sport_d = Bmp_sports::where('id', $object_id)->select('id', 'sport', 'locality_name','city','state')->first();
                $loc = $sport_d->locality_name;
                $city = $sport_d->city;
                $state = $sport_d->state;
            } else if ($type == "loc-id enquiry") {
                $object_id = preg_match('/-locid-(\d+)/', url()->previous(), $matches) ? $matches[1] : null;
                $object_type = "loc-id";
                $loc_d = Adm_location_master::where('id', $object_id)->select('id', 'locality_name','city','state')->first();
                if ($loc_d) {
                    $loc = $loc_d->locality_name;
                    $city = $loc_d->city;
                    $state = $loc_d->state;
                }
            }

            $lead = new Bmp_leads();
            $lead->object_id = $object_id;
            $lead->object_type = $object_type;
            $lead->name = $name;
            $lead->email = $email;
            $lead->phone = $phone;
            $lead->description = $message;
            $lead->sport_id = $sport_id;
            $lead->sport = $sport_g->sport;
            $lead->loc_id = $loc_id;
            $lead->loc = $loc;
            $lead->lat = $lat;
            $lead->lng = $lng;
            $lead->city = $city;
            $lead->state = $state;
            $lead->ip = $request->ip();
            $lead->refer = url()->previous();
            $lead->browser = strtolower($request->server('HTTP_USER_AGENT'));
            $lead->type = $type;
            $lead->source = 'message';

            $lead->save();

            session()->forget(['otp', 'sent_time']);

            return response()->json(['status' => 1, 'message' => 'Message sent successfully.']);

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function get_sdid_url(Request $request)
    {
        try {
            $loc_id = $request->input('loc_id');
            $sport_id = $request->input('sport_id');

            $missingFields = array_filter(['loc_id', 'sport_id'], function ($field) use ($request) {
                return !$request->input($field);
            });

            if ($missingFields) {
                return response()->json([
                    'error' => 'Missing required fields: ' . implode(', ', $missingFields)
                ], 400);
            }

            $sport = Bmp_sports::where('loc_id', $loc_id)->where('sport_id', $sport_id)->select('url')->first();
            if (!$sport) {
                return response()->json(['status' => 0, 'message' => "no sport found"]);
            }
            return response()->json(['status' => 1, 'url' => $sport->url]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    // Handeling Redirect
    public function handle_redirect(Request $request, $lat, $lng)
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
            return redirect($data[0]->url);
        } else {
            return back();
        }
    }
}
