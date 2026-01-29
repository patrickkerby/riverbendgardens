<article @php post_class("row justify-content-center") @endphp>  
  <div class="left-column col-md-5">
    @foreach ($recipe_photos as $item)
      <img class="ingredients d-none d-md-block d-sm-none" src="{{ $item->url }}" />
    @endforeach

    <section class="ingredients d-none d-md-block d-sm-none">
      <h4>Ingredients</h4>
      @foreach ($ingredients_section as $item)
        <strong>{{ $item->ingredients_section_title }}</strong>
        <ul>
        @foreach ($item->ingredients as $item)
            <li>{{ $item->ingredient }}</li>
          @endforeach
        </ul>
      @endforeach
    </section>

  </div>
  <div class="entry-content col-md-7">
    <a class="back-button" href="/recipes">Back to all Recipes</a>
    <h1 class="page-title"><?php the_title(); ?></h1>
    @if ($subtitle)
      <h3>{{ $subtitle }}</h3>
    @endif

    <div class="meta">      
      <ul class="pills-list">
        @foreach ($veggies_used as $item)
          <li class="pills"><a href="/veggies/?modal={{ $item->post_name }}">{{ $item->post_title }}</a></li>
        @endforeach
      </ul>

      @if ($prep_time && !$cooking_time)
        <span>Prep: {{ $prep_time }}</span>      
      @elseif ($cooking_time && !$prep_time)
        <span>Cook: {{ $cooking_time }}</span>      
      @elseif ($prep_time && $cooking_time)
        <span>Prep: {{ $prep_time }} / Cook: {{ $cooking_time }} </span>
      @endif
      
      @if ($servings)
        <span>Servings: {{ $servings }}</span>
      @endif
    </div>

    @if ( $recipe_description)
      <div class="description">
        {!! $recipe_description !!}
      </div>
    @endif

    @foreach ($recipe_photos as $item)
      <img class="ingredients d-sm-block d-md-none" src="{{ $item->url }}" />
    @endforeach
      
    <section class="ingredients d-sm-block d-md-none">
      <h4>Ingredients</h4>
      @foreach ($ingredients_section as $item)
        <strong>{{ $item->ingredients_section_title }}</strong>
        <ul>
        @foreach ($item->ingredients as $item)
            <li>{{ $item->ingredient }}</li>
          @endforeach
        </ul>
      @endforeach
    </section>
    
    @if ( $directions)
      <section class="directions">
        <h4>Directions</h4>
        {!! $directions !!}
      </section>
    @endif

    @if ($notes)
      @foreach ($notes as $item)
        <div class="notes">
          <h4>Notes</h4>
          {!! $item->note !!}
        </div>
      @endforeach
    @endif
  </div>
    {{-- @php the_content() @endphp --}}
    
  </div>
</article>
