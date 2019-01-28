@php 
$hero = get_field('background_image');
$hero_news = get_field('background_image', get_option('page_for_posts'));
$hero_shop = get_field('background_image', get_option('woocommerce_shop_page_id'));

$overlay = get_field('overlay');	
$overlay_news = get_field('overlay', get_option('page_for_posts'));	
$overlay_shop = get_field('overlay', get_option('woocommerce_shop_page_id'));	

$logo = get_field('logo');

$shop_title = get_the_title( get_option('woocommerce_shop_page_id') );
$news_title = get_the_title( get_option('page_for_posts', true) );

$hero_product = get_field('shop_header_image', 'option');

@endphp

@if ( is_front_page() )
  <header class="banner" style="background-image: linear-gradient(rgba(45,51,55,0.{{ $overlay }}), rgba(45,51,55,0.{{ $overlay }})), url('{{ $hero }}');">
@elseif ( is_home() )
  <header class="banner" style="background-image: linear-gradient(rgba(45,51,55,0.{{ $overlay_news }}), rgba(45,51,55,0.{{ $overlay_news }})), url('{{ $hero_news }}');">
@elseif ( is_shop() )
  <header class="banner" style="background-image: linear-gradient(rgba(45,51,55,0.{{ $overlay_shop }}), rgba(45,51,55,0.{{ $overlay_shop }})), url('{{ $hero_shop }}');">
@elseif ( is_product() )
  <header class="banner" style="background-image: linear-gradient(rgba(45,51,55,0.{{ $overlay_shop }}), rgba(45,51,55,0.{{ $overlay_shop }})), url('{{ $hero_shop }}');">
@else
  <header class="banner" style="background-image: linear-gradient(rgba(45,51,55,0.{{ $overlay }}), rgba(45,51,55,0.{{ $overlay }})), url('{{ $hero }}');">
@endif

  <nav class="nav-primary">
    @if (has_nav_menu('primary_navigation'))
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
    @endif
  </nav>
  @if (!empty($logo))			
    <img src="{{$logo}}" />
    <h1>Riverbend Gardens <br><span>- CSA {{ date("Y") }} -</span></h1>

  @elseif ( is_front_page() )
    {{-- Do not display title --}}
    
  @elseif ( is_home() )
    <h1 class="page-title"><?php echo $news_title; ?></h1>    	        				        			    

  @elseif ( is_shop() )
    <h1 class="page-title"><?php echo $shop_title; ?></h1>    	        				        			    

  @elseif ( is_product() )
    <h1 class="page-title"><?php echo $shop_title; ?></h1>    	        				        			    

  @elseif ( is_tax() )
    <h1 class="page-title"><?php echo $termname; ?></h1> 
    <div class="description"><?php echo term_description(); ?></div>   	        				        			    

  @else
    <h1 class="page-title"><?php the_title() ?></h1>    	        				        			    
  @endif

</header>
