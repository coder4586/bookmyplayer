<?php

namespace App\Http\Controllers\Admin\Player;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Intervention\Image\ImageManagerStatic as Image;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\Adm_sports_master;
use App\Models\Adm_location_master;
use App\Models\Adm_support_ticket;
use App\Models\Adm_lead_assignment;
use App\Models\Bmp_sport_faqs;
use App\Models\Bmp_sport_skill;
use App\Models\Bmp_users;
use App\Models\Xx_log;
use App\Models\Bmp_notifications;
use App\Models\Bmp_player_details;
use App\Models\Adm_orders;
use App\Services\B2Service;




class admin_player extends BaseController
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


  public function show_player_admin(Request $request, $id)
  {
    [$auth, $user] = authenticate(3);
    if (!$auth) {
      return redirect('/');
    }

    $id = $user->parent_id;
    $player_model = Bmp_player_details::class;

    $d = $player_model::find($id);
    $folder = "player";
    $sport = isset($d->sport_id) ? Adm_sports_master::find($d->sport_id) : [];
    $locality = isset($d->loc_id) ? Adm_location_master::find($d->loc_id) : [];
    $email_verified = DB::table('xx_emails')->where('email', $user->email)->where('type', 'verify-email')->where('email_verified', '1')->count();
    $notifications = Bmp_notifications::where('user_id', $user->id)->orderBy('id', 'asc')->get();
    $log = Xx_log::where('attr1', $user->id)->whereIn('attr6', ['signup: success', 'login: logged in'])->orderBy('id', 'desc')->first();
    $last_login = $log ? Carbon::parse($log->creation_date)->diffForHumans() : "-";
    $pin = $user->pin;
    $skills = array_filter(explode(",", $d->skill), 'strlen');
    $awards = array_filter(explode(",", $d->awards), 'strlen');
    $education = array_filter(explode(",", $d->education), 'strlen');
    $experience = array_filter(explode(",", $d->experience), 'strlen');
    $reviews = [];
    $logo = $d->logo ? env('AWS_S3_BASE_URL') . "/{$folder}/{$d->id}/{$d->logo}" : env('AWS_S3_BASE_URL') . "/asset/images/register-image.jpg";
    $address = $locality ? $locality->locality_name . ", " . $locality->state : null;
    $city_id = $locality ? ($locality->city_id == 0 ? $locality->id : $locality->city_id) : 0;
    $leads = $user->parent_tbl !== 0 ? Adm_lead_assignment::query()->join('master.bmp_leads', 'adm_lead_assignment.lead_id', '=', 'bmp_leads.id')->select('adm_lead_assignment.*', 'bmp_leads.*')->where('adm_lead_assignment.coach_id', $user->parent_id)->get() : [];
    $ticket = Adm_support_ticket::where("user_id", $user->id)->get();
    $order = Adm_orders::where("user_id", $user->id)->latest()->first();
    $premium_pkg = ['purchase_date' => null, 'expiration_date' => null];
    $city_leads = DB::selectOne("SELECT COUNT(*) as lead_count FROM bmp_leads JOIN adm_location_master alm ON bmp_leads.loc_id = alm.id WHERE bmp_leads.sport_id = ? AND (alm.id = ? OR (alm.city_id = ? AND alm.city_id != 0)) AND bmp_leads.creation_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)", [$d->sport_id, $city_id, $city_id, 30]);
    $photos = [];
    $videos = [];
    $certificates = [];
    $files = array_filter(explode(',', $d->photos), 'strlen');
    $cert_files = array_filter(explode(',', $d->certificate), 'strlen');
    $baseUrl = env('AWS_S3_BASE_URL') . "/player/{$d->id}/";
    foreach ($files as $file) {
      $fullPath = $baseUrl . $file;
      $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

      if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'ico'])) {
        $photos[] = $fullPath;
      } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'mkv', 'flv', 'webm', '3gp', 'm4v', 'ts', 'mpeg', 'mpg'])) {
        $videos[] = $fullPath;
      }
    }

    if ($order = Adm_orders::where("user_id", $user->id)->latest()->first()) {
      $created_at = $order->created_at instanceof \Carbon\Carbon
        ? $order->created_at
        : \Carbon\Carbon::parse($order->created_at);

      $premium_pkg['purchase_date'] = $created_at->format('d F Y');
      $premium_pkg['expiration_date'] = $created_at->copy()->addYear()->format('d F Y');
    }

    foreach ($cert_files as $file) {
      $fullPath = $baseUrl . $file;
      $certificates[] = $fullPath;
    }

    $breadcrumbs = [(object) ['name' => "Dashboard", 'link' => ""], (object) ['name' => $d->name, 'link' => ""]];
    $completion_percent = ["photo" => min(100, count($photos) * 20), "video" => min(100, count($videos) * 20), "skills" => min(100, count($skills) * 10), "awards" => min(100, count($awards) * 25), "education" => min(100, count($education) * 25), "experience" => min(100, count($experience) * 50)];
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
      "skills" => $skills,
      "notifications" => $notifications,
      "photos" => $photos,
      "videos" => $videos,
      "certificates" => $certificates,
      "locality" => $locality ? $locality : null,
      "folder" => $folder,
      "leads" => $leads,
      "reviews" => $reviews,
      "awards" => $awards,
      "education" => $education,
      "experience" => $experience,
      "order" => $order,
      "pin" => $pin,
      "premium_pkg" => $premium_pkg,
      "email_verified" => $email_verified,
      "completion_percent" => $completion_percent,
      "overall_percent" => $overall_percent,
      "breadcrumbs" => $breadcrumbs,
    );

    createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($d));
    if ($request->ajax()) {
      return response()->json(['d' => $d, 'photos' => $photos, 'videos' => $videos, 'reviews' => $reviews, 'leads' => $leads, 'notifications' => $notifications, 'd' => $d, 'tickets' => $ticket]);
    }
    return view("admin.player.player_admin")->with('data', $data);
  }


  public function update_player(Request $request)
  {
    try {
      [$auth, $user] = authenticate(3);
      if (!$auth) {
        return redirect('/');
      }

      $id = $user->parent_id;
      $player_model = Bmp_player_details::class;
      $player = $player_model::find($id);

      $id = $user->parent_id;

      if (!$player) {
        if ($request->ajax()) {
          return response()->json(['status' => 0, 'message' => 'Player not found']);
        }
        session()->flash('error_update_player', 'Coach not found');
        return redirect()->back();
      }

      $allowedFields = [
        'name',
        'loc_id',
        'city',
        'about',
        'logo',
        'position',
        'height',
        'weight',
        'dob',
        'awards',
        'facebook',
        'instagram',
        'heighlight',
        'skill',
        'awards',
        'education',
        'experience'
      ];

      $fieldsToUpdate = [];
      foreach ($allowedFields as $field) {
        if ($request->has($field)) {
          $fieldsToUpdate[$field] = $request->input($field);
        }
      }

      $player_city = Adm_location_master::where('id', $request->input("loc_id"))->first();
      $player_sport = Adm_sports_master::where('id', $player->sport_id)->first();
      $city = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($player_city->locality_name)), '-');
      $sport = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($player_sport->sport)), '-');
      $name = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($request->input("name"))), '-');
      $skill = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($player->skill)), '-');
      // $fieldsToUpdate['url'] = "https://www.bookmyplayer.com/$sport/$name-$sport-player-in-$city-pid-$player->id";
      $fieldsToUpdate['url'] = "https://www.bookmyplayer.com/" . $name . "-" . $skill . "-" . $sport . "-player-in-" . $city . "-pid-" . $player->id;

      $player->update($fieldsToUpdate);
      $updated_player = $player->fresh();

      createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($player), "update:" . json_encode($fieldsToUpdate));
      if ($request->ajax()) {
        return response()->json(['status' => 1, 'message' => 'Player details updated successfully']);
      }
      session()->flash('success_update_player', 'Player details updated successfully');
      return redirect()->back();

    } catch (\Exception $e) {
      if ($request->ajax()) {
        return response()->json(['status' => 0, 'message' => 'Something went wrong']);
      }
      return redirect()->back();
    }
  }

  public function upload_player_photosvideos(Request $request)
  {
    try {
      [$auth, $user] = authenticate(3);
      if (!$auth) {
        return redirect('/');
      }

      $id = $user->parent_id;
      $tbl = 'bmp_player_details';
      $folder = "player/$id";

      $player = DB::table($tbl)->where('id', $id)->first();
      if (!$player) {
        return response()->json(['status' => 0, 'message' => 'Player not found']);
      }

      $name = $player->name;
      $mediaFiles = $player->photos ? explode(',', $player->photos) : [];

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

        // $originalFileName = $file->getClientOriginalName();
        // $fileType = $file->getMimeType();
        // $extension = $file->getClientOriginalExtension();

        // $sanitizedBaseName = preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower(str_replace(' ', '-', $name)));
        // $filename = "{$sanitizedBaseName}.{$extension}";

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
          // ===== ADD WATERMARK END ===== 


          $originalFile = new \Illuminate\Http\UploadedFile(
            $file->getPathname(),
            $filename,
            $file->getMimeType(),
            null,
            true
          );
          $result = $b2->uploadFile($originalFile, 'bmpcdn90', $folder);

        } elseif (str_contains($fileType, 'video')) {
          // $result = $b2->uploadFile($file, 'bmpcdn90original', $folder);
          $originalFile = new \Illuminate\Http\UploadedFile(
            $file->getPathname(),
            $filename,
            $file->getMimeType(),
            null,
            true
          );
          $result = $b2->uploadFile($originalFile, 'bmpcdn90', $folder);

        } else {
          return response()->json(['status' => 0, 'message' => 'Only images and videos are allowed']);
        }

        $fileNameOnly = basename($result['fileName']);
        $mediaFiles[] = $fileNameOnly;

        DB::table($tbl)->where('id', $id)->limit(1)->update([
          'photos' => implode(',', $mediaFiles)
        ]);

        createAdminLog(
          $user->id,
          $request->ip(),
          $request->url(),
          URL::previous(),
          $this->getDeviceType(),
          "user:" . json_encode($user),
          "entity:" . json_encode($player),
          "add media:" . $fileNameOnly
        );

        return response()->json([
          'status' => 1,
          'message' => 'File uploaded successfully.',
          'result' => $result
        ]);
      }

      return response()->json(['status' => 0, 'message' => 'Please upload exactly one file.']);

    } catch (\Exception $e) {
      return response()->json(['status' => 0, 'message' => 'Something went wrong']);
    }
  }

  public function delete_player_photovideos(Request $request)
  {
    try {
      [$auth, $user] = authenticate(3);
      if (!$auth) {
        return redirect('/');
      }

      $tbl = 'bmp_player_details';
      $folder = "player";
      $id = $user->parent_id;
      $player = DB::table($tbl)->where('id', $id)->first();
      if (!$player) {
        session()->flash('error_message_delete_photos', 'player not found');
        return redirect()->back();
      }

      $selectedImages = $request->selected_images ?? [];
      $selectedVideos = $request->selected_videos ?? [];

      if (empty($selectedImages) && empty($selectedVideos)) {
        session()->flash('error_message_delete_photos', 'No files chosen');
        return redirect()->back();
      }

      $photoArray = explode(',', $player->photos);
      $trashedPhotos = array_map(function ($url) {
        return basename(parse_url($url, PHP_URL_PATH));
      }, array_merge($selectedImages, $selectedVideos));

      $remainingPhotos = array_diff($photoArray, $trashedPhotos);
      $photoColumn = implode(',', $remainingPhotos);

      DB::table($tbl)->where('id', $id)->update([
        'photos' => $photoColumn,
      ]);
      createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($player), "delete photos:" . json_encode($trashedPhotos));

      session()->flash('success_message_delete_photos', 'Files deleted successfully');
      return redirect()->back();
    } catch (\Exception $e) {
      dd($e);
      session()->flash('error_message_delete_photos', 'something went wrong');
      return redirect()->back();
    }
  }


}
