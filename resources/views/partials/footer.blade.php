<footer class="content-info">
      @php 
        $logo = get_field('footer_logo', 'options');
      @endphp
      <img src="{{ $logo }}" alt="Riverbend Gardens, Edmonton, Alberta" />
    <nav class="nav-footer">
      @if (has_nav_menu('footer_navigation'))
        {!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>  
    <nav class="nav-secondary-footer">
      @if (has_nav_menu('footer__secondary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'footer__secondary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
    <nav class="social">
      <a href="https://www.instagram.com/riverbendgarden/" target="_blank"><img src="@asset('images/instagram.svg')" alt="Follow Riverbend Gardens on Instagram, see our team, the fields, and our process." /></a>
      <a href="https://www.facebook.com/RiverbendGardensYEG/" target="_blank"><img src="@asset('images/facebook.svg')" alt="Follow Riverbend Gardens on facebook. Be a part of the RBG family, and keep up with what's happening on the farm." /></a>
      <a href="https://twitter.com/RiverbendGarden" target="_blank"><img src="@asset('images/twitter.svg')" alt="Follow Riverbend Gardens on Twitter, keep up on when we're at market, what vegetables are in season and when to buy the CSA!." /></a>
    </nav>
    @php dynamic_sidebar('sidebar-footer') @endphp
</footer>
