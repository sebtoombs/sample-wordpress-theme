<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')

<body @php body_class('no-js') @endphp>
  <div class="site" x-data :class="{'overflow-hidden max-w-full': $store.navigation.open}">
    <div class="site-wrap  origin-top"
      :class="{'h-screen overflow-hidden rounded-xl shadow-md origin-top site-wrap--open pointer-events-none z-10 relative bg-white': $store.navigation.open}">

      @php do_action('get_header') @endphp
      @include('partials.header')
      <div class="wrap container" role="document">
        <div class="content">
          <main class="main">
            @yield('content')
          </main>
          @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
          @endif
        </div>
      </div>
      @php do_action('get_footer') @endphp
      @include('partials.footer')
    </div>
    @include('partials.mobile-navigation')
  </div>
  @php wp_footer() @endphp
</body>

</html>