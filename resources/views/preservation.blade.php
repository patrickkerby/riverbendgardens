{{--
  Template Name: Preservation Page
--}}

@php
@endphp

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    
    <section class="row no-gutters justify-content-center preservation-content">    
      <ul class="nav col-sm-12 justify-content-center" id="pills-tab" role="tablist">
        @foreach ($preservation_terms as $type)
          <li class="nav-item" role="presentation">
            <button class="ghost nav-link {{ $type->slug }}" id="pills-{{ $type->slug }}-tab" data-toggle="pill" data-target="#pills-{{ $type->slug }}" type="button" role="tab" aria-controls="pills-{{ $type->slug }}" aria-selected="true">{{ $type->name }}</button>
          </li>
        @endforeach
      </ul>      
    
      <div class="veggie_select dropdown show">
        <a class="btn btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          or, learn by veggie:
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          @foreach ($preservation_loop as $item)
            <a class="dropdown-item {{ $item['slug'] }}" href="{{ $item['link'] }}">{{ $item['title'] }}</a>          
          @endforeach
        </div>
      </div>

      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-start" role="tabpanel" aria-labelledby="pills-start-tab">
          <section class="row justify-content-center">
            <div class="col-sm-9">
              @include('partials.content-page')
            </div>
          </section>
        </div>

        @foreach ($preservation_terms as $type)
          @php
            $category_content = get_field('preservation_technique_details', 'term_'.$type->term_id);
            $category_slug = $type->slug;
          @endphp
          <div class="tab-pane fade" id="pills-{{ $type->slug }}" role="tabpanel" aria-labelledby="pills-{{ $type->slug }}-tab">
            <section class="row justify-content-center">
              <div class="col-sm-10">
                {!! $category_content !!}
              </div>
            </section>
            
            <div class="row related_veggies justify-content-center">              
              <h2 class="col-12">Vegetables that are well suited to canning:</h2>
              <p class="col-sm-6"><strong>Choose a veggie and learn everything you need  to keep it through the seasons.</strong></p>
              <div class="row">
                @foreach ($preservation_loop as $item)                    
                  @php
                    $post_terms = $item['preservation_techniques'];
                    $post_term_slugs = array();

                    foreach($post_terms as $preservation_term) {
                      $post_term_slugs[] = $preservation_term->slug;
                    }

                    $veggie_object = $item['veggie'];
                    $veggie_id = $veggie_object->ID;

                    $thumbnail = get_the_post_thumbnail($veggie_object->ID, 'large');
                  @endphp                
                  @if(in_array($type->slug, $post_term_slugs))
                    <div class="col-sm-6 col-md-3">
                      <a href="{{ $item['link'] }}">
                        {!! $thumbnail !!}
                        <h4>{{ $veggie_object->post_title }}</h4>
                      </a>
                    </div>      
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        @endforeach
      </div>      
    </section>
  @endwhile
@endsection
