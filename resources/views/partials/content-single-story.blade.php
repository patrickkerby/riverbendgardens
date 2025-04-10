<article @php post_class("row justify-content-center") @endphp>  
    <div class="entry-content col-md-10">

        
        @php
        // This loop requires a /partials template that is named exactly the same as the layout title in ACF flexible content page builder
        $id = get_the_ID();
        if ( have_rows( 'page_builder', $id ) ) :
          // loop through the selected ACF layouts and display the matching partial
          while ( have_rows( 'page_builder', $id ) ) : the_row();
            $layout = get_row_layout();
            @endphp
              @include( "partials.page-builder.{$layout}")
            @php
          endwhile;
        elseif ( get_the_content() ) :
        endif;
      @endphp

    </div>    
  </article>
  