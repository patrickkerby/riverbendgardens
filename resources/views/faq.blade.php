{{--
  Template Name: FAQ
--}}

@extends('layouts.app')
@section('content')

<section>
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-page')
    
    <div class="row">
      <div class="col-md-3 side-nav faq-nav">          
        <a href="#program">About the program</a>
        <a href="#farm">About the farm</a>
        <a href="#veggies">About the veggies</a>
      </div>
      <div class="col-md-9 faq">
        @if(have_rows('faq'))
          <div id="accordion1" class="accordion">
            <h2 id="program">About the CSA Program</h2>
            @php $count1 = 0;	@endphp
            @while(have_rows('faq'))
              @php the_row() @endphp
              @if( get_sub_field('faq_category') == 'csa' )
                @php
                  $faq_title = get_sub_field('faq_title');
                  $faq_content = get_sub_field('faq_content');
                @endphp
                <h3><button class="btn btn-link faq" data-toggle="collapse" data-target="#collapse-{{ $count1 }}" aria-expanded="false" aria-controls="collapse-{{ $count1 }}">@php echo($faq_title); @endphp </button></h3>
                <div id="collapse-{{ $count1 }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion1">
                  {!! $faq_content !!}
                </div>
                @php $count1++; @endphp
              @endif
            @endwhile
          </div>
            
          <div id="accordion2" class="accordion">
            <h2 id="farm">About the Farm</h2>					  
            @php $count2 = 0;	@endphp
            @while(have_rows('faq'))
              @php the_row() @endphp
              @if( get_sub_field('faq_category') == 'farm' )
                @php
                  $faq_title = get_sub_field('faq_title');
                  $faq_content = get_sub_field('faq_content');
                @endphp
                <h3><button class="btn btn-link faq" data-toggle="collapse" data-target="#collapse2-{{ $count2 }}" aria-expanded="false" aria-controls="collapse2-{{ $count2 }}">@php echo($faq_title); @endphp </button></h3>
                <div id="collapse2-{{ $count2 }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                  {!! $faq_content !!}
                </div>            
                @php $count2++; @endphp
              @endif
            @endwhile
          </div>

          <div id="accordion3" class="accordion">
            <h2 id="veggies">About the Veggies</h2>
            @php $count3 = 0;	@endphp
            @while(have_rows('faq'))
              @php the_row() @endphp
              @if( get_sub_field('faq_category') == 'produce' )
                @php
                  $faq_title = get_sub_field('faq_title');
                  $faq_content = get_sub_field('faq_content');
                @endphp
                <h3><button class="btn btn-link faq" data-toggle="collapse" data-target="#collapse3-{{ $count3 }}" aria-expanded="false" aria-controls="collapse3-{{ $count3 }}">@php echo($faq_title); @endphp </button></h3>
                <div id="collapse3-{{ $count3 }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion3">                
                    {!! $faq_content !!}
                </div>
                @php $count3++; @endphp
              @endif
            @endwhile
          </div>
        @endif
      </div>
    </div>

  @endwhile
</section>
@endsection
