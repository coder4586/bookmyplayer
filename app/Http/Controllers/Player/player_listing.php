<?php
namespace App\Http\Controllers\Player;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Adm_sports_master;
use App\Models\Adm_location_master;
use App\Models\Bmp_player_listing;
use App\Models\Bmp_player_details;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;


class player_listing extends BaseController
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

    public function player_listing(Request $request, $name, $id)
    {
        $page = $request->input('page', 1); // Get the page number from the request, default to 1 if not provided
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $d = Bmp_player_listing::find($id);
        if (!$d) {
            return redirectUrl($request->getRequestUri(), null);
        }


        DB::table('bmp_player_listing')->where('id', $id)->increment('views', 1);
        $sport = Adm_sports_master::find($d->sport_id);
        $location = Adm_location_master::find($d->loc_id);

        if ($d->loc_id == 0 || !$location) {
            $location = (object) [
                'locality_name' => 'India',
                'state' => ''
            ];
            $coachesQuery = Bmp_player_details::where('sport_id', $d->sport_id)
                ->orderBy('id', 'desc');
            $nearbylocations = [];
        } else {
            $latitude = $location->lat;
            $longitude = $location->lng;
            $nearbyLocationIds = DB::table('adm_location_master')
                ->select('id', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(lat)))) AS distance'))
                ->having('distance', '<', 10)
                ->orderBy('distance')
                ->pluck('id')
                ->toArray();
            $coachesQuery = Bmp_player_details::where('sport_id', $d->sport_id)
                ->whereIn('loc_id', $nearbyLocationIds)
                ->orderBy('id', 'desc');
            $nearbylocations = DB::table('bmp_player_listing')
                ->select('id', 'location', 'url', DB::raw('(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(lat)))) AS distance'))
                ->where('loc_id', '!=', 0)
                ->where('sport_id', '=', $d->sport_id)
                ->having('distance', '<', 3)
                ->orderBy('distance')
                ->get()
                ->toArray();
        }

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

        $breadcrumbs = [
            (object) [
                'name' => ($sport?->name ?? 'Sport') . ' Player in ' . ($location?->locality_name ?? 'India') .
                    (($location?->locality_name ?? '') === ($location?->city ?? '') ? ', ' . ($location?->state ?? '') : ', ' . ($location?->city ?? '')),
                'link' => ""
            ]
        ];


        $data = array(
            "breadcrumbs" => $breadcrumbs,
            'title' => 'Top ' . ($sport?->name ?? 'Sport') . ' Players in ' . ($location?->locality_name ?? 'India') .
                (($location?->locality_name ?? '') === ($location?->city ?? '') ? ', ' . ($location?->state ?? '') : ', ' . ($location?->city ?? '')),
            'des' => 'Find top ' . ($sport?->name ?? 'Sport') . ' Players in ' . ($location?->locality_name ?? 'India') . '. Connect and grow your team. Arrange Sport events, grow players into coaches.',
            'url' => 'https://www.bookmyplayer.com' . $request->getRequestUri(),
            "totalcoaches" => $totalCoaches,
            'pagination' => $pagination,
            'coaches' => $coaches,
            'd' => $d,
            'sport' => $sport,
            'location' => $location,
            'nearbylocations' => $nearbylocations
        );

        if ($request->ajax()) {
            return response()->json([
                'd' => $coaches,
                'hasMoreRecords' => $hasMoreRecords,
                'pagination' => $pagination,
                'coaches' => $coaches
            ]);
        }

        return view("player.player_listing")->with([
            'data' => $data,
        ]);
    }
}
