@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/academy_listing_v4.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/academy_listing_v1.js') }}" defer></script>
@endpush

@extends('layouts.app')
@section('content')

<section class="listing-section clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3 col-xl-3 d-none d-md-block">
                <div class="filter-group">
                    <div class="heading">
                        <h2 style="font-size:22px;">Filters</h2>
                        <button type="reset">Reset All</button>
                    </div>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    Localities
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div class="search mb-3">
                                        <input type="search" name="" id="searchLocality" placeholder="Search Localities">
                                        <!-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                                    </div>
                                    <div class="show-more-text show-more-height scrollbar" id="localityList">
                                        @foreach ($data['otherLocalities'] as $locality)
                                        <div class="form-check-new mb-2">
                                            <a href="{{ $locality->url }}" target="_blank" class="text-capitalize">{{ $locality->locality_name }}</a>
                                        </div>
                                        @endforeach
                                    </div>

                                    <p><a href="#" class="show-more">More...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseTwo">
                                    Search By
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="11">
                                        <label class="form-check-label" for="11">Academy</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="12">
                                        <label class="form-check-label" for="12">Coach</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    Sport
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <div class="search mb-3">
                                        <input type="search" name="" id="searchSport" placeholder="Search Sport">
                                    </div>
                                    <div class="show-more-text2 show-more-height2 scrollbar" id="sportsList">
                                    <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input sport-filter" id="sport-1" name="sports[]" value="">
                                            <label class="form-check-label text-capitalize" for="sport-1">Football</label>
                                        </div>
                                    </div>


                                    <p><a href="javascript:void(0)" class="show-more2">More...</a></p>
                                </div>
                            </div>

                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseFour">
                                    Rating
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFour">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input rating-check" id="31" value="2">
                                        <label class="form-check-label d-flex align-items-center" for="31">2.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/2star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input rating-check" id="32" value="3">
                                        <label class="form-check-label d-flex align-items-center" for="32">3.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/3star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input rating-check" id="33" value="4">
                                        <label class="form-check-label d-flex align-items-center" for="33">4.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/4star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input rating-check" id="34" value="5">
                                        <label class="form-check-label d-flex align-items-center" for="34">5.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/5star.png" loading="lazy" alt="Star"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseFive">
                                    More
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingFive">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="41">
                                        <label class="form-check-label" for="41">Open Academies</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="42">
                                        <label class="form-check-label" for="42">Verified Only</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="filter-content">
                <div class="filter-tab">
                    <div class="heading">
                        <h6>Filters</h6>
                        <button type="reset">Reset All</button>
                    </div>
                    <div class="season_tabs">
                        <div class="season_tab">
                            <input type="radio" id="tab-1" name="tab-group-1" checked>
                            <label class="label-tab" for="tab-1">Localities <i
                                    class="fa-solid fa-chevron-right"></i></label>
                            <div class="season_content">
                                <div class="search mb-3">
                                    <input type="search" name="" id="searchLocality2" placeholder="Search Localities">
                                    <!-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                                </div>
                                <div class="show-more-text show-more-height scrollbar" id="localityList2">
                                    @foreach ($data['otherLocalities'] as $locality)
                                    <div class="form-check-new mb-2">
                                        <a href="{{ $locality->url }}" target="_blank" class="text-capitalize">{{ $locality->locality_name }}</a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-2" name="tab-group-1">
                            <label class="label-tab" for="tab-2">Search By <i
                                    class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="11">
                                    <label class="form-check-label" for="11">Academy</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="12">
                                    <label class="form-check-label" for="12">Coach</label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-3" name="tab-group-1">
                            <label class="label-tab" for="tab-3">Sports <i
                                    class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="search mb-3">
                                    <input type="search" name="" id="searchSport2" placeholder="Search Sports">
                                    <!-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                                </div>
                                <div class="show-more-text show-more-height2 scrollbar" id="sportsList2">
                                    @foreach ($data['sports'] as $sport)
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input sport-filter" id="sport-{{ $sport['sport_id'] }}" name="sports[]" value="{{ $sport['sport_id'] }}">
                                        <label class="form-check-label text-capitalize" for="sport-{{ $sport['sport_id'] }}">{{ $sport['sport'] }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-4" name="tab-group-1">
                            <label class="label-tab" for="tab-4">Ratings <i
                                    class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="31">
                                    <label class="form-check-label d-flex align-items-center" for="31">2.0 <img
                                            src="{{env('AWS_CF_BASE_URL')}}/asset/image/2star.png" loading="lazy" alt="Star"></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="32">
                                    <label class="form-check-label d-flex align-items-center" for="32">3.0 <img
                                            src="{{env('AWS_CF_BASE_URL')}}/asset/image/3star.png" loading="lazy" alt="Star"></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="33">
                                    <label class="form-check-label d-flex align-items-center" for="33">4.0 <img
                                            src="{{env('AWS_CF_BASE_URL')}}/asset/image/4star.png" loading="lazy" alt="Star"></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="34">
                                    <label class="form-check-label d-flex align-items-center" for="34">5.0 <img
                                            src="{{env('AWS_CF_BASE_URL')}}/asset/image/5star.png" loading="lazy" alt="Star"></label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-5" name="tab-group-1">
                            <label class="label-tab" for="tab-5">More <i
                                    class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="41">
                                    <label class="form-check-label" for="41">Open Academies</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="42">
                                    <label class="form-check-label" for="42">Verified Only</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 col-xl-9">
                <div class="d-flex justify-content-between align-items-center flex-wrap w-100 mt-3">
                    <h1 style="font-size:22px;" class="listing-title text-capitalize">Play Sports In {{ $data['city'] }}, {{ $data['record']->state }}</h1>
                    <div class="right d-flex justify-content-between align-items-center mb-3">
                        <button type="menu" class="d-block d-md-none" id="btn-open">Filter</button>
                        <div class="detect-location" id="detect-location-academy">
                            <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/detect2.svg" alt="Detect" width="24" height="24">
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs top_tabs" id="myTab" role="tablist">
                    <li class="nav-item academy_tab" role="presentation">
                        <button class="nav-link active" id="academy-tab" data-bs-toggle="tab" data-bs-target="#academy-tab-pane" type="button" role="tab" aria-controls="academy-tab-pane" aria-selected="true">Academies<span id="totalRecords"></span></button>
                    </li>
                    <li class="nav-item coach_tab" role="presentation">
                        <button class="nav-link" id="coach-tab" data-bs-toggle="tab" data-bs-target="#coach-tab-pane" type="button" role="tab" aria-controls="coach-tab-pane" aria-selected="false">Coaches<span id="totalRecords2"></span></button>
                    </li>
                    <li class="nav-item player_tab" role="presentation">
                        <button class="nav-link" id="player-tab" data-bs-toggle="tab" data-bs-target="#player-tab-pane" type="button" role="tab" aria-controls="player-tab-pane" aria-selected="false">Players<span id="totalRecords3"></span></button>
                    </li>
                    <li class="nav-item sports_tab" role="presentation">
                        <button class="nav-link" id="sports-tab" data-bs-toggle="tab" data-bs-target="#sports-tab-pane" type="button" role="tab" aria-controls="sports-tab-pane" aria-selected="false">Sports<span id="totalRecords4"></span></button>
                    </li>
                    <li class="nav-item location_tab" role="presentation">
                        <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location-tab-pane" type="button" role="tab" aria-controls="location-tab-pane" aria-selected="false">Location<span id="totalRecords5"></span></button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">


                    <div class="tab-pane fade show active" id="academy-tab-pane" role="tabpanel" aria-labelledby="academy-tab" tabindex="0">

                        <div class="academy-list-wrapper" id="academy-listing">
                        </div>
                        <div id="loading-indicator">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader Icon">
                        </div>
                        <div id="no-data-found" class="d-none">
                            <h4>No More Data Show.</h4>
                        </div>
                        <section class="inquiry-section clearfix">
                            <div class="container">
                                <section>
                                    <h2>Send your Inquiry Now</h2>
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="" id="" placeholder="Enter Your full name">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="email" name="" id="" placeholder="Enter Your email address">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="tel" name="" id="" placeholder="Enter Your phone number">
                                            </div>
                                            <div class="col-md-6">
                                                <select name="" id="">
                                                    <option value="">Select quire for</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <textarea name="" id="" placeholder="Enter Your message"></textarea>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <input type="button" class="btn btn-secondary" value="SUBMIT">
                                            </div>
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </section>

                        <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations">
                            <ul class="pagination">
                                <li class="page-item" id="prev-page">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span> Previous
                                    </a>
                                </li>
                                <li class="page-item active" id="current-page"><span class="page-link"></span></li>
                                <li class="page-item" id="next-page">
                                    <a class="page-link" href="#" aria-label="Next">
                                        Next <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>


                    <div class="tab-pane fade" id="coach-tab-pane" role="tabpanel" aria-labelledby="coach-tab" tabindex="0">

                        <div class="academy-list-wrapper" id="coach-listing">
                        </div>
                        <div id="loading-indicator2">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader Icon">
                        </div>
                        <div id="no-data-found" class="d-none">
                            <h4>No More Data Show.</h4>
                        </div>
                        <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations2">
                            <ul class="pagination">
                                <li class="page-item" id="prev-page2">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span> Previous
                                    </a>
                                </li>
                                <li class="page-item active" id="current-page2"><span class="page-link"></span></li>
                                <li class="page-item" id="next-page2">
                                    <a class="page-link" href="#" aria-label="Next">
                                        Next <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                    </div>

                    <div class="tab-pane fade" id="player-tab-pane" role="tabpanel" aria-labelledby="player-tab" tabindex="0">

                        <div class="academy-list-wrapper" id="player-listing">
                        </div>
                        <div id="loading-indicator3">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader Icon">
                        </div>
                        <div id="no-data-found" class="d-none">
                            <h4>No More Data Show.</h4>
                        </div>
                        <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations3">
                            <ul class="pagination">
                                <li class="page-item" id="prev-page3">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span> Previous
                                    </a>
                                </li>
                                <li class="page-item active" id="current-page3"><span class="page-link"></span></li>
                                <li class="page-item" id="next-page3">
                                    <a class="page-link" href="#" aria-label="Next">
                                        Next <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                    </div>

                    <div class="tab-pane fade" id="sports-tab-pane" role="tabpanel" aria-labelledby="sports-tab" tabindex="0">

                        <div class="academy-list-wrapper" id="sport-listing">
                        </div>
                        <div id="loading-indicator4">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader Icon">
                        </div>
                        <div id="no-data-found" class="d-none">
                            <h4>Last Record.</h4>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="location-tab-pane" role="tabpanel" aria-labelledby="location-tab" tabindex="0">

                        <div class="academy-list-wrapper">
                            <section class="other-links-section clearfix">
                                <div class="container">
                                    <section>
                                        <h2 style="font-size:22px;" class="fw-bold mb-3 heading_border">Location Links</h2>
                                        <ul style="cursor:pointer" id="location-listing">
                                        </ul>
                                    </section>
                                </div>
                            </section>
                        </div>
                        <div id="loading-indicator5">
                            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader Icon">
                        </div>
                        <div id="no-data-found" class="d-none">
                            <h4>No More Data Show.</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="register-academy-section clearfix">
    <div class="container">
        <div class="register-academy-wrap">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-8">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/register-accademy-img.png" loading="lazy" alt="Register Academy"></figure>
                </div>
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="register-academy-cont">
                        <h3>Grow your Academy. Register today and inspire the champions of tomorrow.</h3>
                        <a class="btn btn-secondary" href="{{env('AWS_CF_BASE_URL')}}/register-your-academy" target="_blank">Register Academy</a>
                    </div>
                </div>
            </div>
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/dotted.png" loading="lazy" alt="Dotted Icon" class="doted-shape">
        </div>
    </div>
</section>

<div class="modal fade" id="whatsappModal2" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel2">Contact</h5>
                <div type="button" class="close" id="close_whatsapp2" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="similarAcademyForm" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <span class="error" id="formError2" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name2" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email2" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone2" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc2" placeholder="Enter your description" autocomplete="off"></textarea>

                    </div>
                    <button type="button" id="similarAcademyFormButton" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="whatsappModal3" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel3">Contact</h5>
                <div type="button" class="close" id="close_whatsapp3" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="similarAcademyForm3" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <span class="error" id="formError3" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name3" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email3" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone3" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc3" placeholder="Enter your description" autocomplete="off"></textarea>

                    </div>
                    <button type="button" id="similarAcademyFormButton3" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="whatsappModal4" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <h5 class="modal-title" id="whatsappModalLabel4">Contact</h5>
                <div type="button" class="close" id="close_whatsapp4" style=" margin-top:-10px">
                    <span aria-hidden="true" style="font-size: 35px">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="similarAcademyForm4" action="{{ route('submit.contact.player') }}" method="post">
                    @csrf
                    <span class="error" id="formError4" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name4" placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email4" placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone4" placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc4" placeholder="Enter your description" autocomplete="off"></textarea>

                    </div>
                    <button type="button" id="similarAcademyFormButton4" class="btn btn-primary">Send</button>
                </form>

            </div>
        </div>
    </div>
</div>



@endsection