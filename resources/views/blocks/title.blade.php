<div data-{{ $block['id'] }} class="{{ $block['classes'] }}">
  <h1 class="block-title" style="{{get_field('block_color') ? 'color: '.get_field('block_color') : ''}}">{!!
    get_field('block_title') !!}</h1>
</div>