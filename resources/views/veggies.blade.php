{{--
  Template Name: Veggies Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section class="row">
        @foreach ($veggie_loop as $item)
          <div class="col-sm-12 col-md-6 col-lg-4 justify-content-center">
            <a href="#" class="card">
              <div class="veggie-img">
                {!! $item['thumbnail'] !!}
              </div>
              <div class="card-body">
                <h3>{{ $item['title'] }}</h3>
                <h4>{{ $item['family'] }}</h4>
              </div>
            </a>
          </div>
        @endforeach
        @include('partials.content-page')
    </section>
  @endwhile
@endsection
