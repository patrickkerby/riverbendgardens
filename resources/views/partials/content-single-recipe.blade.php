<article @php post_class("row justify-content-center") @endphp>  
  <div class="entry-content col-md-10">
    @php the_content() @endphp
    @if ($subtitle)
      <h3>{{ $subtitle }}</h3>
    @endif
    <div class="description">
      {!! $recipe_description !!}
    </div>
    @foreach ($recipe_photos as $item)
      <img src="{{ $item->url }}" />
    @endforeach

    <div class="meta">
      <span>Servings: {{ $servings }}</span>
      <span>Prep Time: {{ $prep_time }}</span>
      <span>Cooking Time: {{ $cooking_time }}</span>
    </div>

    <ul>
      @foreach ($veggies_used as $item)
        <li><a href="/veggies/?modal={{ $item->post_name }}">{{ $item->post_title }}</a></li>
      @endforeach
    </ul>

    <section class="ingredients">
      @foreach ($ingredients_section as $item)
        {{ $item->ingredients_section_title }}

        @foreach ($item->ingredients as $item)
          {{ $item->ingredient }}
        @endforeach
      @endforeach
    </section>

    @if ( $directions)
      <section class="directions">
        {!! $directions !!}
      </section>
    @endif

    @if ($notes)
      @foreach ($notes as $item)
        <div class="notes">
          {!! $item->note !!}
        </div>
      @endforeach
    @endif
  </div>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
