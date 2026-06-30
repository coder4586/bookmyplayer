<?php
namespace App\Http\Controllers\Listings;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bmp_sports;
use App\Models\Adm_location_master;
use App\Models\Bmp_academy_details;
use App\Models\Bmp_coach_details;
use App\Models\Bmp_player_details;

class sdid extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function show_sdid(Request $request, $name, $id)
    {

        $record = Bmp_sports::find($id);
        if (!$record) {
            return redirecturl($request->getRequestUri());
        }
        DB::table('bmp_sports')->where('id', $id)->increment('views', 1);
        $sport_id = $record->sport_id;
        $sport = ucwords($record->sport);
        $location_name = "India";
        if (!$record->locality_name) {
            $location_name = "India";
        } else {
            if ($record->locality_name === $record->city) {
                $location_name = $record->locality_name . ', ' . $record->state;
            } else {
                $location_name = $record->locality_name . ', ' . $record->city;
            }
        }

        $total_academies_count = count(explode(',', $record->academy));
        $total_coaches_count = count(explode(',', $record->coach));
        $total_player_count = count(explode(',', $record->player));
        $listing_count = $total_academies_count > 0 ? $total_academies_count : ($total_coaches_count > 0 ? $total_coaches_count : ($total_player_count > 0 ? $total_player_count : 100));
        if ($record->sport_id == 31) {
            $title = "Best Gyms & Fitness Centers in $location_name | BookMyPlayer";
            $des = "Discover the top gyms and fitness centers in $location_name. Explore facilities, read reviews, check membership details, and find personal trainers. Start your fitness journey today with the best gyms near you.";
            $keywords = "Top Gym in $location_name, Fitness Center in $location_name, 24/7 Gym near me in $location_name, Health Club in $location_name, Best gym in my city $location_name, Fitness Membership, Gym with Personal Trainer in $location_name";
            $breadcrumbs = [(object) ['name' => 'Top ' . ucwords($record->sport) . ' in ' . $location_name, 'link' => ''], (object) ['name' => "({$listing_count}+) Listings", 'link' => "",]];
            $listing_title = "Top $sport in $location_name";
        } elseif ($record->sport_id == 5) {
            $title = "Best Swimming Classes in $location_name - Book Your Swimming Lessons Today";
            $des = "Discover the best swimming classes and swimming pools in $location_name Find top-rated swimming academies, professional instructors, and convenient locations near you. Perfect for all ages and skill levels. Book your swimming lessons today at BookMyPlayer.";
            $keywords = "swimming classes in $location_name, swimming pools in $location_name, swimming lessons near me, swimming trainers in $location_name, swimming academies in $location_name, swimming pools $location_name, swimming classes for kids $location_name, swimming courses $location_name, swimming coaching, learn swimming in $location_name";
            $breadcrumbs = [(object) ['name' => 'Top ' . ucwords($record->sport) . ' Pool in ' . $location_name, 'link' => ''], (object) ['name' => "({$listing_count}+) Listings", 'link' => "",]];
            $listing_title = 'Top ' . ucwords($record->sport) . ' Academies in ' . $location_name;
        } elseif ($record->sport_id == 3) {
            $title = "Cricket Coaching in $location_name - BookMyPlayer";
            $des = "Discover the best cricket coaching near $location_name. Find top-rated cricket academies, professional coaches. Perfect for all ages and skill levels. Practice the game under national level cricket coaches in India.";
            $keywords = "cricket coaching in $location_name, cricket pitches in $location_name, cricket coaching near me, cricket coaches in $location_name, cricket academies in $location_name, cricket pitches $location_name, cricket coaching for kids $location_name, learn cricket in $location_name";
            $breadcrumbs = [(object) ['name' => 'Cricket Coaching in ' . $location_name, 'link' => ''], (object) ['name' => "({$listing_count}+) Listings", 'link' => "",]];
            $listing_title = 'Top ' . ucwords($record->sport) . ' Academies in ' . $location_name;
        } else {
            $title = "Best $sport Classes in $location_name - Book Your $sport Lessons Today";
            $des = "Discover the best $sport classes in $location_name Find top-rated $sport academies, Coaches and players with professional instructors, and convenient locations near you. Perfect for all ages and skill levels. Book your $sport lessons today at BookMyPlayer.";
            $keywords = $record->sport . ' academies near me, ' . $record->sport . ' coaches near me, ' . $record->sport . ' training, ' . $record->sport . ' academies,  ' . $record->sport . ' events, ' . $record->sport . ' community , BookMyPlayer, ' . $record->sport . ' academy near me';
            $breadcrumbs = [(object) ['name' => ucwords($record->sport) . ' Lessons in ' . $location_name, 'link' => ''], (object) ['name' => "({$listing_count}+) Listings", 'link' => "",]];
            $listing_title = 'Learn ' . ucwords($record->sport) . ' in ' . $location_name . '. Find list of Top ' . ucwords($record->sport) . ' Lessons, Teams, Players to play.';
        }

        $data = [
            "title" => $title,
            "des" => $des,
            "keywords" => $keywords,
            "d" => $record,
            "listing_title" => $listing_title,
            "sport_id" => $sport_id,
            "url" => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
            "breadcrumbs" => $breadcrumbs
        ];

        return view('Listings.sdid', compact('data'));
    }

    // Api
    public function show_sdid_api(Request $request)
    {
        $id = $request->input('id');
        $page = (int) $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $type = $request->input('type', 'academy');

        $record = Bmp_sports::where('id', $id)->first();
        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $result = [];
        $totalItems = $counts[$type] ?? 0;
        $lastPage = ceil($totalItems / $perPage);

        if ($type === "academy") {
            $ids = explode(',', $record->academy);
            $paginatedIds = array_slice($ids, $offset, $perPage);
            $result = Bmp_academy_details::whereIn('bmp_academy_details.id', $paginatedIds)
                ->select(
                    'bmp_academy_details.id',
                    'bmp_academy_details.name',
                    'bmp_academy_details.url',
                    'bmp_academy_details.views',
                    'bmp_academy_details.rating',
                    'bmp_academy_details.reviews',
                    'bmp_academy_details.address1',
                    'bmp_academy_details.address2',
                    'bmp_academy_details.city',
                    'bmp_academy_details.timing',
                    'bmp_academy_details.review_highlights',
                    'bmp_academy_details.photos',
                    'bmp_academy_details.url_loc as loc_locality_name',
                    'bmp_academy_details.url_city as loc_city',
                    'bmp_academy_details.state as loc_state',
                    'bmp_academy_details.sport_id',
                    'bmp_academy_details.loc_id',
                    'bmp_academy_details.postcode as loc_postcode',
                    'bmp_academy_details.sport as adm_sport',
                    'bmp_academy_details.lat',
                    'bmp_academy_details.lng'
                )
                ->orderByRaw("FIELD(bmp_academy_details.id, " . implode(',', $paginatedIds) . ")")
                ->get();

            if ($id == 10306) {
                $premiumIds = array_filter(explode(',', $record->premium_academy ?? ''));
                $academyIds = array_filter(explode(',', $record->academy ?? ''));
                $combinedIds = array_merge($premiumIds, $academyIds);
                $paginatedIds = array_slice($combinedIds, $offset, $perPage);
                $result = Bmp_academy_details::whereIn('id', $paginatedIds)
                    ->select(
                        'id',
                        'name',
                        'url',
                        'views',
                        'rating',
                        'reviews',
                        'address1',
                        'address2',
                        'city',
                        'timing',
                        'review_highlights',
                        'photos',
                        'url_loc as loc_locality_name',
                        'url_city as loc_city',
                        'state as loc_state',
                        'sport_id',
                        'loc_id',
                        'postcode as loc_postcode',
                        'sport as adm_sport',
                        'lat',
                        'lng'
                    )
                    ->get();

                $result->each(function ($academy) use ($premiumIds) {
                    $academy->is_premium = in_array($academy->id, $premiumIds);
                });

                $lastPage = ceil(count($combinedIds) / $perPage);
            }
        } elseif ($type === "sdid_backlinks") {
            $limit = 100;
            $academy_bklinks = empty(array_filter(explode(',', $record->academy ?? '')))
                ? collect()
                : Bmp_academy_details::whereIn('id', array_filter(explode(',', $record->academy ?? '')))
                    ->select('name', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', array_filter(explode(',', $record->academy ?? ''))) . ")")
                    ->take($limit)
                    ->get();

            $coach_bklinks = empty(array_filter(explode(',', $record->coach ?? '')))
                ? collect()
                : Bmp_coach_details::whereIn('id', array_filter(explode(',', $record->coach ?? '')))
                    ->select('name', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', array_filter(explode(',', $record->coach ?? ''))) . ")")
                    ->take($limit)
                    ->get();

            $player_bklinks = empty(array_filter(explode(',', $record->player ?? '')))
                ? collect()
                : Bmp_player_details::whereIn('id', array_filter(explode(',', $record->player ?? '')))
                    ->select('name', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', array_filter(explode(',', $record->player ?? ''))) . ")")
                    ->take($limit)
                    ->get();

            $location_bklinks = empty(array_filter(explode(',', $record->location ?? '')))
                ? collect()
                : Bmp_sports::whereIn('id', array_filter(explode(',', $record->location ?? '')))
                    ->select('id', 'locality_name', 'city', 'url_state', 'url')
                    ->orderByRaw("FIELD(id, " . implode(',', array_filter(explode(',', $record->location ?? ''))) . ")")
                    ->take($limit)
                    ->get();
            $result = ["location_backlinks" => $location_bklinks, "academy_backlinks" => $academy_bklinks, "coach_backlinks" => $coach_bklinks, "player_backlinks" => $player_bklinks];
        } elseif ($type === "premium_academy") {
            $ids = explode(',', $record->premium_academy);
            $paginatedIds = array_slice($ids, $offset, $perPage);
            $result = Bmp_academy_details::whereIn('bmp_academy_details.id', $paginatedIds)
                ->select(
                    'bmp_academy_details.id',
                    'bmp_academy_details.name',
                    'bmp_academy_details.url',
                    'bmp_academy_details.views',
                    'bmp_academy_details.rating',
                    'bmp_academy_details.reviews',
                    'bmp_academy_details.address1',
                    'bmp_academy_details.address2',
                    'bmp_academy_details.city',
                    'bmp_academy_details.timing',
                    'bmp_academy_details.review_highlights',
                    'bmp_academy_details.photos',
                    'bmp_academy_details.url_loc as loc_locality_name',
                    'bmp_academy_details.url_city as loc_city',
                    'bmp_academy_details.state as loc_state',
                    'bmp_academy_details.sport_id',
                    'bmp_academy_details.loc_id',
                    'bmp_academy_details.postcode as loc_postcode',
                    'bmp_academy_details.sport as adm_sport',
                    'bmp_academy_details.lat',
                    'bmp_academy_details.lng'
                )
                ->get();
        } elseif ($type === "coach") {
            $ids = explode(',', $record->coach);
            $paginatedIds = array_slice($ids, $offset, $perPage);
            $result = Bmp_coach_details::leftJoin('adm_location_master', 'bmp_coach_details.loc_id', '=', 'adm_location_master.id')
                ->whereIn('bmp_coach_details.id', $paginatedIds)
                ->select(
                    'bmp_coach_details.*',
                    'adm_location_master.locality_name as loc_locality_name',
                    'adm_location_master.city as loc_city',
                    'adm_location_master.state as loc_state'
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
                    'adm_sports_master.sport as adm_sport'
                )
                ->get();
        } elseif ($type === "location") {
            $ids = explode(',', $record->location);
            $record = Bmp_sports::whereIn('id', $ids)->select('id', 'locality_name', 'city', 'url_state', 'url')->get();
        } elseif ($type === "counts") {
            return response()->json([
                'data' => [
                    "counts" => [
                        'academy' => !empty($record->academy) ? count(explode(',', $record->academy)) : 0,
                        'coach' => !empty($record->coach) ? count(explode(',', $record->coach)) : 0,
                        'player' => !empty($record->player) ? count(explode(',', $record->player)) : 0,
                        'location' => !empty($record->location) ? count(explode(',', $record->location)) : 0
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

    // Handeling Redirec
    public function handle_redirect(Request $request, $sport_id, $lat, $lng)
    {
        $data = DB::select("
          SELECT
              *,
              ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance
          FROM bmp_sports
          WHERE type = 'listing' AND sport_id = $sport_id AND lat is not null AND lng is not null
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
