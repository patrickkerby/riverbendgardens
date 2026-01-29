<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PGPJGB4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    @php do_action('get_header') @endphp
    
    @include('partials.header')

    @if (is_page('recipes'))
    <div class="wrap container-fluid">
      <div class="content">
        @yield('content')
      </div>
    </div>
    @else
    <div class="wrap container" role="document">
      <div class="content">
        @if ( is_front_page() )
          <main class="main">
            @yield('content')
          </main>
        @else
          <main class="main justify-content-center">
            @yield('content')
          </main>        
        @endif

        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
      </div>
    </div>
    @endif
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
    <a href="#" class="close-product" onclick="return false;">close</a>
  </body>
</html>
