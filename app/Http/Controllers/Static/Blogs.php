<?php

namespace App\Http\Controllers\Static;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;



class Blogs extends BaseController
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

	public function blogs(Request $request)
	{
		$name = 'blog';
		$url = 'https://www.bookmyplayer.com/blogs';
		$blogs = get_data_array('bookmyplayer', 'xx_blog', null, null, null, null, 'id', 'desc', 75);
		$categories = ['Weekend Reads', 'Sports & Work', 'Journal'];
		$blogCategories = get_data_array('bookmyplayer', 'xx_blog_tag', null, null, null, null, 'count', 'desc', 20);
		$breadcrumbs = [(object) ['name' => "Blogs", 'link' => ""]];

		createLog(null, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType(), $name);

		$data = [
			"title" => "BookMyPlayer Blogs - Sports Insights, Tips, and News",
			"des" => "Explore the latest sports insights, tips, and news on the BookMyPlayer blog. Stay updated with articles on sports events, player profiles, and more. Join the conversation today.",
			"keywords" => "Sports Blog, Sports Insights, Sports Tips, Sports News, Player Profiles, Sports Events, Athlete Updates, Game Analysis, Sports Discussions, Sports Enthusiasts",
			"url" => $url,
			"page" => $name,
			"template" => $name,
			"blogs" => $blogs,
			"blogCategories" => $blogCategories,
			"categories" => $categories,
			"breadcrumbs" => $breadcrumbs,
		];

		return view('static.blog', compact('data'));
	}

	public function details(Request $request, $name, $id)
	{
		$url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
		$blog = get_data_row('bookmyplayer', 'xx_blog', 'id', $id);
		$blogDetails = get_data_array(null, 'xx_blog_details', 'blogid', $id);
		$blogs = get_data_array('bookmyplayer', 'xx_blog', null, null, null, null, 'id', 'desc');
		$comments = get_data_array('bookmyplayer', 'xx_blog_comments', 'blog_id', $id, null, null, 'id', 'desc', 10);
		$tagarray = explode(",", $blog->tag);
		$tags = get_data_array_where_in(null, 'xx_blog_tag', 'id', $tagarray);
		$timeToRead = round($blog->word_count / 60);
		$blogImg = $blog->image ? env('AWS_S3_BASE_URL') . "/blog/" . $blog->image : env('AWS_S3_BASE_URL') . "/default/default_blog_image.webp";
		$creationDate = date("F jS, Y", strtotime($blog->update_date));
		$ninesectioncat = ['Weekend Reads', 'Most Reads'];
		$breadcrumbs = [(object) ['name' => "Blogs", 'link' => "/blogs"], (object) ['name' => $blog->title, 'link' => "/blogs"]];
		createLog($id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType());
		$data = array(
			"title" => $blog->title,
			"des" => $blog->meta_description,
			"desc" => $blog->description,
			"keywords" => $blog->keywords,
			"blogImg" => $blogImg,
			"comments" => $comments,
			"blogTags" => $tags,
			"creationDate" => date("F jS, Y", strtotime($blog->update_date)),
			"ninesectioncat" => $ninesectioncat,
			"url" => $url,
			"id" => $id,
			"blogs" => $blogs,
			"blog" => $blog,
			"timeToRead" => $timeToRead,
			"breadcrumbs" => $breadcrumbs,
			"page" => "blog_details",
			"blogDetails" => $blogDetails,
			"template" => "blog_details"
		);
		return view('static.blog_details', compact('data'));
	}

	public function tags(Request $request, $name, $id)
	{
		$url = 'https://www.bookmyplayer.com' . $request->getRequestUri();
		$d = get_data_row('bookmyplayer', 'xx_blog_tag', 'id', $id);
		$blogs = get_data_array_or_like('bookmyplayer', 'xx_blog', 'tag', $id, 'id', 'desc');
		$blogCategories = get_data_array('bookmyplayer', 'xx_blog_tag', 'sport', $d->sport, null, null, 'count', 'desc', 20);
		$ninesectioncat = ['Weekend Reads', 'Most Reads'];
		$breadcrumbs = [(object) ['name' => "Blogs", 'link' => "/blogs"], (object) ['name' => $d->tag, 'link' => "/blogs"]];

		$meta = (object) [
			'title' => $d->tag . ' Blog Category | BookMyPlayer.com',
			'des' => 'Explore latest blogs on ' . $d->tag . ' Blog Categories at BookMyPlayer.com',
			'keywords' => $d->tag . ' blog category'
		];
		createLog($id, $request->ip(), $request->url(), URL::previous(), $this->getDeviceType());

		$data = array(
			"page" => 'tag_details',
			"title" => $meta->title,
			"des" => $meta->des,
			"keywords" => $meta->keywords,
			"d" => $d,
			"url" => $url,
			"blogs" => $blogs,
			"blogCategories" => $blogCategories,
			"breadcrumbs" => $breadcrumbs,
			"ninesectioncat" => $ninesectioncat,
			"template" => "tag_details"
		);
		return view('static.blog_tags', compact('data'));
	}

}
