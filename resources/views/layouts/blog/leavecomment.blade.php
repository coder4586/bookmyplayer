
<!-- Comment form -->
<div class="bd_comment">
   <div class="leave_comment">
   @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
   @endif
      <h2 class="fb_font">Leave a Comment</h2>
   </div>
   <div class="comment_input">
      <form action="{{ route('post.comment') }}" method="post">
      @csrf
      <input type="hidden" name="id" value="{{ $data['id'] }}">
      <input type="text" name="name" placeholder="Name" class="bd_input fb_font" required>
      <textarea name="comment" placeholder="Comment" cols="30" rows="4" class="bd_input fb_font" required></textarea>
      <div class="comment_btn">
         <button type="submit">Post a comment</button>
      </div>
      </form>
   </div>
</div>
