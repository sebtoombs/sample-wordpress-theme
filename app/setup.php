<?php

namespace App;

use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Container;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('sage/fonts.css', asset_path('styles/fonts.css'), false, null);
  wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
  wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

  // wp_enqueue_style('sage/google-fonts', 'https://fonts.googleapis.com/css2?family=Varta:wght@400;700&display=swap', false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}, 100);

add_action('wp_head', function () {
/*  ?>
<link rel="preconnect" href="https://fonts.gstatic.com"><?php*/

  $font_weights = ['Regular']; //, 'Bold', 'Medium', 'Light', 'SemiBold'];
  $font_formats = ['woff2']; //, 'woff', 'ttf'];

  foreach ($font_weights as $font_weight) {
    foreach ($font_formats as $font_format) {
      ?>
<link rel="preload" href="<?php echo asset_path('fonts/varta/Varta-' . $font_weight . '.' . $font_format); ?>" as="font"
  type="font/<?php echo $font_format; ?>" crossorigin>
<?php
}
  }

});

add_action('wp_footer', function () {
  ?>
<script type="text/javascript">
(function() {
  document.querySelector('body').classList.remove('no-js');
})();
</script>
<?php
}, 0);

add_action('enqueue_block_editor_assets', function () {
  // wp_get_theme()->get( 'Version' )
  wp_enqueue_style('sage/editor.css', asset_path('styles/editor.css'), array(), null, 'all');
  wp_enqueue_script('sage/editor.js', asset_path('scripts/editor.js'), ['wp-blocks', 'wp-element', 'wp-i18n'], null);
});

// Disable woocommerce stylesheets
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
  /**
   * Enable features from Soil when plugin is activated
   * @link https://roots.io/plugins/soil/
   */
  add_theme_support('soil', [
    'clean-up',
    'disable-rest-api',
    'disable-asset-versioning',
    'disable-trackbacks',
    'js-to-footer',
    'nav-walker',
    'nice-search',
    'relative-urls',
  ]);

  /**
   * Enable plugins to manage the document title
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
   */
  add_theme_support('title-tag');

  /**
   * Register navigation menus
   * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
   */
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'secondary_navigation' => __('Secondary Navigation', 'sage'),
    'footer_navigation' => __('Footer Navigation', 'sage'),
  ]);

  /**
   * Enable post thumbnails
   * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
   */
  add_theme_support('post-thumbnails');

  /**
   * Enable HTML5 markup support
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
   */
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  /**
   * Enable selective refresh for widgets in customizer
   * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
   */
  add_theme_support('customize-selective-refresh-widgets');

  /**
   * Use main stylesheet for visual editor
   * @see resources/assets/styles/layouts/_tinymce.scss
   */
//   add_editor_style(asset_path('styles/main.css'));

/**
 * Add custom logo support
 */
  add_theme_support('custom-logo');

  /**
   * Add alignwide/alignfull support
   */
  add_theme_support('align-wide');

  /**
   * Add woocoommerce support
   */
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');

/**
 * Add image size
 */
//   add_image_size('gallery_thumb', 300, 300, true);

  add_theme_support('editor-color-palette', array(
    array(
      'name' => __('Teal', 'sample-wordpress'),
      'slug' => 'teal-500',
      'color' => '#319795',
    ),
    array(
      'name' => __('Teal 600', 'sample-wordpress'),
      'slug' => 'teal-600',
      'color' => '#2C7A7B',
    ),
    array(
      'name' => __('Orange', 'sample-wordpress'),
      'slug' => 'orange-500',
      'color' => '#F15A29',
    ),
    array(
      'name' => __('White', 'sample-wordpress'),
      'slug' => 'white',
      'color' => '#FFFFFF',
    ),
    array(
      'name' => __('Black', 'sample-wordpress'),
      'slug' => 'black',
      'color' => '#000000',
    ),
  ));

  add_theme_support(
    'editor-gradient-presets',
    array(
      array(
        'name' => __('Orange', 'sample-wordpress'),
        'gradient' => 'linear-gradient(90deg, #F15A29 0%, #EE7645 100%)',
        'slug' => 'orange',
      ),
    )
  );

  add_theme_support('editor-font-sizes', array(
    array(
      'name' => __('Small', 'sample-wordpress'),
      'size' => 14,
      'slug' => 'small',
    ),
    array(
      'name' => __('Normal', 'sample-wordpress'),
      'size' => 16,
      'slug' => 'normal',
    ),
    array(
      'name' => __('Medium', 'sample-wordpress'),
      'size' => 18,
      'slug' => 'medium',
    ),
    array(
      'name' => __('Large', 'sample-wordpress'),
      'size' => 24,
      'slug' => 'large',
    ),
    array(
      'name' => __('Extra large', 'sample-wordpress'),
      'size' => 36,
      'slug' => 'extra-large',
    ),
  ));

  add_theme_support('widgets-block-editor');
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
  $config = [
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<span class="widget-title">',
    'after_title' => '</span>',
  ];

  register_sidebar([
    'name' => __('Footer 1', 'sage'),
    'id' => 'sidebar-footer-1',
  ] + $config);
  register_sidebar([
    'name' => __('Footer 2', 'sage'),
    'id' => 'sidebar-footer-2',
  ] + $config);
  register_sidebar([
    'name' => __('Footer 3', 'sage'),
    'id' => 'sidebar-footer-3',
  ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
  sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
  /**
   * Add JsonManifest to Sage container
   */
  sage()->singleton('sage.assets', function () {
    return new JsonManifest(config('assets.manifest'), config('assets.uri'));
  });

  /**
   * Add Blade to Sage container
   */
  sage()->singleton('sage.blade', function (Container $app) {
    $cachePath = config('view.compiled');
    if (!file_exists($cachePath)) {
      wp_mkdir_p($cachePath);
    }
    (new BladeProvider($app))->register();
    return new Blade($app['view']);
  });

  /**
   * Create @asset() Blade directive
   */
  sage('blade')->compiler()->directive('asset', function ($asset) {
    return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
});
});

/**
* Add ACF extras
*/
add_action('acf/init', function () {

/**
* Add theme options page
*/
// Check function exists.
if (function_exists('acf_add_options_page')) {

// Register options page.
$option_page = acf_add_options_page(array(
'page_title' => __('Theme General Settings'),
'menu_title' => __('Theme Settings'),
'menu_slug' => 'theme-general-settings',
'capability' => 'edit_posts',
'redirect' => false,
'position' => 50,
));
}

/**
* Add custom blocks
*/
if (function_exists('acf_register_block_type')) {

// Register a menu block.
// acf_register_block_type(array(
// 'name' => 'my-custom-block',
// 'title' => __('My Custom BLock'),
// 'description' => __('Display a custom block.'),
// 'render_callback' => __NAMESPACE__ . '\\sage_blocks_callback',
// 'category' => 'layout',
// ));

// Page title
acf_register_block_type(array(
'name' => 'title',
'title' => __('Page title'),
'description' => __('Display a page title. Warning: only use once per page.'),
'render_callback' => __NAMESPACE__ . '\\sage_blocks_callback',
'category' => 'layout',
));

// Container
acf_register_block_type(array(
'name' => 'container',
'title' => __('Container'),
'description' => __('Limit the max width of content. Useful for inside an element with align: "full".'),
'render_callback' => __NAMESPACE__ . '\\sage_blocks_callback',
'category' => 'layout',
'supports' => array(
'align' => true,
'mode' => false,
'jsx' => true,
),
));

// Container
acf_register_block_type(array(
'name' => 'hero-background',
'title' => __('Hero Background'),
'description' => __('The green wavy background. Wrap your hero content in this.'),
'render_callback' => __NAMESPACE__ . '\\sage_blocks_callback',
'category' => 'layout',
'supports' => array(
'align' => true,
'mode' => false,
'jsx' => true,
),
));

// Background
acf_register_block_type(array(
'name' => 'background',
'title' => __('Background'),
'description' => __('Various design element backgrounds.'),
'render_callback' => __NAMESPACE__ . '\\sage_blocks_callback',
'category' => 'layout',
'supports' => array(
'align' => true,
'mode' => false,
'jsx' => true,
),
));

// Card
acf_register_block_type(array(
'name' => 'card',
'title' => __('Card'),
'description' => __('A "card" block with rounded corners and shadow.'),
'render_callback' => __NAMESPACE__ . '\\sage_blocks_callback',
'category' => 'layout',
'supports' => array(
'align' => true,
'mode' => false,
'jsx' => true,
),
));

// FAQ
// acf_register_block_type(array(
// 'name' => 'faq',
// 'title' => __('FAQs'),
// 'description' => __('A block of FAQs.'),
// 'render_callback' => __NAMESPACE__ . '\\sage_blocks_callback',
// 'category' => 'layout',
// 'supports' => array(
// 'align' => true,
// 'mode' => false,
// 'jsx' => true,
// ),
// ));

}

});

function sage_blocks_callback($block, $content = '', $is_preview = false, $post_id = 0) {
$slug = str_replace('acf/', '', $block['name']);
$block = array_merge(['className' => ''], $block);
$block['post_id'] = $post_id;
$block['is_preview'] = $is_preview;
$block['content'] = $content;
$block['slug'] = $slug;
$block['anchor'] = isset($block['anchor']) ? $block['anchor'] : '';
// Send classes as array to filter for easy manipulation.
$block['classes'] = [
$slug,
$block['className'],
$block['is_preview'] ? 'is-preview' : null,
'align' . $block['align'],
];

// Filter the block data.
$block = apply_filters("sage/blocks/$slug/data", $block);

// Join up the classes.
$block['classes'] = implode(' ', array_filter($block['classes']));

$template = '';
if ($block['name'] === 'acf/title') {
$template = 'blocks.title';
} elseif ($block['name'] === 'acf/container') {
$template = 'blocks.container';
} elseif ($block['name'] === 'acf/hero-background') {
$template = 'blocks.hero-background';
} elseif ($block['name'] === 'acf/background') {
$template = 'blocks.background';
} elseif ($block['name'] === 'acf/card') {
$template = 'blocks.card';
} elseif ($block['name'] === 'acf/faq') {
$template = 'blocks.faq';
}

if (!empty($template)) {
echo \App\template($template, ['block' => $block]);
} else {
echo '<p><strong>Block template missing!</strong></p>';
}
}

if (function_exists('register_block_pattern')) {
register_block_pattern(
'sample-wordpress/hero',
array(
'title' => __('Hero', 'text-domain'),
'categories' => array('layout'),
'keywords' => ['hero'],
'description' => __('A two column hero block with content left and media right.', 'sample-wordpress'),
'content' => file_get_contents(get_theme_file_path() . '/views/block-patterns/hero.html'),
)
);

register_block_pattern(
'sample-wordpress/page-header',
array(
'title' => __('Page Header', 'text-domain'),
'categories' => array('layout'),
'keywords' => ['header'],
'description' => __('Page header with single column', 'sample-wordpress'),
'content' => file_get_contents(get_theme_file_path() . '/views/block-patterns/page-header.html'),
)
);

register_block_pattern(
'sample-wordpress/footer-cta',
array(
'title' => __('Footer Call to Action', 'text-domain'),
'categories' => array('layout'),
'keywords' => ['footer'],
'description' => __('A last ditch attempt to catch a customer.', 'sample-wordpress'),
'content' => file_get_contents(get_theme_file_path() . '/views/block-patterns/footer.html'),
)
);
}