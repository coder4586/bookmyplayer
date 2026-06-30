<?php
namespace App\Http\Controllers\Tournament;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Bmp_league_details;
use App\Models\Bmp_leads_league;
use App\Models\Bmp_users;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


class tournament_details extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function show_tournament_details(Request $request, $sport, $name, $id)
    {

        $d = Bmp_league_details::find($id);
        if (!$d) {
            return redirectUrl($request->getRequestUri(), null);
        }

        DB::table('bmp_league_details')->where('id', $id)->increment('views', 1);
        $rules = explode('$$', $d->rules);
        $advantages = explode('$$', $d->advantages);
        $subTournaments = json_decode($d->sub_tournament ?? '[]', true);


        $breadcrumbs = [
            (object) [
                'name' => ($d->name ?? 'League'),
                'link' => ''
            ]
        ];

        $data = array(
            "title" => "Tournament - " . $d->name,
            "des" => $d->name,
            "url" => URL::current(),
            "d" => $d,
            "rules" => $rules,
            "subTournaments" => $subTournaments,
            "advantages" => $advantages,
            "breadcrumbs" => $breadcrumbs,
        );

        return view("tournament.tournament_display")->with('data', $data);
    }

    // Old scid pages route
    public function old_show_tournament_details(Request $request, $name, $id)
    {

        $d = Bmp_league_details::find($id);
        if (!$d) {
            return redirectUrl($request->getRequestUri(), null);
        }

        $rules = explode('$$', $d->rules);
        $advantages = explode('$$', $d->advantages);
        $subTournaments = json_decode($d->sub_tournament ?? '[]', true);


        $breadcrumbs = [
            (object) [
                'name' => ($d->name ?? 'League'),
                'link' => ''
            ]
        ];

        $data = array(
            "title" => "Tournament - " . $d->name,
            "des" => $d->name,
            "url" => URL::current(),
            "d" => $d,
            "rules" => $rules,
            "subTournaments" => $subTournaments,
            "advantages" => $advantages,
            "breadcrumbs" => $breadcrumbs,
        );

        return view("tournament.tournament_display")->with('data', $data);
    }

    public function create_lead(Request $request)
    {
        try {
            $league_id = $request->input('league_id');
            $name = $request->input('name');
            $phone = $request->input('phone');
            $description = $request->input('description');
            $email = $request->input('email');
            $address = $request->input('address');
            $source = $request->input('source');

            $isLeagueExists = Bmp_league_details::where('id', $league_id)->first();

            if (!$isLeagueExists) {
                return response()->json(['status' => 0, 'message' => 'League does not exist'], 404);
            }
            $sport = $isLeagueExists->sport;
            $user = Bmp_users::where('id', $isLeagueExists->user_id)->first();
            if (!$user) {
                return response()->json(['status' => 0, 'message' => 'User does not exist'], 404);
            }

            $userName = $user->name;

            $newLead = new Bmp_leads_league();
            $newLead->league_id = $league_id;
            $newLead->name = $name;
            $newLead->phone = $phone;
            $newLead->description = $description;
            $newLead->email = $email;
            $newLead->address = $address;
            $newLead->source = $source;
            $newLead->refer = url()->previous();
            $newLead->ip = $request->ip();
            $newLead->browser = strtolower($request->server('HTTP_USER_AGENT'));
            $newLead->save();

            $leadSport = "Soccer";
            $leadCity = "New York";
            $response = Http::get('https://kapi.omni-channel.in/fe/api/v1/send', [
                'username' => 'bookplayer.trans',
                'password' => 'iBjzv',
                'unicode' => 'false',
                'from' => 'BMPLYR',
                'to' => $user->phone,
                'text' => "Hello $userName. You have a new lead assigned. Name: $name. Sport: $sport. Location: $leadCity. Please login to your account to respond. Login: https://www.bookmyplayer.com/login",
                'dltPrincipalEntityId' => '1701170598958918686',
                'dltContentId' => '1707172544729048801'
            ]);

            return response()->json(['status' => 1, 'message' => 'Lead inserted successfully', 'lead' => $newLead], 201);

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'error' => $e->getMessage()], 500);
        }
    }

}
