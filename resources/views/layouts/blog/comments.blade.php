<div class="comment_section">

    <div class="bd_total_comment">
        <p class="fb_font ">Comments ({{count($data['comments'])}})</p>
    </div>

    @if(count($data['comments']) > 0)
    <section class="review_wrapper">
        <div class="mob_academy_review">
            @foreach($data['comments'] as $comment)


            <div class="mob_academy_reply_wrapper">
                <div class="mob_academy_review_name">
                    <div class="mob_academy_review_person">
                        <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/mob_reply.svg" loading="lazy" alt="reply" width="18"
                            height="18">
                        <span class="mob_academy_person_name">{{$comment->name}}</span>
                    </div>
                    <div>
                    <span class="mob_academy_min">{{ (new DateTime($comment->creation_date))->format('Y-m-d (H:i)') }}</span>
                    </div>
                </div>
                <div class="mob_academy_review_para">
                    <span>{{$comment->comment}}</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>