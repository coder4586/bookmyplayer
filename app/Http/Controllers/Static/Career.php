<?php

namespace App\Http\Controllers\Static;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;
use App\Models\xx_jobs;
use App\Models\xx_career;

class Career extends BaseController
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

	public function career(Request $request)
	{
		$name = 'career';
		$url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
		$openPositions = $name == "career" ? get_data_array(null, 'xx_jobs', 'closed', 0, null, null, 'id', 'desc', 75) : [];
		$meta = get_data_row('bookmyplayer', 'xx_pages', 'route', $name);
		$breadcrumbs = [(object) ['name' => "Career", 'link' => ""]];
		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), $name);

		$data = [
			"title" => $meta->title,
			"des" => $meta->description,
			"url" => $url,
			"keywords" => $meta->keywords,
			"openPositions" => $openPositions,
			"page" => $name,
			"breadcrumbs" => $breadcrumbs,
			"template" => $name,
		];

		return view('static.career', compact('data'));
	}

	public function applyJob(Request $request)
	{
		try {
			$validatedData = $request->validate([
				'position_id' => 'required|integer',
				'name' => 'required|string',
				'email' => 'required|email',
				'phone' => 'required|string|min:10',
				'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
				'linkedin_url' => 'nullable|url',
			]);

			if ($validatedData['position_id'] != 0) {
				$job = xx_jobs::where("id", $validatedData['position_id'])->where('closed', "0")->first();
				if (!$job) {
					return response()->json(['status' => 0, 'message' => 'No job found']);
				}
			}

			$career = xx_career::where('id', $validatedData['position_id'])
				->where(function ($query) use ($validatedData) {
					$query->where('email', $validatedData['email'])
						->orWhere('phone', $validatedData['phone']);
				})
				->first();

			if ($career) {
				return response()->json(['status' => 0, 'message' => 'You have already applied for this position.']);
			}

			$resumeFilename = null;
			if ($request->hasFile('resume')) {
				$file = $request->file('resume');
				$resumeFilename = 'resume_' . uniqid() . '.' . $file->getClientOriginalExtension();
				$folder = "attachments/resume";
				$file->storeAs($folder, $resumeFilename, 's3_cdn90');
			}

			$application = new xx_career();
			$application->position_id = $validatedData['position_id'];
			$application->name = $validatedData['name'];
			$application->email = $validatedData['email'];
			$application->phone = $validatedData['phone'];
			$application->resume = $resumeFilename;
			$application->linkedin_url = $validatedData['linkedin_url'];
			// $application->status = 'applied';
			$application->save();

			return response()->json([
				'status' => 1,
				'message' => 'Job application submitted successfully.',
			]);

		} catch (\Illuminate\Validation\ValidationException $e) {
			return response()->json([
				'status' => 0,
				'message' => implode('; ', array_merge(...array_values($e->errors()))),
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 0,
				'message' => $e->getMessage(),
			]);
		}
	}


}
