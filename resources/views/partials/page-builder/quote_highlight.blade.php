@php
  $quote = get_sub_field('quote');
  $border = get_sub_field('following-border');
  $vertical_padding = get_sub_field('vertical_padding');
@endphp


<section class="flexible-content quote {{ $border ? 'border-follow' : '' }} {{ $vertical_padding ? 'extrapadding-'.$vertical_padding : '' }}">
  <div class="quote">
      <div>
        <h2>{!! $quote !!}</h2>
      </div>
  </div>
</section>