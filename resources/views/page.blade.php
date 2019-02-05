@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    {{-- @include('partials.page-header') --}}
    <section>
      @include('partials.content-page')
    </section>
  @endwhile
@endsection
