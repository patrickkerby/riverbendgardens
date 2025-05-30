@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @php    
      // This loop requires a /partials template that is named exactly the same as the layout title in ACF flexible content page builder
      $id = get_the_ID();    
      if ( have_rows( 'page_builder', $id ) ) :      
        // loop through the selected ACF layouts and display the matching partial
        while ( have_rows( 'page_builder', $id ) ) : the_row();
          $layout = get_row_layout();
        @endphp      
          @include( "partials.page-builder.{$layout}")
        @php
        endwhile;      
      elseif ( get_the_content() ) :      
        // no layouts found  
        @endphp
        <section class="row justify-content-center">
          <div class="col-sm-10">
            {{-- @include( "partials.page-builder.{$layout}") --}}
            @include('partials.content-page')
          </div>
        </section>
        @php
      endif;        
    @endphp
  @endwhile
@endsection
