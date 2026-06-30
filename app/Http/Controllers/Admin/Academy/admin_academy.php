<?php

namespace App\Http\Controllers\Admin\Academy;
use Intervention\Image\ImageManagerStatic as Image;
use App\Services\B2Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\Adm_sports_master;
use App\Models\Adm_location_master;
use App\Models\Adm_support_ticket;
use App\Models\Adm_lead_assignment;
use App\Models\Bmp_review_coaches;
use App\Models\Bmp_gym_details;
use App\Models\Adm_orders;
use App\Models\Xx_log;
use App\Models\Bmp_notifications;
use App\Models\Bmp_academy_details;
use App\Models\Bmp_academy_details_temp;


class admin_academy extends BaseController
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


  public function show_academy_admin(Request $request, $id)
  {
    [$auth, $user] = authenticate(2);
    if (!$auth) {
      return redirect('/');
    }

    $id = $user->parent_id;
    $academy_model = ($user->parent_tbl == 1) ? Bmp_academy_details::class : Bmp_academy_details_temp::class;
    $pin = $user->pin;


    $d = $academy_model::find($id);

    $email_verified = DB::table('xx_emails')->where('email', $user->email)->where('type', 'verify-email')->where('email_verified', '1')->count();
    $folder = $user->parent_tbl == 0 ? "academy_temp" : "academy";
    $sport = isset($d->sport_id) ? Adm_sports_master::find($d->sport_id) : [];
    $locality = isset($d->loc_id) ? Adm_location_master::find($d->loc_id) : [];
    $notifications = Bmp_notifications::where('user_id', $user->id)->orderBy('id', 'asc')->get();
    $plans = Adm_orders::where('user_id', $user->id)->orderBy('id', 'desc')->get();
    $current_plan = $plans->isNotEmpty() ? $plans->first()->plan_id : null;
    $fee = isset($d->fee) ? array_filter(explode(",", $d->fee), 'strlen') : [];
    $log = Xx_log::where('attr1', $user->id)->whereIn('attr6', ['signup: success', 'login: logged in'])->orderBy('id', 'desc')->first();
    $last_login = $log ? Carbon::parse($log->creation_date)->diffForHumans() : "-";
    $spoken_languages = isset($d->spoken_languages) ? array_filter(explode(",", $d->spoken_languages), 'strlen') : [];
    $reviews = $user->parent_tbl == 1 ? Bmp_review_coaches::where('object_id', $id)->get() : [];
    $logo = isset($d) && $d->logo
      ? env('AWS_S3_BASE_URL') . "/{$folder}/{$d->id}/{$d->logo}"
      : env('AWS_S3_BASE_URL') . "/asset/images/register-image.jpg";

    $address = $locality ? $locality->locality_name . ", " . $locality->state : null;
    $loc_id_other_localities = isset($d->loc_id_other)
      ? Adm_location_master::whereIn('id', array_filter(explode(',', $d->loc_id_other)))->select('id', 'locality_name')->get()
      : collect();  // Return an empty collection if $d->loc_id_other is null
    $leads = $user->parent_tbl !== 0 ? Adm_lead_assignment::join('master.bmp_leads', 'adm_lead_assignment.lead_id', '=', 'bmp_leads.id')->leftJoin('master.adm_location_master', 'bmp_leads.loc_id', '=', 'master.adm_location_master.id')->select('adm_lead_assignment.id as assignment_id', 'adm_lead_assignment.*', 'bmp_leads.*', 'master.adm_location_master.locality_name')->where('adm_lead_assignment.academy_id', $user->parent_id)->get() : [];
    $ticket = Adm_support_ticket::where("user_id", $user->id)->get();
    $gym = $d->sport_id == 31 ? Bmp_gym_details::where('academy_id', $id)->first() : [];
    $breadcrumbs = [(object) ['name' => "Dashboard", 'link' => ""], (object) ['name' => $d->name, 'link' => ""]];
    $city_id = $locality ? ($locality->city_id == 0 ? $locality->id : $locality->city_id) : 0;
    $city_leads = DB::selectOne("SELECT COUNT(*) as lead_count FROM bmp_leads JOIN adm_location_master alm ON bmp_leads.loc_id = alm.id WHERE bmp_leads.sport_id = ? AND (alm.id = ? OR (alm.city_id = ? AND alm.city_id != 0)) AND bmp_leads.creation_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)", [$d->sport_id, $city_id, $city_id, 30]);
    $base_url = env('AWS_S3_BASE_URL') . "/{$folder}/{$d->id}/";
    $photos = $d->photos ? array_map(function ($photo) use ($base_url) {
      return $base_url . $photo;
    }, array_filter(explode(",", $d->photos), 'strlen')) : [];
    $videos = $d->videos ? array_map(function ($video) use ($base_url) {
      return $base_url . $video;
    }, array_filter(explode(",", $d->videos), 'strlen')) : [];

    $completion_percent = ["fee" => min(100, count($fee) * 25), "photos" => min(100, count($photos) * 20), "video" => min(100, count($videos) * 20)];
    $overall_percent = intval(array_sum($completion_percent) / count($completion_percent));
    $data = array(
      "title" => "bookmyplayer - dashboard",
      "des" => "",
      "url" => URL::current(),
      "logo" => $logo,
      "last_login" => $last_login,
      "city_leads" => $city_leads,
      "d" => $d,
      "address" => $address,
      "sport" => $sport ? $sport->sport : null,
      "spoken_languages" => $spoken_languages,
      "notifications" => $notifications,
      "photos" => $photos,
      "videos" => $videos,
      "locality" => $locality ? $locality : null,
      "loc_id_other_localities" => $loc_id_other_localities,
      "folder" => $folder,
      "leads" => $leads,
      "reviews" => $reviews,
      "photos" => $photos,
      "videos" => $videos,
      "fee" => $fee,
      "pin" => $pin,
      "email_verified" => $email_verified,
      "parent_tbl" => $user->parent_tbl,
      "completion_percent" => $completion_percent,
      "overall_percent" => $overall_percent,
      "plans" => $plans,
      "gym" => $gym,
      "current_plan" => $current_plan,
      "breadcrumbs" => $breadcrumbs,
    );

    createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($d));
    if ($request->ajax()) {
      return response()->json(['d' => $d, 'photos' => $photos, 'videos' => $videos, 'reviews' => $reviews, 'leads' => $leads, 'notifications' => $notifications, 'd' => $d, 'tickets' => $ticket]);
    }
    return view("admin.academy.academy_admin")->with('data', $data);
  }


  public function update_academy(Request $request)
  {
    try {
      [$auth, $user] = authenticate(2);
      if (!$auth) {
        return redirect('/');
      }

      $id = $user->parent_id;
      $academy_model = ($user->parent_tbl == 0) ? Bmp_academy_details_temp::class : Bmp_academy_details::class;
      $academy = $academy_model::find($id);
      $fw_id = $user->fw_id;
      // $id = $user->parent_id;

      if (!$academy) {
        if ($request->ajax()) {
          return response()->json(['status' => 0, 'message' => 'academy not found']);
        }
        session()->flash('error_update_academy', 'academy not found');
        return redirect()->back();
      }

      $allowedFields = [
        'name',
        'loc_id',
        'loc_id_other',
        'about',
        'categories',
        'experience',
        'address1',
        'spoken_languages',
        'timing',
        'closed_on',
        'friendly',
        'website',
        'facebook',
        'instagram',
        'fee',
        'logo',
        'banner',
        'age_group',
        'completion_percentage'
      ];

      $fieldsToUpdate = [];
      foreach ($allowedFields as $field) {
        if ($request->has($field)) {
          $fieldsToUpdate[$field] = $request->input($field);
        }
      }

      $academy_city = Adm_location_master::where('id', $request->input("loc_id"))->first();
      $academy_sport = Adm_sports_master::where('id', $academy->sport_id)->first();

      if (!$academy_city || !$academy_sport) {
        if ($request->ajax()) {
          return response()->json(['status' => 0, 'message' => 'location not found']);
        }
      }

      if ($academy->sport_id == 31) {
        $gymFields = ['memberships', 'fitness_options', 'premium_facilities', 'equipment', 'gym_area', 'trial_classes'];
        $gymData = [];
        foreach ($gymFields as $field) {
          if ($request->has($field)) {
            $gymData[$field] = $request->input($field);
          }
        }
        if (!empty($gymData)) {
          $gym = Bmp_gym_details::where('academy_id', $id)->first();

          if ($gym) {
            $gym->update($gymData);
          } else {
            $gymData['academy_id'] = $id;
            Bmp_gym_details::create($gymData);
          }
        }
      }


      if ($request->input("loc_id_other")) {
        $loc_id_other_array = explode(',', $request->input("loc_id_other"));
        $loc_id_other_array = array_unique($loc_id_other_array);
        $valid_loc_ids = Adm_location_master::whereIn('id', $loc_id_other_array)->pluck('id')->toArray();
        $fieldsToUpdate['loc_id_other'] = implode(',', $valid_loc_ids);
      }

      $fieldsToUpdate['address2'] = $academy_city->locality_name;
      $fieldsToUpdate['city'] = $academy_city->locality_name;
      $fieldsToUpdate['state'] = $academy_city->state;
      $fieldsToUpdate['postcode'] = $academy_city->postcode;
      $location = ($academy_city->locality_name === $academy_city->city) ? "$academy_city->locality_name $academy_city->state" : "$academy_city->locality_name $academy_city->city";
      $city = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($location)), '-');
      $sport = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($academy_sport->sport)), '-');
      $name = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($request->input("name"))), '-');
      $fieldsToUpdate['url'] = "https://www.bookmyplayer.com/$sport/$name-$city-aid-$academy->id";

      $academy->update($fieldsToUpdate);

      if ($fw_id) {
        $response = Http::withHeaders([
          'Authorization' => 'Token token=' . getenv('FRESHWORK_KEY'),
          'Content-Type' => 'application/json',
        ])->put("https://bookmyplayer-org.myfreshworks.com/crm/sales/api/contacts/{$fw_id}", [
              'contact' => [
                'city' => $academy_city->locality_name,
                'custom_field' => [
                  'cf_url' => $fieldsToUpdate['url'],
                  'cf_account_name' => $request->input("name")
                ],
              ],
            ]);
      }

      createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($academy), "update:" . json_encode($fieldsToUpdate));
      if ($request->ajax()) {
        return response()->json(['status' => 1, 'message' => 'academy details updated successfully']);
      }
      session()->flash('success_update_academy', 'academy details updated successfully');
      return redirect()->back();

    } catch (\Exception $e) {
      // dd($e);
      if ($request->ajax()) {
        return response()->json(data: ['status' => 0, 'message' => $e->getMessage()]);
      }
      return redirect()->back();
    }
  }

  public function upload_academy_photosvideos(Request $request)
  {
    try {
      [$auth, $user] = authenticate(2);
      if (!$auth) {
        return redirect('/');
      }

      $id = $user->parent_id;
      $tbl = $user->parent_tbl == 0 ? 'bmp_academy_details_temp' : 'bmp_academy_details';
      $folder = $user->parent_tbl == 0 ? "academy_temp/$id" : "academy/$id";

      $academy = DB::table($tbl)->where('id', $id)->first();
      if (!$academy) {
        session()->flash('error_message_upload_photo', 'Academy not found');
        return redirect()->back();
      }

      $name = $academy->name; // Academy name (e.g., "test")
      $academyPhotos = $academy->photos ? explode(',', $academy->photos) : [];
      $academyVideos = $academy->videos ? explode(',', $academy->videos) : [];

      if ($request->hasFile('file')) {
        $files = $request->file('file');

        if (is_array($files)) {
          if (count($files) !== 1) {
            return response()->json(['status' => 0, 'message' => 'Please upload exactly one file.']);
          }
          $file = $files[0];
        } else {
          $file = $files;
        }

        $b2 = new B2Service();
        $result = "";

        $fileType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($name));
        $filename = "{$sanitizedName}.{$extension}";

        if (str_contains($fileType, 'image')) {
          // ===== ADD WATERMARK START ===== 
          // $image = Image::make($file);
          // $width = $image->width();
          // $height = $image->height();

          // $watermark = Image::canvas($width, $height, array(0, 0, 0, 0));
          // $watermark->text('bookmyplayer', $width / 2, $height / 2, function ($font) use ($width) {
          //   $font->file(public_path('fonts/Arial-Bold.ttf'));
          //   $font->size($width * 0.1);
          //   $font->color(array(255, 255, 255, 0.4));
          //   $font->align('center');
          //   $font->valign('middle');
          // });

          // $image->blur(0.5)->insert($watermark, 'center');

          // $tempPath = tempnam(sys_get_temp_dir(), 'watermarked_');
          // $image->save($tempPath, 100);

          // $processedFile = new \Illuminate\Http\UploadedFile(
          //   $tempPath,
          //   $filename,
          //   $file->getMimeType(),
          //   null,
          //   true
          // );

          // $result = $b2->uploadFile($processedFile, 'bmpcdn90original', $folder);
          // unlink($tempPath);
          // $fileNameOnly = basename($result['fileName']);
          // $academyPhotos[] = $fileNameOnly;
          // ===== ADD WATERMARK ENDS ===== 

          // $result = $b2->uploadFile($file, 'bmpcdn90', $folder);
          // $fileNameOnly = basename($result['fileName']);
          // $academyPhotos[] = $fileNameOnly;

          $originalFile = new \Illuminate\Http\UploadedFile(
            $file->getPathname(),
            $filename,
            $file->getMimeType(),
            null,
            true
          );
          $result = $b2->uploadFile($originalFile, 'bmpcdn90', $folder);
          $fileNameOnly = basename($result['fileName']);
          $academyPhotos[] = $fileNameOnly;

        } elseif (str_contains($fileType, 'video')) {
          $videoFile = new \Illuminate\Http\UploadedFile(
            $file->getPathname(),
            $filename,
            $file->getMimeType(),
            null,
            true
          );
          $result = $b2->uploadFile($videoFile, 'bmpcdn90', $folder);
          $fileNameOnly = basename($result['fileName']);
          $academyVideos[] = $fileNameOnly;
        } else {
          return response()->json(['status' => 0, 'message' => 'Only images and videos are allowed']);
        }

        DB::table($tbl)->where('id', $id)->limit(1)->update([
          'photos' => implode(',', $academyPhotos),
          'videos' => implode(',', $academyVideos),
        ]);

        return response()->json(['status' => 1, 'message' => 'File uploaded successfully.', 'result' => $result]);
      }

      // If no file or more than one file uploaded
      return response()->json(['status' => 0, 'message' => 'Please upload exactly one file.']);
    } catch (\Exception $e) {
      return response()->json(['status' => 0, 'message' => $e->getMessage()]);
    }
  }



  public function delete_academy_photovideos(Request $request)
  {
    try {
      [$auth, $user] = authenticate(2);
      if (!$auth) {
        return redirect('/');
      }

      $tbl = $user->parent_tbl == 0 ? 'bmp_academy_details_temp' : 'bmp_academy_details';
      $folder = $user->parent_tbl == 0 ? "academy_temp" : "academy";
      $id = $user->parent_id;
      $academy = DB::table($tbl)->where('id', $id)->first();
      if (!$academy) {
        session()->flash('error_message_delete_photos', 'academy not found');
        return redirect()->back();
      }

      $selectedImages = $request->selected_images ?? [];
      $selectedVideos = $request->selected_videos ?? [];

      if (empty($selectedImages) && empty($selectedVideos)) {
        session()->flash('error_message_delete_photos', 'No files chosen');
        return redirect()->back();
      }

      $photoArray = explode(',', $academy->photos);
      $videoArray = explode(',', $academy->videos);

      $trashedPhotos = array_map(function ($url) {
        return basename(parse_url($url, PHP_URL_PATH));
      }, $selectedImages);

      $trashedVideos = array_map(function ($url) {
        return basename(parse_url($url, PHP_URL_PATH));
      }, $selectedVideos);

      $remainingPhotos = array_diff($photoArray, $trashedPhotos);
      $remainingVideos = array_diff($videoArray, $trashedVideos);

      $photoColumn = implode(',', $remainingPhotos);
      $videoColumn = implode(',', $remainingVideos);

      DB::table($tbl)->where('id', $id)->update([
        'photos' => $photoColumn,
        'videos' => $videoColumn,
      ]);
      $photo_log = [
        'photos' => $trashedPhotos,
        'videos' => $trashedVideos,
      ];

      createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($academy), "delete photos:" . json_encode($photo_log));

      session()->flash('success_message_delete_photos', 'Files deleted successfully');
      return redirect()->back();

    } catch (\Exception $e) {
      dd($e);
      session()->flash('error_message_delete_photos', 'Something went wrong');
      return redirect()->back();
    }
  }



}
