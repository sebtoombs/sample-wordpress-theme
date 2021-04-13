@php
$block_classes = $block['classes'];
$width = get_field('block_width');
if($width === 'narrow') {
$block_classes .= ' max-w-7xl mx-auto';
}
if($width === 'tiny') {
$block_classes .= ' max-w-3xl mx-auto';
}
@endphp

<div data-{{ $block['id'] }} class="container {{ $block_classes }}">
  <InnerBlocks />
</div>