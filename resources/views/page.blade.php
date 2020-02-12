@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    {{-- @include('partials.page-header') --}}
    <section class="col-11">
      @include('partials.content-page')
    </section>
  @endwhile
@endsection
