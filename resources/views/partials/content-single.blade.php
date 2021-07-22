<article @php post_class("row justify-content-center") @endphp>  
  <div class="entry-content col-md-10">
    @php the_content() @endphp
  </div>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
