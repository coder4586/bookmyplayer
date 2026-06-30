<section class="hp_wrapper">
   <div class="hp_content">
      <div class="help-content">
         <span class="close-help"><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/menu_cross.svg" class="help_cross" alt="Close Menu"></span>
         <h4>Support: Manage {{$data["d"]->name}}</h4>
         @if(session('success_ticket'))
         <div class="alert alert-success m-1 toast-help">
            {{ session('success_ticket') }}
         </div>
         @endif
         @if(session('error_ticket'))
         <div class="alert alert-danger m-1 toast-help">
            {{ session('error_ticket') }}
         </div>
         @endif


         <form id="help_form2" method="POST" action="{{ route('submit.ticket') }}">
            <div class="form_help_error">
               <p id="formError2"></p>
            </div>

            @csrf
            <div class="form-group-coach new_input_grp">
               <input type="text" name="title" id="name_help2" class="form-input-coach" placeholder="" />
               <label for="name" class="form-label-coach">Name:</label>
            </div>

            <div class="">
               <div class="">
                  <div class="form-group-academy">
                     <div class="gender_heading_academy">Query Type</div>
                     <div class="form-group-radio-academy">
                        <select name="experience" id="query_help2" class="skill_select_academy">
                           <option selected value="registered mobile and email on account is incorrect.">Registered mobile and email on account is incorrect.</option>
                           <option value="Unable to login.">Unable to login.</option>
                           <option value="This academy is no longer available.">This academy is no longer available.</option>
                           <option value="Other issues.">Other issues.</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>

            <div class="form-group-coach new_input_grp">
               <input type="email" name="email" id="email_help2" class="form-input-coach" placeholder="" />
               <label for="name" class="form-label-coach">Email:</label>
            </div>
            <div class="form-group-coach new_input_grp">
               <input type="tel" name="mobile" id="phone_help2" class="form-input-coach" placeholder="" />
               <label for="name" class="form-label-coach">Phone:</label>
            </div>

            <div class="form-group-coach new_input_grp">
               <textarea type="text" name="description" id="desc_help2" class="form-input-coach" placeholder=""></textarea>
               <label for="name" class="form-label-coach">Please describe your issue in detail</label>
            </div>

            <div class="help_submit2 hp_submit">
               <button id="send_help_btn2" class="hp_btn" type="submit">Submit</button>
            </div>
         </form>
         <a href="https://api.whatsapp.com/send/?phone=%2B918826450360&text=I+own+this+business.+need+your+help.+academy+({{ $data['d']->id }})" target="_blank"><button class="mob_call_btn fb_call_new"> <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mwhtaps.svg" loading="lazy" alt="chat">Chat</button></a>
      </div>
   </div>
</section>
