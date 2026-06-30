<div class="blog_category">
<div><h3 class="fb_font blog_category_heading">Related Categories</h3></div>
<div class="category_scroll">
   <div class="category_list">
      <ul class="fb_font">
      @foreach($data['blogCategories'] as $category)
        <li>
            <div class="blog_category_details">
                <p class="fb_font bog_category_count"><a href="{{ $category->url }}" target="_blank">({{ $category->count }})</a></p>
                <p class="fb_font blog_category_name"><a href="{{ $category->url }}" target="_blank">{{ $category->title }}</a></p>
            </div>
        </li>
       @endforeach
      </ul>
   </div>
</div>
</div>
