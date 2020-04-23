{{--
  Template Name: Veggies Page
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <section class="row justify-content-center">
    <div class="col-md-10 veggie-content">
      @include('partials.content-page')
      <div class="callstoaction row justify-content-center">
        <a href="#" class="ghost" data-toggle="modal" data-target="#pickupModal-seasonality">Veggie Seasonality Chart</a>
        <a href="#" class="ghost" data-toggle="modal" data-target="#pickupModal-csa">What to expect in your CSA</a>    
      </div>
    </div>
    <div class="modal fullmodal fade" id="pickupModal-csa" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="modal-body">
            <div class="container-fluid">                
              @include( "partials.flexible-csachart")
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fullmodal fade" id="pickupModal-seasonality" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="modal-body">
            <div class="container-fluid">                
              @include( "partials.flexible-veggiechart")
              <section class="row justify-content-center">
                <div class="col-sm-10">
                  <p>All timelines may vary due to weather. The above listed crops are our regular veggie offerings. We try new crops each season which may or may not be available for purchase at our market stalls or included in the CSA depending on their success and volume.</p>
                  <p>**Berries from our U-Pick saskatoon orchard are not sold at Farmers' Markets or included in the CSA.</p>
                  <p><strong class="marketOnly">MARKET ONLY</strong> crops will be available on our Farmers' Market tables but not included in the CSA. These crops either reach their peak too early in the season (pre-CSA) or do not produce enough volume to be fairly distributed in each of the weekly CSA bounties. If weather conditions give us bumper crops or longer seasons for these veggies, there is always a chance you'll find them included but they should not be expected to make an appearance.</p>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
            <div class="modal fullmodal fade" id="pickupModal-{{ $loop->index }}" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
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
                          <h5>Storage Recommendations &amp; Recipes:</h5>
                          {!! $item['storage'] !!}
                          <hr />                        
                          @if(!empty($item['variety']))
                            <h4>Varieties</h4>
                            @foreach ($item['variety'] as $type)
                              <h5>{{ $type['title'] }}:</h5>
                              <p>{{ $type['description'] }}</p>
                            @endforeach
                          @endif
                          @if ( !empty($item['notes']) )
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
          </div>
        @endforeach
    </section>
  @endwhile
@endsection
