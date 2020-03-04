{{--
  Template Name: Veggies Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section class="row">
        @foreach ($veggie_loop as $item)
          <div class="col-sm-10 col-md-6 col-lg-4 justify-content-center">
          <a href="#" data-toggle="modal" data-target="#pickupModal-{{ $loop->index }}" class="card">
              <div class="veggie-img">
                {!! $item['thumbnail'] !!}
              </div>
              <div class="card-body">
                <h3>{{ $item['title'] }}</h3>
                <h4>{{ $item['family'] }}</h4>
              </div>
            </a>
            <div class="modal fullmodal" id="pickupModal-{{ $loop->index }}" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-sm-6 col-lg-5 intro">
                          <h3>{{ $item['title'] }}</h3>
                          <h4>{{ $item['family'] }}</h4>
                          {!! $item['thumbnail'] !!}
                        </div>
                        <div class="col-sm-6 col-lg-7 details">
                          <h5>Storage Recommendations:</h5>
                          {!! $item['storage'] !!}
                          <hr />                        
                          @if($item['variety'])
                            <h4>Varieties</h4>
                            @foreach ($item['variety'] as $item)
                              <h5>{{ $item['title'] }}:</h5>
                              <p>{{ $item['description'] }}</p>
                            @endforeach
                          @endif
                          @if($item['notes'])
                            <div class="notes">
                              {{ $item['notes'] }}
                            </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>										
              </div>
            </div>
          </div>
        @endforeach
        @include('partials.content-page')
    </section>
  @endwhile
@endsection
