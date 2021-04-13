<header class="site-header bg-teal-1000 text-white">
  <div class="container">
    <div class="flex items-center">
      <div class="mr-3 py-4">

        {!! get_custom_logo( )!!}
      </div>
      <nav class="nav-primary hidden lg:block">
        @if (has_nav_menu('primary_navigation'))
        {!! App\display_menu('primary_navigation') !!}
        @endif
      </nav>
      <nav class="nav-secondary hidden lg:block ml-auto">
        @if (has_nav_menu('secondary_navigation'))
        {!! App\display_menu('secondary_navigation') !!}
        @endif
      </nav>
      <div x-data class="ml-auto lg:hidden">
        <button
          @click="$store.navigation.triggerEl = $event.currentTarget; $store.navigation.open = !$store.navigation.open;"
          class="inline-flex items-center justify-center p-2 text-white hover:text-gray-100 hover:bg-teal-900 focus:bg-teal-900
          focus:outline-none focus:shadow-outline transition duration-200">
          <span class="sr-only">Open main menu</span>
          <svg :class="{ 'hidden': $store.navigation.open, 'block': !$store.navigation.open }" class="h-6 w-6 block"
            x-description="Heroicon name: menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
          <svg :class="{ 'hidden': !$store.navigation.open, 'block': $store.navigation.open }" class="h-6 w-6 hidden"
            x-description="Heroicon name: x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</header>