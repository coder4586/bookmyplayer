<?php

namespace App\Http\Controllers\Academy;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;
use App\Models\Bmp_sports;
use App\Models\Adm_location_master;
use App\Models\Adm_sports_master;
use App\Models\Bmp_academy_details;
use App\Models\Bmp_reviews;
use App\Models\Bmp_sport_faq;
use App\Models\Bmp_certifications;
use App\Models\Bmp_league_details;
use App\Models\Bmp_about;
use App\Models\Bmp_gym_details;
use App\Models\Bmp_review_details;
use Carbon\Carbon;



class academy_details extends BaseController
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


  public function show_academy(Request $request, $sport, $name, $id)
  {
    $url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
    $agent = new Agent();
    $mobile = $agent->isMobile();
    $d = Bmp_academy_details::find($id);

    if (!$d) {
      return redirecturl($request->getRequestUri(), $sport);
    }

    DB::table('bmp_academy_details')->where('id', $id)->increment('views', 1);
    $sport_byid = Adm_sports_master::find($d->sport_id);
    $sport = $d->sport_id ? $sport_byid->name : 'sports';

    $location = Bmp_sports::where('sport_id', $d->sport_id)
      ->where(function ($query) use ($d) {
        $query->where('loc_id', $d->loc_id)
          ->orWhere('loc_id', $d->city_id);
      })
      ->first();
    if ($d->loc_id_other) {
      $location = Adm_location_master::find($d->loc_id);
    }

    $nearby_serving_location = [];
    if (!empty($d->loc_id_other)) {
      $nearby_serving_location = Adm_location_master::whereIn('id', explode(',', $d->loc_id_other))
        ->select('locality_name', 'url')
        ->orderBy('views', 'desc')
        ->get();
    }

    $breadcrumbs = [];
    $totalReviews = Bmp_reviews::where('object_id', $id)->where('status', 1)->count();
    $photos = explode(',', $d->photos);
    $videos = explode(',', $d->videos);
    $first_banner_img = null;
    $fee = $d->fee;
    $address = implode(', ', array_filter([$d->address1, $d->address2, $d->city, $d->state, $d->postcode]));
    $review_page = Bmp_review_details::where("object_id", $id)->where("object_type", "a")->select("url")->first();

    //  Breadcrumbs Handeling Start
    if (!$location) {
      $breadcrumbs = [
        (object) [
          'name' => "{$sport_byid->name} in India",
          'link' => "https://www.bookmyplayer.com/"
        ]
      ];
    } else {
      $location_name = $location->locality_name;

      if ($location->city_id != 0 && $location->city !== $location->locality_name) {
        $location_name .= ', ' . $location->city;
      }

      if ($location->state !== $location->locality_name && $location->state !== $location->city) {
        $location_name .= ', ' . $location->state;
      }

      if ($sport == 'gym') {
        $breadcrumbs = [
          (object) [
            'name' => "List of {$sport_byid->name} in " . $location_name,
            'link' => $location->url
          ]
        ];
      } else {
        $classes_coaching = ($d->sport_id == 3) ? 'Coaching' : 'Classes';

        $breadcrumbs = [
          (object) [
            'name' => ($sport_byid?->name ?? 'Sport') . " $classes_coaching in " . ($location_name ?? 'India'),
            'link' => $location?->url ?? 'https://www.bookmyplayer.com/'
          ]
        ];
      }
    }
    $breadcrumbs[] = (object) ['name' => $d->name . (!empty($location->city) ? ', ' . $location->city : ''), 'link' => ''];

    if ($totalReviews > 0) {
      $breadcrumbs[] = (object) ['name' => "{$totalReviews} " . ($totalReviews == 1 ? 'Review' : 'Reviews'), 'link' => ''];
    }
    //  Breadcrumbs Handeling End

    if ($sport == 'gym') {
      $title = ucwords($d->name) . " : " . ucwords($sport) . " & Fitness Center in " . ($d->address2 ? $d->address2 . ", " : "") . $d->city;
      $des = 'Discover your best fit at ' . $d->name . ' ' . $d->city . '! State-of-the-art facilities, 24/7 access, and a supportive community in ' . $d->state . '. Start today!';
      $keywords = $d->name . ' ' . $d->city . ', Gym in ' . $d->city . ', Fitness Center in ' . $d->address2 . ' ' . $d->city . ', 24/7 Gym near me, Health Club ' . $d->city . ', Best gym in ' . $d->city . ', Fitness Membership ' . $d->city . ', Gym with Personal Trainer in ' . $d->city;
    } else {
      $title = ucwords($d->name) . " | " . ($d->address2 ? $d->address2 . ", " : "") . $d->city;
      $des = $d->name . ' ' . $sport . ' coaching and training in ' . ($d->address2 ? $d->address2 . ", " : "") . $d->city . '. Find fee, charges, timings, reviews, photos, ratings and contact number. Book coaching classes. Join training schedule & timings with free trial.';
      $keywords = "What is the coaching fee of " . $d->name . ", how much does it cost and how to join " . $d->name . ", batch timings for joining " . $d->name . " fee, batches for " . $d->name . ", Best academy for playing " . $sport;
    }

    //  Photo Handeling Start
    $banners = $photos;
    $json_ld = [];
    $photo_object = [];
    $video_object = [];
    function checkImageExists($url)
    {
        $response = Http::head($url);
            if ($response->successful()) {
            return true;
        }
    
        // If status is not 200, return false
        return false;
    }

    $is_banner_set = false;
    $banner_img = $d->banner;
    if ($banner_img && in_array($banner_img, $banners)) {
      if (checkImageExists(env('AWS_S3_BASE_URL_70') . "/academy/{$id}/{$banner_img}")) {
        $banners = array_diff($banners, [$banner_img]);
        array_unshift($banners, $banner_img);
        $is_banner_set = true;
      }
    }

    foreach ($banners as $key => $photo) {
      $external_link = env('AWS_S3_BASE_URL_70') . "/academy/{$id}/{$photo}";
      // $is_first_banner_link = env('AWS_S3_BASE_URL_70') . "/academy/{$id}/{$photo}";
      // if (checkImageExists($is_first_banner_link)) {
      //   $first_banner_img = $banners[$key];
      // }
      // if (!checkImageExists($external_link)) {
      //   unset($banners[$key]);
      // }
      // if (checkImageExists($external_link)) {
        $photo_object[] = [
          "@context" => "https://schema.org/",
          "@type" => "ImageObject",
          "contentUrl" => $external_link,
          "license" => "https://www.bookmyplayer.com/terms",
          "acquireLicensePage" => "https://www.bookmyplayer.com/terms",
          "creditText" => "BookMyPlayer",
          "creator" => [
            "@type" => "Organization",
            "name" => "BookMyPlayer"
          ],
          "copyrightNotice" => "BookMyPlayer"
        ];
      // }
    }

    foreach ($videos as $key => $video) {
      $external_link = env('AWS_S3_BASE_URL_70') . "https://f005.backblazeb2.com/file/bmpcdn90original/academy/{$id}/{$video}";
      // if (!checkImageExists($external_link)) {
      //   unset($videos[$key]);
      // }

      // if (checkImageExists($external_link)) {
        $video_object[] = [
          "@context" => "https://schema.org/",
          "@type" => "VideoObject",
          "contentUrl" => $external_link,
          "name" => $d->name,
          "description" => $des,
          "thumbnailUrl" => "https://d146zb2foqhwdd.cloudfront.net/asset/images/logo.svg",
          "uploadDate" => date('Y-m-d\TH:i:s+05:30', strtotime($d->creation_date) + 19800),
          "license" => "https://www.bookmyplayer.com/terms",
          "acquireLicensePage" => "https://www.bookmyplayer.com/terms",
          "creditText" => "BookMyPlayer",
          "creator" => [
            "@type" => "Organization",
            "name" => "BookMyPlayer"
          ],
          "copyrightNotice" => "BookMyPlayer"
        ];
      // }
    }

    // $json_ld = json_encode($photo_object, JSON_UNESCAPED_SLASHES);
    $json_ld = json_encode(array_merge($photo_object, $video_object), JSON_UNESCAPED_SLASHES);


    $banners = array_values($banners);
    $videos = array_values($videos);
    $photos = $banners;
    //  Photo Handeling End

    // Banner and Logo Handeling Start
    if ($d->banner != null && $d->banner != "") {
      $banner = env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->banner}";
    } elseif (count(array_filter($photos)) > 0) {
      $banner = env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$photos[0]}";
    } else {
      $banner = env('AWS_S3_BASE_URL') . "/default/" . strtolower($sport) . "_banner.webp";
    }
    $logo = (is_null($d->logo) || $d->logo === "")
      ? env('AWS_S3_BASE_URL') . "/asset/images/logo.svg"
      : (checkImageExists(env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->logo}")
        ? env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->logo}"
        : env('AWS_S3_BASE_URL') . "/asset/images/logo.svg");
    // Banner and Logo Handeling End

    $data = array(
      "cattype" => 'aid',
      "title" => $title,
      "des" => $des,
      "keywords" => $keywords,
      "d" => $d, // 1
      "sport" => $sport,
      "fee" => $fee,
      "url" => $url,
      "nearby_serving_location" => $nearby_serving_location,
      "totalReviews" => $totalReviews,
      "listingTitle" => $d->name,
      "address" => str_replace([',,'], [','], $address),
      "banner" => $banner,
      "logo" => $logo,
      "banners" => $banners,
      "is_banner_set" => $is_banner_set,
      "first_banner_img" => $first_banner_img,
      'videos' => array_reverse($videos),
      "id" => $id,
      "reviewPageUrl" => $review_page ? $review_page->url : null,
      "json_ld" => $json_ld,
      "breadcrumbs" => $breadcrumbs,
      "object_type" => 'academy',
    );
    return view('academy.academy_details', compact('data'));
  }

  // Api - academy details
  public function getAdditionalInfo(Request $request)
  {
    try {
      $id = $request->input('id');
      $type = $request->input('type', 'reviews');
      $page = $request->input('page', 1);

      $nearbyacademies = $photos = $videos = $faqs = $schools = $tournaments = $certificates = $reviews = $highlights = $positive = $negative = $neutral = $otherLocalities = $about = [];
      $review_summary = $totalReviews = "";

      if (!$id) {
        return $request->ajax()
          ? response()->json(['status' => 0, 'message' => 'id is required'])
          : null;
      }

      $d = DB::table('bmp_academy_details')->where('id', $id)->first();

      if (!$d) {
        return $request->ajax()
          ? response()->json(['status' => 0, 'message' => 'no data found'])
          : null;
      }

      $sport_byid = Adm_sports_master::find($d->sport_id);
      $sport = $d->sport_id ? $sport_byid->name : 'sports';
      $about = $d->about;
      $photos = explode(',', $d->photos);
      $videos = explode(',', $d->videos);
      $first_banner_img = null;
      $perPage = 10;
      $skip = ($page - 1) * $perPage;

      if ($type == "nearbyacademies") {
        $nearbyacademies = $d->lat && $d->lng
          ? getNearbyAcademy('bmp_academy_details', $d->lat, $d->lng, 50, 5, ['bmp_academy_details.sport' => $sport], 'rating', 'desc')
          : [];
        foreach ($nearbyacademies as &$academy) {
          unset($academy->phone);
        }
      } elseif ($type == "media") {
        $banners = $photos;
        foreach ($banners as $key => $photo) {
          $external_link = env('AWS_S3_BASE_URL_70') . "/academy/{$id}/{$photo}";
          $is_first_banner_link = env('AWS_S3_BASE_URL_70') . "/academy/{$id}/{$photo}";
          if (Http::head($is_first_banner_link)->successful()) {
            $first_banner_img = $banners[$key];
          }
          if (!Http::head($external_link)->successful()) {
            unset($banners[$key]);
          }
        }
        foreach ($videos as $key => $video) {
          $external_link = env('AWS_S3_BASE_URL_70') . "/academy/{$id}/{$video}";
          if (!Http::head($external_link)->successful()) {
            unset($videos[$key]);
          }
        }
        $photos = array_values($banners);
        $videos = array_values($videos);
      } elseif ($type == "faqs") {
        $faqs = Bmp_sport_faq::where('sport_id', $d->sport_id)->take(10)->get();
      } elseif ($type == "tables") {
        $tournaments = Bmp_league_details::where('sport_id', $d->sport_id)->take(10)->get();
        $certificates = Bmp_certifications::where('sport_id', $d->sport_id)->take(10)->get();
      } elseif ($type == 'about') {
        if (empty($about) || strlen($about) < 500) {
          $defaultabout = Bmp_about::where('sport_id', $d->sport_id)->where('object', '1')->first();
          if ($defaultabout) {
            $replacedAbout = str_replace(['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'], [$d->name, $d->city, $d->address2], $defaultabout->about);
            $about = empty($about) ? $replacedAbout : $about . "</br></br><b><u> Further information about the Academy: </b></u></br>" . $replacedAbout;
          }
        } else {
          $about = $d->about;
        }
      } elseif ($type == "reviews") {

        $totalReviews = Bmp_reviews::where('object_id', $id)
          ->where('status', 1)
          ->count();

        $reviews = Bmp_reviews::where('object_id', $id)
          ->where('status', 1)
          ->orderBy('creation_date', 'desc')
          ->skip($skip)
          ->take($perPage)
          ->get()
          ->map(function ($review) {
            if ($review->creation_date) {
              $review->creation_date = Carbon::parse($review->creation_date)->format('d F Y');
            } else {
              $review->creation_date = Carbon::now()->format('d F Y');
            }

            return $review;
          });
      } elseif ($type == "ai_reviews") {
        $review_summary = explode('$', $d->review_summary);
        $highlights = explode('|', $d->review_highlights);
        foreach ($highlights as $highlight) {
          if (strpos($highlight, ':') !== false) {
            [$key, $value] = explode(':', $highlight);
            ${$key} = strpos($value, ',') !== false ? array_merge(${$key}, explode(',', $value)) : array_merge(${$key}, [$value]);
          }
        }
      } elseif ($type == "otherLocalities") {
        $city_id = $d->city_id == 0 ? $d->loc_id : $d->city_id;
        $otherLocalities = Bmp_sports::where('sport_id', $d->sport_id)->where('city_id', $city_id)->where('type', 'listing')->orderBy('views', 'desc')->take(25)->select('views', 'url', 'locality_name', 'city', 'sport')->get();
      }

      if ($request->ajax()) {
        return response()->json([
          'status' => 1,
          'message' => 'Data loaded successfully',
          'photos' => array_reverse($photos),
          'videos' => array_reverse($videos),
          'faqs' => $faqs,
          'schools' => $schools,
          'tournaments' => $tournaments,
          'certificates' => $certificates,
          'reviews' => $reviews,
          'reviewCount' => $totalReviews,
          'positive' => $positive,
          'negative' => $negative,
          'neutral' => $neutral,
          'about' => $about,
          'otherLocalities' => $otherLocalities,
          'nearbyacademies' => $nearbyacademies,
          'review_summary' => $review_summary,
        ]);
      }
    } catch (Exception $e) {
      if ($request->ajax()) {
        return response()->json(['status' => 0, 'message' => 'An error occurred while processing your request.']);
      }
    }
  }

  // api - gym details
  public function getAdditionalInfoGym(Request $request)
  {
    try {
      $id = $request->input('id');
      if (!$id) {
        return response()->json(['status' => 0, 'message' => 'id is required']);
      }


      $academy = Bmp_academy_details::where("id", $id)->select('id', 'sport_id')->first();

      if (!$academy || $academy->sport_id != 31) {
        return response()->json(['status' => 0, 'message' => 'Invalid gym id']);
      }

      $d = Bmp_gym_details::where("academy_id", $id)->first();
      if (!$d) {
        return response()->json(['status' => 0, 'message' => 'No data found for this gym',]);
      }

      if ($request->ajax()) {
        return response()->json([
          'status' => 1,
          'message' => 'Data loaded successfully',
          'data' => $d
        ]);
      }

    } catch (Exception $e) {
      return response()->json(['status' => 0, 'message' => 'An error occurred while processing your request.']);
    }
  }


}
