<section class="gallery row no-gutters">
  {{-- <div class="grid-layout "> --}}
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
  {{-- </div>   --}}
</section>