@php
  $border = get_sub_field('following-border');
  $photo = get_sub_field('full_width_photo');
@endphp

<section class="flexible-content full-width-photo {{ $border ? 'border-follow' : '' }} {{ $vertical_padding ? 'extrapadding-'.$vertical_padding : '' }}">
  <div class="full-width">
    @if( get_row_layout() == 'flexible-photo' )
        <img src="{{ $photo}}" />
    @endif
  </div>
</section>
