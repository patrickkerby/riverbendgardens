<article>  
  <section class="intro row justify-content-center">
    <div class="col-sm-11">
      @php the_content() @endphp
    </div>
  </section>
  <section class="row justify-content-center">
    <div class="sidebar col-md-3 order-last order-md-first">
      <h4 class="sidebar-title">Learn by Veggie</h4>
      <nav class="nav flex-column">
        @foreach ($preservation_loop as $item)
          <a class="nav-link" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
        @endforeach
      </nav>
    </div>
    <div class="entry-content col-md-9 order-first order-md-last">
      @foreach ($preservation_technique as $item)
        <div class="preservation-block @if(!$item['content']) empty @endif">
          <h2 class="title">{{ $item['title'] }}</h2>
          <p>{{ $item['intro'] }}</p>        
          @if ($item['content'])  
            <a class="collapse-indicator" data-toggle="collapse" href="#collapseExample-{{ $loop->iteration }}" role="button" aria-expanded="false" aria-controls="collapseExample-{{ $loop->iteration }}">+</a>
            <div class="collapse" id="collapseExample-{{ $loop->iteration }}">
              {!! $item['content'] !!}
            </div>
          @endif  
        </div>      
      @endforeach
    </div>
  </section>
</article>
