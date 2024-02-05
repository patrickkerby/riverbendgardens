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
        @php      
        if( have_rows('faq') ):
        
        $count = 0;	@endphp
        <div id="accordion1" class="accordion">

          <h3><button class="btn btn-link faq" data-toggle="collapse" data-target="#collapse-{{ $count }}" aria-expanded="false" aria-controls="collapse-{{ $count }}">@php echo($faq_title); @endphp </button></h3>
          <div id="collapse-{{ $count }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion1">
              @php echo($faq_content); @endphp
          </div>
          
          @php $count++; endif;          
          endwhile; @endphp
        </div>
          
          @php      
          
          $count1 = 0;	@endphp
          <div id="accordion1" class="accordion">
            <h2 id="program">About the CSA Program</h2>
					  @php while ( have_rows('faq') ) : the_row();
            if( get_sub_field('faq_category') == 'csa' ): 
              $faq_title = get_sub_field('faq_title');
              $faq_content = get_sub_field('faq_content');
            @endphp

            <h3><button class="btn btn-link faq" data-toggle="collapse" data-target="#collapse-{{ $count1 }}" aria-expanded="false" aria-controls="collapse-{{ $count1 }}">@php echo($faq_title); @endphp </button></h3>
            <div id="collapse-{{ $count1 }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion1">
                @php echo($faq_content); @endphp
            </div>
            
            @php $count1++; endif;          
            endwhile; @endphp
          </div>

          @php 
          $count2 = 0;	@endphp
          <div id="accordion2" class="accordion">
            <h2 id="farm">About the Farm</h2>
					  @php while ( have_rows('faq') ) : the_row();
            if( get_sub_field('faq_category') == 'farm' ): 
              $faq_title = get_sub_field('faq_title');
              $faq_content = get_sub_field('faq_content');
            @endphp

            <h3><button class="btn btn-link faq" data-toggle="collapse" data-target="#collapse2-{{ $count2 }}" aria-expanded="false" aria-controls="collapse2-{{ $count2 }}">@php echo($faq_title); @endphp </button></h3>
            <div id="collapse2-{{ $count2 }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                @php echo($faq_content); @endphp
            </div>
            
            @php $count2++; endif;          
            endwhile; @endphp
          </div>

          @php 
          $count3 = 0;	@endphp
          <div id="accordion3" class="accordion">
            <h2 id="veggies">About the Veggies</h2>
					  @php while ( have_rows('faq') ) : the_row();
            if( get_sub_field('faq_category') == 'produce' ): 
              $faq_title = get_sub_field('faq_title');
              $faq_content = get_sub_field('faq_content');
            @endphp

            <h3><button class="btn btn-link faq" data-toggle="collapse" data-target="#collapse3-{{ $count3 }}" aria-expanded="false" aria-controls="collapse3-{{ $count3 }}">@php echo($faq_title); @endphp </button></h3>
            <div id="collapse3-{{ $count3 }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion3">
                @php echo($faq_content); @endphp
            </div>
            
            @php $count3++; endif;          
            endwhile; @endphp
          </div>
          
          
          @php else :
						// no rows found
					endif;
					@endphp
      </div>
      
    </div>

  @endwhile
</section>
@endsection
