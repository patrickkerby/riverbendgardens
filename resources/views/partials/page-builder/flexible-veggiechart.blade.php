@php
  $title = get_sub_field('title');
  $description = get_sub_field('description');
@endphp

<section class="row veggiechart">
  @if( get_row_layout() == 'flexible-veggiechart' )
    <h2>{{ $title }}</h2>
  @endif
  <div class="breakout row justify-content-center">
    <div id="chart">
      <ul>
        <li>June</li>
        <li>July</li>
        <li>Aug</li>
        <li>Sept</li>
        <li>Oct</li>
        <li>Nov</li>
        <li>Dec</li>
        <li>Jan</li>
        <li>Feb</li>
        <li>Mar</li>
      </ul>
      @foreach ($acf_options->vegetable as $item)
        <div class="veggie">
          <h5>{{ $item->vegetable_title }}
          </h5>
          <span class="{{ $item->season_start }} {{ $item->season_length }} @if($item->market_only===true) marketOnly @endif"></span>
        </div> 
      @endforeach                                                
    </div>
  </div>  
  @if( get_row_layout() == 'flexible-veggiechart' )
    <p>{!! $description !!}</p>
  @endif      
</section>