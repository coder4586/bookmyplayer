<?php

namespace App\Http\Controllers;

use App\Models\xx_email_spam;
use App\Models\xx_emails;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Bmp_leads;
use App\Models\Bmp_leads_player;
use App\Models\Bmp_subscriptions;
use App\Models\Bmp_other_details;
use App\Models\Adm_academy_details;
use App\Models\Adm_coach_details;
use App\Models\Adm_lead_assignment;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Storage;
use App\Models\MenuCities;
use App\Models\Adm_location_master;
use App\Models\Adm_plans;
use App\Models\Bmp_sport_faqs;
use App\Models\Bmp_reviews;
use App\Models\MenuSports;
use App\Models\Coach;
use App\Models\Academy;
use App\Models\Bmp_review_coaches;
use App\Models\Bmp_review_player;
use App\Models\Bmp_player_listing;
use App\Models\Adm_support_ticket;
use App\Models\Bmp_coach_details;
use App\Models\Bmp_player_details;
use App\Models\Adm_orders;
use App\Models\Bmp_academy_details;
use App\Models\Adm_sports_master;
use App\Models\Bmp_sports;
use App\Models\Bmp_league_details;
use App\Models\Bmp_sport_faq;
use App\Models\Bmp_certifications;
use App\Services\B2Service;

class Common extends BaseController
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

	public function index(Request $request, $name)
	{
		$allowedPages = ['contact', 'privacy', 'blog', 'about', 'terms', 'career', 'signup', '404', 'register'];
		if (!in_array($name, $allowedPages)) {
			return redirecturl($request->getRequestUri());
		}

		$url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
		$openPositions = $name == "career" ? get_data_array(null, 'xx_jobs', 'closed', 0, null, null, 'id', 'desc', 75) : [];
		$blogs = $name == "blog" ? get_data_array('bookmyplayer', 'xx_blog', null, null, null, null, 'id', 'desc', 75) : [];
		$meta = get_data_row('bookmyplayer', 'xx_pages', 'route', $name);
		$categories = ['Weekend Reads', 'Sports & Work', 'Journal'];
		$blogCategories = get_data_array('bookmyplayer', 'xx_blog_tag', null, null, null, null, 'count', 'desc', 20);
		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), $name);

		$data = [
			"title" => $meta->title,
			"des" => $meta->description,
			"url" => $url,
			"keywords" => $meta->keywords,
			"blogs" => $blogs,
			"openPositions" => $openPositions,
			"blogCategories" => $blogCategories,
			"categories" => $categories,
			"page" => $name,
			"template" => $name,
		];

		return view('common_template', compact('data'));
	}

	public function manageUsers(Request $request)
	{

		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'manage user');

		$data = array(
			"page" => 'manage_user',
			"title" => 'BookMyPlayer: Your Source for Top Sports Academies and Coaches in India',
			"des" => 'Discover the finest sports academies and coaches on BookMyPlayer! Whether you need athletes, coaches, or sports academy, we connect you with top professionals. Join top sports academy and coach to elevate your game',
			"keywords" => 'Sports academies, sport coaches, sport trainers, join sport academies, hire sport coaches, find cheapest sport trainer',
			"url" => "",
			"breadcrumbs" => [],
			"template" => "manage_user",
		);
		return view('manage_user')->with('data', $data);
	}

	public function home(Request $request)
	{
		$url = 'https://www.bookmyplayer.com';
		$blogs = get_data_array('bookmyplayer', 'xx_blog', null, null, null, null, 'id', 'desc', 5);
		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'home');

		$data = array(
			"page" => 'home',
			"title" => 'BookMyPlayer: Your Source for Top Sports Academies and Coaches in India',
			"des" => 'Discover the finest sports academies and coaches on BookMyPlayer! Whether you need athletes, coaches, or sports academy, we connect you with top professionals. Join top sports academy and coach to elevate your game',
			"keywords" => 'Sports academies, sport coaches, sport trainers, join sport academies, hire sport coaches, find cheapest sport trainer',
			"url" => $url,
			"blogs" => $blogs,
			"template" => "home",
		);
		return view('common_template')->with('data', $data);
	}

	public function homenew(Request $request)
	{
		$url = 'https://www.bookmyplayer.com';
		$blogs = get_data_array('bookmyplayer', 'xx_blog', null, null, null, null, 'id', 'desc', 5);
		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'home');
		$breadcrumbs = [];

		$data = array(
			"page" => 'home',
			"title" => 'BookMyPlayer: Your Source for Top Sports Academies and Coaches in India',
			"des" => 'Discover the finest sports academies and coaches on BookMyPlayer! Whether you need athletes, coaches, or sports academy, we connect you with top professionals. Join top sports academy and coach to elevate your game',
			"keywords" => 'Sports academies, sport coaches, sport trainers, join sport academies, hire sport coaches, find cheapest sport trainer',
			"breadcrumbs" => $breadcrumbs,
			"url" => $url,
			"blogs" => $blogs,
			"template" => "home",
		);
		return view('home')->with('data', $data);
	}

	public function login(Request $request)
	{
		$url = 'https://www.bookmyplayer.com/login';
		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login');

		$data = array(
			"page" => 'login',
			"title" => 'BookMyPlayer: Your Source for Top Sports Academies and Coaches in India',
			"des" => 'Discover the finest sports academies and coaches on BookMyPlayer! Whether you need athletes, coaches, or sports academy, we connect you with top professionals. Join top sports academy and coach to elevate your game',
			"keywords" => 'Sports academies, sport coaches, sport trainers, join sport academies, hire sport coaches, find cheapest sport trainer',
			"url" => $url,
			"template" => "login",
		);
		return view('common_template')->with('data', $data);
	}

	public function applyForJob(Request $request, $position, $id)
	{
		$job = get_data_row(null, 'xx_jobs', 'id', $id);
		$openPositions = get_data_array(null, 'xx_jobs', 'closed', 0, null, null, 'id', 'desc', 75);


		if (!$job) {
			createLog($id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), '404', 'job_details');
			return response()->view('errors.404', [], 404);
		}
		createLog($id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), null, 'job_details');

		$data = array(
			"page" => 'job_details',
			"title" => "Apply for position - $job->position",
			"des" => $job->description,
			'job' => $job,
			"openPositions" => $openPositions,
			"keywords" => 'Sports Players, Professional Athletes, Athlete Booking, Sports Talent, Athlete Hire, Coach Booking, Sports Entertainment, Find Athletes, Sports Events, Player Recruitment',
			"url" => "https://www.bookmyplayer.com/$position/$id",
			"template" => "job_details",
		);
		return view('common_template')->with('data', $data);
	}


	function sendEntityDetailSms($leadName, $leadPhone, $objectType, $objectId)
	{
		$entityMap = [
			'academy' => ['table' => 'bmp_academy_details', 'fields' => ['name', 'owner', 'phone']],
			'coach' => ['table' => 'bmp_coach_details', 'fields' => ['name', 'phone']],
			'player' => ['table' => 'bmp_player_details', 'fields' => ['name', 'phone']]
		];

		if (!isset($entityMap[$objectType])) {
			\Log::error('Invalid object type', ['objectType' => $objectType]);
			return;
		}

		$entity = DB::table($entityMap[$objectType]['table'])
			->where('id', $objectId)
			->first($entityMap[$objectType]['fields']);

		if (!$entity) {
			\Log::error('Entity not found', ['objectType' => $objectType, 'objectId' => $objectId]);
			return;
		}

		$name = $objectType === 'academy' ? ($entity->name ?? $entity->name) : $entity->name;
		$text = "Hello $leadName. Please find contact details of " . ucfirst($objectType) .
			". Name: $name. Mobile: $entity->phone. Team BookMyPlayer";

		$params = [
			'username' => 'bookplayer.trans',
			'password' => env('API_PASSWORD'),
			'unicode' => 'false',
			'from' => 'BMPLYR',
			'to' => $leadPhone,
			'dltPrincipalEntityId' => env('DLT_PRINCIPAL_ENTITY_ID'),
			'dltContentId' => env('DLT_CONTENT_ID'),
			'text' => $text // Do not URL encode this field
		];

		try {
			$response = Http::timeout(5)->get("https://kapi.omni-channel.in/fe/api/v1/send", $params);
			if (!$response->successful()) {
				\Log::error('SMS sending failed', ['response' => $response->body()]);
			}
		} catch (\Exception $e) {
			\Log::error('An error occurred while sending SMS', ['error' => $e->getMessage()]);
		}
	}

	function sendLeadDetailSms($name, $recipientPhone, $leadName, $leadPhone, $leadSport, $leadCity)
	{
		$api_str = "https://mshastra.com/sendurl.aspx?user=" . env('M_USER') . "&pwd=" . env('M_PASSWORD') . "&senderid=" . env('SENDER_ID') . "&CountryCode=91&mobileno=$recipientPhone&msgtext=Hello $name. You have a new lead assigned. Name: $leadName. Sport:- $leadSport. Location:- $leadCity. Please login to your account to respond. Login: https://www.bookmyplayer.com/login&smstype=0pe_id=" . env('PE_ID') . "&template_id=1707172544729048801";
		Http::timeout(10)->get($api_str);

	}



	function assignLead($loc_id, $sport_id, $lead_id)
	{
		try {
			if ($loc_id && $sport_id) {
				// dd("OK");

				$city_info = Adm_location_master::where('id', $loc_id)->first();
				$city_id_info = $city_info->city_id;
				$city_id = $city_id_info == 0 ? $city_info->id : $city_id_info;
				$academy_emails = [];
				$coach_emails = [];
				$lead_assignment_data = [];
				$leadCity = $city_info->locality_name ?? "india";

				$matched_result_ac = DB::select("SELECT academy_id FROM admin.adm_verified_academies WHERE city_id = ? AND sport_id = ?", [$city_id, $sport_id]);
				$matched_result_ch = DB::select("SELECT coach_id FROM admin.adm_verified_coaches WHERE city_id = ? AND sport_id = ?", [$city_id, $sport_id]);

				$sport_info = get_data_row(null, 'adm_sports_master', 'id', $sport_id);
				$sport = $sport_info ? $sport_info->name : 'sport';

				if ($matched_result_ac || $matched_result_ch) {
					$academy_ids = array_column($matched_result_ac, 'academy_id');
					$coach_ids = array_column($matched_result_ch, 'coach_id');

					$academy_emails = DB::table('admin.adm_verified_academies as va')
						->select('va.*', 'bd.email', 'bd.name', 'bd.phone as en_phone')
						->join('master.bmp_academy_details as bd', 'va.academy_id', '=', 'bd.id')
						->whereIn('va.academy_id', $academy_ids)
						->get();

					$coach_emails = DB::table('admin.adm_verified_coaches as vc')
						->select('vc.*', 'cd.email', 'cd.name', 'cd.phone as en_phone')
						->join('master.bmp_coach_details as cd', 'vc.coach_id', '=', 'cd.id')
						->whereIn('vc.coach_id', $coach_ids)
						->get();
				}

				$lead = DB::table('master.bmp_leads')
					->where('id', $lead_id)
					->first();

				if (!$lead) {
					return;
				}

				$lead_phone_sms = $lead->phone;
				// $lead_phone = substr($lead->phone ?? '', 0, 4) . "******";
				$lead_phone = substr($lead->phone ?? '', 0, -2) . "**";
				// $lead_email = substr($lead->email ?? '', 0, 4) . "******" . "@gmail.com";
				$lead_email = substr($lead->email ?? '', 0, 3) . '***' . substr(strrchr($lead->email ?? '', '@'), 1);
				$lead_name = $lead->name ?? '';
				$lead_description = $lead->description ?? '';

				$recipients = [];
				foreach ($academy_emails as $email) {
					$recipients[] = ['email' => $email->email, 'name' => $email->name, "sport" => $sport, "parent_id" => $email->academy_id, "type" => "academy", "phone" => $email->en_phone];
					$lead_assignment_data[] = [
						'academy_id' => $email->academy_id,
						'coach_id' => null,
						'sport_id' => $sport_id,
						'lead_id' => $lead_id,
						'loc_id' => $loc_id,
					];
				}
				foreach ($coach_emails as $email) {
					$recipients[] = ['email' => $email->email, 'name' => $email->name, "sport" => $sport, "parent_id" => $email->coach_id, "type" => "coach", "phone" => $email->en_phone];
					$lead_assignment_data[] = [
						'academy_id' => null,
						'coach_id' => $email->coach_id,
						'sport_id' => $sport_id,
						'lead_id' => $lead_id,
						'loc_id' => $loc_id
					];
				}

				Adm_lead_assignment::insert($lead_assignment_data);
				foreach ($recipients as $recipient) {
					$email = $recipient['email'];
					$name = $recipient['name'] ?? '';
					sendLeadAllocationEmail($email, $name, $sport, $recipient['parent_id'], $recipient['type'], $lead_email, $lead_phone, $lead_description, $lead_name, $leadCity);
					$this->sendLeadDetailSms($name, $recipient['phone'], $lead_name, $lead_phone_sms, $sport, $leadCity);
				}
			}
		} catch (\Exception $e) {
			\Log::error('Error assigning lead: ' . $e->getMessage());
		}
	}


	public function submitContactStatic(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'name' => 'required',
				'phone' => 'required',
				'description' => 'required',
				'email' => 'required',
				'source' => 'required',
			]);

			// $storedOtp = session('otp');
			// $sentTime = session('sent_time');
			// $enteredOtp = $request->input('otp');

			// if (!$storedOtp || !$sentTime) {
			// 	return response()->json(['status' => 1, 'message' => 'Please enter correct otp.']);
			// }

			// $currentTime = now();
			// $expiryTime = $sentTime->addMinutes(20);
			// if ($enteredOtp != $storedOtp || $currentTime->gt($expiryTime)) {
			// 	return response()->json(['status' => 0, 'message' => 'invalid or expired otp.']);
			// }

			$sport = $request->input('sport') ? $request->input('sport') : null;
			$query = $request->input('query') ? $request->input('query') : null;
			$lat = $request->input('latitude') ? $request->input('latitude') : null;
			$lng = $request->input('longitude') ? $request->input('longitude') : null;
			$city = null;
			$state = null;

			$emailPatterns = ['orozcotrucking', '@registry.godaddy', 'dispatch@'];
			$descriptionPatterns = ['Hola', 'Hej', 'Salut', 'é', 'ø', 'ë', 'í'];
			$namePatterns = ['Robertunwiz'];

			function containsAny($input, $patterns)
			{
				foreach ($patterns as $pattern) {
					if (strpos($input, $pattern) !== false) {
						return true;
					}
				}
				return false;
			}

			// Check each field
			if (containsAny($request->input('email'), $emailPatterns)) {
				return response()->json(['status' => 1, 'message' => 'Please check your email']);
			} elseif (containsAny($request->input('description'), $descriptionPatterns)) {
				return response()->json(['status' => 1, 'message' => 'Please check your email']);
			} elseif (containsAny($request->input('name'), $namePatterns)) {
				return response()->json(['status' => 1, 'message' => 'Please check your email']);
			}

			// Proceed with the rest of your code here
			$leadData = [
				'name' => ucwords(strtolower($validatedData['name'])),
				'phone' => $validatedData['phone'],
				'description' => $validatedData['description'],
				'source' => $validatedData['source'],
				'email' => strtolower($validatedData['email']),
				'sport' => $sport,
				'query' => $query,
				'ip' => $request->ip(),
				'city' => $city,
				'state' => $state,
				'lat' => $lat,
				'lng' => $lng,
				'browser' => strtolower($request->server('HTTP_USER_AGENT')),
				'refer' => url()->previous()
			];

			if ($request->has('object_id') && $request->has('object_type')) {
				$leadData['object_id'] = $request->input('object_id');
				$leadData['object_type'] = $request->input('object_type');
				$leadData['type'] = "enquiry";
			}

			if ($request->has('sport_id')) {
				$leadData['sport_id'] = (int) $request->input('sport_id');
			}

			if ($request->has('loc_id')) {
				$leadData['loc_id'] = (int) $request->input('loc_id');
				$location_info = Adm_location_master::find($leadData['loc_id']);

				if ($location_info) {
					$leadData['city'] = $location_info->city ?? null;
					$leadData['state'] = $location_info->state ?? null;

					if (!$lat || !$lng) {
						$leadData['lat'] = $location_info->lat ?? null;
						$leadData['lng'] = $location_info->lng ?? null;
					}
				}
			}

			if ($leadData['email'] != "maheshmhaske241198@gmail.com") {
				$duplicate_lead = Bmp_leads::where('object_id', $leadData['object_id'])
					->where('object_type', $leadData['object_type'])
					->where('phone', $leadData['phone'])
					->where('creation_date', '>=', now()->subHours(24))
					->count();

				$total_leads = Bmp_leads::where('phone', $leadData['phone'])
					->where('creation_date', '>=', now()->subHours(24))
					->count();

				if ($duplicate_lead > 0 || $total_leads > 3) {
					return response()->json(['status' => 1, 'message' => 'Your message has been sent successfully.']);
				}
			}

			$lead = Bmp_leads::create($leadData);
			$lead_id = $lead->id;
			if ($leadData['object_type'] && $leadData['object_id']) {
				$this->sendEntityDetailSms($leadData['name'], $leadData['phone'], $leadData['object_type'], $leadData['object_id']);
				// if($leadData['email'] == "maheshmhaske241198@gmail.com"){
				// 	$this->sendAcademyInfoEmail($leadData['email'],$leadData['name'],"Academy-details: $leadData['object_id']",'source',$leadData['object_id']);
				// }
			}

			if ($request->has('loc_id') && $request->has('sport_id') && stripos($leadData['description'], 'test') === false) {
				$this->assignLead($leadData['loc_id'], $leadData['sport_id'], $lead_id);
			}
			return response()->json(['status' => 1, 'message' => 'Your message has been sent successfully.']);
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
	}

	public function submitContactPlayer(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'name' => 'required',
				'phone' => 'required',
				'description' => 'required',
				'email' => 'required',
				'source' => 'required',
			]);

			$sport = $request->input('sport') ? $request->input('sport') : null;
			$query = $request->input('query') ? $request->input('query') : null;
			$lat = $request->input('latitude') ? $request->input('latitude') : null;
			$lng = $request->input('longitude') ? $request->input('longitude') : null;
			$city = null;
			$state = null;


			$emailPatterns = ['orozcotrucking', '@registry.godaddy', 'dispatch@'];
			$descriptionPatterns = ['Hola', 'Hej', 'Salut', 'é', 'ø', 'ë', 'í'];
			$namePatterns = ['Robertunwiz'];

			function containsAny($input, $patterns)
			{
				foreach ($patterns as $pattern) {
					if (strpos($input, $pattern) !== false) {
						return true;
					}
				}
				return false;
			}

			// Check each field
			if (containsAny($request->input('email'), $emailPatterns)) {
				return redirect()->back()->with('success_contact', 'Please check and verify your email.!');
			} elseif (containsAny($request->input('description'), $descriptionPatterns)) {
				return redirect()->back()->with('success_contact', 'Please check and verify your email.!');
			} elseif (containsAny($request->input('name'), $namePatterns)) {
				return redirect()->back()->with('success_contact', 'Please check and verify your email.!');
			}

			// Proceed with the rest of your code here
			$leadData = [
				'name' => ucwords(strtolower($validatedData['name'])),
				'phone' => $validatedData['phone'],
				'description' => $validatedData['description'],
				'source' => $validatedData['source'],
				'email' => strtolower($validatedData['email']),
				'sport' => $sport,
				'query' => $query,
				'ip' => $request->ip(),
				'city' => $city,
				'state' => $state,
				'lat' => $lat,
				'lng' => $lng,
				'browser' => strtolower($request->server('HTTP_USER_AGENT')),
				'refer' => url()->previous()
			];

			if ($request->has('object_id') && $request->has('object_type')) {
				$leadData['object_id'] = $request->input('object_id');
				$leadData['object_type'] = $request->input('object_type');
				$leadData['type'] = "enquiry";
			}

			if ($request->has('sport_id')) {
				$leadData['sport_id'] = (int) $request->input('sport_id');
			}

			if ($request->has('loc_id')) {
				$leadData['loc_id'] = (int) $request->input('loc_id');
				$location_info = Adm_location_master::find($leadData['loc_id']);

				if ($location_info) {
					$leadData['city'] = $location_info->city ?? null;
					$leadData['state'] = $location_info->state ?? null;

					if (!$lat || !$lng) {
						$leadData['lat'] = $location_info->lat ?? null;
						$leadData['lng'] = $location_info->lng ?? null;
					}
				}
			}

			if ($leadData['email'] != "maheshmhaske241198@gmail.com") {
				$duplicate_lead = Bmp_leads_player::where('object_id', $leadData['object_id'])
					->where('object_type', $leadData['object_type'])
					->where('phone', $leadData['phone'])
					->where('creation_date', '>=', now()->subHours(24))
					->count();

				$total_leads = Bmp_leads_player::where('phone', $leadData['phone'])
					->where('creation_date', '>=', now()->subHours(24))
					->count();

				if ($duplicate_lead > 0 || $total_leads > 3) {
					return redirect()->back()->with('success_contact', 'Your form has been submitted successfully.');
				}
			}

			$lead = Bmp_leads_player::create($leadData);
			$lead_id = $lead->id;
			if ($leadData['object_type'] && $leadData['object_id']) {
				$this->sendEntityDetailSms($leadData['name'], $leadData['phone'], $leadData['object_type'], $leadData['object_id']);
			}

			if ($request->has('loc_id') && $request->has('sport_id') && stripos($leadData['description'], 'test') === false) {
				// $this->assignLead($leadData['loc_id'], $leadData['sport_id'], $lead_id);
			}
			return redirect()->back()->with('success_contact', 'Your form has been submitted successfully.');
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
	}


	public function submitContact(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'name' => 'required',
				'phone' => 'required',
				'description' => 'required',
				'email' => 'required',
				'source' => 'required',
			]);

			$sport = $request->input('sport') ? $request->input('sport') : null;
			$query = $request->input('query') ? $request->input('query') : null;
			$lat = $request->input('latitude') ? $request->input('latitude') : null;
			$lng = $request->input('longitude') ? $request->input('longitude') : null;
			$city = null;
			$state = null;

			if (strpos($request->input('email'), '@registry.godaddy') !== false) {
				return response()->json(['status' => 1, 'message' => "Please check and verify your email.",]);
			}

			$leadData = [
				'name' => ucwords(strtolower($validatedData['name'])),
				'phone' => $validatedData['phone'],
				'description' => $validatedData['description'],
				'email' => strtolower($validatedData['email']),
				'source' => $validatedData['source'],
				'ip' => $request->ip(),
				'sport' => $sport,
				'query' => $query,
				'city' => $city,
				'state' => $state,
				'lat' => $lat,
				'lng' => $lng,
				'browser' => strtolower($request->server('HTTP_USER_AGENT')),
				'refer' => url()->previous()
			];

			if ($request->has('object_id') && $request->has('object_id')) {
				$leadData['object_id'] = $request->input('object_id');
				$leadData['object_type'] = $request->input('object_type');
				$leadData['type'] = "enquiry";
			}

			if ($request->has('sport_id')) {
				$leadData['sport_id'] = (int) $request->input('sport_id');
			}

			if ($request->has('loc_id')) {
				$leadData['loc_id'] = (int) $request->input('loc_id');
				$location_info = Adm_location_master::find($leadData['loc_id']);

				if ($location_info) {
					$leadData['city'] = $location_info->city ?? null;
					$leadData['state'] = $location_info->state ?? null;

					if (!$lat || !$lng) {
						$leadData['lat'] = $location_info->lat ?? null;
						$leadData['lng'] = $location_info->lng ?? null;
					}
				}
			}

			$duplicate_lead = Bmp_leads::where('object_id', $leadData['object_id'])
				->where('object_type', $leadData['object_type'])
				->where('phone', $leadData['phone'])
				->where('creation_date', '>=', now()->subHours(24))
				->count();

			$total_leads = Bmp_leads::where('phone', $leadData['phone'])
				->where('creation_date', '>=', now()->subHours(24))
				->count();

			if ($duplicate_lead > 0 || $total_leads > 3) {
				return redirect()->back()->with('success_contact', 'Your form has been submitted successfully.');
			}

			$lead = Bmp_leads::create($leadData);
			$lead_id = $lead->id;
			if ($leadData['object_type'] && $leadData['object_id']) {
				$this->sendEntityDetailSms($leadData['name'], $leadData['phone'], $leadData['object_type'], $leadData['object_id']);
			}
			// sendWelcomeEmail($validatedData['email'], $validatedData['name'], "welcome-email", url()->previous());
			$leadData['object_type'] == "academy" && sendAcademyInfoEmail($validatedData['email'], $validatedData['name'], "Academy-details: {$leadData['object_id']}", "http://books.academy", "academy", $leadData['object_id']);
			if ($request->has('loc_id') && $request->has('sport_id') && stripos($leadData['description'], 'test') === false) {
				$this->assignLead($leadData['loc_id'], $leadData['sport_id'], $lead_id);
			}
			return response()->json(['status' => 1, 'message' => "Please check and verify your email.",]);
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e]);
		}
	}

	public function create_ticket_contactus(Request $request)
	{
		try {
			$userId = session()->get('userId');

			$validatedData = $request->validate([
				'name' => 'required|string',
				'description' => 'required|string',
				'email' => 'required|string',
				'phone' => 'required|string',
				'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
				'category' => 'required|string'
			]);

			$referrer = $request->headers->get('referer');
			if (!$referrer || strpos($referrer, 'bookmyplayer.com') === false) {
				session()->flash('success_message_create_contact_ticket', 'Ticket created successfully');
				return redirect()->back();
			}

			if (stripos($validatedData['description'], 'page: https://www.bookmyplayer.com') === false) {
				session()->flash('success_message_create_contact_ticket', 'Ticket created successfully');
				return redirect()->back();
			}

			$ticket = new Adm_support_ticket();
			$ticket->email = $validatedData['email'];
			$ticket->name = $validatedData['name'];
			$ticket->phone = $validatedData['phone'];
			$ticket->description = $validatedData['description'];
			$ticket->user_id = $userId;
			$ticket->status = "waiting for support";
			$ticket->category = $validatedData['category'];
			$ticket->title = "contact support";

			$ticket->save();

			if ($validatedData['category'] == 'report_page_issue') {
				sendWReportPageIssueEmail($validatedData['name'], $validatedData['phone'], $validatedData['email'], $validatedData['description']);
			}

			session()->flash('success_message_create_contact_ticket', 'Ticket created successfully');
			return redirect()->back();
		} catch (\Exception $e) {
			session()->flash('error_message_create_contact_ticket', $e->getMessage());
			return redirect()->back();
		}
	}

	public function submitSubscriptionRequest(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'email' => 'required|email',
			]);

			// Check if the email already exists
			if (Bmp_subscriptions::where('email', $validatedData['email'])->exists()) {
				return redirect()->back()->withInput()->with('sub_error', 'This email is already subscribed.');
			}

			Bmp_subscriptions::create([
				'email' => $validatedData['email'],
				'ip' => $request->ip(),
				'browser' => strtolower($request->server('HTTP_USER_AGENT')),
				'ref_url' => url()->previous(),
			]);


			return redirect()->back()->with('sub_success', 'You’re subscribed! Stay tuned for exciting updates.');
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect()->back()->withInput()->with('sub_error', $e->getMessage());
		} catch (\Exception $e) {
			return redirect()->back()->withInput()->with('sub_error', $e->getMessage());
		}
	}

	public function submitTicket(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'title' => 'required',
				'description' => 'required',
				'mobile' => 'required',
				'email' => 'required',
			]);

			if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return redirect()->back()->with('error_ticket', 'Invalid email format');
			}

			if (!preg_match('/^\d{10}$/', $request->mobile)) {
				return redirect()->back()->with('error_ticket', 'Invalid mobile number');
			}

			$validatedData['created_at'] = now();
			$validatedData['updated_at'] = now();
			$validatedData['query'] = $request->input('query') ?? null;

			if (Session::has('userId')) {
				$validatedData['user_id'] = Session::get('userId');
				$validatedData['email'] = Session::get('email');
				$validatedData['mobile'] = Session::get('phone');
				$validatedData['title'] = Session::get('name');
			}

			$inserted = DB::table('tickets')->insert($validatedData);
			if ($inserted) {
				return redirect()->back()->with('success_ticket', 'Ticket sent Successfully!');
			} else {
				return redirect()->back()->with('error_ticket', 'Failed to submit ticket. Please try again later.');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('error_ticket', $e->getMessage());
		}
	}

	public function sentOtp(Request $request)
	{
		$phone = $request->input('phone');
		$type = $request->input('type');
		$email = $request->input('email');
		$otp = rand(1000, 9999);
		$user = get_data_row(null, 'bmp_user', 'phone', $phone);

		$logs = DB::table('xx_log')
			->where('attr7', $phone)
			->where('attr6', 'like', '%otp send%')
			->where('creation_date', '>', Carbon::now()->subSeconds(60))
			->latest('id')
			->first();

		if ($logs) {
			$now = Carbon::now();
			$logTime = Carbon::parse($logs->creation_date);
			$remainingSeconds = ceil(60 - $logTime->diffInSeconds($now));
			return ['status' => 0, 'message' => "You can re-send OTP in {$remainingSeconds} seconds."];
		}

		switch ($type) {
			case 'resend_login_otp':
				$otp_type = 'login: resend login otp';
				break;
			case 'resend_signup_otp':
				$otp_type = 'signup: resend signup otp';
				break;
			case 'signup_otp':
				$otp_type = 'signup: signup otp';
				break;
			case 'login_otp':
				$otp_type = 'login: login otp';
				break;
			case 'identity_verification_otp':
				$otp_type = 'verification: identity verification otp';
				break;
			default:
				$otp_type = '';
				break;
		}

		$api_str = "";
		if (strpos($type, 'login') !== false) {
			// $api_str = "https://mshastra.com/sendurl.aspx?user=" . env('M_USER') . "&pwd=" . env('M_PASSWORD') . "&senderid=" . env('SENDER_ID') . "&CountryCode=91&mobileno=$phone&msgtext=Your OTP for login to website BookMyPlayer is $otp. Do not share this code with anyone. This code is valid for 10 minutes. BookMyPlayer.com&smstype=0pe_id=" . env('PE_ID') . "&template_id=1707170652633929804";
			$api_str = "https://mshastra.com/sendurl.aspx?user=" . env('M_USER') . "&pwd=" . env('M_PASSWORD') . "&senderid=" . env('SENDER_ID') . "&CountryCode=91&mobileno=$phone&msgtext=Your OTP for login to website BookMyPlayer is $otp. Do not share this code with anyone. This code is valid for 10 minutes. BookMyPlayer.com&smstype=0&pe_id=" . env('PE_ID') . "&template_id=1707173476703662390";
		} elseif (strpos($type, 'signup') !== false) {
			$api_str = "https://mshastra.com/sendurl.aspx?user=" . env('M_USER') . "&pwd=" . env('M_PASSWORD') . "&senderid=" . env('SENDER_ID') . "&CountryCode=91&mobileno=$phone&msgtext=Your OTP for Registration to website BookMyPlayer is $otp. Do not share this code with anyone. This code is valid for 10 minutes. BookMyPlayer.com&smstype=0&pe_id=" . env('PE_ID') . "&template_id=1707173444781797210";
		} else {
			return ['status' => 0, 'message' => 'Invalid Type.'];
		}

		if ($user) {
			createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "$otp_type request", $phone, $otp);
		} else {
			createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "$otp_type request", $phone, $otp);
		}

		$response = Http::timeout(10)->get($api_str);
		if ($response->successful()) {

			$responseBody = $response->body(); // Get raw response string
			if (strpos($responseBody, 'Send Successful') !== false) {
				Session::put([
					'otp' => $otp,
					'sent_time' => now()
				]);
				session()->save();

				if ($email) {
					send_otp_verification_email($email, $otp, "identity-verification-otp", url()->previous());
				}
				if ($user) {
					createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "$otp_type send", $phone, $otp);
				} else {
					createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "$otp_type send", $phone, $otp);
				}

				return ['status' => 1, 'message' => 'Otp sent.'];
			} else {
				if ($user) {
					createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "$otp_type failed to sent", $phone, $otp);
				} else {
					createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "$otp_type failed to send", $phone, $otp);
				}
				return ['status' => 0, 'message' => "Failed to send OTP( " . explode(',', $responseBody)[2] . " )" ?? 'Failed to send OTP'];
			}
		} else {
			if ($user) {
				createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "send $otp_type error", $phone, $otp);
			} else {
				createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), "send $otp_type error", $phone, $otp);
			}
			return ['status' => 0, 'message' => 'Failed to send OTP.'];
		}
	}


	public function loginSave(Request $request)
	{
		$mobile = $request->input('mobile');
		$enteredOtp = $request->input('otp');
		$userPin = $request->input('userPin');
		$storedOtp = session('otp');
		$sentTime = session('sent_time');
		$type = $request->input('type', "1"); //1.otp login 2.pin login

		// if($type !== '1' || $type !== '2') {
		// 	return ['status' => 0, 'message' => 'Invalid type'];
		// }

		$user = get_data_row(null, 'bmp_user', 'phone', $mobile);
		if ($user) {
			createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login: verify login otp request', $user->type_id, $enteredOtp);
		}

		if ($user === null) {
			createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login: user not found', null, $mobile);
			return ['status' => 0, 'message' => 'user not registered'];
		}

		if ($type === "1") {
			if (!$storedOtp || !$sentTime) {
				return ['status' => 0, 'message' => 'Please resent Otp.'];
			}

			if ($enteredOtp == $storedOtp) {
				$currentTime = now();
				$expiryTime = $sentTime->addMinutes(20);
				$dashboardType = ['1' => 'coach', '2' => 'academy', '3' => 'player', '5' => 'tournament'][$user->type_id] ?? null;
				$parentId = ($user->type_id == 5) ? $user->id : $user->parent_id;
				$entity_url = $dashboardType ? "https://www.bookmyplayer.com/{$dashboardType}/dashboard/{$parentId}" : null;

				if ($currentTime->lt($expiryTime)) {
					$expirationTimestamp = Carbon::now()->addDays(180)->timestamp;

					Session::put([
						'userId' => $user->id,
						'name' => $user->name,
						'phone' => $user->phone,
						'email' => $user->email,
						'session_exp' => $expirationTimestamp,
						'type_id' => $user->type_id,
						'parent_id' => $user->parent_id
					]);
					session()->save();
					session()->forget(['otp', 'sent_time']);
					createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login: logged in', $user->type_id);
					return ['status' => 1, 'message' => 'Logged In', 'redirect_url' => $entity_url ? $entity_url : null];
				} else {
					createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login: login request with expired otp', $user->type_id, $enteredOtp);
					return ['status' => 0, 'message' => 'Otp expired.'];
				}
			} else {
				createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login: login request with incorrect otp', $user->type_id, $enteredOtp);
				return ['status' => 0, 'message' => 'Incorrect Otp.'];
			}
		} else if ($type == "2") {
			if (empty($userPin) || $userPin !== $user->pin) {
				createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login: incorrect PIN', $user->type_id, $userPin);
				return ['status' => 0, 'message' => 'Incorrect PIN.'];
			}

			session()->forget(['otp', 'sent_time']);
		} else {
			return ['status' => 0, 'message' => 'Invalid login type'];
		}

		$expirationTimestamp = Carbon::now()->addDays(180)->timestamp;
		$dashboardType = ['1' => 'coach', '2' => 'academy', '3' => 'player', '5' => 'tournament'][$user->type_id] ?? null;
		$parentId = ($user->type_id == 5) ? $user->id : $user->parent_id;
		$entityUrl = $dashboardType ? "https://www.bookmyplayer.com/{$dashboardType}/dashboard/{$parentId}" : null;

		Session::put([
			'userId' => $user->id,
			'name' => $user->name,
			'phone' => $user->phone,
			'email' => $user->email,
			'session_exp' => $expirationTimestamp,
			'type_id' => $user->type_id,
			'parent_id' => $user->parent_id
		]);
		session()->save();

		createLog($user->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'login: logged in', $user->type_id);

		return ['status' => 1, 'message' => 'Logged In', 'redirect_url' => $entityUrl];

	}

	public function registervalidate(Request $request)
	{

		$enteredOtp = $request->input('otp');
		$name = $request->input('name');
		$phone = $request->input('phone');
		$email = $request->input('email');
		$type_id = $request->input('type_id');
		$sport_id = $request->input('sport_id');
		$loc_id = $request->input('loc_id');
		$new_city = $request->input('new_city');
		$owner = $request->input('owner');
		$height = $request->input('height');
		$weight = $request->input('weight');
		$dob = $request->input('dob');
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$address = $request->input('cus_address');
		$cus_locality_name = $request->input('cus_locality_name');
		$cus_district = $request->input('cus_district');
		$cus_state = $request->input('cus_state');
		$cus_postcode = $request->input('cus_postcode');
		$cus_address1 = $request->input('cus_address1');
		$heighlight = $request->input('heighlight');
		$gender = $request->input('gender');
		$skill = $request->input('skill');
		$is_guardian = $request->input('is_guardian');
		$base_url = "https://www.bookmyplayer.com/";
		$photoId = $request->input('photos'); // Single photo ID
		$updatedPhotoName = null; // To store the new file name
		$logo = null;
		$filename = null;

		if (!$type_id) {
			return ['status' => 0, 'message' => 'something went wrong.'];
		}

		$requiredFields = ['otp', 'name', 'phone', 'sport_id'];
		if ($type_id != 5) {
			$requiredFields[] = 'email';
		}
		if ($type_id == 2) {
			$requiredFields[] = 'owner';
		} elseif ($type_id == 3) {
			$requiredFields = array_merge($requiredFields, ['height', 'weight', 'dob']);
		}

		$missingFields = [];
		foreach ($requiredFields as $field) {
			if (empty($request->input($field))) {
				$missingFields[] = $field;
			}
		}

		if (!empty($missingFields)) {
			return ['status' => 0, 'message' => 'The following fields are missing: ' . implode(', ', $missingFields)];
		}

		$user_mobile = get_data_row(null, 'bmp_user', 'phone', $phone);
		$user_email = ($type_id != 5 && $email != 'bmpregistrationmail@gmail.com')
			? get_data_row(null, 'bmp_user', 'email', $email)
			: null;

		if ($user_mobile || $user_email) {
			$message = $user_mobile
				? 'A user with this phone number is already registered.'
				: 'A user with this email address is already registered.';

			return ['status' => 0, 'message' => $message];
		}//bmpregistrationmail@gmail.com

		$storedOtp = session('otp');
		$sentTime = session('sent_time');
		$bus_id = $request->input('bus_id');
		$browser = $request->header('User-Agent');
		$ipAddress = $request->ip();
		$b2 = new B2Service();

		$types = [1 => 'Coach', 2 => 'Academy', 3 => 'Player', 4 => 'Other', 5 => 'Tournament'];
		$type = $types[$type_id] ?? '';

		$sport_master = get_data_row(null, 'adm_sports_master', 'id', $sport_id);
		$location_info = Adm_location_master::where('id', $loc_id)->first();
		$sport = $sport_master ? strtolower($sport_master->sport) : "select";
		$city = $location_info ? strtolower($location_info->locality_name . ' ' . $location_info->state) : "select select";
		$state = $location_info && $location_info->state !== null ? $location_info->state : "";
		$city_id = null;
		if ($location_info) {
			if ($location_info->city_id === 0 || $location_info->city_id === null) {
				$city_id = $location_info->id;
			} else {
				$city_id = $location_info->city_id;
			}
		}

		if ($type_id == "3" || $type_id == "1") {
			$city = $state = $address = $address1 = "";
			$city_id = $postcode = 0;
			if ($loc_id == 17500) {
				$loc_id = 17500;
				$postcode = $cus_postcode;
				$address = $cus_locality_name;
				$address1 = $cus_address1;
				$city = $cus_district;
				$state = $cus_state;
			} else {
				$loc_id = $location_info->id ?? "";
				$postcode = $location_info->postcode ?? 0;
				$lat = $location_info->lat ?? "";
				$lng = $location_info->lng ?? "";
				$address = $location_info->locality_name ?? "";
				$address1 = $location_info->address1 ?? "";
				$city = $location_info->city ?? "";
				$state = $location_info->state ?? "";
				$city_id = $location_info->city_id === 0 || $location_info->city_id === null ? ($location_info->id ?? "") : ($location_info->city_id ?? "");
			}
		}


		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup: verify signup otp', $type_id, $phone);

		if (!$storedOtp || !$sentTime) {
			return ['status' => 0, 'message' => 'Please resent Otp.'];
		}

		if ($enteredOtp == $storedOtp) {
			$currentTime = now();
			$expiryTime = $sentTime->addMinutes(20);

			if ($currentTime->lt($expiryTime)) {
				// signup for others start
				if ($type_id == 4) {
					$other_user = Bmp_other_details::where('phone', $phone)->orWhere('email', $email)->first();
					if ($other_user) {
						createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup other: account already exists', $type_id, $phone);
						return ['status' => 0, 'message' => 'Account already exists.'];
					}

					$new_user = Bmp_other_details::create(['name' => $request->name, 'email' => $email, 'phone' => $phone, 'description' => $request->description, 'type' => $type_id, 'loc_id' => $loc_id]);
					if ($new_user) {
						createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup other: new account created', $type_id, $phone);
						return ['status' => 1, 'message' => 'Account created successfully.'];
					} else {
						createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup other: account creation failed', $type_id, $phone);
						return ['status' => 0, 'message' => 'Failed to create account. Please try again.'];
					}
				}
				// signup for others ends

				$parent_id = null;
				if ($type_id == "2") {

					$academyData = [
						'name' => $name,
						'phone' => $phone,
						'email' => $email,
						'owner' => $owner,
						'assigned_acid' => $bus_id ? "own_bus_request:$bus_id" : null,
						'sport_id' => $sport_id,
						'loc_id' => $loc_id,
						'city_id' => $city_id,
						'lat' => $lat,
						'lng' => $lng,
						'sport' => $sport,
						'city' => $city,
						'address1' => $address
					];

					if ($loc_id == 17500) {
						$city = ($cus_locality_name === $cus_district) ? "{$cus_locality_name} {$cus_state}" : "{$cus_locality_name} {$cus_district}";
						$academyData = array_merge($academyData, [
							'address2' => $cus_locality_name,
							'address1' => $cus_address1,
							'city' => $cus_district,
							'state' => $cus_state,
							'postcode' => $cus_postcode
						]);
					}

					$parent_id = DB::table('bmp_academy_details_temp')->insertGetId($academyData);
					$url_name = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);

					DB::table('bmp_academy_details_temp')
						->whereNull('url')
						->where('id', $parent_id)
						->update([
							'url' => DB::raw("REPLACE(CONCAT('https://www.bookmyplayer.com/',LOWER('$sport'),'/',REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER('$url_name'),' ','-'),'/','-'),'(','-'),')','-'),'\'','-'),'.','-'),'&','-'),'|','-'),',','-'),'-',REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER('$city'),' ','-'),'/','-'),'(','-'),')','-'),'\'','-'),'.','-'),'&','-'),'|','-'),',','-'),'-aid-',id),'--','-')"),
						]);

					$url = DB::table('bmp_academy_details_temp')->where('id', $parent_id)->value('url');
				}

				if ($type_id == "3") {
					$playerData = [
						'name' => $name,
						'phone' => $phone,
						'email' => $email,
						'sport_id' => $sport_id,
						'loc_id' => $loc_id,
						'height' => $height,
						'weight' => $weight,
						'dob' => $dob,
						'lat' => $lat,
						'lng' => $lng,
						'city_id' => $city_id,
						'sport' => $sport,
						'city' => $city,
						'state' => $state,
						'postcode' => $postcode,
						'address' => $address,
						'address1' => $address1,
						'skill' => $skill,
						'heighlight' => $heighlight,
						'is_guardian' => $is_guardian
					];

					if ($loc_id == 17500) {
						$city = ($cus_locality_name === $cus_district) ? "{$cus_locality_name} {$cus_state}" : "{$cus_locality_name} {$cus_district}";
					} else {
						$city = $location_info ? strtolower($location_info->locality_name . ' ' . $location_info->state) : "select select";
					}

					$parent_id = DB::table('bmp_player_details')->insertGetId($playerData);

					$display_sport = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($sport)), '-');
					$display_city = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($city)), '-');
					$display_name = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-');
					$skill = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($skill)), '-');
					$url = $base_url . $display_name . "-" . $skill . "-" . $display_sport . "-player-in-" . $display_city . "-pid-" . $parent_id;
					// DB::select('CALL `A1.1into_new_player`(?)', [$parent_id]);

					if (!empty($photoId)) {
						$photoId = trim($photoId);
						$sourceFileId = $photoId;

						$fileInfo = $b2->getFileInfo($sourceFileId);
						if ($fileInfo) {
							$fileName = $fileInfo['fileName'];
							$newFileName = 'player/' . $parent_id . '/' . basename($fileName);

							try {
								$copyResponse = $b2->copyFile($sourceFileId, 'bmpcdn90', $newFileName); 
								if ($copyResponse) {
									$updatedPhotoName = basename($newFileName); 
								}
							} catch (Exception $e) {
								\Log::error('B2 Copy Error: ' . $e->getMessage());
							}
						}
					}

					DB::table('bmp_player_details')
						->whereNull('url')
						->where('id', $parent_id)
						->update([
							'url' => $url,
							'logo' => $updatedPhotoName
						]);
					// if ($loc_id == "17500") {
					// 	DB::statement('CALL create_update_player_location_17500(?)', [$parent_id]);
					// } else {
						$url = DB::table('bmp_player_details')->where('id', $parent_id)->value('url');
					// }

				}

				if ($type_id == "1") {
					$coachData = [
						'name' => $name,
						'phone' => $phone,
						'email' => $email,
						'sport_id' => $sport_id,
						'loc_id' => $loc_id,
						'lat' => $lat,
						'lng' => $lng,
						'city_id' => $city_id,
						'sport' => $sport,
						'city' => $city,
						"postcode" => $postcode,
						"state" => $state,
						'address' => $address,
						"address1" => $address1,
						'gender' => $gender
					];

					if ($loc_id == 17500) {
						$city = ($cus_locality_name === $cus_district) ? "{$cus_locality_name} {$cus_state}" : "{$cus_locality_name} {$cus_district}";
					} else {
						$city = $location_info ? strtolower($location_info->locality_name . ' ' . $location_info->state) : "select select";
					}

					$parent_id = DB::table('bmp_coach_details')->insertGetId($coachData);

					$display_sport = $sport_id == 32 ? "yoga-trainer" : ($sport_id == 34 ? "personal-trainer" : (trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($sport)), '-') . "-coach"));
					$display_city = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($city)), '-');
					$display_name = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-');
					$url = $base_url . $display_name . "-" . $display_sport . "-in-" . $display_city . "-chid-" . $parent_id;
					
					// if ($loc_id != 17500) { 
					// DB::select('CALL `A1.1into_new_coach`(?)', [$parent_id]);
					// }

					if (!empty($photoId)) {
						$photoId = trim($photoId);
						$sourceFileId = $photoId;

						$fileInfo = $b2->getFileInfo($sourceFileId);
						if ($fileInfo) {
							$fileName = $fileInfo['fileName'];
							$newFileName = 'coach/' . $parent_id . '/' . basename($fileName);

							try {
								$copyResponse = $b2->copyFile($sourceFileId, 'bmpcdn90', $newFileName); 
								if ($copyResponse) {
									$updatedPhotoName = basename($newFileName); 
								}
							} catch (Exception $e) {
								\Log::error('B2 Copy Error: ' . $e->getMessage());
							}
						}
					}

					DB::table('bmp_coach_details')
						->whereNull('url')
						->where('id', $parent_id)
						->update([
							'url' => $url,
							'profile_img' => $updatedPhotoName
						]);
					// if ($loc_id == "17500") {
					// 	DB::statement('CALL create_update_coach_location_17500(?)', [$parent_id]);
					// }
				}

				if ($type_id == "5") {
					$parent_id = 0;
				}

				$dashboard_type = ['1' => 'coach', '2' => 'academy', '3' => 'player', '5' => 'tournament'][$type_id] ?? null;
				$entity_url = "https://www.bookmyplayer.com/{$dashboard_type}/dashboard/{$parent_id}";

				$randomToken = Str::random(40);
				$isInserted = DB::table('bmp_user')->insertGetId([
					'type' => $type,
					'type_id' => $type_id,
					'parent_tbl' => $type_id == 2 ? 0 : 1,
					'type' => $type,
					'name' => $name,
					'phone' => $phone,
					'email' => $email,
					'parent_id' => $parent_id,
					'ip_address' => $ipAddress,
					'browser' => $browser,
					'email_token' => $randomToken
				]);

				if ($isInserted > 0) {
					if ($type_id == "5") {
						$entity_url = "https://www.bookmyplayer.com/{$dashboard_type}/dashboard/{$isInserted}";
					}
					sendEmailVerificationEmail($email, $name, "", "verify-email", url()->previous());

					$expirationTimestamp = Carbon::now()->addDays(180)->timestamp;
					Session::put([
						'userId' => $isInserted,
						'academy_name' => $name,
						'name' => $name,
						'email' => $email,
						'session_exp' => $expirationTimestamp,
						'phone' => $phone,
						'type_id' => $type_id,
						'parent_id' => $parent_id
					]);
					session()->save();
					session()->forget(['otp', 'sent_time']);
					createLog($isInserted, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup: otp verified', $type_id, $phone);
					createLog($isInserted, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup: success', $type_id, $phone);

					if ($type_id != "3" && $type_id != "5") {
						$response = Http::withHeaders([
							'Authorization' => 'Token token=' . getenv('FRESHWORK_KEY'),
							'Content-Type' => 'application/json',
						])->post('https://bookmyplayer-org.myfreshworks.com/crm/sales/api/contacts', [
									'contact' => [
										'city' => $city,
										'state' => $state,
										'address' => '',
										'email' => $email,
										'custom_field' => [
											'cf_account_type' => $dashboard_type,
											'cf_id' => $parent_id,
											'cf_url' => $url,
											'cf_account_name' => $name,
											'cf_owner_email_address' => $email,
											'cf_sport' => $sport,
											'cf_creation_date' => date('F j, Y \a\t H:i T'),
											'cf_phone' => $phone
										]
									]
								]);
						if ($response->successful()) {
							$fw_id = $response->json('contact.id');
							DB::table('bmp_user')->where('id', $isInserted)->update(['fw_id' => $fw_id]);
						}
					}



					return ["status" => 1, "message" => "User inserted successfully", "redirect_url" => $entity_url ? $entity_url : null];
				} else {
					createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup: Failed to insert user', $type_id, $phone);
					return ["status" => 0, "message" => "Failed to insert user"];
				}
			} else {
				createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup: expired otp', $type_id, $phone);
				return ['status' => 0, 'message' => 'OTP expired.'];
			}
		} else {
			createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'signup: incorrect otp', $type_id, $phone);
			return ['status' => 0, 'message' => 'Incorrect OTP.'];
		}
	}

	public function sendVerificationEmail(Request $request)
	{
		$email = $request->input('email');
		$name = $request->input('name');

		if (!$email || !$name) {
			if ($request->ajax()) {
				return response()->json(['status' => 0, 'message' => 'Required fields are missing.']);
			}
		}

		try {
			$user = DB::table('bmp_user')->where('email', $email)->first();

			if (!$user) {
				if ($request->ajax()) {
					return response()->json(['status' => 0, 'message' => 'User not found with this email']);
				}
			}

			$isemailAlreadyVerified = DB::table('xx_emails')->where('email', $email)->where('type', 'verify-email')->where('email_verified', '1')->count();

			if ($isemailAlreadyVerified > 0) {
				if ($request->ajax()) {
					return response()->json(['status' => 0, 'message' => 'email already verified.']);
				}
			}

			$isemailSentBeforeHour = DB::table('xx_emails')->where('email', $email)->where('type', 'verify-email')->where('creation_date', '>=', DB::raw('NOW() - INTERVAL 1 HOUR'))->count();

			if ($isemailSentBeforeHour) {
				if ($request->ajax()) {
					return response()->json(['status' => 0, 'message' => 'An email was already sent within the last hour.']);
				}
			}

			$isSent = sendEmailVerificationEmail($email, $name, "", "verify-email", url()->previous());

			if ($email == "maheshmhaske241198@gmail.comx") {
				if ($isSent === "Invalid_email") {
					return response()->json([
						'status' => 0,
						'message' => 'unable to send email on ' . $email,
					]);
				}
			}

			if ($request->ajax()) {
				return response()->json(['status' => 1, 'message' => 'Verification email sent successfully.']);
			}

		} catch (Exception $e) {
			if ($request->ajax()) {
				return response()->json(['status' => 0, 'message' => 'An error occurred while processing your request.']);
			}
		}
	}

	public function modifyleadstatus(Request $request)
	{
		try {
			$id = $request->input('lead_assigned_id');
			$userId = session('userId');
			$type_id = session('type_id');
			$type = $request->input('type', 'markasread');
			$feedback = $request->input('feedback');

			if (!$id) {
				if ($request->ajax()) {
					return response()->json(['status' => 0, 'message' => 'Required fields are missing - lead_assignemt_id']);
				}
			}

			if (!$userId || !$type_id) {
				if ($request->ajax()) {
					return response()->json(['status' => 0, 'message' => 'Unauthorized access']);
				}
			}

			$user = DB::table('bmp_user')->where('id', $userId)->first();
			if (!$user) {
				if ($request->ajax()) {
					return response()->json(['status' => 0, 'message' => 'Unauthorized access']);
				}
			}
			$parent_id = $user->parent_id;
			$type_id = $user->type_id;

			if ($type == "markasread") {
				$lead = DB::table('admin.adm_lead_assignment')->where('id', $id)->where('open', 0)->first();
				if (!$lead) {
					if ($request->ajax()) {
						return response()->json(['status' => 0, 'message' => 'lead already opened or invalid lead_id']);
					}
				}

				$compare_id = ($type_id == 1) ? $lead->coach_id : $lead->academy_id;

				if ($parent_id !== $compare_id) {
					if ($request->ajax()) {
						return response()->json(['status' => 0, 'message' => 'not Authorized.']);
					}
				} else {
					$updateResult = DB::table('admin.adm_lead_assignment')
						->where('id', $id)
						->limit(1)
						->update([
							'open' => 1,
							'open_date' => Carbon::now(),
						]);
					if ($request->ajax()) {
						return response()->json(['status' => 1, 'message' => 'lead marked as read']);
					}
				}
			} else if ($type == "feedback") {
				if (!$feedback) {
					if ($request->ajax()) {
						return response()->json(['status' => 0, 'message' => 'Required fields are missing - feedback']);
					}
				}
				$lead = DB::table('admin.adm_lead_assignment')->where('id', $id)->first();

				if (!$lead) {
					if ($request->ajax()) {
						return response()->json(['status' => 0, 'message' => 'Lead already opened or invalid lead_id']);
					}
				} elseif (isset($lead->feedback) && !empty($lead->feedback)) {
					if ($request->ajax()) {
						return response()->json(['status' => 0, 'message' => 'You have already added feedback']);
					}
				}
				$updated = DB::table('admin.adm_lead_assignment')
					->where('id', $id)
					->update(['feedback' => $feedback]);

				if ($updated) {
					if ($request->ajax()) {
						return response()->json(['status' => 1, 'message' => 'Feedback added successfully']);
					}
				} else {
					if ($request->ajax()) {
						return response()->json(['status' => 0, 'message' => 'Failed to add feedback']);
					}
				}
			}

		} catch (Exception $e) {
			if ($request->ajax()) {
				return response()->json(['status' => 0, 'message' => 'An error occurred while processing your request.']);
			}
		}
	}


	public function bmpSearch(Request $request)
	{
		try {
			$search_type = $request->input('search_type');
			$term = $request->input('term');
			$tbl = $request->input('tbl');
			$sport_id = $request->input('sport_id');
			$loc_id = $request->input('loc_id');

			if (empty($tbl) || empty($search_type)) {
				return response()->json(['status' => 0, 'message' => 'tbl, search_type are required for search']);
			}

			$allowedTables = ['bmp_academy_details', 'bmp_player_details', 'bmp_coach_details', 'global'];
			if (!in_array($tbl, $allowedTables)) {
				return response()->json(['status' => 0, 'message' => 'Invalid table name']);
			}

			// Pincode Search
			if ($search_type == "pincode_search") {
				if (empty($term) || (strlen($term) < 2)) {
					return response()->json(['status' => 0, 'message' => 'atleast 2 digit term is required for search']);
				}

				$results = DB::table('admin.adm_postcode')
					->where('postcode', 'like', $term . '%')
					->limit(10)
					->get();

				return response()->json(['status' => 1, 'results' => $results]);
			}

			// Pre Sport Search
			if ($search_type == "pre_sport_search") {
				$sport_tbl = $tbl == "bmp_player_details" ? "bmp_player_listing" : ($tbl == "bmp_coach_details" ? "bmp_coach_listing" : "bmp_sports");
				$results = DB::table($sport_tbl)
					->join('adm_sports_master', "$sport_tbl.sport_id", '=', 'adm_sports_master.id')
					->select("$sport_tbl.sport_id", 'adm_sports_master.name')
					->distinct()
					->get();
				return response()->json(['status' => 1, 'results' => $results]);
			}

			// Pre Location Search
			if ($search_type == "pre_location_search") {
				if (empty($sport_id) || empty($term)) {
					return response()->json(['status' => 0, 'message' => 'sport_id and term are required for search']);
				}

				$sport_tbl = $tbl == "bmp_player_details" ? "bmp_player_listing" : ($tbl == "bmp_coach_details" ? "bmp_coach_listing" : "bmp_sports");

				if (!empty($sport_tbl)) {
					$results = DB::table($sport_tbl)
						->join('adm_location_master', "$sport_tbl.loc_id", '=', 'adm_location_master.id')
						->where("$sport_tbl.sport_id", $sport_id)
						->where('adm_location_master.locality_name', 'like', '%' . $term . '%')
						->select("$sport_tbl.loc_id", 'adm_location_master.locality_name', 'adm_location_master.city', 'adm_location_master.city_id', 'adm_location_master.state')
						->distinct()
						->limit(20)
						->get();

					return response()->json(['status' => 1, 'results' => $results]);
				} else {
					return response()->json(['status' => 0, 'message' => 'Invalid table specified']);
				}
			}

			// Besic Search
			if ($search_type == "basic") {
				if (empty($term)) {
					return response()->json(['status' => 0, 'message' => 'term is required for basic search']);
				}
				if (strlen($term) < 2) {
					return response()->json(['status' => 0, 'message' => 'Term must be at least 2 characters long']);
				}

				$type = match ($tbl) { 'bmp_academy_details' => 'academy', 'bmp_player_details' => 'player', 'bmp_coach_details' => 'coach', default => null, };

				if ($type === null) {
					return response()->json(['status' => 0, 'message' => 'Invalid table name']);
				}

				$results = DB::table($tbl)
					->join('adm_location_master', $tbl . '.loc_id', '=', 'adm_location_master.id')
					->join('adm_sports_master', $tbl . '.sport_id', '=', 'adm_sports_master.id')
					->select(
						$tbl . '.name',
						$tbl . '.url',
						'adm_location_master.locality_name',
						'adm_location_master.city',
						'adm_location_master.city_id',
						'adm_location_master.state',
						'adm_sports_master.name as sport_name',
						DB::raw("'" . $type . "' as type")
					)
					->where($tbl . '.name', 'like', '%' . $term . '%')
					->limit(20)
					->get();

				return response()->json(['status' => 1, 'results' => $results]);
			}

			// Global search
			if ($search_type == 'basic_global') {
				if (empty($term)) {
					return response()->json(['status' => 0, 'message' => 'Term is required for basic_global search']);
				}
				if (strlen($term) < 2) {
					return response()->json(['status' => 0, 'message' => 'Term must be at least 2 characters long']);
				}

				$results = DB::table('bmp_academy_details as academy')
					->select(
						'academy.name',
						'academy.url',
						DB::raw("'academy' as type"),
						'loc.locality_name',
						'loc.city',
						'loc.state',
						'loc.city_id',
						'sport.name as sport_name'
					)
					->leftJoin('adm_location_master as loc', 'academy.loc_id', '=', 'loc.id')
					->leftJoin('adm_sports_master as sport', 'academy.sport_id', '=', 'sport.id')
					->where('academy.name', 'like', '%' . $term . '%')
					->unionAll(
						DB::table('bmp_player_details as player')
							->select(
								'player.name',
								'player.url',
								DB::raw("'player' as type"),
								'loc.locality_name',
								'loc.city',
								'loc.state',
								'loc.city_id',
								'sport.name as sport_name'
							)
							->leftJoin('adm_location_master as loc', 'player.loc_id', '=', 'loc.id')
							->leftJoin('adm_sports_master as sport', 'player.sport_id', '=', 'sport.id')
							->where('player.name', 'like', '%' . $term . '%')
					)
					->unionAll(
						DB::table('bmp_coach_details as coach')
							->select(
								'coach.name',
								'coach.url',
								DB::raw("'coach' as type"),
								'loc.locality_name',
								'loc.city',
								'loc.state',
								'loc.city_id',
								'sport.name as sport_name'
							)
							->leftJoin('adm_location_master as loc', 'coach.loc_id', '=', 'loc.id')
							->leftJoin('adm_sports_master as sport', 'coach.sport_id', '=', 'sport.id')
							->where('coach.name', 'like', '%' . $term . '%')
					)
					->limit(20)
					->get();

				return response()->json(['status' => 1, 'results' => $results]);
			}

			// Advanced Search
			if ($search_type == "advanced_search") {
				if (empty($sport_id) || empty($loc_id)) {
					return response()->json(['status' => 0, 'message' => 'sport and location are required for advance search']);
				}

				$sport_tbl = $tbl == "bmp_player_details" ? "bmp_player_listing" : ($tbl == "bmp_coach_details" ? "bmp_coach_listing" : "bmp_sports");
				$result = DB::table($sport_tbl)->where('sport_id', $sport_id)->where('loc_id', $loc_id)->select('url')->first();

				return response()->json(['status' => 1, 'results' => $result]);
			}
		} catch (Exception $e) {
			if ($request->ajax()) {
				return response()->json(['status' => 0, 'message' => 'An error occurred while processing your request.']);
			}
		}
	}

	public function checkUserExists(Request $request)
	{
		$phone = $request->input('phone');
		$email = $request->input('email');

		$query = DB::table('bmp_user')
			->select('id', 'type_id');

		if ($phone) {
			$query->where('phone', $phone);
		}
		if ($email && $email !== 'bmpregistrationmail@gmail.com') {
			$query->orWhere('email', $email);
		}

		$result = $query->get();

		if ($result->count() > 0) {
			$firstRecord = $result->first();
			if (isset($firstRecord->id)) {
				createLog($firstRecord->id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'verify user: user found', $firstRecord->type_id ?? null, $email);
			} else {
				createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'verify user: user found, no ID available', $phone, $email);
			}
			return ["status" => 1, "message" => "user exists"];
		} else {
			createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'verify user: user not found', null, $email);
			return ["status" => 0, "message" => "user not exists"];
		}
	}


	public function logout(Request $request)
	{
		$userId = session('userId');
		$type_id = session('type_id');
		if ($userId && $type_id) {
			createLog($userId, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'logout', $type_id);
		}
		session()->flush();
		return redirect(url("/"));
	}

	public function searchAcademy(Request $request)
	{
		$search = $request->get('term');
		$results = [];
		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), 'search', $search);

		if (strlen($search) > 3) {
			$academyResults = DB::table('bmp_academy_details')->select('name', 'city', 'state', 'url', 'sport', DB::raw("'Academy' as type"))->where('name', 'like', '%' . $search . '%')->orWhere('address1', 'like', '%' . $search . '%')->orWhere('address2', 'like', '%' . $search . '%')->limit(10)->get()->toArray();
			$results = array_merge($results, $academyResults);
			$playerResults = DB::table('bmp_player_details')->select('name', 'url', 'sport', DB::raw("'Player' as type"))->where('name', 'like', '%' . $search . '%')->limit(10)->get()->toArray();
			$results = array_merge($results, $playerResults);
			$coachResults = DB::table('bmp_coach_details')->select('name', 'url', 'sport', DB::raw("'Coach' as type"))->where('name', 'like', '%' . $search . '%')->limit(10)->get()->toArray();
			$results = array_merge($results, $coachResults);
			$coachResults = DB::table('bmp_certifications')->select('name', 'url', 'sport', DB::raw("'Certifications' as type"))->where('name', 'like', '%' . $search . '%')->limit(10)->get()->toArray();
			$results = array_merge($results, $coachResults);
			$coachResults = DB::table('bmp_league_details')->select('name', 'url', 'sport', DB::raw("'Tournament' as type"))->where('name', 'like', '%' . $search . '%')->limit(10)->get()->toArray();
			$results = array_merge($results, $coachResults);
			$xxx = DB::table('bmp_states')->select('locality_name', 'state', 'city', 'url', DB::raw("'locality' as type"))->where('locality_name', 'like', '%' . $search . '%')->limit(10)->get()->toArray();
			$results = array_merge($results, $xxx);
		}

		return response()->json($results);
	}

	public function search_academies(Request $request)
	{
		$name = $request->name;

		$entities = Academy::where('name', 'like', '%' . $name . '%')
			->select('name', 'sport', 'city', 'state', 'url')
			->limit(20)
			->get();

		$html = '';

		if ($entities->isEmpty()) {
			// Add a message when no results are found
			$html .= '<li class="list-group-item text-center">No data found</li>';
		} else {
			foreach ($entities as $entity) {
				$html .= '<a href="' . $entity->url . '" target="_blank">';
				$html .= '<li class="list-group-item">';
				$html .= '<span class="font-weight-bold">Academy:</span> ';
				$html .= htmlspecialchars($entity->name) . ' - ';
				$html .= '<span class="text-primary-custom">' . htmlspecialchars($entity->sport) . '</span> - ';
				$html .= '<span class="text-primary">' . htmlspecialchars($entity->city) . '</span> - ';
				$html .= '<span class="text-danger">' . htmlspecialchars($entity->state) . '</span>';
				$html .= '</li></a>';
			}
		}

		return response()->json(['status' => 'success', 'data' => $html]);
	}

	public function get_subcategories(Request $request)
	{
		$id = $request->id; // 1.popular cities(ac) 2.popular sport(ac) 3.popular cities(coaches)
		$html = '';

		if ($id == 1) {
			$subcategories = Adm_location_master::where('menu', 1)->whereNotNull('image')->orderBy('locality_name')->get();
			$loadmorecities = Adm_location_master::where('menu', 1)->whereNull('image')->orderBy('locality_name')->get();

			$html .= '<div id="cityModal" class="city-box d-flex justify-content-between align-items-center" style="gap: 1rem;">';
			$html .= '<div class="categorySearch">';
			$html .= '<input type="text" id="categorySearchInp" placeholder="Search city" autocomplete="off">';
			$html .= '<button><i class="bx bx-search"></i></button>';
			$html .= '</div>';
			$html .= '<img src="https://d2bdxhtfh3zsqc.cloudfront.net/asset/images/menu_cross.svg" alt="Cross" id="closeCityModal">';
			$html .= '</div>';
			$html .= '<h6 class="text-center mt-3">or</h6>';
			$html .= '<h6 class="text-center mt-3"><a href="javascript:void(0)" class="primary-color">Use Your Current Location <i class="bx bx-map"></i></a></h6>';
			$html .= '<h5 class="text-center mt-3">Popular City </h5>';

			$html .= '<ul class="categoryList city-img-list">';
			foreach ($subcategories as $subcategory) {
				$html .= '<li><a href="' . $subcategory->url . '" class="text-decoration-none"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/menu/' . $subcategory->image . '" class="lazy" alt="' . ucwords($subcategory->locality_name) . '" height="60px; width:60px"/><p class="m-0 text-center categoryTitle">' . ucwords($subcategory->locality_name) . '</p><a></li>';
			}
			$html .= '</ul>';

			if (count($loadmorecities) > 0) {
				$html .= '<div class="d-flex justify-content-center"><a class="text-center primary-color toggleMore" href="javascript:void(0)" data-val="cities">See all Cities</a></div>';

				$html .= '<ul class="categoryList city-list">';
				foreach ($loadmorecities as $city) {
					$html .= '<li class="hiddenCategoires d-none"><a href="' . $city->url . '" class="text-decoration-none"><p class="m-0 categoryTitle">' . $city->locality_name . '</p><a></li>';
				}
				$html .= '</ul>';
			}
		} elseif ($id == 2) {
			$subcategories = MenuSports::where('sitemap', 1)->orderBy('name')->get();
			$title = "Sport Academies";

			$html .= '<div style="display: flex; justify-content: space-between; align-items: center;">';
			$html .= '<div class="categorySearch" style="display: flex; align-items: center;">';
			$html .= '<input type="text" id="categorySearchInp" placeholder="Search sport" style="flex-grow: 1; margin-right: 10px;" autocomplete="off">';
			$html .= '<button><i class="bx bx-search"></i></button>';
			$html .= '</div>';
			$html .= '<img src="https://d2bdxhtfh3zsqc.cloudfront.net/asset/images/menu_cross.svg" alt="Cross" id="closeSportModal">';
			$html .= '</div>';
			$html .= '<h3 class="text-center mt-3">' . $title . '</h3>';
			$html .= '<ul class="categoryList city-img-list">';
			foreach ($subcategories as $subcategory) {
				$html .= '<li><a href="' . $subcategory->url . '" class="text-decoration-none"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/menu/' . $subcategory->image . '" class="lazy" alt="' . ucwords($subcategory->name) . '" height="60px; width:60px"/><p class="m-0 text-center categoryTitle">' . ucwords($subcategory->name) . '</p><a></li>';
			}
			$html .= '</ul>';
		} elseif ($id == 3) {
			$subcategories = MenuSports::whereNotNull('coach_url')->orderBy('name')->get();
			$title = "Sport Coaches";

			$html .= '<div style="display: flex; justify-content: space-between; align-items: center;">';
			$html .= '<div class="categorySearch" style="display: flex; align-items: center;">';
			$html .= '<input type="text" id="categorySearchInp" placeholder="Search sport" style="flex-grow: 1; margin-right: 10px;" autocomplete="off">';
			$html .= '<button><i class="bx bx-search"></i></button>';
			$html .= '</div>';
			$html .= '<img src="https://d2bdxhtfh3zsqc.cloudfront.net/asset/images/menu_cross.svg" alt="Cross" id="closeSportModal">';
			$html .= '</div>';
			$html .= '<h3 class="text-center mt-3">' . $title . '</h3>';
			$html .= '<ul class="categoryList city-img-list">';
			foreach ($subcategories as $subcategory) {
				$html .= '<li><a href="' . $subcategory->coach_url . '" class="text-decoration-none"><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/menu/' . $subcategory->image . '" class="lazy" alt="' . ucwords($subcategory->name) . '" height="60px; width:60px"/><p class="m-0 text-center categoryTitle">' . ucwords($subcategory->name) . '</p><a></li>';
			}
			$html .= '</ul>';
		}

		return response()->json(['status' => 'success', 'data' => $html]);
	}


	public function recordAction(Request $request, $id, $action, $actionInfo)
	{
		// createLog($id, $request->ip(),$request->url(),URL::previous(),$this->getDeviceType(),$action,$actionData);
		$isInserted = DB::table('xx_log')->insert([
			'attr1' => $id,
			'attr2' => $request->ip(),
			'attr3' => $request->url(),
			'attr4' => URL::previous(),
			'attr5' => $this->getDeviceType(),
			'attr6' => $action,
			'attr7' => $actionInfo
		]);

		if ($isInserted) {
			return ["status" => 1];
		} else {
			return ["status" => 0];
		}

	}

	public function checkUserDetailsExists(Request $request)
	{
		$email = $request->input('email');
		$mobile = $request->input('mobile');
		$type = $request->input('type');

		if (!$type || !in_array($type, ['email', 'mobile'])) {
			return ["status" => 0, "message" => "Invalid 'type' value. It should be either 'email' or 'mobile'."];
		}

		$result = false;

		if ($type === 'email') {
			$result = DB::table('bmp_user')->where('email', $email)->exists();
		} elseif ($type === 'mobile') {
			$result = DB::table('bmp_user')->where('phone', $mobile)->exists();
		}

		if ($result) {
			return ["status" => 1, "message" => "$type exists"];
		} else {
			return ["status" => 0, "message" => "$type does not exist"];
		}
	}

	public function verifyEmail(Request $request, $token)
	{
		$user = get_data_row(null, 'xx_emails', 'email_token', $token);
		$user_info = get_data_row(null, 'bmp_user', 'email', $user->email);
		// dd($user_info->type_id);
		$status = 0;
		$message = "";
		if (!$user) {
			$status = 0;
			$message = "Invalid token. The verification link is either expired or incorrect.";
		} else {
			$table = null;
			$url = null;
			if ($user_info->type_id == 1) {
				$table = 'bmp_coach_details';
			} elseif ($user_info->type_id == 3) {
				$table = 'bmp_player_details';
			}
			if ($table) {
				$details = get_data_row(null, $table, 'id', $user_info->parent_id);
				if ($details) {
					$url = $details->url;
				}
			}

			if ($user->email_verified == 1) {
				$status = 0;
				$message = "Email already verified.";
			} else {
				DB::table('xx_emails')->where('email_token', $token)->update(['email_verified' => 1]);
				if ($user_info) {
					DB::table('bmp_user')->where('id', $user_info->id)->update(['email_verified' => 1]);
				}

				$status = 1;
				$message = "Email verified successfully!";
				if ($user_info->type_id == 1) {
					sendWelcomeEmailCoach($user_info->email, $user_info->name, $user_info->id, $url, "welcome-email", url()->previous());
				} elseif ($user_info->type_id == 3) {
					sendWelcomeEmailPlayer($user_info->email, $user_info->name, $user_info->id, "welcome-email", $url, url()->previous());
				} else {
					sendWelcomeEmailAcademy($user_info->email, $user_info->name, $user_info->id, "welcome-email", url()->previous());
				}
			}
		}

		$data = array(
			"page" => 'email verification',
			"title" => 'BookMyPlayer: Email Verification',
			"des" => 'Email Verification !',
			"url" => 'https://www.bookmyplayer.com',
			"breadcrumbs" => [],
			"status" => $status,
			"message" => $message,
		);
		return view('static.email_verification')->with('data', $data);
	}

	public function testEmail(Request $request, $email, $name)
	{

		// Check for Basic Auth credentials
		$username = $request->header('PHP_AUTH_USER');
		$password = $request->header('PHP_AUTH_PW');

		if (!$username || !$password) {
			return response()->json([
				'success' => false,
				'message' => 'Authentication required'
			], 401)->header('WWW-Authenticate', 'Basic');
		}

		if (!$this->validateCredentials($username, $password)) {
			return response()->json([
				'success' => false,
				'message' => 'Invalid credentials'
			], 401);
		}



		// Send the test email
		$isSent = send_test_email($email, $name, url()->previous());

		// Return false if sending failed
		if ($isSent === false) {
			return response()->json([
				'success' => false,
				'message' => $name . ' mail sending failed.'
			]);
		}
		return response()->json([
			'success' => true,
			'message' => $name . ' mail sent successfully.'
		]);
	}

	public function sentCustomEmails(Request $request)
	{

		$username = $request->header('PHP_AUTH_USER');
		$password = $request->header('PHP_AUTH_PW');

		if (!$username || !$password) {
			return response()->json([
				'success' => false,
				'message' => 'Authentication required'
			], 401)->header('WWW-Authenticate', 'Basic');
		}

		if (!$this->validateCredentials($username, $password)) {
			return response()->json([
				'success' => false,
				'message' => 'Invalid credentials'
			], 401);
		}
		$users = DB::table('bmp_user as u')
			->join('bmp_academy_details as a', 'u.parent_id', '=', 'a.id')
			->select('u.id', 'u.email', 'u.type_id', 'u.parent_id', 'a.sport_id', 'a.name')
			->where('u.type_id', 2)
			->where('u.id', '>', 2985)
			->whereBetween('u.id', [3841, 3932])
			// ->whereNotIn('a.sport_id', [2, 3])  // Exclude sport_id 2 and 3
			->get();

		// dd($users);

		// Player
		$users = DB::table('bmp_user')
			->select('id', 'email', 'type_id', 'name')
			->where('type_id', 1)
			// ->where('id',">",3459)
			->whereNotNull('email')
			->whereBetween('id', [3128, 3924])
			->get();



		// $users = [
		// 	(object)[
		// 		'id' => 162,
		// 		'email' => 'maheshmhaske241198@gmail.com',
		// 		'type_id' => 2,
		// 		'parent_id' => 22107,
		// 		'sport_id' => 3,
		// 		'name' => 'Talent Hunt Cricket Academy',
		// 	],
		// 	(object)[
		// 		'id' => 169,
		// 		'email' => 'maheshmhaske241198@gmail.com',
		// 		'type_id' => 2,
		// 		'parent_id' => 24008,
		// 		'sport_id' => 12,
		// 		'name' => 'Fine Art Academy (Prashant Date)',
		// 	],
		// 	(object)[
		// 		'id' => 181,
		// 		'email' => 'maheshmhaske241198@gmail.com',
		// 		'type_id' => 2,
		// 		'parent_id' => 25675,
		// 		'sport_id' => 28,
		// 		'name' => 'Samarth Karate Academy',
		// 	]
		// ];


		dd($users);


		$responses = [];
		$successCount = 0;
		$failureCount = 0;

		foreach ($users as $user) {
			$email = $user->email;
			$name = $user->name;
			$isSent = send_custom_email($email, $name);

			if ($isSent === false) {
				$responses[] = $email . ' mail sending failed.';
				$failureCount++;
			} else {
				$responses[] = $email . ' mail sent successfully.';
				$successCount++;
			}
		}

		return response()->json([
			'success' => true,
			'message' => 'Email sending process completed.',
			// 'total_emails' => $users->count(),
			'emails_sent' => $successCount,
			'emails_failed' => $failureCount,
			'details' => $responses
		]);
	}

	private function validateCredentials($username, $password)
	{
		$validUsername = 'bmp_';
		$validPassword = 'Admin@3332';

		return $username === $validUsername && $password === $validPassword;
	}

	public function unsubscribe(Request $request, $token)
	{
		$breadcrumbs = [
			(object) [
				'name' => 'unsubscribe',
				'link' => ''
			]
		];

		$data = [
			'status' => 0,
			'title' => '',
			'des' => '',
			'breadcrumbs' => $breadcrumbs,
			'message' => ''
		];

		$emailInfo = xx_emails::where('unsubscribe_token', $token)->first();
		if (!$emailInfo) {
			$data['title'] = 'Failed to unsubscribe - Invalid token';
			$data['message'] = 'Failed to unsubscribe due to an <span>invalid token</span>';
			return view('static.unsubscribe')->with('data', $data);
		}

		$email = strtolower(trim($emailInfo->email));
		$isEmailAlreadyUnsubscribed = xx_email_spam::where('email', $email)->first();
		if ($isEmailAlreadyUnsubscribed) {
			$data['title'] = 'Failed to unsubscribe - Email is already unsubscribed.';
			$data['message'] = 'you have <span>already Unsubscribed</span>';
			return view('static.unsubscribe')->with('data', $data);
		}

		$emailSpam = new xx_email_spam();
		$emailSpam->email = $email;
		$emailSpam->reason = "unsubscribe:" . $emailInfo->id;
		$emailSpam->save();

		$data['status'] = 1;
		$data['title'] = 'Email unsubscribed successfully.';
		$data['message'] = 'You have <span>Successfully Unsubscribed</span> from BookMyPlayer';

		return view('static.unsubscribe')->with('data', $data);
	}


	private function extractPublicId($url)
	{
		$urlParts = parse_url($url);
		$path = isset($urlParts['path']) ? ltrim($urlParts['path'], '/') : '';
		$path = preg_replace('/^cloud2cdn\//', '', $path);
		$path = preg_replace('/^image\/upload\//', '', $path);
		$path = preg_replace('/^video\/upload\//', '', $path);
		$path = preg_replace('/\..+$/', '', $path);

		return $path;
	}

	public function searchCity(Request $request, $city)
	{
		$results = DB::table('bmp_states')
			->select('*')
			->where('city', 'like', '%' . $city . '%')
			->limit(30)
			->get();

		return response()->json($results);
	}

	public function markAllNotificationsAsRead(Request $request)
	{
		try {
			$id = session()->get('userId');

			if (!$id) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized request'], 401);
			}

			DB::table('bmp_notifications')
				->where('user_id', $id)
				->whereNull('read_at')
				->update(['read_at' => now()]);

			return response()->json(['status' => 1, 'message' => 'All Notifications Marked as Read']);
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'something went wrong']);

		}
	}

	public function getMenuCities(Request $request)
	{
		try {
			$cities = get_data_array(null, 'bmp_states_menu', 'show', 1);
			return response()->json(['status' => 1, 'message' => 'cities', 'data' => $cities]);
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'something went wrong']);
		}
	}

	public function getAdminSports(Request $request)
	{
		try {
			// $sports = get_data_array(null, 'adm_sports_master');
			$sports = get_data_array(null, 'adm_sports_master', null, null, null, null, 'name', 'asc');

			return response()->json(['status' => 1, 'message' => 'sports', 'data' => $sports]);
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'something went wrong']);

		}
	}

	public function deleteUser(Request $request)
	{
		try {
			$entity = $request->input('entity');

			if (!$entity) {
				return response()->json(['status' => 0, 'message' => 'Email or phone required'], 401);
			}

			$allowedEntities = ['9532222456', '7558269998', '8081683816', '7987803489', '6266753002', '8959595204', '9977161252', '7000677106', '7974987419', '7000645609', '7979100801', '9811155939'];

			if (!in_array($entity, $allowedEntities)) {
				return response()->json(['status' => 0, 'message' => "Deletion of $entity not allowed"], 401);
			}

			$user = DB::table('bmp_user')
				->where('phone', $entity)
				->orWhere('email', $entity)
				->first();

			if (!$user) {
				return response()->json(['status' => 0, 'message' => 'User not found with this details.'], 404);
			}

			$parent_id = $user->parent_id;
			$type_id = $user->type_id;

			$tbl = "";
			switch ($type_id) {
				case 1:
					$tbl = $user->parent_tbl == 0 ? 'bmp_coach_details_temp' : 'bmp_coach_details';
					break;
				case 2:
					$tbl = $user->parent_tbl == 0 ? 'bmp_academy_details_temp' : 'bmp_academy_details';
					break;
				case 3:
					$tbl = $user->parent_tbl == 0 ? 'bmp_player_details_temp' : 'bmp_player_details';
					break;
				default:
					break;
			}

			if ($associate_entity = get_data_row(null, $tbl, 'id', $parent_id)) {
				DB::table($tbl)->where('id', $parent_id)->delete();
			}

			$affected = DB::table('bmp_user')->where('id', $user->id)->delete();

			if ($affected > 0) {
				return response()->json(['status' => 1, 'message' => 'User and associated entity deleted successfully.']);
			} else {
				return response()->json(['status' => 0, 'message' => 'No records were deleted.'], 404);
			}
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e], 500);
		}
	}


	public function getAllNotifications(Request $request)
	{
		try {
			$id = session()->get('userId');

			if (!$id) {
				return response()->json(['status' => 0, 'message' => 'Unauthorized request'], 401);
			}

			$unreadNotifications = DB::table('bmp_notifications')
				->where('user_id', $id)
				->whereNull('read_at')
				->count();

			$notifications = get_data_array(null, 'bmp_notifications', 'user_id', $id, null, null, 'id', 'desc', 100);

			return response()->json([
				'status' => 1,
				'message' => 'Notifications.',
				'data' => $notifications,
				'unread_notifications' => $unreadNotifications
			]);

		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'something went wrong']);

		}
	}

	public function sendJobApplication(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'application_id' => 'required',
				'name' => 'required',
				'email' => 'required|email',
				'linkedin_url' => 'nullable|url',
				'phone' => 'required',
				'resume' => 'required',
			]);

			$validatedData['creation_date'] = now();
			$validatedData['site'] = 'bookmyplayer';
			$inserted = DB::table('xx_careers')->insert($validatedData);

			if ($inserted) {
				return redirect()->back()->with('success_message', 'Application submitted successfully!');
			} else {
				return redirect()->back()->with('error_message', 'Failed to submit application. Please try again later.');
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('error_message', $e->getMessage());
		}
	}

	public function addReviewCoach(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'object_id' => 'required|string',
				'name' => 'required|string',
				'comment' => 'required|string',
				'rating' => 'required|string',
				'email' => 'required|email',
				'phone' => 'required|string'
			]);

			// if (!empty($validatedData['phone']) && !empty($validatedData['email'])) {
			// 	$existingMobileObjectId = Bmp_review_coaches::where('phone', $validatedData['phone'])
			// 		->where('object_id', $validatedData['object_id'])
			// 		->exists();

			// 	$existingEmailObjectType = Bmp_review_coaches::where('email', $validatedData['email'])
			// 		->where('object_id', $validatedData['object_id'])
			// 		->exists();

			// 	if ($existingMobileObjectId || $existingEmailObjectType) {
			// 		session()->flash('error_message_add_review_coach', 'You already reviewed this coach.');
			// 		return redirect()->back()->withInput();
			// 	}
			// }

			$review = new Bmp_review_coaches($validatedData);
			$review->save();

			session()->flash('success_message_add_review_coach', 'Review added successfully');
			return redirect()->back();
		} catch (\Exception $e) {
			session()->flash('error_message_add_review_coach', 'Something went wrong');
			return redirect()->back();
		}
	}

	public function addReviewPlayer(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'object_id' => 'required|string',
				'name' => 'required|string',
				'comment' => 'required|string',
				'rating' => 'required|string',
				'email' => 'required|email',
				'phone' => 'required|string'
			]);

			// if (!empty($validatedData['phone']) && !empty($validatedData['email'])) {
			// 	$existingMobileObjectId = Bmp_review_player::where('phone', $validatedData['phone'])
			// 		->where('object_id', $validatedData['object_id'])
			// 		->exists();

			// 	$existingEmailObjectType = Bmp_review_player::where('email', $validatedData['email'])
			// 		->where('object_id', $validatedData['object_id'])
			// 		->exists();

			// 	if ($existingMobileObjectId || $existingEmailObjectType) {
			// 		session()->flash('success_message_add_review_player', 'You have already reviewed this Player.');
			// 		return redirect()->back()->withInput();
			// 	}
			// }

			$review = new Bmp_review_player($validatedData);
			$review->save();

			session()->flash('success_message_add_review_player', 'Review added successfully');
			return redirect()->back();
		} catch (\Exception $e) {
			session()->flash('error_message_add_review_player', 'Something went wrong');
			return redirect()->back();
		}
	}

	public function test(Request $request, $name)
	{

		$id = 1;
		$url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
		$agent = new Agent();
		$mobile = $agent->isMobile();
		$d = Bmp_academy_details::find($id);

		if (!$d) {
			return redirecturl($request->getRequestUri(), $sport);
		}
		DB::table('bmp_academy_details')->where('id', $id)->increment('views', 1);
		createLog($id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType());

		$sport_byid = Adm_sports_master::find($d->sport_id);
		$sport = $d->sport_id ? $sport_byid->name : 'sports';
		$location = Adm_location_master::find($d->loc_id);
		$bredsport = Bmp_sports::where('sport', $sport)->where('type', 'listing')->where('city', $d->city)->first();
		$breadcrumbs = [];


		if (!$location) {
			$breadcrumbs = [
				(object) [
					'name' => "{$sport_byid->name} Academies in India",
					'link' => "https://www.bookmyplayer.com/",
				],
				(object) [
					'name' => $d->name,
					'link' => ''
				]
			];

		} else {
			$breadcrumbs = [
				(object) [
					'name' => "{$sport_byid->name} Academies in " . $location->locality_name,
					'link' => $location->url,
				],
				(object) [
					'name' => $d->name,
					'link' => ''
				]
			];
		}

		$about = $d->about;
		$highlights = explode('|', $d->review_highlights);
		$positive = $negative = $neutral = [];

		foreach ($highlights as $highlight) {
			if (strpos($highlight, ':') !== false) {
				[$key, $value] = explode(':', $highlight);
				if (strpos($value, ',') !== false) {
					${$key} = array_merge(${$key}, explode(',', $value));
				} else {
					${$key}[] = $value;
				}
			}
		}

		$positive ??= [];
		$negative ??= [];
		$neutral ??= [];

		/*if ($about == null || $about == "") {
																																																																																	$defaultabout   = Bmp_about::where('sport_id', $d->sport_id)->where('object', '1')->first();
																																																																																	$about          = $defaultabout ? str_replace(['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'], [$d->name, $d->city, $d->address2], $defaultabout->about) : "";
																																																																																} elseif (strlen($about) < 500) {
																																																																																	$defaultabout   = Bmp_about::where('sport_id', $d->sport_id)->where('object', '1')->first();
																																																																																	$about          = $defaultabout ? $about . "</br></br><b><u> Further information about the Academy: </b></u></br>" . str_replace(['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'], [$d->name, $d->city, $d->address2], $defaultabout->about) : "";
																																																																																}*/

		if ($about == null || $about == "" || strlen($about) < 500) {
			$defaultabout = Bmp_about::where('sport_id', $d->sport_id)->where('object', '1')->first();

			if ($defaultabout) {
				$replacedAbout = str_replace(['ACADEMY_NAME', 'CITY_NAME', 'ADDRESS1'], [$d->name, $d->city, $d->address2], $defaultabout->about);

				if ($about == null || $about == "") {
					$about = $replacedAbout;
				} elseif (strlen($about) < 500) {
					$about .= "</br></br><b><u> Further information about the Academy: </b></u></br>" . $replacedAbout;
				}
			}
		}


		$schools = get_data_array(null, 'bmp_schools', 'district', strtoupper($d->city), null, null, 'id', 'desc', 10);
		$schools = count($schools) < 1 ? get_data_array(null, 'bmp_schools', 'block', strtoupper($d->city), null, null, 'id', 'desc', 10) : $schools;
		$schools = count($schools) < 1 ? get_data_array(null, 'bmp_schools', 'state', strtoupper($d->state), null, null, 'id', 'desc', 10) : $schools;
		$tournaments = Bmp_league_details::where('sport_id', $d->sport_id)->take(10)->get();
		$nearbyacademies = $d->lat && $d->lng ? getNearbyAcademy('bmp_academy_details', $d->lat, $d->lng, 50, 5, ['bmp_academy_details.sport' => $sport], 'rating', 'desc') : [];
		$otherLocalities = Bmp_sports::where('sport_id', $d->sport_id)->where('city_id', $d->city_id)->where('type', 'listing')->orderBy('views', 'desc')->take(25)->get();
		$certificates = Bmp_certifications::where('sport_id', $d->sport_id)->take(10)->get();
		$faqs = Bmp_sport_faq::where('sport_id', $d->sport_id)->where('object', 'academy')->take(10)->get();
		$otherLocalities = Bmp_sports::where('sport_id', $d->sport_id)->where('city_id', $d->city_id)->where('type', 'listing')->orderBy('views', 'desc')->take(25)->get();
		$reviews = Bmp_reviews::where('object_type', 'academy')->where('object_id', $id)->take(10)->get();
		$photos = explode(',', $d->photos);
		$videos = explode(',', $d->videos);

		//if($id == 75){
		// dd($otherLocalities);
		//}

		if ($mobile) {
			if ($d->banner != null && $d->banner != "") {
				$banner = env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->banner}";
			} elseif (count(array_filter($photos)) > 0) {
				$banner = env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$photos[0]}";
			} else {
				$banner = env('AWS_S3_BASE_URL') . "/default/" . strtolower($sport) . "_banner.webp";
			}
			$logo = (is_null($d->logo) || $d->logo === "") ? env('AWS_S3_BASE_URL') . "/default/academy_default_logo.webp" : env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->logo}";
		} else {
			if ($d->banner != null && $d->banner != "") {
				$banner = env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->banner}";
			} elseif (count(array_filter($photos)) > 0) {
				$banner = env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$photos[0]}";
			} else {
				$banner = env('AWS_S3_BASE_URL') . "/default/" . strtolower($sport) . "_banner.webp";
			}
			$logo = (is_null($d->logo) || $d->logo === "") ? env('AWS_S3_BASE_URL') . "/default/academy_default_logo.webp" : env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->logo}";
		}

		$fee = $d->fee;
		if (!$fee || $fee == null) {
			$fee = "Please Contact Academy";
		}

		$address = implode(', ', array_filter([$d->address1, $d->address2, $d->city, $d->state, $d->postcode]));
		$review_summary = explode('$', $d->review_summary);

		if ($sport == 'gym') {
			$title = ucwords($d->name) . " : " . ucwords($sport) . " & Fitness Center in " . ($d->address2 ? $d->address2 . ", " : "") . $d->city;
			$des = 'Discover your best fit at ' . $d->name . ' ' . $d->city . '! State-of-the-art facilities, 24/7 access, and a supportive community in ' . $d->state . '. Start today!';
			$keywords = $d->name . ' ' . $d->city . ', Gym in ' . $d->city . ', Fitness Center in ' . $d->address2 . ' ' . $d->city . ', 24/7 Gym near me, Health Club ' . $d->city . ', Best gym in ' . $d->city . ', Fitness Membership ' . $d->city . ', Gym with Personal Trainer in ' . $d->city;
		} else {
			$title = ucwords($d->name) . " | " . ($d->address2 ? $d->address2 . ", " : "") . $d->city;
			$des = $d->name . ' ' . $sport . ' coaching and training in ' . ($d->address2 ? $d->address2 . ", " : "") . $d->city . '. Find fee, charges, timings, reviews, photos, ratings and contact number. Book coaching classes. Join training schedule & timings with free trial.';
			$keywords = "What is the coaching fee of " . $d->name . ", how much does it cost and how to join " . $d->name . ", batch timings for joining " . $d->name . " fee, batches for " . $d->name . ", Best academy for playing " . $sport;
		}

		//  Photo Processing Start
		$banners = $photos;
		function checkImageExists($url)
		{
			$response = Http::head($url);
			return $response->successful();
		}

		foreach ($banners as $key => $photo) {
			$external_link = env('AWS_S3_BASE_URL_70') . "/academy/{$id}/{$photo}";
			if (!checkImageExists($external_link)) {
				unset($banners[$key]);
			}
		}

		$banners = array_values($banners);
		//  Photo Processing End

		$data = array(
			"cattype" => 'aid',
			"page" => 'academy_details',
			"title" => $title,
			"des" => $des,
			"review_summary" => $d->review_summary,
			"r_summary" => $review_summary,
			"keywords" => $keywords,
			"d" => $d,
			"sport_url" => '',
			"mobile" => $agent->isMobile(),
			"fee" => $fee,
			"schools" => $schools,
			"reviews" => $reviews,
			"upcomingtournament" => $tournaments,
			"nearbyacademies" => $nearbyacademies,
			"certificates" => $certificates,
			"faqs" => $faqs,
			"url" => $url,
			"otherLocalities" => $otherLocalities,
			"listingTitle" => $d->name,
			"address" => str_replace([',,'], [','], $address),
			"banner" => $banner,
			"logo" => $logo,
			"photos" => $photos,
			"banners" => $banners,
			"videos" => $videos,
			"positive" => $positive,
			"negative" => $negative,
			"neutral" => $neutral,
			"about" => str_replace([',,'], [','], $about),
			"id" => $id,
			"breadcrumbs" => $breadcrumbs,
			"object_type" => 'academy',
			"template" => "academyDetails"
		);


		// Example data for view
		$data = [
			"title" => 'Ui Test',
			"des" => 'BookMyPlayer: test!',
			"url" => 'https://www.bookmyplayer.com',
			"breadcrumbs" => [],
			"cattype" => 'aid',
			"page" => 'academy_details',
			"title" => $title,
			"des" => $des,
			"review_summary" => $d->review_summary,
			"r_summary" => $review_summary,
			"keywords" => $keywords,
			"d" => $d,
			"sport_url" => '',
			"mobile" => $agent->isMobile(),
			"fee" => $fee,
			"schools" => $schools,
			"reviews" => $reviews,
			"upcomingtournament" => $tournaments,
			"nearbyacademies" => $nearbyacademies,
			"certificates" => $certificates,
			"faqs" => $faqs,
			"url" => $url,
			"otherLocalities" => $otherLocalities,
			"listingTitle" => $d->name,
			"address" => str_replace([',,'], [','], $address),
			"banner" => $banner,
			"logo" => $logo,
			"photos" => $photos,
			"banners" => $banners,
			"videos" => $videos,
			"positive" => $positive,
			"negative" => $negative,
			"neutral" => $neutral,
			"about" => str_replace([',,'], [','], $about),
			"id" => $id,
			"breadcrumbs" => $breadcrumbs,
			"object_type" => 'academy',
			"template" => "academyDetails"
		];

		return view($name)->with('data', $data);
	}

	public function getEntityCred(Request $request)
	{
		try {
			$objectType = $request->input('object_type');
			$objectId = $request->input('object_id');

			if (!$objectType || !$objectId) {
				return response()->json(['status' => 0, 'message' => 'object_type and object_id are required'], 400);
			}

			$tables = [
				'academy' => 'bmp_academy_details',
				'player' => 'bmp_player_details',
				'coach' => 'bmp_coach_details'
			];

			if (!isset($tables[$objectType])) {
				return response()->json(['status' => 0, 'message' => 'Invalid object type provided'], 400);
			}

			$entity = DB::table($tables[$objectType])
				->where('id', $objectId)
				->first(['id', 'phone']);

			if (!$entity) {
				return response()->json(['status' => 0, 'message' => 'No entity found for the provided object ID'], 404);
			}

			return response()->json(['status' => 1, 'object_id' => $entity->id, 'phone' => $entity->phone], 200);

		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'Something went wrong'], 500);
		}
	}


	public function getPremiumPlans(Request $request)
	{
		try {
			$type_id = $request->input('type_id');

			if (!$type_id) {
				return response()->json(['status' => 0, 'message' => 'type_id is required'], 400);
			}

			$plans = Adm_plans::where('type_id', $type_id)
				->where('active', 1)
				->get();

			if ($plans->isEmpty()) {
				return response()->json(['status' => 0, 'message' => 'No plans found for the provided type'], 404);
			}

			return response()->json(['status' => 1, 'data' => $plans], 200);

		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'Something went wrong'], 500);
		}
	}

	public function setPin(Request $request)
	{
		try {
			$pin = $request->input('pin');
			$userId = session()->get('userId');

			if (!$userId) {
				return response()->json(['status' => 0, 'message' => 'user not logged in'], 400);
			}

			if (empty($pin)) {
				return response()->json(['status' => 0, 'message' => 'Pin is required'], 400);
			}

			if (!ctype_digit($pin) || strlen($pin) !== 4) {
				return response()->json(['status' => 0, 'message' => 'Pin must be exactly 4 digits and contain only numbers'], 400);
			}

			$user = get_data_row(null, 'bmp_user', 'id', $userId);
			if (!$user) {
				return response()->json(['status' => 0, 'message' => 'invalid user'], 400);
			}

			$updated = DB::table('bmp_user')
				->where('id', $userId)
				->limit(1)
				->update(['pin' => $pin]);

			if ($updated) {
				return response()->json(['status' => 1, 'message' => 'Pin updated successfully']);
			} else {
				return response()->json(['status' => 0, 'message' => 'Failed to update pin'], 500);
			}

		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'Something went wrong'], 500);
		}
	}

	public function getDefaultSportPricing(Request $request)
	{
		try {
			$id = $request->input('loc_id');

			if (!$id) {
				return response()->json(['status' => 0, 'message' => 'loc_id is required'], 400);
			}

			$defaultPricing = collect(get_static_data_location_about('location_info_ai.json', $id));

			if ($defaultPricing) {
				return response()->json(['status' => 1, 'message' => 'default pricing fetch successfully', 'data' => $defaultPricing]);
			} else {
				return response()->json(['status' => 0, 'message' => 'Failed to update pin'], 500);
			}

		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'Something went wrong'], 500);
		}
	}

	public function getOrderDetails(Request $request)
	{
		try {
			$orderId = $request->input('orderId');
			$userId = session()->get('userId');

			if (empty($orderId)) {
				return response()->json(['status' => 0, 'message' => 'orderId is required'], 400);
			}

			if (!$userId) {
				return response()->json(['status' => 0, 'message' => 'user not logged in'], 400);
			}

			$user = get_data_row(null, 'bmp_user', 'id', $userId);
			if (!$user) {
				return response()->json(['status' => 0, 'message' => 'invalid user'], 400);
			}

			$Order = Adm_orders::where('user_id', $userId)->where('razorpay_order_id', $orderId)->first();

			if (!$Order) {
				return response()->json(['status' => 1, 'message' => 'Pin updated successfully']);
			}

			$response = Http::withBasicAuth(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'))
				->get("https://api.razorpay.com/v1/orders/{$orderId}");

			if ($response->successful()) {
				return response()->json(['status' => 1, 'message' => 'Order details retrieved successfully', 'data' => $response->json()]);
			} else {
				return response()->json(['status' => 0, 'message' => 'Failed to retrieve order details from Razorpay'], $response->status());
			}

		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => 'Something went wrong'], 500);
		}
	}

	public function uploadTempPhotos(Request $request)
	{
		try {
			$type = $request->input('type');
			$typeId = $request->input('typeId');

			// Validate required fields
			if (!$type) {
				return response()->json(['status' => 0, 'message' => 'type is required']);
			}

			// Validate type
			$validTypes = ['academy', 'coach', 'player'];
			if (!in_array($type, $validTypes)) {
				return response()->json(['status' => 0, 'message' => 'Invalid type. Allowed types: academy, coach, player']);
			}

			// Validate typeId only if type is academy
			if ($type === 'academy' && !$typeId) {
				return response()->json(['status' => 0, 'message' => 'typeId is required for academy']);
			}

			$name = null;
			switch ($type) {
				case 'academy':
					$d = Bmp_academy_details::find($typeId);
					if (!$d) {
						return response()->json(['status' => 0, 'message' => 'Invalid academy details']);
					}
					$name = $d->name;
					break;

				case 'coach':
					$name = "coach";
					break;

				case 'player':
					$name = "player";
					break;

				default:
					return response()->json(['status' => 0, 'message' => 'Invalid type']);
			}

			$folder = "temp";

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

				// Validate file type (only images allowed)
				$fileType = $file->getMimeType();
				if (!str_starts_with($fileType, 'image/')) {
					return response()->json([
						'status' => 0,
						'message' => 'Only image files are allowed'
					]);
				}

				// Validate file size (5MB = 5 * 1024 * 1024 bytes)
				if ($file->getSize() > 5 * 1024 * 1024) {
					return response()->json([
						'status' => 0,
						'message' => 'Image size should be less than 5MB'
					]);
				}

				// Upload file to B2
				$b2 = new B2Service();
				$extension = $file->getClientOriginalExtension();
				$sanitizedName = preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($name));
				$filename = "{$sanitizedName}-review.{$extension}";

				$originalFile = new \Illuminate\Http\UploadedFile(
					$file->getPathname(),
					$filename,
					$file->getMimeType(),
					null,
					true
				);

				$result = $b2->uploadFile($originalFile, 'bmpcdn90', $folder);
				$fileNameOnly = basename($result['fileName']);

				return response()->json([
					'status' => 1,
					'message' => 'File uploaded successfully.',
					'result' => $result,
					'fileName' => $fileNameOnly
				]);
			}

			return response()->json(['status' => 0, 'message' => 'Please upload exactly one file.']);

		} catch (\Exception $e) {
			\Log::error('Error in uploadTempPhotos: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
			return response()->json(['status' => 0, 'message' => 'Something went wrong']);
		}
	}

}
