<?php

namespace App\Http\Controllers\Admin\Tournament;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\Bmp_league_details;
use App\Models\Adm_location_master;
use App\Models\Adm_sports_master;
use App\Models\Bmp_leads_league;
use App\Services\B2Service;

class admin_tournament extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function show_tournament_admin(Request $request, $id)
    {
        [$auth, $user] = authenticateMultiple([1, 2, 5]);
        if (!$auth) {
            return redirect('/');
        }

        $data = array(
            "title" => "bookmyplayer - dashboard",
            "des" => "",
            "url" => URL::current(),
            "pin" => $user->pin,
            "breadcrumbs" => [],
        );

        return view("admin.tournament.tournament_admin")->with('data', $data);
    }

    // Api - Add tournament
    public function save_tournament(Request $request)
    {
        try {
            [$auth, $user] = authenticateMultiple([1, 2, 5]);
            if (!$auth) {
                return response()->json([
                    'error' => 'user not authenticated',
                ], 400);
            }

            $userId = $user->id;
            $requiredFields = ['sport_id', 'intro', 'venue', 'no_of_team', 'name', 'phone', 'loc_id', 'sub_tournament'];
            $missingFields = [];

            foreach ($requiredFields as $field) {
                if (!$request->input($field)) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                return response()->json([
                    'error' => 'Missing required fields: ' . implode(', ', $missingFields)
                ], 400);
            }
            $loc_id = $request->input('loc_id');
            $sport_id = $request->input('sport_id');

            $location = Adm_location_master::where("id", $loc_id)->first();
            if (!$location) {
                return response()->json([
                    'error' => 'invalid location'
                ], 400);
            }
            $pincode = $location->postcode;
            $city = $location->city;
            $state = $location->state;
            $locality_name = $location->locality_name;

            $sportInfo = Adm_sports_master::where("id", $sport_id)->first();
            if (!$sportInfo) {
                return response()->json([
                    'error' => 'Invalid sport'
                ], 400);
            }
            $sport = $sportInfo->name;


            $leagueDetails = new Bmp_league_details();
            $leagueDetails->user_id = $userId;
            $leagueDetails->sport = $sport;
            $leagueDetails->sport_id = $sport_id;
            $leagueDetails->state = $state;
            $leagueDetails->city = $city;
            $leagueDetails->pincode = $pincode;
            $leagueDetails->loc_id = $loc_id;
            $leagueDetails->locality_name = $locality_name;
            $leagueDetails->intro = (string) $request->input('intro');
            $leagueDetails->venue = $request->input('venue');
            $leagueDetails->event_starts_on = $request->input('event_starts_on');
            $leagueDetails->event_ends_on = $request->input('event_ends_on');
            $leagueDetails->no_of_team = $request->input('no_of_team');
            $leagueDetails->entry_fee = $request->input('entry_fee');
            $leagueDetails->winning_amount = $request->input('winning_amount');
            $leagueDetails->name = $request->input('name');
            $leagueDetails->phone = $request->input('phone');
            $leagueDetails->email = $request->input('email');
            $leagueDetails->sub_tournament = $request->input('sub_tournament');
            $leagueDetails->pathway = $request->input('pathway');
            $leagueDetails->rules = $request->input('rules');
            $leagueDetails->advantages = $request->input('advantages');


            $leagueDetails->sponsored_name = $request->input('sponsored_name', null);
            $leagueDetails->organised_by = $request->input('organised_by', null);

            $leagueDetails->save();
            $id = $leagueDetails->id;
            $url = "https://www.bookmyplayer.com/" . Str::slug($sport) . "/" . Str::slug($leagueDetails->name) . "-tid-" . $id;

            // $folder = "league/$id";
            // $photos = [];

            // if ($request->hasFile('file')) {
            //     foreach ($request->file('file') as $file) {
            //         $fileType = $file->getMimeType();

            //         if (!str_contains($fileType, 'image')) {
            //             continue;
            //         }

            //         $extension = $file->getClientOriginalExtension();
            //         $filename = "league_" . uniqid() . "." . $extension;
            //         $filenameWithPath = $folder . '/' . $filename;

            //         if ($file->storeAs($folder, $filename, 's3') && $file->storeAs($folder, $filename, 's3_cdn90')) {
            //             $photos[] = $filename;
            //         } else {
            //             \Log::error("Failed to upload file: $filename");
            //         }
            //     }

            //     if (!empty($photos)) {
            //         $updatedPhotoString = implode(',', $photos);
            //         $leagueDetails->photos = $updatedPhotoString;
            //         $leagueDetails->url = $url;
            //         $leagueDetails->save();
            //     }
                $leagueDetails->url = $url;
                $leagueDetails->save();

            // }
            return response()->json(['status' => 1, 'message' => 'Tournament created successfully.','leagueDetails' => $leagueDetails], 200);


        } catch (\Exception $e) {
            \Log::error('Error in save_tournament: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['status' => 0, 'message' => $e], 500);
        }
    }

    // Api - Get tournaments
    public function get_tournament(Request $request)
    {
        try {
            [$auth, $user] = authenticateMultiple([1, 2, 5]);
            if (!$auth) {
                return response()->json([
                    'error' => 'user not authenticated',
                ], 400);
            }

            $userId = $user->id;

            $query = Bmp_league_details::where('user_id', $userId);

            $status = $request->input('status');
            if ($status === '0' || $status === '1') {
                $query->where('closed', $status === '0');
            }

            $sortOrder = $request->input('sort', 'desc');
            $query->orderBy('creation_date', $sortOrder === 'asc' ? 'asc' : 'desc');

            $tournaments = $query->get();

            return response()->json([
                'status' => 1,
                'tournaments' => $tournaments,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error in get_tournament: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['status' => 0, 'message' => 'An error occurred while fetching tournaments.'], 500);
        }
    }

    // Api - Update tournament
    public function update_tournament(Request $request)
    {
        try {
            [$auth, $user] = authenticateMultiple([1, 2, 5]);
            if (!$auth) {
                return response()->json([
                    'error' => 'user not authenticated',
                ], 400);
            }

            $tournament_id = $request->input('tournament_id');
            $userId = $user->id;

            $tournament = Bmp_league_details::where('user_id', $userId)
                ->where('id', $tournament_id)
                ->first();

            if (!$tournament) {
                if ($request->ajax()) {
                    return response()->json(['status' => 0, 'message' => 'Tournament not found']);
                }
                session()->flash('error_update_tournament', 'Tournament not found');
                return redirect()->back();
            }

            $allowedFields = [
                'sport',
                'sport_id',
                'state',
                'city',
                'pincode',
                'intro',
                'venue',
                'event_starts_on',
                'event_ends_on',
                'no_of_team',
                'entry_fee',
                'winning_amount',
                'name',
                'phone',
                'email',
                'sub_tournament',
                'photos',
                'banner',
                'closed',
                'sponsored_name',
                'pathway',
                'advantages',
                'rules',
                'organised_by'
            ];

            $fieldsToUpdate = [];
            foreach ($allowedFields as $field) {
                if ($request->has($field)) {
                    $fieldsToUpdate[$field] = $request->input($field);
                }
            }

            if ($request->has('loc_id')) {
                $location = Adm_location_master::find($request->input('loc_id'));
                if ($location) {
                    $fieldsToUpdate['pincode'] = $location->postcode;
                    $fieldsToUpdate['city'] = $location->city;
                    $fieldsToUpdate['state'] = $location->state;
                    $fieldsToUpdate['locality_name'] = $location->locality_name;
                }
            }

            if ($request->has('sport_id')) {
                $sportInfo = Adm_sports_master::find($request->input('sport_id'));
                if ($sportInfo) {
                    $fieldsToUpdate['sport'] = $sportInfo->name;
                }
            }

            $tournament->update($fieldsToUpdate);
            $id = $tournament->id;
            $url = "https://bookmyplayer.com/" . Str::slug($tournament->sport) . "/" . Str::slug($tournament->name) . "-tid-" . $id;
            $tournament->url = $url;
            $tournament->save();

            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'Tournament details updated successfully']);
            }
            session()->flash('success_update_tournament', 'Tournament details updated successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 0, 'message' => 'Something went wrong']);
            }
            return redirect()->back();
        }
    }

    // Api - Upload Photos
    public function upload_photos(Request $request)
    {
        try {
            [$auth, $user] = authenticateMultiple([1, 2, 5]);
            if (!$auth) {
                return response()->json([
                    'error' => 'user not authenticated',
                ], 400);
            }
    
            $tournamentId = $request->input('tournament_id');
            $userId = $user->id;
    
            $leagueDetails = Bmp_league_details::where([
                ['id', $tournamentId],
                ['user_id', $userId]
            ])->first();
    
            if (!$leagueDetails) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Tournament not found or you do not have permission to edit this tournament',
                ], 404);
            }
    
            $name = $leagueDetails->name;
            $folder = "league/$tournamentId";
            $mediaFiles = $leagueDetails->photos ? explode(',', $leagueDetails->photos) : [];
    
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
                    $originalFile = new \Illuminate\Http\UploadedFile(
                        $file->getPathname(),
                        $filename,
                        $file->getMimeType(),
                        null,
                        true
                    );
                    $result = $b2->uploadFile($originalFile, 'bmpcdn90', $folder);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Only images are allowed']);
                }
    
                $fileNameOnly = basename($result['fileName']);
                $mediaFiles[] = $fileNameOnly;
    
                $leagueDetails->photos = implode(',', $mediaFiles);
                $leagueDetails->save();
    
                return response()->json([
                    'status' => 1,
                    'message' => 'File uploaded successfully.',
                    'result' => $result
                ]);
            }
    
            return response()->json(['status' => 0, 'message' => 'Please upload exactly one file.']);
    
        } catch (\Exception $e) {
            \Log::error('Error in upload_photos: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'status' => 0,
                'message' => 'An error occurred while uploading photos.',
            ], 500);
        }
    }

    // Api - Get Leads
    public function get_leads(Request $request)
    {
        try {
            [$auth, $user] = authenticateMultiple([1, 2, 5]);
            if (!$auth) {
                return response()->json([
                    'error' => 'user not authenticated',
                ], 400);
            }
            $leagueId = $request->input('leagueId');
            $userId = $user->id;
            if (!$leagueId) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid leagueId'
                ], 400);
            }

            $league = Bmp_league_details::where('id', $leagueId)->where('user_id', $userId)->first();
            if (!$league) {
                return response()->json([
                    'status' => 0,
                    'message' => 'League not found'
                ], 404);
            }

            $leads = Bmp_leads_league::where('league_id', $leagueId)->get();

            return response()->json([
                'status' => 1,
                'leads' => $leads,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error in get_tournament: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 500);
        }
    }

}
