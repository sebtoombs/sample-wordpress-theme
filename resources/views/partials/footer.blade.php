<footer class="site-footer bg-teal-900 py-8 xl:py-16 text-white text-base">
  <div class="container">
    <div class="grid lg:grid-cols-2 gap-4">
      <div class="lg:w-1/2">
        <div class="mb-6">
          {!! get_custom_logo() !!}
        </div>
        <div class="widget-area">
          @php dynamic_sidebar('sidebar-footer-1') @endphp
        </div>
      </div>
      <div class="flex">
        <div class="mr-6 lg:mr-12 widget-area">
          @php dynamic_sidebar('sidebar-footer-2') @endphp
        </div>
        <div class="mr-6 widget-area">
          @php dynamic_sidebar('sidebar-footer-3') @endphp
        </div>
      </div>

    </div>
  </div>
</footer>
<footer class="footer-bar bg-teal-1000 py-2 text-gray-200 text-sm">
  <div class="container">
    <nav class="nav-footer">
      @if (has_nav_menu('footer_navigation'))
        {!! App\display_menu('footer_navigation') !!}
      @endif
    </nav>
  </div>
</footer>
