<?php

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{

    /**
     * Starts the element output.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param WP_Post $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     * @param int $id Current item ID.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        // Depth-dependent classes.
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
        $classes = array(
            'sub-menu'
        );
        $class_names = implode(' ', $classes);

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {

        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $menu_type = get_field('menu_type', $item);
        $culumn_1 = get_field('column_1', $item);
        $culumn_2 = get_field('column_2', $item);
        $culumn_3 = get_field('column_3', $item);

        switch ($menu_type):
            case 'home':
                $news_id = $item->id;
                $classes[] = 'home';
                break;
            case 'paid':
                $news_id = $item->id;
                $classes[] = 'paid-article';
                break;
            case 'mega_menu':
                $news_id = $item->id;
                $classes[] = 'mega-menu';
                break;
        endswitch;
        $args = apply_filters('nav_menu_item_args', $args, $item, $depth);

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts['class'] = '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before;

        switch ($menu_type):
            case 'mega_menu':
                $item_output .= '<div class="mb-2" >';
                $item_output .= '<a' . $attributes . ' class="h5 mb-0" >';
                $item_output .= $args->link_before . $title . $args->link_after;
                $item_output .= '</a>';
                $item_output .= '</div>';
                if ($culumn_1) :
                    $item_output .= '<div>';
                    $item_output .= $culumn_1;
                    $item_output .= '</div>';
                endif;
                if ($culumn_2) :
                    $item_output .= '<div>';
                    $item_output .= $culumn_2;
                    $item_output .= '</div>';
                endif;
                if ($culumn_3) :
                    $item_output .= '<div>';
                    $item_output .= $culumn_3;
                endif;
                $item_output .= '</div>';
                break;
            default:
                $item_output .= '<a' . $attributes . '  >';
                $item_output .= $args->link_before . $title . $args->link_after;
                $item_output .= '</a>';
        endswitch;

        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

}


/**
 * Append dropdown toggle button to menu link
 *
 * @param string $item_output The menu item's starting HTML output.
 * @param WP_Post $item Menu item data object.
 * @param int $depth Depth of menu item. Used for padding.
 * @param stdClass $args An object of wp_nav_menu() arguments.
 *
 * @return string
 */
function append_dropdown_toggle_button($item_output, $item, $depth, $args)
{
    if (!$args->walker instanceof Custom_Walker_Nav_Menu) {
        return $item_output;
    }

    $classes = empty($item->classes) ? array() : (array)$item->classes;

    if (in_array('menu-item-has-children', $classes)) {
        $item_output .= '<button class="dropdown-toggle visible-lg-up" data-toggle="dropdown" aria-label="Dropdown menu toggle"><svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.863281 1.18164L5.80646 6.45437L10.7496 1.18164" stroke="#2A2F38" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>';
    }


    return $item_output;
}

add_filter('walker_nav_menu_start_el', 'append_dropdown_toggle_button', 10, 4);
