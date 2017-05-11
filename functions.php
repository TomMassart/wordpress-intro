<?php

add_action('init', 'dw_register_types');
add_filter('wp_title', 'custom_wp_title');
register_nav_menu('header', 'La navigation principale du site.');
add_theme_support('post-thumbnails');

/*
 * Register custom post-types during initialization
 */
function dw_register_types() {
    register_post_type('trip', [
        'label' => 'Voyages',
        'labels' => [
            'singular_name' => 'voyage',
            'add_new_item' => 'Ajouter un nouveau voyage'
        ],
        'description' => 'Permet d\'administrer les voyages affichés sur le site.',
        'public' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-palmtree'
    ]);
    register_taxonomy('places', 'trip', [
        'label' => 'Endroits',
        'labels' => [
            'singular_name' => 'Endroit',
            'edit_item' => 'Éditer l\'endroit',
            'add_new_item' => 'Ajouter un nouvel endroit'
        ],
        'description' => 'Permet de préciser un continent, un pays ou une ville pour un voyage donné.',
        'public' => true,
        'hierarchical' => true
    ]);
}

/*
 * Hooks into wp_title() content formatting
 * @check add_filter('wp_title')
 */

function custom_wp_title($title) {
    if(empty($title)){
        $title = 'Bienvenue !';
    }
    $title .= ' - ' . get_bloginfo('name');
    return trim($title);
}

/*
 * Retrieves the absolute URI for given asset in this theme.
 */

function get_theme_asset($src = '') {
    return get_template_directory_uri() . '/assets/' . trim($src, '/');
}


/*
 * Displays the absolute URI for given asset in this theme.
 */

function theme_asset($src = '') {
    echo get_theme_asset($src);
}

/*
 * Get navigation links (objects) for given location
 */
function dw_get_nav_items($location) {
    $id = dw_get_nav_id($location);
    $nav = [];
    $children = [];

    if(!$id) return $nav;

    foreach(wp_get_nav_menu_items($id) as $object) {
        $item = new stdClass();
        $item->url = $object->url;
        $item->label = $object->title;
        $item->parent = intval($object->menu_item_parent);
        $item->children = [];

        if($item->parent) $children[] = $item;
        else $nav[$object->ID] = $item;
    }

    foreach($children as $item){
        $nav[$item->parent]->children[] = $item;
    }

    return $nav;
}

/*
 * Get navigation ID from given location
 */
function dw_get_nav_id($location) {
    foreach (get_nav_menu_locations() as $navLocation => $id) {
        if($navLocation == $location) return $id;
    }
    return false;
}


/*
 *  Return a custom excerpt for given length
 */
function dw_get_the_excerpt($length = null) {
    $excerpt = get_the_excerpt();
    if(is_null($length) || strlen($excerpt) <= $length) return $excerpt;
    $string = '';
    $words = explode(' ', $excerpt);
    foreach ($words as $word) {
        //  + 2 is needed in order to include the next space and the &hellip; in the character count.
        if((strlen($string) + strlen($word) + 2) > $length) break;
        $string .= ' ' . $word;
    }
    return trim($string) . '&hellip;';
}

/*
 *  Output a custom excerpt for given length
 */
function dw_the_excerpt($length = null) {
    echo dw_get_the_excerpt($length);
}

/*
 *  Return a list of visited places for given trip.
 */
function dw_get_the_places($glue = '', $prefix = '', $suffix = '', $empty = '') {
    $terms = wp_get_post_terms(get_the_ID(), 'places', ['orderby' => 'name', 'order' => 'ASC', 'fields' => 'all']);
    if(!$terms) return $empty;
    return implode($glue, array_map(function($term) use ($prefix, $suffix){
        return str_replace([':type', ':link'], [get_field('type', $term), get_term_link($term)], $prefix) . $term->name . $suffix;
    }, $terms));    
}

/*
 *  Output a list of visited places for given trip.
 */
function dw_the_places($glue = '', $prefix = '', $suffix = '', $empty = '') {
    echo dw_get_the_places($glue, $prefix, $suffix, $empty);
}

/*
 * Return plural or singular sentence based on given number
 */
function dw_chose_singularity($number, $singular, $plural, $empty = null) {
    switch(intval($number)) {
        case 0:
            if(is_null($empty)) break;
            return str_replace(':number', $number, $empty);
            break;
        case 1:
            return str_replace(':number', $number, $singular);
            break;
    }
    return str_replace(':number', $number, $plural);
}
