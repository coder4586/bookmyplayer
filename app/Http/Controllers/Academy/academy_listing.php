<?php
namespace App\Http\Controllers\Academy;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;


class academy_listing extends BaseController
{
 protected function getDeviceType()
 {
   $agent = new Agent();
   if ($agent->isMobile()) {return 'm';}
   elseif ($agent->isTablet()) {return 't';}
   else {return 'd';}
 }

 use AuthorizesRequests, ValidatesRequests;

 public function show_sport_listing(Request $request, $name, $id){
    $url              = 'https://www.bookmyplayer.com'.$request->getRequestUri();
    if (is_numeric($id) && $id >= 50){return $this->sport_list($request, $id, $url);}
    else {return $this->core_sport_list($request, $id, $url);}
  }

  public function sport_list(Request $request, $id, $url){
    $record = get_data_row(NULL, 'bmp_sports', 'id', $id);
    if(!$record){
      return redirecturl($request->getRequestUri());
    }

    $d = getNearbyAcademy_vi('lat_bmp_academy_details',$record->lat, $record->lng, 200, 300,$record->sport);
    $otherLocalities  = get_data_array(NULL, 'bmp_sports', 'city', $record->city,"sport", $record->sport, 'id', 'desc',150);
    $sport  = [];

    $localityName = ucwords($record->locality_name);
    $cityName = ucwords($record->city);
    $sportName = ucwords($record->sport);
    $city = (strtolower($record->locality_name) !== strtolower($record->city)) ? $record->locality_name . ", " . $record->city : $record->locality_name;
    $localityAndCity = ucwords($record->locality_name) . ($record->locality_name != $record->city ? ', ' . ucwords($record->city) : '');
    $titleSuffix = $record->sport == 'swimming' ? "{$record->sport} in {$localityAndCity}" : "{$record->sport} Academies in {$localityAndCity}";
    $title = ucwords($titleSuffix) . " | BookMyPlayer";
    $des = "Find " . ucwords($record->sport) . " Academies in " . ucwords($record->locality_name) . ($record->locality_name != $record->city ? ", {$record->city}" : "") . ". Details of Academy rating, reviews, charges, timings, joining details, distance, women and kids friendly options. Batch timings and other details. Find " . ucwords($record->sport) . " academies near to you.";

    $data = array(
      "title"         => $title,
      'des'           => $des,
      "url"           => 'https://www.bookmyplayer.com'.$request->getRequestUri(),
      "d"             => $d,
      "record"        => $record,
      "sports"        => $sport,
      "city"          => $city,
      "otherLocalities"=>$otherLocalities,
      "topAcademies"  => [],
      "page"          => 'sdid_sport',
      "template"      => "sdid_sport"
    );
    return view('common_template', compact('data'));
  }


  public function core_sport_list(Request $request, $id, $url){
    $record = get_data_row(NULL, 'bmp_sports', 'id', $id);
    if(!$record){
      return redirecturl($request->getRequestUri());
    }
    $conditions = [
      'bmp_academy_details.sport' =>$record->sport// specify the table alias for the sport column
    ];

    $d = get_data_array(NULL,'bmp_academy_details','sport', $record->sport,null,null,'views','desc',300);
    $otherLocalities  = get_data_array(NULL, 'bmp_sports', 'subtype','city','sport',$record->sport);
    $sport = get_data_array(NULL, 'bmp_sports', 'type', 'core');

    $localityName = ucwords($record->locality_name);
    $cityName = ucwords($record->city);
    $sportName = ucwords($record->sport);

    if ($record->sport == 'gym') {
      $title = "Find Top 10 Gym & Fitness Center in India - BookMyPlayer";
      $des = 'Discover your best fit gym and professional persoanl trainers. State-of-the-art facilities, 24/7 access, and a supportive community in Start today!';
      $keywords = 'Top Gym in India, Fitness Center near you, 24/7 Gym near me, Health Club, Best gym in my city, Fitness Membership, Gym with Personal Trainer';
      } else {
        $title 		        = 'Top '.$record->sport.' Academies & Coaches Near You - BookMyPlayer';
        $des 				      = 'Discover best '.$record->sport.' academies, coaches near you. Find list of top academies with reviews, rating, photos, price, charges, contact number, location, schedule, timings, with address.';
        $keywords 	      = $record->sport.' academies near me, '.$record->sport.' coaches near me, '.$record->sport.' training, '.$record->sport.' academies,  '.$record->sport.' events, '.$record->sport.' community , BookMyPlayer, '.$record->sport.' academy near me';
      }

    $data = array(
      "title"         => $title,
      'des'           => $des,
      "keywords"       => $keywords,
      "url"           => 'https://www.bookmyplayer.com'.$request->getRequestUri(),
      "d"             => $d,
      "record"        => $record,
      "sports"        => $sport,
      "city"          => "India",
      "otherLocalities"=>$otherLocalities,
      "topAcademies"  => [],
      "page"          => 'sdid_sport',
      "template"      => "sdid_sport"
    );
    return view('common_template', compact('data'));
  }

  public function show_city_listing(Request $request, $city, $name, $id){
    $record           = get_data_row(null,'bmp_states','id',$id);
    $d                = getNearbyAcademy_vg('lat_bmp_academy_details',$record->lat, $record->lng, 60, 300);
    $city             = (strtolower($record->locality_name) !== strtolower($record->city)) ? $record->locality_name . ", " . $record->city : $record->locality_name;
    $otherLocalities  = get_data_array(NULL, 'bmp_states', 'city', $record->city,null, null, 'views', 'desc',150);
    $gyms             = [];
    $nonGyms          = [];
    $sports           = [];
    createLog($id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType());
    $topAcademies = array_slice($d, 0, 10);

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

    if ($record->type=='city'){
      $title='Top Sports Coaching in '.ucfirst($record->city).', '.ucfirst($record->state).' | BookMyPlayer';
      $des='Find Top Coaches, Academies for Sports training in '.$record->city.', '.$record->state.'. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports academies and coaches.';
    }else {
      $title='Top Sports Coaching in '.ucfirst($record->locality_name).', '.ucfirst($record->city).' | BookMyPlayer';
      $des='Find Top Coaches, Academies for Sports training in '.$record->locality_name.', '.$record->city.'. Kids and Women friendly swimming Pools, badminton courts, football grounds, basketball, cricket, tennis and other top sports academies and coaches.';
    }


    $data = array(
      "title"         => $title,
      'des'           => $des,
      "url"           => 'https://www.bookmyplayer.com'.$request->getRequestUri(),
      "d"             => $d,
      "record"        => $record,
      "sports"        => $sports,
      "city"          => $city,
      "otherLocalities"=>$otherLocalities,
      "topAcademies"  => $topAcademies,
      "page"          => 'sdid_locality',
      "template"      => "sdid_locality"
    );
    return view('common_template', compact('data'));
  }

  public function show_nearby_academy_listing(Request $request, $lat, $lng) {
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
      createLog($data[0]->id, $request->ip(), $data[0]->url, URL::previous(), $this->getDeviceType(),$lat . ',' . $lng, $data[0]->lat . ',' . $data[0]->lng);
        return redirect($data[0]->url);
    } else {
        return redirect('/');
    }
}

}
