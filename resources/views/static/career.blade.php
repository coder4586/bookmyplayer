@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/career.min.css') }}" type="text/css">
@endpush
@push('scripts')
<script src="{{ asset('asset/js/career_v1.js') }}" defer></script>
@endpush
@extends('layouts.app')
@section('content')
<main class="career-main-container">
   <header>
      <div class="career-bg">
         <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/career_banner.webp" alt="career banner">
         <div>
            <h1 class="common-fonts career-join-us"><span>join us</span> & be the <br /> part of the change</h1>
         </div>
      </div>
   </header>
   <section class="career-intern-container">
      <div class="career-intern-left">
         <div>
            <h2 class="common-fonts career-team">Why you Should Join Our
               Awesome Team
            </h2>
         </div>
         <div>
            <p class="common-fonts career-note">Are you a <span>passionate and driven individual</span> with a
               strong interest in both sports and technology? We welcome interns who are eager to make a
               significant impact at the intersection of these two dynamic fields.
            </p>
         </div>
         <div>
            <button class="common-fonts career-join-btn">Join Us</button>
         </div>
      </div>
      <div class="career-intern-right">
         <div>
            <div class="career-intern-img">
               <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/cap.svg" loading="lazy" alt="experience">
            </div>
            <div>
               <h3 class="common-fonts career-intern-heading">Hands-On Experience</h3>
            </div>
            <div>
               <p class="common-fonts career-intern-note">You won't just be observing from the sidelines. Our
                  interns are given real responsibilities and projects.
               </p>
            </div>
         </div>
         <div>
            <div class="career-intern-img">
               <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/user-grp.svg" loading="lazy" alt="mentorship">
            </div>
            <div>
               <h3 class="common-fonts career-intern-heading">Mentorship</h3>
            </div>
            <div>
               <p class="common-fonts career-intern-note">You'll have access to experienced professionals who
                  are passionate about nurturing talent.
               </p>
            </div>
         </div>
         <div>
            <div class="career-intern-img">
               <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/bulb.svg" loading="lazy" alt="innovation">
            </div>
            <div>
               <h3 class="common-fonts career-intern-heading">Innovation</h3>
            </div>
            <div>
               <p class="common-fonts career-intern-note">Be part of a team that's pushing the boundaries of
                  what's possible in the world of sports technology.
               </p>
            </div>
         </div>
         <div>
            <div class="career-intern-img">
               <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/hand.svg" loading="lazy" alt="impact">
            </div>
            <div>
               <h3 class="common-fonts career-intern-heading">Impact</h3>
            </div>
            <div>
               <p class="common-fonts career-intern-note">Your contributions matter. You'll have the chance to
                  see your work make a difference in the world of sports and technology.
               </p>
            </div>
         </div>
      </div>
   </section>
   <section class="career-tab">
      <div class="availiblity">
         <h3 class="available_roles">Apply for Open <span>Roles & Positions</span></h3>
      </div>
      <div class="table-responsive">
      <table class="table">
    <thead>
        <tr class="career-profile-top">
            <th>Position</th>
            <th>Experience</th>
            <th>Type</th>
            <th>Location</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['openPositions'] as $position)
        <tr class="career-product">
            <td data-label="Position">{{ $position->position }}</td>
            <td data-label="Experience">{{ $position->experience }}</td>
            <td data-label="Type">{{ $position->employment_type }}</td>
            <td data-label="Location">{{ $position->location }}</td>
            <td>
                <button class="btn btn-danger apply-button" data-id="{{ $position->id }}">Apply Now</button>
            </td>
        </tr>
        <tr class="career-details-row" id="details-{{ $position->id }}" style="display: none;">
            <td colspan="5">
                <div class="details-container">
                    <div class="job-description">
                        <h4>Job Description</h4>
                        <p>{{ $position->description }}</p>
                    </div>
                    <div class="right_resume">
                    <div class="job-description mb-3">
                      <h6>Apply for this job</h4>
                    </div>
               <span class="form-error"></span>
      <div class="resume_form">
         <div class="mb-3">
         <span id="error-message-{{ $position->id }}" style="color:red;"></span>
         </div>
         
         <input type="text" class="common-fonts resume_input" id="name-{{ $position->id }}" placeholder="Full Name">
         <input type="email" class="common-fonts resume_input input_two" id="email-{{ $position->id }}" placeholder="Email Address">
         <input type="number" class="common-fonts resume_input input_two" id="phone-{{ $position->id }}" placeholder="Phone Number">
         <input type="text" class="common-fonts resume_input input_two" id="linkedin-{{ $position->id }}" placeholder="linkedIn profile URLr">
         <div class="mt-3">
         <span id="file-name-{{ $position->id }}"></span>
         </div>
      </div>
      <div class="file-upload">
         <label for="resume-upload-{{ $position->id }}" class="custom-file-upload">
            Upload Resume
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/resume_download.svg" loading="lazy" alt="" width="14" height="14">
         </label>
         <input type="file" id="resume-upload-{{ $position->id }}" class="common-fonts input_two">
      </div>

      <div class="career_btn">
    <button class="apply-job-button" data-id="{{ $position->id }}">Submit</button>
</div>
   </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

      </div>
   </section>
   </div>
   </section>
</main>
<!-- resume section  -->
<section class="career_resume">
   <div class="left_resume">
      <div>
         <h2 class="common-fonts resume_heading">Didn’t find a role matching your area of interest?</h2>
         <p class="common-fonts resume_ans">Fill in the details and we will reach out to you.
         </p>
      </div>
   </div>
   <div class="right_resume">
      <div class="resume_form">
      <div class="mb-3">
         <span id="error-message-0" style="color:red;"></span>
         </div>
         <input type="text" class="common-fonts resume_input" id="name-0" placeholder="Full Name">
         <input type="email" class="common-fonts resume_input input_two" id="email-0" placeholder="Email Address">
         <input type="number" class="common-fonts resume_input input_two" id="phone-0" placeholder="Phone Number">
         <input type="text" class="common-fonts resume_input input_two" id="linkedin-0" placeholder="linkedIn profile URLr">
         <div class="mt-3">
         <span id="file-name-0"></span>
         </div>
         
      </div>
      <div class="file-upload">
         <label for="resume-upload-0" class="custom-file-upload">
            Click Here To Upload Resume
            <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/resume_download.svg" loading="lazy" alt="" width="14" height="14">
         </label>
         <input type="file" id="resume-upload-0" class="common-fonts input_two">
      </div>

      <div class="career_btn">
    <button class="apply-job-button" data-id="0">Submit</button>
</div>
   </div>
</section>
<!-- resume section ends -->
@endsection

