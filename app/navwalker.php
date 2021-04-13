<?php

namespace App;

/**
 * Custom Menu Walker so can add icons
 */
class Icon_Walker extends \Walker_Nav_Menu {

  var $number = 1;
  var $currentEl;

  var $args = [];

  function __construct($args = []) {
    $this->args = array_merge([
      'mobile' => false,
    ], $args);
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $this->currentEl = $item;

    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;

    $visibility = get_field('visibility', $item->ID);
    if ($visibility && array_search('mobile', $visibility) === false) {
      $classes[] = 'hidden';
      $classes[] = 'lg:block';
    }
    if ($visibility && array_search('desktop', $visibility) === false) {
      $classes[] = 'lg:hidden';
    }

    $hasChildren = array_search('menu-item-has-children', $classes) !== false;

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = $id ? ' id="' . esc_attr($id) . '"' : '';

    $parentItemString = '@mouseenter="$store.dropdown.open=' . $item->ID . '" @mouseleave="$store.dropdown.open=null" @keydown="$store.dropdown.keydownParent(' . $item->ID . ', $event, $el)"';

    $output .= $indent . '<li x-data ' . $id . $value . $class_names . ' ' . (!$this->args['mobile'] && $hasChildren ? $parentItemString : '') . '>';

// add svg icons here
    // $themeDir = get_template_directory_uri();
    // $theIcon = sprintf('<svg class="icon icon-home" aria-labelledby="desc"><desc>Decorative Icon</desc></title><use xlink:href="' . plugins_url('fonts/symbol-defs.svg', __FILE__) . '#' . esc_attr($item->menuIcon) . '"></use></svg>');
    $icon = get_field('icon', $item->ID);
    $iconHtml = '';
    if ($icon && $depth > 0) {
      $iconHtml = wp_get_attachment_image($icon, 'full', true);
    }

    $atts = array();
    $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
    $atts['target'] = !empty($item->target) ? $item->target : '';
    $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
    $atts['href'] = !empty($item->url) ? $item->url : '';
    $atts['class'] = $depth === 0 ? 'nav-link' : 'dropdown-link';

    if (($style = get_field('style', $item->ID)) && isset($style['style']) && $style['style'] === 'button') {
      $btnClasses = ['btn'];
      if (isset($style['color_scheme'])) {
        $btnClasses[] = 'btn-' . $style['color_scheme'];
      }
      if (isset($style['variant']) && $style['variant'] === 'outline') {
        $btnClasses[] = 'btn-outline';
      }
      if (isset($style['rounded']) && $style['rounded']) {
        $btnClasses[] = 'rounded-full';
      }
      $atts['class'] .= ' ' . implode(' ', $btnClasses);
    }

    $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

    $attributes = '';
    foreach ($atts as $attr => $value) {
      if (!empty($value)) {
        $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    if ($icon) {
      $item_output .= '<span class="icon-wrap">' . $iconHtml . '</span>';
    }
    $item_output .= '<span class="title-wrap">' . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after . '</span>';
    if ($this->args['mobile'] && $hasChildren) {
      $item_output .= '<span class="button-wrap"><button class="dropdown-toggle" @click="$store.dropdown.toggle(' . $item->ID . ', $event, $el)">
      <svg x-show="$store.dropdown.open!==' . $item->ID . '" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.072 8.024L5.715 3.667l.618-.62L11 7.716v.618L6.333 13l-.618-.619 4.357-4.357z"></path></svg>
      <svg x-show="$store.dropdown.open===' . $item->ID . '" x-cloak stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.976 10.072l4.357-4.357.62.618L8.284 11h-.618L3 6.333l.619-.618 4.357 4.357z"></path></svg>
      </button></span>';
    }
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }

  public function start_lvl(&$output, $depth = 0, $args = null) {
    if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat($t, $depth);
    // Default class to add to the file.
    $classes = array('dropdown-menu');
    /**
     * Filters the CSS class(es) applied to a menu list element.
     *
     * @since WP 4.8.0
     *
     * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
     * @param stdClass $args    An object of `wp_nav_menu()` arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    $output .= "{$n}{$indent}<ul$class_names tabindex=\"-1\" x-data x-cloak x-show.transition=\"\$store.dropdown.open===" . $this->currentEl->ID . "\" data-parent=\"" . $this->currentEl->ID . "\">{$n}";
  }

}