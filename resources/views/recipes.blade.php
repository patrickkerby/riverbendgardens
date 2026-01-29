{{--
  Template Name: Recipes Page
--}}
@php
    $args = [
        "post_type"      => 'recipe',
        "posts_per_page" => 12,
        "facetwp"        => true,
    ];
    // Run the query - FacetWP will handle pagination and sorting (via filter)
    $recipes_loop = new WP_Query( $args );

@endphp

@extends('layouts.app')
@section('content')
    
    <section class="recipes-container container-fluid">
        <div class="row">
            <button class="button facetwp-flyout-open d-block d-sm-none"><i class="fas fa-sliders-h"></i> Filter by veggies</button>

            <section class="filter col-md-3 d-none d-sm-block">
                <div class="facets">
                    <div class="categories">
                        <h4>Categories:</h4>
                        {!! facetwp_display( 'facet', 'recipe_categories' ) !!}
                    </div>
                    <div class="veggie-filter">
                        <h4>Filter by Veggies:</h4>
                        {!! facetwp_display( 'facet', 'veggies' ) !!}
                    </div>
                    {!! facetwp_display( 'facet', 'reset' ) !!}
                </div>

                <div class="cta d-none d-md-block d-sm-none">
                    <a href="/preservation">Check out our <strong>Preservation Guide!</strong></a>
                </div>

                <div class="cta d-none d-md-block d-sm-none">
                    <a href="/veggies">Learn about seasonality: <strong>Veggie Guide</strong></a>
                </div>
            </section>        
            <section class="recipes-grid col-md-9">

                @php if ( $recipes_loop->have_posts() ) :
                    while ( $recipes_loop->have_posts() ) :
                        $recipes_loop->the_post(); 
                        @endphp
                        {{-- @dump($recipes_loop->post); --}}
                        @include('partials.recipe-card')
                    @php endwhile;
                    else : @endphp
                        <p><?php  _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                @php endif;

                wp_reset_postdata(); @endphp

                @php
                    $stories = get_posts([
                        'post_type' => 'story',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                    ]);
                @endphp

                @if ($stories)
                <div class="cta-stories">
                    <div class="content">
                        <h2>CSA Subscriber Stories</h2>
                        <p>See why other Edmontonians choose our CSA, and the impact it has on their day to day lives!</p>
                    </div>
                    <div id="storiesCarousel" class="carousel slide carousel-fade image" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($stories as $index => $story)
                                <li data-target="#storiesCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($stories as $index => $story)
                                @php
                                    $hero_image = get_field('background_image', $story->ID);
                                @endphp
                                <a href="{{ get_permalink($story->ID) }}" data-interval="10000" data-pause="hover" class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <h3>CSA Stories</h3>
                                    <h4>{{ $story->post_title }}</h4>
                                    @if ($hero_image)
                                        <img src="{{ $hero_image }}" alt="{{ $story->post_title }}">
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </section>

            <div class="cta d-md-none d-sm-block col-12">
                <a href="/preservation">Check out our <strong>Preservation Guide!</strong></a>
            </div>

            <div class="cta d-md-none d-sm-block col-12">
                <a href="/veggies">Learn about seasonality: <strong>Veggie Guide</strong></a>
            </div>

            {{-- {!! facetwp_display( 'facet', 'paging' ) !!} --}}
        </div>
    </section>

@endsection

