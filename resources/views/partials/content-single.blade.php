{{-- <article @php post_class() @endphp>
  <header>
    <h1 class="entry-title">{!! get_the_title() !!}</h1>
    @include('partials/entry-meta')
  </header>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article> --}}

<article @php post_class() @endphp>
  <div class="max-w-4xl mx-auto">
    <header class="pt-24 pb-20">
      <h1 class="entry-title text-3xl xl:text-5xl">{!! get_the_title() !!}</h1>
      <div class="text-gray-500 font-bold">
        <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
      </div>
    </header>

    <div class="copy pb-10">
      @php the_content() @endphp
    </div>
  </div>
</article>
