<!-- training ground tab  -->
@if(count($data['otherLocalities'])>0)
<div class="mob_academy_box">
    <div class="mob_academy_fee_box other_local_box">
        <p class="mob_academy_fee_heading">Other Localities</p>
    </div>
    <section class="local_section">
        <div class="other_local_flex">
        @php
            $words = ['Academy', 'Coach', 'Training', 'Player', 'Basketball', 'Football', 'Swimming', 'Hockey', 'Cricket', 'Badminton'];
        @endphp
        @foreach($data['otherLocalities'] as $index => $otherLocalities)
        @php
                $wordIndex = $index % count($words);
                $cityOrLocality = rand(0, 1) == 1 ? 'City' : 'Locality';
            @endphp
            <div class="local_new_flex">
                <div class="other_local">
                    <div class="sno_flex">
                        <span class="sno_value">{{$index+1}}</span>
                        <div class="info_on_img">
                            <img src="{{ env('AWS_S3_BASE_URL') }}/asset/images/build_icon_{{($index % 8)+1}}.png" loading="lazy" alt="localities" class="grey_border">
                            <div class="image_text">
                                <span class="sample_hd">{{$words[$wordIndex]}}</span>
                                <div class="hd">
                                <span>{{$cityOrLocality}}</span>
                                </div>
                            </div>
                            <div class="count_local">
                                <span>{{$otherLocalities->count?$otherLocalities->count:"0"}}</span>
                            </div>
                        </div>

                    </div>


                </div>
                <div>
                    <div class="local_main">
                        <span class="local_name"><a target="_blank" href="{{$otherLocalities->url}}">{{$otherLocalities->locality_name?$otherLocalities->locality_name:""}}</a></span>
                        <span class="local_add">{{ ($otherLocalities->locality_name ? $otherLocalities->locality_name : '') . ($otherLocalities->locality_name ? ', ' . $otherLocalities->city : '') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

</div>
<!-- training ground tab ends -->
@endif