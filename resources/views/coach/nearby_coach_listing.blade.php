@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />
<link rel="stylesheet" href="{{ asset('asset/css/coach_listing.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/nearby_coach_listing.js') }}" defer></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<script src="https://kit.fontawesome.com/6d54d92cfd.js" crossorigin="anonymous"></script>
@endpush
@extends('layouts.app')
@section('content')

<section class="listing-section clearfix mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xl-4 d-none d-md-block">
                <div class="filter-group">
                    <div class="heading">
                        <h6>Filters</h6>
                        <button type="reset">Reset All</button>
                    </div>

                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Localities
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div class="search mb-3">
                                        <input type="search" name="" id="" placeholder="Search Localities">
                                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <div class="show-more-text show-more-height scrollbar">
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="101">
                                            <label class="form-check-label" for="101">Prayagraj</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="102">
                                            <label class="form-check-label" for="102">Jamshedpur</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="103">
                                            <label class="form-check-label" for="103">Gwalior</label>
                                        </div>
                                    </div>
                                    <p><a href="#" class="show-more">More...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                    Search By
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="11">
                                        <label class="form-check-label" for="11">Academy (857)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="12">
                                        <label class="form-check-label" for="12">Coach (8578)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                    Sport
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="21">
                                        <label class="form-check-label" for="21">Football</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="22">
                                        <label class="form-check-label" for="22">Basketball</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="23">
                                        <label class="form-check-label" for="23">Cricket</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="24">
                                        <label class="form-check-label" for="24">Swimming</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="25">
                                        <label class="form-check-label" for="25">Badminton</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">
                                    Rating
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFour">
                                <div class="accordion-body">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="31">
                                        <label class="form-check-label d-flex align-items-center" for="31">2.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/2star.png" alt=""></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="32">
                                        <label class="form-check-label d-flex align-items-center" for="32">3.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/3star.png" alt=""></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="33">
                                        <label class="form-check-label d-flex align-items-center" for="33">4.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/4star.png" alt=""></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="34">
                                        <label class="form-check-label d-flex align-items-center" for="34">5.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/5star.png" alt=""></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true" aria-controls="panelsStayOpen-collapseFive">
                                    More
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFive">
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
                            <label class="label-tab" for="tab-1">Localities <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="search mb-3">
                                    <input type="search" name="" id="" placeholder="Search Localities">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                                <div class="show-more-text show-more-height scrollbar">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="101">
                                        <label class="form-check-label" for="101">Prayagraj</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="102">
                                        <label class="form-check-label" for="102">Jamshedpur</label>
                                    </div>
                                </div>
                                <p><a href="#" class="show-more">More...</a></p>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-2" name="tab-group-1">
                            <label class="label-tab" for="tab-2">Search By <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="11">
                                    <label class="form-check-label" for="11">Academy (857)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="12">
                                    <label class="form-check-label" for="12">Coach (8578)</label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-3" name="tab-group-1">
                            <label class="label-tab" for="tab-3">Sports <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="21">
                                    <label class="form-check-label" for="21">Football</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="22">
                                    <label class="form-check-label" for="22">Basketball</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="23">
                                    <label class="form-check-label" for="23">Cricket</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="24">
                                    <label class="form-check-label" for="24">Swimming</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="25">
                                    <label class="form-check-label" for="25">Badminton</label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-4" name="tab-group-1">
                            <label class="label-tab" for="tab-4">Ratings <i class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="31">
                                    <label class="form-check-label d-flex align-items-center" for="31">2.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/2star.png" alt=""></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="32">
                                    <label class="form-check-label d-flex align-items-center" for="32">3.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/3star.png" alt=""></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="33">
                                    <label class="form-check-label d-flex align-items-center" for="33">4.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/4star.png" alt=""></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="34">
                                    <label class="form-check-label d-flex align-items-center" for="34">5.0 <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/5star.png" alt=""></label>
                                </div>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-5" name="tab-group-1">
                            <label class="label-tab" for="tab-5">More <i class="fa-solid fa-chevron-right"></i></label>

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
            <div class="col-md-8 col-xl-8">
                <!-- <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="right d-flex justify-content-between align-items-center flex-wrap">
                        <div class="detect-location"><button type="button"><i class="fa-solid fa-location-crosshairs"></i>
                                <span>Detect My Location</span></button>
                        </div>
                    </div>
                </div> -->
                <div class="coaches-list-wrapper">
                    <div class="row" id="coach-listing">
                    </div>
                    <div id="loading-indicator">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" alt="">
                    </div>
                    <div id="no-data-found" class="d-none">
                        <h4>No More Data Show.</h4>
                    </div>
                    <nav aria-label="Page navigation example" class="d-flex justify-content-end">
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
            </div>
        </div>
    </div>
    <!-- Modal HTML -->

    <div id="messageModal" class="coach_custom-modal">
        <div class="coach_modal-content">
            <span class="coach_close">&times;</span>
            <h6 id="message-model-title">Message</h6>
            <form id="messageForm" class="coach_custom-form" action="{{ route('submit.contact') }}" method="post">
                @csrf
                <input type="hidden" name="source" value="coach listing">
                <input hidden name="object_type" value="coach">
                <input hidden name="object_id" id="object_id">
                <input hidden name="sport" id="sport">
                <input hidden name="sport_id" id="sport_id">
                <label for="modalName" class="coach_modal-label">Name</label>
                <input type="text" id="modalName" name="name" class="coach_modal-input" required>
                <label for="modalEmail" class="coach_modal-label">Email</label>
                <input type="email" id="modalEmail" name="email" class="coach_modal-input" required>
                <label for="modalPhone" class="coach_modal-label">Phone</label>
                <input type="tel" id="modalPhone" name="phone" class="coach_modal-input" required>
                <label for="modalDescription" class="coach_modal-label">Description</label>
                <textarea id="modalDescription" name="description" class="coach_modal-textarea" required></textarea>
                <button type="submit" class="coach_modal-button">Send</button>
            </form>
        </div>
    </div>

</section>

<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel"></h5>
                <div type="button" class="close" id="close_whatsapp">
                    <span aria-hidden="true" style="font-size: 35px;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <form id="newForm" action="{{ route('submit.contact') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" id="source_details" value="whatsapp">
                    <input type="hidden" name="sport" id="sport_details"
                        value="{{ isset($data['d']->sport) ? $data['d']->sport : '' }}">
                    <input type="hidden" name="sport_id" id="sport_id_details"
                        value="{{ isset($data['d']->sport_id) ? $data['d']->sport_id : ''}}">
                    <input type="hidden" name="object_id" id="object_id_details"
                        value="{{ isset($data['id']) ? $data['id'] : '' }}">
                    <input type="hidden" name="object_type" id="object_type_details"
                        value="{{ isset($data['object_type']) ? $data['object_type'] : '' }}">
                    <input type="hidden" name="loc_id" id="loc_id_details"
                        value="{{ isset($data['d']->loc_id) ? $data['d']->loc_id : '' }}">
                    <input type="hidden" name="screen" id="screen_details" value="message" required>
                    <span class="error" id="formError" style="display:none; color:red;"></span>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="name" id="details_name"
                            placeholder="Enter your name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" id="details_email"
                            placeholder="Enter your email" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <input type="number" class="form-control" name="phone" id="details_phone"
                            placeholder="Enter your phone" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="description" rows="3" id="details_desc"
                            placeholder="Enter your description" autocomplete="off"></textarea>

                    </div>
                    <button type="submit" id="formSubmitButton" class="btn btn-primary">Send</button>
                </form>

            </div>


        </div>
    </div>

</div>

@endsection
