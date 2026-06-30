<?php

namespace App\Http\Controllers\Academy;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Bmp_review_details;
use App\Models\Bmp_reviews;
use App\Models\Bmp_academy_details;
use App\Models\Bmp_sports;
use App\Models\Adm_location_master;
use App\Services\B2Service;


class academy_review extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;


	public function academy_review(Request $request, $id)
	{
		$d = Bmp_academy_details::find($id);
		if ($d) {
			$reviews = Bmp_reviews::where('object_id', $d->id)->where('status', 1)->get();
			$logo = $d->logo ? env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->logo}" : env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
			$address = ($d->state ?? '') . ($d->city ? " - $d->city" : '') ?: ($d->address1 ?? ($d->address2 ?? ''));

		} else {
			$d = (object) [
				'id' => $id,
				'name' => 'Add Review',
				'sport' => 'Cricket',
				'url' => '#',
				'state' => '',
				'city' => ''
			];

			$reviews = 10;
			$logo = env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
			$address = "";
		}

		$breadcrumbs = [
			(object) ['name' => $d->name . " (" . $d->sport . ")", 'link' => $d->url],
			(object) ['name' => "Add Review", 'link' => ""]
		];

		$data = array(
			"title" => "add review - " . $d->name,
			"des" => 'BookMyPlayer: test!',
			"url" => URL::current(),
			"logo" => $logo,
			"d" => $d,
			"address" => $address,
			"reviews" => $reviews,
			"breadcrumbs" => $breadcrumbs,
		);

		return view("academy.academy_review")->with('data', $data);
	}

	public function show_academy_review(Request $request, $academy_name, $id)
	{
		$review_data = Bmp_review_details::find($id);
		if (!$review_data) {
			return abort(404, "Invalid review-id");
		}

		$acId = $review_data->object_id;
		$d = Bmp_academy_details::select('name', 'address1', 'address2', 'state', 'city', 'id', 'logo', 'sport', 'sport_id', 'url', 'loc_id', 'city_id', 'postcode', 'lat', 'lng', 'photos', "fee", "default_pricing")->find($acId);
		if (!$d) {
			return abort(404, "Invalid academy-id");
		}

		$review_data->increment('views');

		$loc_id = $d->loc_id;
		$city_id = ($d->city_id != 0) ? $d->city_id : $loc_id;
		$sport_id = $d->sport_id;

		$review_ids = implode(',', array_column(array_map(fn($r) => explode(':', $r), explode(',', $review_data->reviews)), 0));
		$reviews = Bmp_reviews::whereIn('id', explode(',', $review_ids ?? []))
			->orderBy('rating', 'desc')
			->orderByRaw('LENGTH(comment) DESC')
			->limit(5)
			->get();

		$bredLocationInfo = Adm_location_master::where('id', $city_id)->where('city_id', 0)->select('locality_name', 'url')->first();
		$bredSportInfo = Bmp_sports::where('sport_id', $sport_id)->where('loc_id', $city_id)->select('locality_name', 'url', 'sport')->first();

		$bredLocalitySportInfo = ($d->city_id != 0)
			? Bmp_sports::where('sport_id', $sport_id)->where('loc_id', $loc_id)->select('locality_name', 'url', 'sport', 'city')->first()
			: null;

		$total_reviews = $review_data->reviews ? count(explode(',', $review_data->reviews)) : 40;
		$average_rating = $review_data->rating ?? 4.5;
		$percentages = array_map(
			fn($count) => round(($count / $total_reviews) * 100, 2),
			array_count_values(array_column(array_map(fn($r) => explode(':', $r), explode(',', $review_data->reviews)), 1))
		);

		$logo = $d->logo
			? env('AWS_S3_BASE_URL') . "/academy/{$d->id}/{$d->logo}"
			: env('AWS_S3_BASE_URL') . "/asset/images/logo.svg";
		$formatted_address = implode(', ', array_filter([$d->address1, $d->address2, $d->city, $d->state, $d->postcode]));

		// Metadata
		$meta_title = "{$d->name} Reviews, {$formatted_address} - {$total_reviews} Ratings - Bookmyplayer";
		$meta_description = "Reviews for {$d->name}, located at {$formatted_address}. Unbiased, genuine user reviews, ratings, and experiences for {$d->name} on BookMyPlayer.";
		$photoArray = explode(',', $d->photos);
		$firstFivePhotos = array_slice($photoArray, 0, 5);
		$baseURL = "https://d146zb2foqhwdd.cloudfront.net/academy/" . $acId . "/";
		$photoURLs = array_map(fn($photo) => $baseURL . $photo, $firstFivePhotos);

		$json_ld = [
			"@context" => "http://schema.org",
			"@type" => "LocalBusiness",
			"name" => $d->name,
			"url" => $d->url,
			"image" => $photoURLs,
			"priceRange" => $d->fee ?: ($d->default_pricing ?: "Rs.1000/month"),
			"address" => [
				"@type" => "PostalAddress",
				"streetAddress" => $formatted_address ?? null,
				"addressLocality" => $d->city ?? null,
				"postalCode" => $d->postcode ?? null,
				"addressRegion" => $d->state ?? null,
				"addressCountry" => "IN"
			],
			"geo" => [
				"@type" => "GeoCoordinates",
				"latitude" => $d->lat,
				"longitude" => $d->lng,
			],
			"aggregateRating" => [
				"@type" => "AggregateRating",
				"ratingValue" => $average_rating,
				"ratingCount" => $total_reviews,
				"bestRating" => "5",
				"worstRating" => "1"
			],
			"review" => $reviews->map(function ($review) {
				return [
					"@type" => "Review",
					"datePublished" => (new \DateTime($review->creation_date))->format('Y-m-d'),
					"reviewBody" => $review->comment,
					"author" => [
						"@type" => "Person",
						"name" => $review->name
					]
				];
			})->toArray()
		];

		// Breadcrumbs
		$breadcrumbs_review = [
			(object) ['name' => $bredLocationInfo->locality_name ?? '', 'link' => $bredLocationInfo->url ?? ''],
			(object) ['name' => ($bredSportInfo->sport ?? '') . ' Coaching Classes In ' . ($bredSportInfo->locality_name ?? ''), 'link' => $bredSportInfo->url ?? '']
		];
		if ($bredLocalitySportInfo) {
			$breadcrumbs_review[] = (object) [
				'name' => ($bredLocalitySportInfo->sport ?? '') . ' Coaching Classes In ' . ($bredLocalitySportInfo->locality_name ?? '') . ' (' . ($bredLocalitySportInfo->city ?? '') . ')',
				'link' => $bredLocalitySportInfo->url ?? ''
			];
		}

		$breadcrumbs_review[] = (object) ['name' => $d->name, 'link' => $d->url];
		$breadcrumbs_review[] = (object) ['name' => 'Reviews of ' . $d->name, 'link' => ''];

		return view("academy.show_reviews", [
			'data' => [
				"title" => $meta_title,
				"url" => URL::current(),
				"des" => $meta_description,
				"keywords" => "{$d->name}, Ratings, User reviews, Experiences, {$formatted_address}",
				"logo" => $logo,
				"d" => $d,
				"address" => $formatted_address,
				"json_ld" => json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
				"review_stats" => ["total_review" => $total_reviews, "average_rating" => $average_rating, "percentages" => $percentages],
				"breadcrumbs" => [],
				"breadcrumbs_review" => $breadcrumbs_review
			]
		]);
	}

	//  Api - Add academy review
	public function add_review_academy(Request $request)
	{
		try {
			$objectId = $request->input('object_id');
			$name = $request->input('name');
			$comment = $request->input('comment');
			$rating = $request->input('rating');
			$email = $request->input('email');
			$phone = $request->input('phone');
			$type = $request->input('type', 'review');
			$parentId = $request->input('parent_id');
			$advance_review = $request->input('advance_review');
			$photos = $request->input('photos');


			if (!$objectId || !$name || !$comment || !$email || !$phone) {
				return response()->json(['status' => 0, 'message' => 'name, email, phone, comment and id are required fields.']);
			}

			if ($type === 'reply') {
				if (!$parentId || !is_string($parentId)) {
					return response()->json(['status' => 0, 'message' => 'parent_id is required for replies']);
				}
			} else {
				if (!$rating || !is_string($rating)) {
					return response()->json(['status' => 0, 'message' => 'rating is required for reviews']);
				}
			}

			$academy = Bmp_academy_details::find($objectId);
			if (!$academy) {
				return response()->json(['status' => 0, 'message' => 'No academy found with this id']);
			}

			$reviewData = [
				'object_id' => $objectId,
				'name' => $name,
				'comment' => $comment,
				'email' => $email,
				'phone' => $phone,
				'type' => $type,
				'advance_review' => $advance_review,
				'object_type' => 'academy',
			];

			if ($type === 'reply') {
				$reviewData['parent_id'] = $parentId;
			} else {
				$reviewData['rating'] = $rating;
			}

			$review = new Bmp_reviews($reviewData);
			$review->save();

			$updatedPhotoNames = [];

			if ($photos) {
				$photoIds = explode(',', $photos);
				$b2 = new B2Service();
				$destinationBucket = 'bmpcdn90';

				foreach ($photoIds as $photoId) {
					$photoId = trim($photoId);
					$sourceFileId = $photoId;

					$fileInfo = $b2->getFileInfo($sourceFileId);
					if (!$fileInfo)
						continue;

					$fileName = $fileInfo['fileName'];
					$newFileName = 'academy/' . $academy->id . '/' . basename($fileName);

					try {
						$copyResponse = $b2->copyFile($sourceFileId, $destinationBucket, $newFileName);
						if ($copyResponse) {
							$updatedPhotoNames[] = basename($newFileName); // Store only filename
						}
					} catch (Exception $e) {
						\Log::error('B2 Copy Error: ' . $e->getMessage());
					}
				}


				if ($updatedPhotoNames) {
					$review->photos = implode(',', $updatedPhotoNames);
					$review->save();
				}
			}

			return response()->json(['status' => 1, 'message' => 'Review added successfully.']);
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
	}


	//Api - Show academy review
	public function api_show_academy_review(Request $request)
	{
		try {
			$id = $request->input('id');
			$type = $request->input('type');
			$data = [];

			$missingFields = array_filter(['id', 'type'], fn($field) => !$request->filled($field));
			if ($missingFields) {
				return response()->json([
					'status' => 0,
					'message' => 'Missing required fields: ' . implode(', ', $missingFields),
				]);
			}

			$review_data = Bmp_review_details::find($id);
			if (!$review_data) {
				return response()->json(['status' => 0, 'message' => 'Invalid review-id']);
			}

			$d = Bmp_academy_details::select('name', 'address1', 'address2', 'state', 'city', 'id', 'logo', 'sport', 'sport_id', 'loc_id', 'city_id')->find($review_data->object_id);
			if (!$d) {
				return response()->json(['status' => 0, 'message' => 'Invalid academy-id']);
			}

			// HELPER FUNCTIONS START
			function getSortedIds($reviews, $order = SORT_DESC)
			{
				$reviewsArray = explode(',', $reviews);

				usort($reviewsArray, function ($a, $b) use ($order) {
					$ratingA = (int) explode(':', $a)[1];
					$ratingB = (int) explode(':', $b)[1];
					return $order === SORT_DESC ? $ratingB - $ratingA : $ratingA - $ratingB;
				});
				return array_map(fn($review) => (int) explode(':', $review)[0], $reviewsArray);
			}
			// HELPER FUNCTIONS END

			if ($type == "filter") {
				$filter = $request->input('filter', 'latest');
				$page = (int) $request->input('page', 1);
				$perPage = 10;
				$offset = ($page - 1) * $perPage;

				$reviewIds = $filter === 'top' ? getSortedIds($review_data->reviews, SORT_DESC) :
					($filter === 'low' ? getSortedIds($review_data->reviews, SORT_ASC) :
						getSortedIds($review_data->reviews));

				$reviews = Bmp_reviews::whereIn('id', array_slice($reviewIds, $offset, $perPage))
					->orderByRaw('FIELD(id, ' . implode(',', array_map('intval', array_slice($reviewIds, $offset, $perPage))) . ')')
					->select(
						'id',
						'name',
						'rating',
						'comment',
						'creation_date',
						'photos',
						'advance_review'
						// DB::raw('(SELECT COUNT(*) FROM bmp_reviews AS r WHERE r.parent_id = bmp_reviews.id AND r.status = 1) AS replies')
					)->get();

				$data = ['reviews' => $reviews];
			} else if ($type == "replies") {
				$page = (int) $request->input('page', 1);
				$review_id = (int) $request->input('review_id', 1);
				$perPage = 5;
				$offset = ($page - 1) * $perPage;

				if (!$review_id) {
					return response()->json(['status' => 0, 'message' => 'missing required field: review_id']);
				}

				$query = Bmp_reviews::where('parent_id', $review_id)->where('status', 1);
				$reviews = $query->select('id', 'name', 'comment', 'creation_date')->skip($offset)->take($perPage)->get();
				$totalReviews = Bmp_reviews::where('parent_id', $review_id)->where('status', 1)->count();

				$data = [
					'current_page' => $page,
					'total_reviews' => $totalReviews,
					'last_page' => ceil($totalReviews / $perPage),
					'reviews' => $reviews
				];
			} else if ($type == 'photos') {
				$type = 'r-photos';
				$ac_id = $d->id;

				$photos = Bmp_reviews::where('object_id', $d->id)->where('status', 1)
					->whereNotNull('photos')
					->where('photos', '!=', '')
					->select('id', 'object_id', 'photos')
					->get();

				if ($photos->isEmpty()) {
					$academy = Bmp_academy_details::where('id', $d->id)
						->select('id as object_id', 'loc_id', 'sport_id', 'photos')
						->first();

					if ($academy && $academy->photos) {
						$photos = collect([
							[
								'id' => $academy->object_id,
								'object_id' => $academy->object_id,
								'photos' => $academy->photos
							]
						]);
						$type = 'a-photos';
					} else {
						$academyWithLongestPhotos = Bmp_academy_details::where('loc_id', '=', $academy->loc_id)
							->where('sport_id', '=', $academy->sport_id)
							->orderByRaw('LENGTH(photos) DESC')
							->select('id as object_id', 'photos')
							->first();

						if ($academyWithLongestPhotos && $academyWithLongestPhotos->photos) {
							$photos = collect([
								[
									'id' => $academyWithLongestPhotos->object_id,
									'object_id' => $academyWithLongestPhotos->object_id,
									'photos' => $academyWithLongestPhotos->photos
								]
							]);
							$type = 'other-a-photos';
							$ac_id = $academyWithLongestPhotos->object_id;
						} else {
							$photos = collect();
							$type = 'no-photos';
							$ac_id = 0;
						}
					}
				}

				function checkImageExists($url)
				{
					$headers = @get_headers($url);
					return $headers && strpos($headers[0], '200 OK') !== false;
				}

				$photos = $photos->map(function ($photo) use ($ac_id) {
					$filteredPhotos = collect(explode(',', $photo['photos']))->filter(function ($filename) use ($ac_id) {
						$url = "https://d146zb2foqhwdd.cloudfront.net/academy/{$ac_id}/{$filename}";
						return checkImageExists($url);
					});

					$photo['photos'] = $filteredPhotos->implode(',');
					return $photo;
				})->filter(function ($photo) {
					return !empty($photo['photos']);
				});

				$totalPhotos = $photos->sum(function ($photo) {
					return count(explode(',', $photo['photos']));
				});

				$data = ['total_photos' => $totalPhotos, 'type' => $type, 'ac_id' => $ac_id, 'photos' => $photos->toArray()];
			} else if ($type == 'footer') {
				$locations = [
					'nearByLocations' => Bmp_sports::where('city_id', ($d->city_id != 0) ? $d->city_id : $d->loc_id)->where('sport_id', $d->sport_id)->select('url', 'locality_name', 'city', 'state')->orderBy('views', 'desc')->limit(50)->get(),
					'topLocations' => Bmp_sports::where('city_id', 0)->where('sport_id', $d->sport_id)->select('url', 'locality_name', 'city', 'state')->orderBy('views', 'desc')->limit(50)->get(),
					'otherNearbySports' => Adm_location_master::where('city_id', ($d->city_id != 0) ? $d->city_id : $d->loc_id)->select('url', 'locality_name', 'city', 'state')->orderBy('views', 'desc')->limit(50)->get()
				];

				$data = $locations;
			} else {
				return response()->json(['status' => 0, 'message' => 'Invalid type']);
			}

			return response()->json(['status' => 1, 'message' => 'reviews information', 'data' => $data]);
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
	}

	// Api - get reviews heightlight
	public function api_get_review_heightlights(Request $request)
	{
		try {
			$id = $request->input('id');
			$rating = $request->input('rating');

			$missingFields = array_filter(['id', 'rating'], function ($field) use ($request) {
				return !$request->input($field);
			});

			if ($missingFields) {
				return response()->json([
					'status' => 0,
					'message' => 'Missing required fields: ' . implode(', ', $missingFields)
				]);
			}

			$data = get_review_highlight("reviews_heighlight.json", $id, $rating);


			return response()->json([
				'status' => 1,
				'message' => 'review heighlight',
				'data' => $data
			]);

		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
	}

	// HELPER FUNCTIONS START
	function getSortedIds($reviews, $order)
	{
		$reviewsArray = explode(',', $reviews);
		usort($reviewsArray, function ($a, $b) use ($order) {
			list($idA, $ratingA) = explode(':', $a);
			list($idB, $ratingB) = explode(':', $b);
			return $order === SORT_DESC ? (int) $ratingB - (int) $ratingA : (int) $ratingA - (int) $ratingB;
		});
		return array_map(fn($id) => (int) strtok($id, ':'), $reviewsArray);
	}

	function checkImageExists($url)
	{
		$headers = @get_headers($url);
		return $headers && strpos($headers[0], '200 OK') !== false;
	}

	function getMissingFields($request, $requiredFields)
	{
		return array_filter($requiredFields, fn($field) => !$request->input($field));
	}

	function sendErrorResponse($message)
	{
		return response()->json(['status' => 0, 'message' => $message]);
	}
	// HELPER FUNCTIONS END
}
