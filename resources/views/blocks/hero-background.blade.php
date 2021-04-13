<div data-{{ $block['id'] }} class="{{ $block['classes'] }}">
  <div class="relative lg:pb-20">
    <div class="absolute w-full h-full flex flex-col">
      <div class="bg-teal-900 flex-grow w-full"></div>
      <svg class="w-full hidden lg:block" viewBox="0 0 1440 175" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M1440 144.259V-7.62939e-06L0 1.52588e-05C312 144.259 512.678 174.209 719.75 174.209C926.822 174.209 1099 91 1440 144.259Z"
          fill="#1D4044" />
      </svg>
    </div>
    <div class="relative">
      <InnerBlocks />
    </div>
  </div>
</div>