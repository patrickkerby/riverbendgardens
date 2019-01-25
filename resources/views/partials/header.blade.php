<header class="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
    <nav class="nav-primary">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
  </div>
</header>
<div class="cbp-af-header">
  <div class="cbp-af-inner">
    <div class="wrapper">
        <h4><span>I know about it already, </span>sign me up!</h4>
        <nav>
            <a href="/product/csa15week/">Full Season <span>(15 weeks)</span></a>
          <a href="/product/weekly/" class="wk">Week-to-Week</a>
        </nav>
      </div>
  </div>
</div>
