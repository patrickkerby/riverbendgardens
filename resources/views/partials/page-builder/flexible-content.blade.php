@php
  $content = get_sub_field('content');
  $border = get_sub_field('following-border');
  $vertical_padding = get_sub_field('vertical_padding');
  $columns = get_sub_field('columns');
  $content_1col = get_sub_field('content_1col');
  $content_2col_a = get_sub_field('content_2col_a');
  $content_2col_b = get_sub_field('content_2col_b');
  $content_3col_a = get_sub_field('content_3col_a');
  $content_3col_b = get_sub_field('content_3col_b');
  $content_3col_c = get_sub_field('content_3col_c');
@endphp


<section class="flexible-content {{ $border ? 'border-follow' : '' }} {{ $vertical_padding ? 'extrapadding-'.$vertical_padding : '' }}">
  <div class="wysiwyg">
    @if($columns == 'one')
      <div class="columns-1">
        {!! $content_1col !!}
      </div>
    @endif
    @if($columns == 'two')
      <div class="columns-2">
        {!! $content_2col_a !!}
      </div>
      <div class="columns-2">
        {!! $content_2col_b !!}
      </div>
    @endif
    @if($columns == 'three')
      <div class="columns-3">
          {!! $content_3col_a !!}
      </div>
      <div class="columns-3">
          {!! $content_3col_b !!}
      </div>
      <div class="columns-3">
          {!! $content_3col_c !!}
      </div>
    @endif
  </div>
</section>