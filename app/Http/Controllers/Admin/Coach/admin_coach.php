<?php

namespace App\Http\Controllers\Admin\Coach;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\Adm_sports_master;
use App\Models\Adm_location_master;
use App\Models\Adm_support_ticket;
use App\Models\Adm_lead_assignment;
use App\Models\Bmp_sport_faq;
use App\Models\Bmp_sport_faqs_coach;
use App\Models\Bmp_sport_skill;
use App\Models\Bmp_review_coaches;
use App\Models\Bmp_coach_details;
use App\Models\Xx_log;
use App\Models\Adm_orders;
use App\Models\Bmp_notifications;
use App\Services\B2Service;


class admin_coach extends BaseController
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


    public function show_coach_admin(Request $request, $id)
    {
        [$auth, $user] = authenticate(1);
        if (!$auth) {
            return redirect('/');
        }


        $id = $user->parent_id;
        $coachModel = Bmp_coach_details::class;

        $d = $coachModel::find($id);
        $email_verified = DB::table('xx_emails')->where('email', $user->email)->where('type', 'verify-email')->where('email_verified', '1')->count();
        $folder = $user->parent_tbl == 0 ? "coach" : "coach";
        $sport = Adm_sports_master::find($d->sport_id);
        $locality = Adm_location_master::find($d->loc_id);
        $popularcoaches = Bmp_coach_details::where('sport_id', $d->sport_id)->get();
        $notifications = Bmp_notifications::where('user_id', '353')->orderBy('id', 'asc')->get();
        $custom_faqs = Bmp_sport_faqs_coach::where('user_id', $user->id)->get();
        $plans = Adm_orders::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $current_plan = $plans->isNotEmpty() ? $plans->first()->plan_id : null;
        $pin = $user->pin;
        $log = Xx_log::where('attr1', $user->id)->whereIn('attr6', ['signup: success', 'login: logged in'])->orderBy('id', 'desc')->first();
        $last_login = $log ? Carbon::parse($log->creation_date)->diffForHumans() : "-";
        $other_serving_localities = Adm_location_master::whereIn('id', explode(',', $d->loc_id_other))->select('id', 'locality_name')->get();
        $skills = array_filter(explode(",", $d->skill), 'strlen');
        $packages = array_filter(explode(";", $d->package), 'strlen');
        $location = explode("||", $d->location);
        $location_description = $location && isset($location[1]) ? $location[1] : '';
        $location_type = $location && isset($location[0]) ? explode(',', $location[0]) : [];
        $faqs = Bmp_sport_faq::where("sport_id", $d->sport_id)->where("title", 0)->get();
        $coach_faqs = Bmp_sport_faqs_coach::where("user_id", $user->id)->get();
        $reviews = $user->parent_tbl == 1 ? Bmp_review_coaches::where('object_id', $id)->get() : [];
        $logo = $d->profile_img ? env('AWS_S3_BASE_URL') . "/{$folder}/{$d->id}/{$d->profile_img}" : env('AWS_S3_BASE_URL') . "/asset/images/register-image.jpg";
        $address = $locality ? $locality->locality_name . ", " . $locality->state : null;
        // $leads = $user->parent_tbl !== 0 ? Adm_lead_assignment::query()->join('master.bmp_leads', 'adm_lead_assignment.lead_id', '=', 'bmp_leads.id')->select('adm_lead_assignment.*', 'bmp_leads.*')->where('adm_lead_assignment.coach_id', $user->parent_id)->get() : [];
        $leads = $user->parent_tbl !== 0 ? Adm_lead_assignment::join('master.bmp_leads', 'adm_lead_assignment.lead_id', '=', 'bmp_leads.id')->leftJoin('master.adm_location_master', 'bmp_leads.loc_id', '=', 'master.adm_location_master.id')->select('adm_lead_assignment.id as assignment_id', 'adm_lead_assignment.*', 'bmp_leads.*', 'master.adm_location_master.locality_name')->where('adm_lead_assignment.coach_id', $user->parent_id)->get() : [];
        $ticket = Adm_support_ticket::where("user_id", $user->id)->get();
        $baseUrl = env('AWS_S3_BASE_URL') . "/coach/{$d->id}/";
        $city_id = $locality ? ($locality->city_id == 0 ? $locality->id : $locality->city_id) : 0;
        $city_leads = DB::selectOne("SELECT COUNT(*) as lead_count FROM bmp_leads JOIN adm_location_master alm ON bmp_leads.loc_id = alm.id WHERE bmp_leads.sport_id = ? AND (alm.id = ? OR (alm.city_id = ? AND alm.city_id != 0)) AND bmp_leads.creation_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)", [$d->sport_id, $city_id, $city_id, 30]);

        $photos = $videos = $certificates = [];
        $cert_files = array_filter(explode(",", $d->certificate), 'strlen');
        $files = array_filter(explode(",", $d->photos), 'strlen');

        foreach ($files as $file) {
            $fullPath = $baseUrl . $file;
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'ico'])) {
                $photos[] = $fullPath;
            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'mkv', 'flv', 'webm', '3gp', 'm4v', 'ts', 'mpeg', 'mpg'])) {
                $videos[] = $fullPath;
            }
        }

        foreach ($cert_files as $file) {
            $fullPath = $baseUrl . $file;
            $certificates[] = $fullPath;
        }

        $breadcrumbs = [(object) ['name' => "Dashboard", 'link' => ""], (object) ['name' => $d->name, 'link' => ""]];
        $fields = [$d->name, $d->phone, $d->about, $d->email, $d->loc_id, $d->gender, $d->heighlight];
        $personal_info_percent = round((count(array_filter($fields, 'strlen')) / count($fields)) * 100);
        $completion_percent = ["personal_info_percent" => min(100, $personal_info_percent), "skills" => min(100, count($skills) * 10), "package" => min(100, count($packages) * 25), "faqs" => min(100, $coach_faqs->count() * 10), "photo" => min(100, count($photos) * 20), "video" => min(100, count($videos) * 20), "certificate" => min(100, count($certificates) * 50), "other_localities" => min(100, count($other_serving_localities) * 25)];
        $overall_percent = intval(array_sum($completion_percent) / count($completion_percent));

        $data = array(
            "title" => "bookmyplayer - dashboard",
            "des" => $d->heighlight,
            "url" => URL::current(),
            "logo" => $logo,
            "last_login" => $last_login,
            "city_leads" => $city_leads,
            "d" => $d,
            "address" => $address,
            "sport" => $sport ? $sport->sport : null,
            "skills" => $skills,
            "packages" => $packages,
            "notifications" => $notifications,
            "other_serving_localities" => $other_serving_localities,
            "photos" => $photos,
            "videos" => $videos,
            "locality" => $locality ? $locality : null,
            "certificates" => $certificates,
            "folder" => $folder,
            "leads" => $leads,
            "faqs" => $faqs,
            "custom_faqs" => $custom_faqs,
            "reviews" => $reviews,
            "coach_faqs" => $coach_faqs,
            "location_description" => $location_description,
            "location_type" => $location_type,
            "completion_percent" => $completion_percent,
            "overall_percent" => $overall_percent,
            "email_verified" => $email_verified,
            "plans" => $plans,
            "pin" => $pin,
            "current_plan" => $current_plan,
            "breadcrumbs" => $breadcrumbs,
        );

        if ($request->ajax()) {
            return response()->json(['faqs' => $faqs, 'd' => $d, 'photos' => $photos, 'videos' => $videos, 'popularcoaches' => $popularcoaches, 'reviews' => $reviews, 'leads' => $leads, 'notifications' => $notifications, 'd' => $d, 'coach_faqs' => $coach_faqs, 'tickets' => $ticket]);
        }
        createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($d));
        return view("admin.coach.coach_admin")->with('data', $data);
    }


    public function update_coach(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $id = $user->parent_id;
            $coachModel = Bmp_coach_details::class;
            $coach = $coachModel::find($id);
            $fw_id = $user->fw_id;

            if (!$coach) {
                if ($request->ajax()) {
                    return response()->json(['status' => 0, 'message' => 'Coach not found']);
                }
                session()->flash('error_update_coach', 'Coach not found');
                return redirect()->back();
            }

            $allowedFields = [
                'heighlight',
                'name',
                'loc_id',
                'city',
                'about',
                'package',
                'skill',
                'location',
                'trial_class',
                'loc_id_other',
                'profile_img',
                'gender',
                'experience'
            ];

            $fieldsToUpdate = [];
            foreach ($allowedFields as $field) {
                if ($request->has($field)) {
                    $fieldsToUpdate[$field] = $request->input($field);
                }
            }

            $coach_city = Adm_location_master::where('id', $request->input("loc_id"))->first();
            $coach_sport = Adm_sports_master::where('id', $coach->sport_id)->first();
            $city = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($coach_city->locality_name)), '-');
            $state = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($coach_city->state)), '-');
            $sport = $request->input("sport_id") == 32 ? "yoga-trainer" : ($request->input("sport_id") == 34 ? "personal-trainer" : (trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($coach_sport->sport)), '-') . "-coach"));
            $name = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($request->input("name"))), '-');
            $fieldsToUpdate['url'] = "https://www.bookmyplayer.com/" . $name . "-" . $sport . "-in-" . $city . "-" . $state . "-chid-" . $coach->id;

            $coach->update($fieldsToUpdate);
            $updated_coach = $coach->fresh();

            if ($fw_id) {
                $response = Http::withHeaders([
                    'Authorization' => 'Token token=' . getenv('FRESHWORK_KEY'),
                    'Content-Type' => 'application/json',
                ])->put("https://bookmyplayer-org.myfreshworks.com/crm/sales/api/contacts/{$fw_id}", [
                            'contact' => [
                                'city' => $coach_city->locality_name,
                                'custom_field' => [
                                    'cf_url' => $fieldsToUpdate['url'],
                                    'cf_account_name' => $request->input("name")
                                ],
                            ],
                        ]);
            }

            createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($coach), "update:" . json_encode($fieldsToUpdate));
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Coach details updated successfully']);
            }
            session()->flash('success_update_coach', 'Coach details updated successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            // dd($e);
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => 'Something went wrong']);
            }
            return redirect()->back();
        }
    }

    public function add_faq(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $id = $user->parent_id;
            $user_id = $user->id;

            $coachModel = Bmp_coach_details::class;
            $coach = $coachModel::find($id);

            if (!$coach) {
                session()->flash('error_message_add_faq', 'Coach not found');
                return redirect()->back();
            }

            $validatedData = $request->validate([
                'question' => 'required|string',
                'answer' => 'required|string',
            ]);

            $faq = new Bmp_sport_faqs_coach();
            $faq->question = $validatedData['question'];
            $faq->answer = $validatedData['answer'];
            $faq->user_id = $user_id;
            $faq->save();

            createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($coach), "add faq:" . json_encode($validatedData));
            session()->flash('success_message_add_faq', 'FAQ added successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error_message_add_faq', 'Something went wrong');
            return redirect()->back();
        }
    }
    public function add_review_request(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $validatedData = $request->validate([
                'email' => 'required|email',
                'name' => 'required|string|max:255',
            ]);

            sendReviewRequestEmail($validatedData['email'], $validatedData['name'], "review-request", url()->previous(), "https://www.bookmyplayer.com/coach/add-review/$user->parent_id");

            session()->flash('success_message_add_review_request', 'Request sent successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error_message_add_review_request', 'Something went wrong');
            return redirect()->back();
        }
    }
    public function delete_faq(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $user_id = $user->id;
            $faqIds = explode(',', $request->input('faq_ids'));

            foreach ($faqIds as $faqId) {
                $faqId = trim($faqId);

                $faq = Bmp_sport_faqs_coach::where('id', $faqId)
                    ->where('user_id', $user_id)
                    ->first();

                if ($faq) {
                    $faq->delete();
                }
            }

            createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode(""), "delete faq:" . json_encode($faqIds));
            session()->flash('success_message_delete_faq', 'FAQs deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error_message_delete_faq', 'Something went wrong');
            return redirect()->back();
        }
    }
    public function get_location_master(Request $request)
    {
        try {

            $term = $request->input('term');
            $loc_id = $request->input('loc_id');
            if ($loc_id) {
                $d = Adm_location_master::where('id', $loc_id)->first();
                if (!$d) {
                    if ($request->ajax()) {
                        return response()->json(['status' => 0, 'message' => 'invalid location id']);
                    }
                }
                $latitude = $d->lat;
                $longitude = $d->lng;
                $distance = 30;
            }

            $locations = $term
                ? Adm_location_master::where('locality_name', 'like', '%' . $term . '%')
                    ->orWhere('postcode', 'like', '%' . $term . '%')
                    ->take(50)
                    ->get()
                : DB::select("
                SELECT *,
                       (6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance
                FROM adm_location_master
                HAVING distance < ?
                ORDER BY distance
            ", [$latitude, $longitude, $latitude, $distance]);

            if ($request->ajax()) {
                return response()->json(['status' => 1, 'locations' => $locations]);
            }

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => $e->getMessage()]);
            }
        }
    }

    public function get_skills(Request $request)
    {
        try {
            $sport_id = $request->input('sport_id');

            $skills = Bmp_sport_skill::where('sport_id', $sport_id)->get();

            if ($request->ajax()) {
                return response()->json(['status' => 1, 'skills' => $skills]);
            }

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => $e->getMessage()]);
            }
        }
    }

    public function upload_coach_photosvideos(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $id = $user->parent_id;
            $tbl = 'bmp_coach_details';
            $folder = "coach/$id";

            $coach = DB::table($tbl)->where('id', $id)->first();
            if (!$coach) {
                return response()->json(['status' => 0, 'message' => 'Coach not found']);
            }

            $name = $coach->name;
            // dd($id,$tbl,$folder,$name);
            $mediaFiles = $coach->photos ? explode(',', $coach->photos) : [];

            if ($request->hasFile('file')) {
                $files = $request->file('file');

                // Ensure only one file is uploaded
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
                    //     $font->file(public_path('fonts/Arial-Bold.ttf'));
                    //     $font->size($width * 0.1);
                    //     $font->color(array(255, 255, 255, 0.4));
                    //     $font->align('center');
                    //     $font->valign('middle');
                    // });

                    // $image->blur(0.5)->insert($watermark, 'center');

                    // $tempPath = tempnam(sys_get_temp_dir(), 'watermarked_');
                    // $image->save($tempPath, 100);

                    // $processedFile = new \Illuminate\Http\UploadedFile(
                    //     $tempPath,
                    //     $filename,
                    //     $file->getMimeType(),
                    //     null,
                    //     true
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
                    //   $fileNameOnly = basename($result['fileName']);
                    //   $academyPhotos[] = $fileNameOnly;

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

    public function delete_coach_photovideos(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $tbl = 'bmp_coach_details';
            $folder = $user->parent_tbl == 0 ? "coach" : "coach";
            $id = $user->parent_id;
            $coach = DB::table($tbl)->where('id', $id)->first();
            if (!$coach) {
                session()->flash('error_message_delete_photos', 'Coach not found');
                return redirect()->back();
            }

            $selectedImages = $request->selected_images ?? [];
            $selectedVideos = $request->selected_videos ?? [];

            if (empty($selectedImages) && empty($selectedVideos)) {
                session()->flash('error_message', 'No files chosen');
                return redirect()->back();
            }

            $photoArray = explode(',', $coach->photos);
            $trashedPhotos = array_map(function ($url) {
                return basename(parse_url($url, PHP_URL_PATH));
            }, array_merge($selectedImages, $selectedVideos));

            $remainingPhotos = array_diff($photoArray, $trashedPhotos);
            $photoColumn = implode(',', $remainingPhotos);

            DB::table($tbl)->where('id', $id)->update([
                'photos' => $photoColumn,
            ]);
            createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($coach), "delete photos:" . json_encode($trashedPhotos));
            session()->flash('success_message_delete_photos', 'Files deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error_message_delete_photos', 'something went wrong');
            return redirect()->back();
        }
    }

    public function upload_coach_certificates(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $id = $user->parent_id;
            $tbl = 'bmp_coach_details';
            $folder = $user->parent_tbl == 0 ? "coach/$id" : "coach/$id";
            $user_type = session()->get('type_id');

            $coach = DB::table($tbl)->where('id', $id)->first();
            if (!$coach) {
                session()->flash('error_message_upload_cert', 'Coach not found');
                return redirect()->back();
            }

            $containsFiles = false;
            $coachFiles = $coach->certificate ? explode(',', $coach->certificate) : [];

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $originalFileName = $file->getClientOriginalName();
                    $fileType = $file->getMimeType();

                    if (str_contains($fileType, 'image') || str_contains($fileType, 'pdf')) {
                        $containsFiles = true;
                    } else {
                        continue;
                    }

                    $extension = $file->getClientOriginalExtension();

                    $filename = "bmp_" . uniqid() . "." . $extension;
                    $filenameWithPath = $folder . '/' . $filename;
                    $file->storeAs($folder, $filename, 's3');
                    $file->storeAs($folder, $filename, 's3_cdn90');

                    $coachFiles[] = $filename;
                }

                $updatedFileString = implode(',', $coachFiles);
                DB::table($tbl)->where('id', $id)->update(['certificate' => $updatedFileString]);
                createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($coach), "add cert:" . json_encode($updatedFileString));

                $successMessage = $containsFiles ? 'Files uploaded successfully.' : 'No files uploaded.';
                if ($request->ajax()) {
                    return response()->json(['status' => 1, 'message' => $successMessage]);
                }

                createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($coach), "add cert.:" . $updatedFileString);
                session()->flash('success_message_upload_cert', $successMessage);
                return redirect()->back();
            } else {
                if ($request->ajax()) {
                    return response()->json(['status' => 0, 'message' => 'No files uploaded.']);
                }
                session()->flash('error_message_upload_cert', 'No files uploaded.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => 'something went wrong']);
            }
            session()->flash('error_message_upload_cert', 'Something went wrong');
            return redirect()->back();
        }
    }


    public function delete_coach_certificates(Request $request)
    {
        try {
            [$auth, $user] = authenticate(1);
            if (!$auth) {
                return redirect('/');
            }

            $tbl = 'bmp_coach_details';
            $id = $user->parent_id;
            $coach = DB::table($tbl)->where('id', $id)->first();
            if (!$coach) {
                session()->flash('error_message', 'Coach not found');
                return redirect()->back();
            }

            $selectedCertificates = $request->selected_certificates ?? [];

            if (empty($selectedCertificates)) {
                session()->flash('error_message_delete_cert', 'No certificates chosen');
                return redirect()->back();
            }

            $certificateArray = explode(',', $coach->certificate);
            $trashedCertificates = array_map(function ($url) {
                return basename(parse_url($url, PHP_URL_PATH));
            }, $selectedCertificates);

            $remainingCertificates = array_diff($certificateArray, $trashedCertificates);
            $certificateColumn = implode(',', $remainingCertificates);

            DB::table($tbl)->where('id', $id)->update([
                'certificate' => $certificateColumn,
            ]);
            createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($user), "entity:" . json_encode($coach), "delete cert.:" . json_encode($trashedCertificates));

            session()->flash('success_message_delete_cert', 'Certificates deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error_message_delete_cert', 'Something went wrong');
            return redirect()->back();
        }
    }

    // common ticket submit
    public function create_support_ticket(Request $request)
    {
        try {
            $userId = session()->get('userId');
            if (!$userId) {
                session()->flash('error_message_create_ticket', 'Unauthorised user');
                return redirect()->back();
            }
            $user = get_data_row(null, 'bmp_user', 'id', $userId);
            if (!$user) {
                session()->flash('error_message_create_ticket', 'Unauthorised user');
                return redirect()->back();
            }
            $type_id = $user->type_id;
            $type = ($type_id == 1) ? "coach" : (($type_id == 2) ? "academy" : "player");
            $user_id = $user->id;

            $validatedData = $request->validate([
                'description' => 'required|string',
                'email' => 'required|string',
                'phone' => 'required|string',
                'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120'
            ]);

            $ticket = new Adm_support_ticket();
            $ticket->email = $validatedData['email'];
            $ticket->phone = $validatedData['phone'];
            $ticket->description = $validatedData['description'];
            $ticket->user_id = $user_id;
            $ticket->status = "waiting for support";
            $ticket->category = $type . " admin support";
            $ticket->title = $type . " admin support";

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = 'bmp_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $folder = "attachments/tickets";
                $file->storeAs($folder, $filename, 's3_cdn90');
                $ticket->attachment = $filename;
            }

            $ticket->save();

            createAdminLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "user:" . json_encode($userId), "entity:" . json_encode(""), "raise ticket:" . json_encode($validatedData));
            session()->flash('success_message_create_ticket', 'Ticket created successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error_message_create_ticket', $e->getMessage());
            return redirect()->back();
        }
    }

}
