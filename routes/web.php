<?php

use App\Services\B2Service;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\{
    Common,
    Sitemap
};
use App\Http\Controllers\Static\Home;
use App\Http\Controllers\Static\Terms;
use App\Http\Controllers\Static\Privacy;
use App\Http\Controllers\Static\Blogs;
use App\Http\Controllers\Static\Career;
use App\Http\Controllers\Static\NotFound;
use App\Http\Controllers\Static\About;
use App\Http\Controllers\Static\Contact;
use App\Http\Controllers\Static\Register_all;
use App\Http\Controllers\Static\OurServices;
use App\Http\Controllers\Coach\coach_details;
use App\Http\Controllers\Coach\coach_review;
use App\Http\Controllers\Player\player_review;
use App\Http\Controllers\Academy\academy_review;
use App\Http\Controllers\Coach\coach_listing;
use App\Http\Controllers\Coach\nearby_coach_listing;
use App\Http\Controllers\Admin\Coach\admin_coach;
use App\Http\Controllers\Player\player_details;
use App\Http\Controllers\Player\Player_corn_emails;
use App\Http\Controllers\Coach\Coach_corn_emails;
use App\Http\Controllers\Player\player_listing;
use App\Http\Controllers\Admin\Player\admin_player;
use App\Http\Controllers\Academy\academy_details;
use App\Http\Controllers\Admin\Academy\admin_academy;
use App\Http\Controllers\Admin\Tournament\admin_tournament;
use App\Http\Controllers\Admin\Admin\admin;
use App\Http\Controllers\Academy\Listing;
use App\Http\Controllers\Listings\locid;
use App\Http\Controllers\Listings\sdid;
use App\Http\Controllers\Academy\manage_this_business;
use App\Http\Controllers\Admin\Orders\PaymentController;
use App\Http\Controllers\Tournament\tournament_details;
use App\Http\Controllers\EmailCampaigns\emailCampaign;

// common routes
Route::get('/get_subcategories', [Common::class, 'get_subcategories'])->name('get_subcategories');
Route::get('/search_academies', [Common::class, 'search_academies'])->name('search_academies');
Route::post('/bmp-subscribe', [Common::class, 'submitSubscriptionRequest'])->name('bmp.subscribe');
Route::post('/submit-contact-static', [Common::class, 'submitContactStatic'])->name('submit.contact');
Route::post('/submit-contact-static/player', [Common::class, 'submitContactPlayer'])->name('submit.contact.player');
Route::post('/login/validate', [Common::class, 'loginSave'])->name('bmp.loginvalidate');
Route::post('/create-comment', [Academy::class, 'postComment'])->name('post.academy.comment');
Route::post('/post-comment', [Blog::class, 'postComment'])->name('post.comment');
Route::post('/get-admin-sports', [Common::class, 'getAdminSports']);
Route::post('/user-details/check', [Common::class, 'checkUserDetailsExists']);
Route::post('/api/check-user-exist', [Common::class, 'checkUserExists']);
Route::post('/otp/send', [Common::class, 'sentOtp']);
Route::post('/register/validate', [Common::class, 'registervalidate'])->name('bmp.registervalidate');
Route::get('/test/ui/{name}', [Common::class, 'test'])->name('test');
Route::post('/submit-contact-ticket', [Common::class, 'create_ticket_contactus'])->name('submit.contact.ticket');
Route::post('/submit-ticket', [Common::class, 'submitTicket'])->name('submit.ticket');
Route::get('/test/send-email/{email}/{name}', [Common::class, 'testEmail']);
Route::get('/test/send-custom-email', [Common::class, 'sentCustomEmails']);
Route::post('/send-sms-entity-details', [Common::class, 'sendEntityDetailSms']);
Route::post('/send-verification-email', [Common::class, 'sendVerificationEmail'])->name('sent.email.verification');
Route::post('/add-coach-review', [Common::class, 'addReviewCoach'])->name('add.coach.review');
Route::post('/add-player-review', [Common::class, 'addReviewPlayer'])->name('add.player.review');
Route::post('/modify-lead-status', [Common::class, 'modifyleadstatus'])->name('modify.lead.status');
Route::post('/bmp-search', [Common::class, 'bmpSearch'])->name('bmp.bmpSearch');
Route::post('/get-entity-contact', [Common::class, 'getEntityCred'])->name('bmp.getEntityCred');
Route::post('/api/getPremiumPlans', [Common::class, 'getPremiumPlans']);
Route::post('/api/setpin', [Common::class, 'setPin']);
Route::post('/api/getOrderDetails', [Common::class, 'getOrderDetails']);
Route::post('/api/getDefaultSportPricing', [Common::class, 'getDefaultSportPricing']);
Route::post('/api/upload-temp-photos', [Common::class, 'uploadTempPhotos']);


// static routes
Route::get('/', [Home::class, 'home']);
Route::get('/terms', [Terms::class, 'terms'])->name('terms');
Route::get('/about', [About::class, 'about'])->name('about');
Route::get('/privacy', [Privacy::class, 'privacy'])->name('privacy');
Route::get('/contact', [Contact::class, 'contact'])->name('contact');
Route::get('/career', [Career::class, 'career'])->name('career');
Route::get('/404', [NotFound::class, 'notfound'])->name('notfound');
Route::get('/register', [Register_all::class, 'register'])->name('register');
Route::get('/register-your-academy', [Register_all::class, 'register_academy']);
Route::get('/register-as-a-coach-trainer', [Register_all::class, 'register_coach']);
Route::get('/register-as-a-player', [Register_all::class, 'register_player']);
Route::get('/register-tournaments', [Register_all::class, 'register_tournament']);
Route::get('/register-as-other', [Register_all::class, 'register_other']);
Route::get('/login', [Register_all::class, 'login'])->name('login');
Route::get('/buy-our-services', [OurServices::class, 'index']);
Route::post('/api/buy-our-services', [OurServices::class, 'buyServiceRequest']);
Route::get('/profile/logout', [Common::class, 'logout'])->name('bmp.logout');
Route::post('/user/delete', [Common::class, 'deleteUser'])->name('delete-user');
Route::post('/api/apply-job', [Career::class, 'applyJob']);
Route::get('/manage-users/lkdsfldkflsdfjlsdjfldsjfldsjf/jdaosjdoasdioaido/sdasda', [Common::class, 'manageUsers']);
Route::get('/payment', [PaymentController::class, 'index']);
Route::post('create-order', [PaymentController::class, 'createOrder']);
Route::post('verify-payment', [PaymentController::class, 'verifyPayment']);
Route::get('/verify-email/{token}', [Common::class, 'verifyEmail']);
Route::get('/unsubscribe/{token}', [Common::class, 'unsubscribe']);

// blog routes
Route::get('/blogs', [Blogs::class, 'blogs'])->name('blogs');
Route::get('/blog', function () {
    return redirect()->route('blogs');
});
Route::get('/blog/{name}-bid-{id}', [Blogs::class, 'details'])->where(['name' => '.*', 'id' => '.*',])->name('blog.details');
Route::get('/blog/tag/{name}-tagid-{id}', [Blogs::class, 'tags'])->where(['name' => '.*', 'id' => '.*',])->name('blog.tags');

// tournament routes
Route::get('/{sport}/{name}-tid-{id}', [tournament_details::class, 'show_tournament_details'])->where(['id' => '.*', 'name' => '.*', 'sport' => '.*']);
Route::get('/tournament/dashboard/{id}', [admin_tournament::class, 'show_tournament_admin']);
Route::post('/api/add-tournament', [admin_tournament::class, 'save_tournament']);
Route::post('/api/get-tournaments', [admin_tournament::class, 'get_tournament']);
Route::post('/api/update-tournaments', [admin_tournament::class, 'update_tournament']);
Route::post('/api/upload-photos-tournaments', [admin_tournament::class, 'upload_photos']);
Route::post('/tournament/create-lead', [tournament_details::class, 'create_lead']);
Route::post('/tournament/get-lead', [admin_tournament::class, 'get_leads']);


// coaches routes
Route::get('/{name}-clid-{id}', [coach_listing::class, 'coach_listing'])->where(['id' => '.*', 'name' => '.*'])->name('coach.listing');
Route::get('/nearby-coaches/{lat}/{lng}', [nearby_coach_listing::class, 'nearby_coach_listing'])->where(['lat' => '.*', 'lng' => '.*'])->name('nearby.coach.listing');
Route::get('/{name}-{sport}-in-{city}-chid-{id}', [coach_details::class, 'coach_details'])->where(['id' => '.*', 'name' => '.*', 'sport' => '.*', 'city' => '.*'])->name('coach.listing');
Route::get('/coach/add-review/{id}', [coach_review::class, 'show_coach_review'])->name('coach.review')->where(['id' => '.*']);
Route::get('/coach/dashboard/{id}', [admin_coach::class, 'show_coach_admin'])->where('id', '.*')->name('coach.dashboard');
Route::post('/coach/dashboard/update-profile', [admin_coach::class, 'update_coach'])->name('coach.update');
Route::post('/coach/dashboard/add-faqs', [admin_coach::class, 'add_faq'])->name('coach.add.faqs');
Route::post('/coach/dashboard/delete-faqs', [admin_coach::class, 'delete_faq'])->name('coach.delete.faqs');
Route::post('/coach/upload-photos-videos', [admin_coach::class, 'upload_coach_photosvideos'])->name('coach.upload.photos.videos');
Route::post('/coach/delete-photos-videos', [admin_coach::class, 'delete_coach_photovideos'])->name('coach.delete.photos.videos');
Route::post('/coach/upload-certificates', [admin_coach::class, 'upload_coach_certificates'])->name('coach.upload.certificates');
Route::post('/coach/delete-certificates', [admin_coach::class, 'delete_coach_certificates'])->name('coach.delete.certificates');
Route::post('/coach/add-review-request', [admin_coach::class, 'add_review_request'])->name('coach.add.reviewrequest');
Route::post('/admin/create-support-ticket', [admin_coach::class, 'create_support_ticket'])->name('admin.create.ticket');
Route::get('/coach/get-location-master', [admin_coach::class, 'get_location_master'])->name('coach.loc.master');
Route::get('/coach/get-skills', [admin_coach::class, 'get_skills'])->name('coach.getskills');
Route::get('/coach-corn/profile-update', [Coach_corn_emails::class, 'corn_email']);


// player routes
Route::get('/{name}-pid-{id}', [player_details::class, 'player_details'])->where(['id' => '.*', 'name' => '.*'])->name('player.details');
Route::get('/player-corn/profile-update', [Player_corn_emails::class, 'corn_email']);
Route::get('/{sport}/{name}-player-profile-{id}', [player_details::class, 'player_details'])->where(['id' => '.*', 'name' => '.*', 'sport' => '.*'])->name('player.details');
// Route::get('/{name}-plid-{id}', [player_listing::class, 'player_listing'])->where(['id' => '.*']);
Route::get('/{name}-plid-{id}', [player_listing::class, 'player_listing'])->where(['id' => '.*', 'name' => '.*']);
Route::get('/player/dashboard/{id}', [admin_player::class, 'show_player_admin'])->where('id', '.*')->name('player.dashboard');
Route::post('/player/dashboard/update-profile', [admin_player::class, 'update_player'])->name('player.update');
Route::post('/player/upload-photos-videos', [admin_player::class, 'upload_player_photosvideos'])->name('player.upload.photos.videos');
Route::post('/player/delete-photos-videos', [admin_player::class, 'delete_player_photovideos'])->name('player.delete.photos.videos');
Route::get('/player/add-review/{id}', [player_review::class, 'show_player_review'])->name('player.review')->where(['id' => '.*']);

// academy routes
Route::get('/{sport}/{name}-aid-{id}', [academy_details::class, 'show_academy'])->where(['sport' => '.*', 'name' => '.*', 'id' => '.*']);
Route::post('/academy/get-additonal-info', [academy_details::class, 'getAdditionalInfo']);
Route::get('/{name}-sdid-{id}', [sdid::class, 'show_sdid'])->where(['name' => '.*', 'id' => '.*',]);
Route::post('/api/get-sdid', [sdid::class, 'show_sdid_api']);
Route::get('/sdid-redirect/{sport_id}/{lat}-{lng}', [sdid::class, 'handle_redirect'])->where(['sport_id' => '.*', 'lat' => '.*', 'lng' => '.*',]);
Route::get('/{name}-locid-{id}', [locid::class, 'show_locid'])->where(['name' => '.*', 'id' => '.*',]);
Route::post('/api/get-locid', [locid::class, 'show_locid_api']);
Route::post('/api/send-enqury-locid', [locid::class, 'locid_enqury_api']);
Route::post('/api/get-sdid-url', [locid::class, 'get_sdid_url']);
Route::get('/locid-redirect/{lat}-{lng}', [locid::class, 'handle_redirect'])->where(['lat' => '.*', 'lng' => '.*',]);
Route::get('/{name}-scid-{id}', [Listing::class, 'sport_competition_listing'])->where(['sport' => '.*', 'name' => '.*', 'id' => '.*',])->name('sport.details');
Route::get('/{city}-llid-{id}', [Listing::class, 'llid'])->where(['city' => '.*', 'id' => '.*',])->name('location.details');
Route::get('/academy/dashboard/{id}', [admin_academy::class, 'show_academy_admin'])->where('id', '.*')->name('academy.dashboard');
Route::post('/academy/dashboard/update-profile', [admin_academy::class, 'update_academy'])->name('academy.update');
Route::post('/academy/upload-photos-videos', [admin_academy::class, 'upload_academy_photosvideos'])->name('academy.upload.photos.videos');
Route::post('/academy/delete-photos-videos', [admin_academy::class, 'delete_academy_photovideos'])->name('academy.delete.photos.videos');
Route::get('/{entity}/manage-this-business-{id}', [manage_this_business::class, 'manage_business'])->where(['entity' => '.*', 'id' => '.*']);
Route::get('/academy/add-review/{id}', [academy_review::class, 'academy_review'])->name('academy.review')->where(['id' => '.*']);
Route::get('/{academy_name}-review-rid-{id}', [academy_review::class, 'show_academy_review'])->name('academy.review')->where(['academy_name' => '.*', 'id' => '.*']);
Route::post('/api/add-academy-review', [academy_review::class, 'add_review_academy'])->name('add.academy.review');
Route::post('/api/academy/reviews', [academy_review::class, 'api_show_academy_review'])->where(['id' => '.*']);
Route::post('/api/reviews/get-heighlights', [academy_review::class, 'api_get_review_heightlights'])->where(['id' => '.*']);
Route::post('/api/gym/get-data', [academy_details::class, 'getAdditionalInfoGym'])->where(['id' => '.*']);

// admin routes
Route::get('/admin/dashboard/{id}', [admin::class, 'show_admin'])->where('id', '.*')->name('admin.dashboard');

// lead info. capture routes
Route::get('/link/{redirect_id}/{lead_id}', [emailCampaign::class, 'handle_redirect'])->where('redirect_id', '.*', 'lead_id', '.*');
Route::get('/track-email', [emailCampaign::class, 'trackEmail'])->name('track.email');
Route::get('/sent-campaign-email', [emailCampaign::class, 'sentCampaignEmail']);

// sitemap routes
Route::get('/sitemap1{extension?}', [Sitemap::class, 'sitemap1'])->where('extension', '(\.xml)?');
Route::get('/sitemap2{extension?}', [Sitemap::class, 'sitemap2'])->where('extension', '(\.xml)?');
Route::get('/sitemap3{extension?}', [Sitemap::class, 'sitemap3'])->where('extension', '(\.xml)?');
Route::get('/sitemap4{extension?}', [Sitemap::class, 'sitemap4'])->where('extension', '(\.xml)?');
Route::get('/sitemap5{extension?}', [Sitemap::class, 'sitemap5'])->where('extension', '(\.xml)?');
Route::get('/sitemap6{extension?}', [Sitemap::class, 'sitemap6'])->where('extension', '(\.xml)?');
Route::get('/sitemap{extension?}', [Sitemap::class, 'sitemap'])->where('extension', '(\.xml)?');
Route::get('/semrush{extension?}', [Sitemap::class, 'semrush'])->where('extension', '(\.xml)?');

