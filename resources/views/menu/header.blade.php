@php
$redirectUrl = "";
$value = "";

if (session()->has('userId')) {
$userId = session()->get('userId');
$user = get_data_row(null, 'bmp_user', "id", $userId, null, null);

if (!$user) {
header("Location: https://www.bookmyplayer.com/profile/logout");
exit;
} else {
$session_exp = session()->get('session_exp');
$type_id = $user->type_id;
$parent_id = $type_id == 5 ? $userId : $user->parent_id;
$parent_tbl = $user->parent_tbl;

if ($type_id == 1) {
$tbl = "bmp_coach_details";
}
if ($type_id == 3) {
$tbl = "bmp_player_details";
}
if ($type_id == 5) {
$tbl = "bmp_user";
}
if ($type_id == 2) {
$tbl = $parent_tbl == 0 ? "bmp_academy_details_temp" : "bmp_academy_details";
}

$entity_name = get_data_row(null, $tbl, "id", $parent_id, null, null);
$profile_pic = ($type_id == 1) ? $entity_name->profile_img : ($type_id == 2 || $type_id == 3 ? $entity_name->logo : null);

if ($type_id == 5) {
$profile_pic = "";
}
$profile_img = env('AWS_CF_BASE_URL') . '/' .
($type_id == "1" ? "coach" :
($type_id == "2" ?
($parent_tbl == 0 ? "academy_temp" : "academy") :
($type_id == "3" ? "player" :
($type_id == "5" ? "default-profile-pic" : null)))) .
'/' . $entity_name->id . '/' . $profile_pic;



$headers = get_headers($profile_img, 1);
if (strpos($headers[0], '200') === false) {
$profile_img = env('AWS_CF_BASE_URL') . '/asset/images/logo 1.svg';
}

$profile_url = $type_id == 5 ? "" : $entity_name->url;

$userName = $entity_name ? $entity_name->name : "Guest";
$expirationTime = ini_get('session.gc_maxlifetime');
$redirectUrl = "/" .
(($type_id == "1") ? "coach" :
(($type_id == "2") ? "academy" :
(($type_id == "3") ? "player" :
(($type_id == "5") ? "tournament" : null)))) .
"/dashboard/" . $parent_id;
}
}
@endphp

<nav class="navbar navbar-expand-lg">
  @if(session('success_message_create_contact_ticket'))
  <div class="confirm-box" style="z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
      <div class="confirm-body">
        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/success.gif" class="img-fluid" alt=""></figure>
        <h6>{{ session('success_message_create_contact_ticket') }}</h6>
      </div>
      <div class="" style="text-align:center;">
        <button class="get_back btn btn-secondary">Go Back!!</button>
      </div>
    </div>
  </div>
  @endif
  @if(session('error_message_create_contact_ticket'))
  <div class="confirm-box" style="z-index: 10;">
    <div class="confirm-backdrop"></div>
    <div class="confirm-content">
      <div class="confirm-body">
        <figure><img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/error.gif" class="img-fluid" alt=""></figure>
        <h6>{{ session('error_message_create_contact_ticket') }}</h6>
      </div>
      <div class="confirm-footer">
        <button class="get_back btn btn-secondary">Go Back</button>
      </div>
    </div>
  </div>
  @endif
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center top-header-flex w-100">
      <div class="d-flex align-items-center">
        <a class="navbar-brand me-3" href="/">
          <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/logo 1.svg" alt="logo BookMyPlayer" width="105" height="35">
        </a>
      </div>
      <div class="position-relative search-width w-75">
        <form class="d-flex justify-content-center align-items-center" id="searchForm">
          <div class="form-group">
            <select class="form-control size_input custom-select custom-select-top" id="yourSelectId"
              style="border: none; width:8rem;">
              <option value="academy">Academy</option>
              <option value="coach">Coach</option>
              <option value="player">Player</option>
              <option value="location">Location</option>
            </select>
          </div>

          <input class="form-control size_input" type="text" placeholder="Search" name="query" id="searchInput2"
            autocomplete="off">
          <div class="detect-location" id="detect-location-academy2">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/detect2.svg" alt="Detect" width="24" height="24">
          </div>
          <div id="search_result"></div>
          <button class="btn btn-outline-secondary ms-2" type="submit"><i class='bx bx-search'></i></button>
        </form>

      </div>
      <div class="d-flex align-items-center ms-3">
        <ul class="navbar-nav">
          @if(session()->get('userId'))
          <li class="d-flex justify-content-end align-items-center gap-2">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/search.svg" alt="search" height="16" width="16"
              class="search-img">
            <div class="new_flex">
              <div class="new_login_menu">
                <div class="d-flex justify-content-between align-items-center gap-3">
                  <div class="top_academy_name" id="toggleMenu">
                    @if(!empty($profile_pic))
                    @php
                    $is_default_img = strpos($profile_img, '/asset/images/logo 1.svg') !== false;
                    @endphp

                    <div class="top_new_logo {{ $is_default_img ? '' : 'top_logo' }}">
                      <img src="{{ $profile_img }}" loading="lazy" alt="logo">
                    </div>
                    @else
                    <div class="top_new_logo">
                      <img src="{{ env('AWS_CF_BASE_URL') }}/asset/images/logo 1.svg" loading="lazy"
                        alt="logo BookMyPlayer">
                    </div>
                    @endif
                    <div class="top_academy">
                      <p class="fb_font">{{$userName}}</p>
                    </div>
                  </div>
                  <div class="hamburger-menu">
                    <div class="bar bar1"></div>
                    <div class="bar bar2"></div>
                    <div class="bar bar3"></div>
                  </div>
                </div>

                <div class="new_menu_box" id="menuBox">
                  <a href="{{$redirectUrl}}">Dashboard</a>
                  @if($profile_url)
                  <br />
                  <a href="{{ $profile_url }}">View Profile </a>
                  @endif
                  <br />
                  <a href="{{ url('profile/logout') }}">Logout </a>
                </div>
              </div>
          </li>
          @else
          <li class="nav-item d-flex justify-content-center align-items-center gap-2">
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/search.svg" alt="search" height="16" width="16"
              class="search-img">
            <a class="nav-link registerBtn" href="/register">Register</a>
            <div class="hamburger-menu">
              <div class="bar bar1"></div>
              <div class="bar bar2"></div>
              <div class="bar bar3"></div>
            </div>
          </li>
          @endif

        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="side_overlay"></div>

<div class="side_modal">
  <ul>
    <li><a href="https://www.bookmyplayer.com/buy-our-services">Buy Our Services</a></li>
    <li><a href="https://www.bookmyplayer.com/contact">Contact</a></li>
    <li><a href="https://www.bookmyplayer.com/about">About Us</a></li>
    <li><a href="https://www.bookmyplayer.com/register-your-academy">Register Academy</a></li>
    <li><a href="https://www.bookmyplayer.com/register-as-a-coach-trainer">Register As a Coach</a></li>
    <li><a href="https://www.bookmyplayer.com/register-as-a-player">Register As a Player</a></li>
    <li><a href="https://www.bookmyplayer.com/register-tournaments">Post Your Tournament</a></li>
    <li id="trigger-report">Report An Issue</li>
    @if (session()->has('userId'))
    <li><a href="{{ url('profile/logout') }}">Logout</a></li>
    @else
    <li><a href="https://www.bookmyplayer.com/login">Login</a></li>
    @endif

  </ul>
</div>

<div class="overlay-report" id="report-overlay">
  <div class="modal-report" id="report-modal">
    <span class="btn-close-report" id="close-report">
      <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" alt="Close" loading="lazy" style="width: 24px; height: 24px; cursor: pointer;">
    </span>
    <h3 class="text-center mb-4">Report an Issue</h3>
    <p id="error-report-message" class="text-center error-report"></p>
    <form id="report-form" action="{{ route('submit.contact.ticket') }}" method="post">
      @csrf
      <input type="hidden" name="latitude" id="report_latitude" value="">
      <input type="hidden" name="longitude" id="report_longitude" value="">
      <input type="hidden" name="category" value="report_page_issue">
      <input type="hidden" name="title" value="report page issue">
      <div class="mb-3">
        <input type="text" class="form-control" name="name" id="report-name" placeholder="Enter your name">
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" name="email" id="report-email" placeholder="Enter your email">
      </div>
      <div class="mb-3">
        <input type="number" class="form-control" name="phone" id="report-phone" placeholder="Enter your phone number">
      </div>
      <div class="mb-3">
        <textarea class="form-control" id="report-issue" name="description" rows="4" placeholder="Describe the issue"></textarea>
      </div>
      <button type="submit" id="report-submit" class="btn btn-primary w-100">Submit</button>
    </form>
  </div>
</div>

@include('menu.menu')