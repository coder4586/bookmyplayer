
<div class="bd_tag_top">
    <h3 class="fb_font bd_tag">Tags</h3>
    <div class="bd_tag_list">
    @foreach($data['blogTags'] as $tags)
        <div class="tag_round">
            <a href="{{ $tags->url }}" target="_blank"><p class="fb_font">{{ $tags->tag }}</p></a>
        </div>
    @endforeach
    </div>
</div>