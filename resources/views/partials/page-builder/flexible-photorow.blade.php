{{-- <section class="gallery row no-gutters">
    @php 

      $images = get_sub_field('gallery');
      
      if( $images ): @endphp
              @php foreach( $images as $image ): @endphp
                  <div class="grid-item image col-sm">
                      <a href="@php echo $image['url']; @endphp" target="_blank" style="background-image: url('@php echo $image['sizes']['large']; @endphp');">
                        <img src="{{ $image['sizes']['medium'] }}" alt="{{ $image['alt'] }}" />
                      </a>
                  </div>
              @php endforeach; @endphp
      @php endif;		
    @endphp
</section> --}}

<section class="flexible-content photo-row-section {{ $border ? 'border-follow' : '' }} {{ $vertical_padding ? 'extrapadding-'.$vertical_padding : '' }}">
  @foreach(get_sub_field('photos') as $photo)
    @php 
      $count = $loop->count;
    @endphp
  @endforeach

  <div class="photo-row count-{{ $count }}">
    @if( get_row_layout() == 'flexible-photorow' )
        @foreach(get_sub_field('photos') as $photo)
          <div class="photo-row-item">
            <img src="{{ $photo['url'] }}" alt="{{ $photo['alt'] }}">
          </div>
        @endforeach
    @endif
  </div>
</section>
