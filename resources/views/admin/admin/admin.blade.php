@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="{{ asset('asset/css/admin/coach_admin_v6.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/admin/master_admin.css') }}" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="{{ asset('asset/js/admin/master_admin.js') }}" defer></script>
<script src="{{ asset('asset/js/admin/academy_admin_v9.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });
</script>
@endpush
@extends('layouts.admin_app')
@section('content')

<section class="dashboard-menu-section clearfix">
    <div class="container">
        <div class="row">
            <!-- <div class="col-md-2 col-4 mb-3">
                <div class="page-menu">
                    <div class="top_menu " id="dashboard_box"><span class="icon-icon-01"></span>Dashboard</div>
                </div>
            </div> -->
            <div class="col-md-2 col-4 mb-3">
                <div class="page-menu">
                    <div class="top_menu active" id="academy_box"><span class="icon-icon-02"></span>Academy</div>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-3">
                <div class="page-menu">
                    <div class="top_menu" id="coach_box"><span class="icon-icon-02"></span>Coach</div>
                </div>
            </div>
            <div class="col-md-2 col-4 mb-3">
                <div class="page-menu">
                    <div class="top_menu" id="players_box"><span class="icon-icon-02"></span>Players</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <div id="dashboard_page" class="content-page">
</div> -->

<div id="academy_page" class="content-page">
<div id="academy-search-container">
    <input type="text" id="academy-search-input" placeholder="Search Academy..." autocomplete="off">
    <div id="academy-results-box">
        <ul id="academy-results-list">
            <!-- Results will be appended here -->
        </ul>
    </div>
</div>


<main id="profile_page" class="hidden">
        <section class="add-personal-info-section clearfix">
            <div class="container">
                <div class="accordion add-accordion" id="accordionadd01">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Add Personal Info
                            </button>
                            <div class="radialProgressBar progress-90">
                                <div class="overlay">90%</div>
                            </div>
                        </h2>
                        <form action="{{ route('academy.update') }}" method="post" id="coach_update" autocomplete="off">
                            @csrf

                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionadd01">
                                <div class="accordion-body">
                                    <div class="row g-2 g-md-3">
                                        <div class="col-lg-4 col-md-6">
                                            <input type="text" name="name" placeholder="Please Enter Your Academy Name" class="form-control your-name" id="profile-name" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <input type="email" placeholder="Please Enter Your Email" name="email" class="form-control" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <input type="tel" class="form-control" placeholder="Please Enter Your Phone Number" value="">
                                            <div class="verified">Verified</div>
                                        </div>
                                        <div class="col-lg-8 col-md-4">
                                            <div class="col-lg-8 col-md-6 w-100 location-box">
                                                <input type="text" placeholder="Please Enter Your City" name="city" class="form-control" id="locationInput" value="">
                                                <div id="location-name" class="location-list">
                                                    <!-- Dynamically filled based on input -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <select name="" id="" class="form-control">
                                                <option value="">Select range form this location</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="" class="form-label">About Yourself</label>
                                                <label for="" class="form-label"><span>0 - 500 Words</span></label>
                                            </div>
                                            <textarea name="about" id="profile-about" class="form-control" style="display: none;"></textarea>
                                            <div id="editor" class="mb-4"></div>
                                        </div>
                                        <div class="option_margin">
                                            <label for="" class="form-label">Options</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6 checkbox-group">
                                                <div class="form-check">
                                                    <label class="form-check-label" style="margin-right: 1rem;">
                                                        <input type="checkbox" name="option[]" value="Free Trial" class="form-check-input option_input"> Free Trial
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label" style="margin-right: 1rem;">
                                                        <input type="checkbox" name="option[]" value="Women Friendly" class="form-check-input option_input"> Women Friendly
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label" style="margin-right: 1rem;">
                                                        <input type="checkbox" name="option[]" value="Kids Friendly" class="form-check-input option_input"> Kids Friendly
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label" style="margin-right: 1rem;">
                                                        <input type="checkbox" name="option[]" value="Coaching" class="form-check-input option_input"> Coaching
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label" style="margin-right: 1rem;">
                                                        <input type="checkbox" name="option[]" value="Admission Open" class="form-check-input option_input"> Admission Open
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Category</label>
                                            <input type="text" name="categories" placeholder="Please Enter Your Categories" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Age Group</label>
                                            <input type="text" name="age_group" placeholder="Eg: 5-25 Years" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Experience</label>
                                            <select name="experience" class="form-control your-name" id="">
                                                <option value="">Experience</option>
                                                @for ($i = 1; $i <= 20; $i++) <option value="{{ $i }}">
                                                    {{ $i }} year{{ $i > 1 ? 's' : '' }}</option>
                                                    @endfor
                                            </select>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Address 1</label>
                                            <input type="text" name="address1" placeholder="Please Enter Your Address 1" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Address 2</label>
                                            <input type="text" name="address2" placeholder="Please Enter Your Address 2" class="form-control your-name" id="address2" value="" style="pointer-events:none; background-color:#e9ecef; color:#6c757d;">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Zipcode</label>
                                            <input type="text" name="postcode" placeholder="Please Enter Your Zipcode" class="form-control your-name" id="pin_code" value="" style="pointer-events:none; background-color:#e9ecef; color:#6c757d;">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Languages</label>
                                            <input type="text" name="spoken_languages" placeholder="Please Enter Your Languages" class="form-control your-name" id="" value="">
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Timings</label>
                                            <input type="text" name="timing" placeholder="Please Enter Your Timings" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Closed On</label>
                                            <input type="text" name="closed_on" placeholder="Closed On" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Website</label>
                                            <input type="text" name="website" placeholder="Please Enter Your Website" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Instagram Id</label>
                                            <input type="text" name="instagram" placeholder="Please Enter Your Instagram Id" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="" class="form-label">Facebook Id</label>
                                            <input type="text" name="facebook" placeholder="Please Enter Your Facebook Id" class="form-control your-name" id="" value="">
                                        </div>
                                        <div class="col-lg-8 col-md-4">
                                            <label for="" class="form-label">Select Near By Locations</label>
                                            <p>(You can select more than one locations.)</p>
                                            <div class="col-lg-6 col-md-6 location-box">
                                                <input type="text" placeholder="Select near by location" name="" class="form-control" id="nearByInput">
                                                <div id="location-name2" class="nearby_list">
                                                    <!-- Dynamically filled based on input -->
                                                </div>
                                            </div>
                                            <div class="nearby_locations d-flex justify-content-start gap-3 mt-3 align-items-start flex-wrap">

                                                <div class="location-item d-flex align-items-center" data-id=""
                                                    style="background-color:#FFd6F5; border: none; border-radius: 50px; margin: 0.25rem 0;padding:0.1rem 0.5rem; white-space:nowrap">
                                                    <span style="margin-right: 0.5rem;">Delhi</span>
                                                    <button class="remove-location btn btn-sm" style="background-color: transparent; border: none; color: red;">X</button>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-end">
                                            <button type="button" id="btn-save-personal-info" class="btn btn-secondary">Save
                                                &
                                                Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="training-day-time-section clearfix">
            <div class="container">
                <div class="accordion add-accordion" id="accordionaddnew03">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingnewThree">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsenewThree" aria-expanded="true" aria-controls="collapsenewThree">
                                Training Day & Timing
                            </button>
                            <!-- <div class="radialProgressBar progress-0">
                                <div class="overlay">0%</div>
                            </div> -->
                        </h2>
                        <form action="{{ route('academy.update') }}" method="post" id="days_update" autocomplete="off">
                            @csrf
                            <input hidden type="text" name="loc_id" id="loc_id_input" value="">
                            <input hidden type="text" name="name" id="hidden_name_input" value="">
                            <div id="collapsenewThree" class="accordion-collapse collapse"
                                aria-labelledby="headingnewThree" data-bs-parent="#accordionaddnew03">
                                <div class="accordion-body">
                                    <div class="day-box">
                                        <div class="day-check">
                                            <div class="day-name">Monday</div>
                                            <div class="check-box">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="monday-checkbox">
                                                    <label class="form-check-label" for="monday-checkbox">Closed</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="open-close-wrapper">
                                        </div>
                                    </div>

                                    <div class="day-box">
                                        <div class="day-check">
                                            <div class="day-name">Tuesday</div>
                                            <div class="check-box">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="tuesday-checkbox">
                                                    <label class="form-check-label" for="tuesday-checkbox">Closed</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="open-close-wrapper">
                                        </div>
                                    </div>

                                    <div class="day-box">
                                        <div class="day-check">
                                            <div class="day-name">Wednesday</div>
                                            <div class="check-box">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="wednesday-checkbox">
                                                    <label class="form-check-label" for="wednesday-checkbox">Closed</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="open-close-wrapper">
                                        </div>
                                    </div>


                                    <div class="day-box">
                                        <div class="day-check">
                                            <div class="day-name">Thursday</div>
                                            <div class="check-box">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="thursday-checkbox">
                                                    <label class="form-check-label" for="thursday-checkbox">Closed</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="open-close-wrapper">
                                        </div>
                                    </div>


                                    <div class="day-box">
                                        <div class="day-check">
                                            <div class="day-name">Friday</div>
                                            <div class="check-box">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="friday-checkbox">
                                                    <label class="form-check-label" for="friday-checkbox">Closed</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="open-close-wrapper">
                                        </div>
                                    </div>


                                    <div class="day-box">
                                        <div class="day-check">
                                            <div class="day-name">Saturday</div>
                                            <div class="check-box">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="saturday-checkbox">
                                                    <label class="form-check-label" for="saturday-checkbox">Closed</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="open-close-wrapper">
                                        </div>
                                    </div>


                                    <div class="day-box">
                                        <div class="day-check">
                                            <div class="day-name">Sunday</div>
                                            <div class="check-box">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="sunday-checkbox">
                                                    <label class="form-check-label" for="sunday-checkbox">Closed</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="open-close-wrapper">
                                        </div>
                                    </div>

                                    <div class="row g-2 g-md-3 mt-1">
                                        <div class="col-lg-12 text-end">
                                            <button type="button" class="btn btn-secondary days_btn">Save & Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="completion_percentage" id="days_hidden">
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="add-pricing-section clearfix">
            <div class="container">
                <div class="accordion add-accordion" id="accordionadd02">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Add Pricing (<span id="package-count">0</span>)
                            </button>
                            <div class="radialProgressBar progress-100" id="price_percent">
                                <div class="overlay">100%</div>
                            </div>
                        </h2>
                        <form action="{{ route('academy.update') }}" method="post" id="package_update" autocomplete="off">
                            @csrf

                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionadd02">
                                <div class="accordion-body">
                                    <div class="row g-2 g-md-3" id="packageList">
                                
                                        <div class="col-lg-4 col-md-6 skill-item">
                                            <div class="input-container">
                                                <input type="text" class="form-control" value="">
                                                <div class="remove">
                                                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/remove.svg" loading="lazy" alt="">
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <input type="hidden" name="fee" id="package_hidden">
                                        <input type="hidden" name="trial_class" id="trial_hidden">
                                        <div class="add-name-price">
                                            <div class="row g-2 g-md-3 d-flex justify-content-between align-items-center">
                                                <div class="col-lg-5 col-md-5">
                                                    <input type="text" class="form-control" id="packageName" placeholder="Enter Monthly Package Name">
                                                </div>
                                                <div class="col-lg-3 col-md-3">
                                                    <input type="number" class="form-control" id="packageAmount" placeholder="Enter Amount">
                                                </div>
                                                <div class="col-lg-3 col-md-4 group_check">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input2" type="radio" name="packageType" id="personalRadio" value="Personal" checked>
                                                        <label class="form-check-label" for="personalRadio">Personal</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input2" type="radio" name="packageType" id="groupRadio" value="Group">
                                                        <label class="form-check-label" for="groupRadio">Group</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <button type="button" id="btn-add-pricing" class="btn btn-success btn-add price-add"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end mt-2">
                                        <button type="button" class="btn btn-secondary pacakage-save-btn" id="btn-save-coach-packages">Save
                                            &amp; Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="add-photos-section clearfix">
            <div class="container">

                <div class="accordion add-accordion" id="accordionadd06">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                Add Photos (0)
                            </button>
                            <div class="radialProgressBar progress-100">
                                <div class="overlay">100%</div>
                            </div>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse " aria-labelledby="headingSix" data-bs-parent="#accordionadd06">
                            <div class="accordion-body">
                                <div class="row g-2 g-md-3">
                                    <form action="{{ route('academy.delete.photos.videos') }}" method="post" id="delete_form" autocomplete="off">
                                        @csrf
                                        <!-- <input hidden type="text" name="loc_id" id="loc_id_input" value="">
                                        <input hidden type="text" name="name" id="hidden_name_input" value=""> -->
                                        <div class="row g-2 g-md-3">

                                            <div class="col-lg-3 col-md-6">
                                                <div class="add-card">
                                                    <div class="make-profile d-flex justify-content-start align-items-start gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input profile-radio" type="radio" name="flexRadioDefault" id="flexRadio1" value="">
                                                            <label class="form-check-label" for="flexRadio1">
                                                                Logo
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input profile-radio" type="radio" name="flexRadioBannerDefault" id="flexRadioBanner1" value="">
                                                            <label class="form-check-label" for="flexRadioBanner1">
                                                                Banner
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="delete">
                                                        <input type="checkbox" class="photos-checkbox" name="selected_images[]" value="">
                                                    </div>
                                                    <figure><img src="" alt=""></figure>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                    <div class="col-lg-3 col-md-6">
                                        <form action="{{ route('academy.upload.photos.videos') }}" method="post" enctype="multipart/form-data" id="img_submit" autocomplete="off">
                                            @csrf
                                            <div class="add-new-file">
                                                <label class="filelabel">
                                                    <i class="fa-solid fa-plus"></i>
                                                    <span class="title" onclick="document.querySelector('#file-upload').click()">
                                                        Upload New Images
                                                    </span>
                                                    <input class="FileUpload1" name="file[]" type="file" id="file-upload" multiple accept="image/jpeg,image/png,image/gif" />
                                                </label>
                                            </div>
                                            <div class="error_img">
                                                <div id="fileTypeError" class="error-message" style="display:none; color: red;"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-3 col-md-6 delete_btn" style="display: none;">
                                        <div class="delete-new-file">
                                            <label class="filelable2">
                                                <i class="fa-solid fa-minus"></i>
                                                <span class="title">
                                                    Delete Selected Images
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="add-videos-section clearfix">
            <div class="container">
                <div class="accordion add-accordion" id="accordionadd07">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                Add Videos (0)
                            </button>
                            <div class="radialProgressBar progress-100">
                                <div class="overlay">100%</div>
                            </div>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse " aria-labelledby="headingSeven" data-bs-parent="#accordionadd07">
                            <div class="accordion-body">

                                <form action="{{ route('academy.delete.photos.videos') }}" method="post" id="delete_form2" autocomplete="off">
                                    @csrf
                                    <div class="row g-2 g-md-3">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="add-card">
                                                <figure>
                                                    <video controls class="fast_check">
                                                        <source src="" type="video/mp4">
                                                    </video>
                                                </figure>
                                                <div class="delete">
                                                    <input type="checkbox" class="video-checkbox" name="selected_videos[]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-lg-3 col-md-6">
                                    <form action="{{ route('academy.upload.photos.videos') }}" method="post" enctype="multipart/form-data" id="video_submit" autocomplete="off">
                                        @csrf
                                        <div class="add-new-file">
                                            <label class="filelabel">
                                                <i class="fa-solid fa-plus"></i>
                                                <span class="title" onclick="document.querySelector('#file-upload-2').click()">
                                                    Upload New Videos
                                                </span>
                                                <input class="FileUpload1" name="file[]" type="file" id="file-upload-2" multiple accept="video/mp4,video/webm,video/ogg" />
                                            </label>
                                        </div>
                                        <div class="error_img">
                                            <div id="fileTypeError" class="error-message" style="display:none; color: red;"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-3 col-md-6 delete_btn2" style="display: none;">
                                    <div class="delete-new-file">
                                        <label class="filelable2">
                                            <i class="fa-solid fa-minus"></i>
                                            <span class="title">
                                                Delete Selected Videos
                                            </span>
                                        </label>
                                    </div>

                                    <div class="error_img">
                                        <div id="fileTypeError" class="error-message" style="display:none; color: red;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
</div>

</div>

<div id="coach_page" class="content-page" style="display: none;">
</div>

<div id="players_page" class="content-page" style="display: none;">
</div>
@endsection