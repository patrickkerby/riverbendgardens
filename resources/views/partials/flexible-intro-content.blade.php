@php
  $content = get_sub_field('intro-content');
@endphp

{{-- @TODO: add logic for sidebar, along with column, colour, and width settings --}}
<section class="general-content row justify-content-center">
  <div class="col-sm-10 col-md-11">
    {!! $content !!}        
  </div>
</section>
