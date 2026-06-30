@push('styles')
<link rel="stylesheet" href="{{ asset('asset/css/player_listing.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/player_listing_v1.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')


<section class="listing-section clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3 col-xl-3 d-none d-md-block">
                <div class="filter-group">
                    <div class="heading">
                        <h6>Filters</h6>
                        <button type="reset">Reset All</button>
                    </div>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne"> Localities in {{ $data['location']->city ?? "India" }}
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div class="search mb-3">
                                        <input type="search" name="" id="" placeholder="Search Localities">
                                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <div id="locationContainer" class="show-more-text show-more-height scrollbar">
                                        @foreach ($data['nearbylocations'] as $location)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="location-{{ $location->id }}">
                                            <label class="form-check-label" for="location-{{ $location->id }}">
                                                <a href="{{ $location->url }}">{{ ucwords($location->location) }}</a>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <p class="show-more"><a href="#" id="showMoreLink" class="show-more">More...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    Select Level
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <div class="show-more-text3 show-more-height3 scrollbar">
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2021">
                                            <label class="form-check-label" for="2021">Any Level</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2022">
                                            <label class="form-check-label" for="2022">District Level</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2023">
                                            <label class="form-check-label" for="2023">State Level</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2024">
                                            <label class="form-check-label" for="2024">National Level</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2025">
                                            <label class="form-check-label" for="2025">International Level</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2026">
                                            <label class="form-check-label" for="2026">Grassroots Level</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2027">
                                            <label class="form-check-label" for="2027">Age-Group Level</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="2028">
                                            <label class="form-check-label" for="2028">Domestic Level</label>
                                        </div>
                                    </div>
                                    <p><a href="javascript:void(0)" class="show-more3">More...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseFour">
                                    Age Limit
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingFour">
                                <div class="accordion-body">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="RadioAgeLimit"
                                            id="RadioAgeLimit1">
                                        <label class="form-check-label" for="RadioAgeLimit1">
                                            10 Years - 20 Years
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="RadioAgeLimit"
                                            id="RadioAgeLimit2" checked>
                                        <label class="form-check-label" for="RadioAgeLimit2">
                                            21 Years - 25 Years
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="RadioAgeLimit"
                                            id="RadioAgeLimit3">
                                        <label class="form-check-label" for="RadioAgeLimit3">
                                            26 Years - 30 Years
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="RadioAgeLimit"
                                            id="RadioAgeLimit4">
                                        <label class="form-check-label" for="RadioAgeLimit4">
                                            31 Years - 35 Years
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="RadioAgeLimit"
                                            id="RadioAgeLimit5">
                                        <label class="form-check-label" for="RadioAgeLimit5">
                                            Above 35 Years
                                        </label>
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
                            <label class="label-tab" for="tab-1">Localities<i
                                    class="fa-solid fa-chevron-right"></i></label>
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
                                </div>
                                <p><a href="#" class="show-more">More...</a></p>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-2" name="tab-group-1">
                            <label class="label-tab" for="tab-2">Sport <i class="fa-solid fa-chevron-right"></i></label>
                            <div class="season_content">
                                <div class="show-more-text2 show-more-height2 scrollbar">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="RadioSport" id="RadioSport1">
                                        <label class="form-check-label" for="RadioSport1">Football</label>
                                    </div>

                                </div>
                                <p><a href="javascript:void(0)" class="show-more2">More...</a></p>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-3" name="tab-group-1">
                            <label class="label-tab" for="tab-3">Select Level <i
                                    class="fa-solid fa-chevron-right"></i></label>
                            <div class="season_content">
                                <div class="show-more-text3 show-more-height3 scrollbar">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2021">
                                        <label class="form-check-label" for="2021">Any Level</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2022">
                                        <label class="form-check-label" for="2022">District Level</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2023">
                                        <label class="form-check-label" for="2023">State Level</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2024">
                                        <label class="form-check-label" for="2024">National Level</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2025">
                                        <label class="form-check-label" for="2025">International Level</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2026">
                                        <label class="form-check-label" for="2026">Grassroots Level</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2027">
                                        <label class="form-check-label" for="2027">Age-Group Level</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="2028">
                                        <label class="form-check-label" for="2028">Domestic Level</label>
                                    </div>
                                </div>
                                <p><a href="javascript:void(0)" class="show-more3">More...</a></p>
                            </div>
                        </div>
                        <div class="season_tab">
                            <input type="radio" id="tab-4" name="tab-group-1">
                            <label class="label-tab" for="tab-4">Age Limit <i
                                    class="fa-solid fa-chevron-right"></i></label>

                            <div class="season_content">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="RadioAgeLimitMobile"
                                        id="RadioAgeLimit1">
                                    <label class="form-check-label" for="RadioAgeLimit1">
                                        10 Years - 20 Years
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="RadioAgeLimitMobile"
                                        id="RadioAgeLimit2" checked>
                                    <label class="form-check-label" for="RadioAgeLimit2">
                                        21 Years - 25 Years
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="RadioAgeLimitMobile"
                                        id="RadioAgeLimit3">
                                    <label class="form-check-label" for="RadioAgeLimit3">
                                        26 Years - 30 Years
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="RadioAgeLimitMobile"
                                        id="RadioAgeLimit4">
                                    <label class="form-check-label" for="RadioAgeLimit4">
                                        31 Years - 35 Years
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="RadioAgeLimitMobile"
                                        id="RadioAgeLimit5">
                                    <label class="form-check-label" for="RadioAgeLimit5">
                                        Above 35 Years
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 col-xl-9">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="listing-title">
                        {{$data['totalcoaches']}} {{ $data['sport']->name }} Players in
                        {{ $data['location']->locality_name }}

                        @php
                        $city = $data['location']->city ?? null;
                        $state = $data['location']->state ?? null;
                        @endphp

                        @if ($city && $data['location']->locality_name == $city)
                        , {{ $state }}
                        @elseif ($city)
                        , {{ $city }}
                        @elseif ($state)
                        , {{ $state }}
                        @endif
                    </h6>


                    </h6>
                    <div class="right d-flex justify-content-between align-items-center flex-wrap">
                        <div class="detect-location"><button type="button"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/detect2.svg" alt="location" /></button>
                        </div>
                    </div>
                </div>
                <div class="players-list-wrapper">
                    <div class="row" id="listing-html">
                    </div>
                    <div id="loading-indicator">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/loader.gif" loading="lazy" alt="Loader Icon">
                    </div>
                </div>
                <nav aria-label="Page navigation example" class="d-flex justify-content-end" id="paginations">
                    <ul class="pagination">
                        <li class="page-item" id="prev-page">
                            <a class="page-link" href="#" aria-label="Previous" data-value="">
                                <span aria-hidden="true">&laquo;</span> Previous
                            </a>
                        </li>
                        <li class="page-item active" id="current-page">
                            <span class="page-link" data-value=""></span>
                        </li>
                        <li class="page-item" id="next-page">
                            <a class="page-link" href="#" aria-label="Next" data-value="">
                                Next <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="image-container">
                    <img src="https://f005.backblazeb2.com/file/bmpcdn90/asset/images/Register_as_player.webp" alt="" loading="lazy" class="img-fluid mt-4">
                    <div class="overlay-text">
                        <h3>Register as a Player</h3>
                        <p>Participate in professional leagues, gain sponsorships and endorsements, and advance your carrer in sports</p>
                        <a href="/register-as-a-player"> <button>Register now</button></a>
                    </div>
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
</section>




@endsection