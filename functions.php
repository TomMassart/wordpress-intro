<?php

add_action('init', 'dw_init_types');
add_filter('wp_title', 'dw_page_title' );
add_theme_support('post-thumbnails'); 
 

/**
 * Customize the title for the home page, if one is not set.
 *
 * @param string $title The original title.
 * @return string The title to use.
 */
function dw_page_title($title)
{
    if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
        $title = 'Bienvenue';
    }
    $title .=  ' - ' . get_bloginfo( 'name' );
    return $title;
}


/**
 * Register navigation menu
 */
register_nav_menu('header', 'Menu principal, affiché dans le header.');


/**
 * Get menu items
 */
function dw_get_nav_items($location)
{
    $id = dw_get_nav_id($location);
    if(!$id) return [];
    $nav = [];
    $children = [];
    foreach (wp_get_nav_menu_items($id) as $object) {
        $item = new stdClass();
        $item->link = $object->url;
        $item->label = $object->title;
        $item->children = [];

        if($object->menu_item_parent) {
            $item->parent = $object->menu_item_parent;
            $children[] = $item;
        }
        else {
            $nav[$object->ID] = $item;
        }
    }
    foreach ($children as $item) {
        $nav[$item->parent]->children[] = $item;
    }
    return $nav;
}


/**
 * Get menu ID from location
 */
function dw_get_nav_id($location)
{
    foreach (get_nav_menu_locations() as $navLocation => $id) {
        if($navLocation == $location) return $id;
    }
    return false;
}


/*
 *  Get theme asset URI
 */

function get_dw_asset($resource)
{
    return get_template_directory_uri() . '/assets/' . trim($resource, '/');
}


/*
 *  Output theme asset URI
 */
function dw_asset($resource)
{
    echo get_dw_asset($resource);
}


/**
 *  Get a customizable excerpt
 */
function dw_get_the_excerpt($length = null)
{
    $excerpt = get_the_excerpt();
    if(is_null($length) || strlen($excerpt) <= $length) return $excerpt;
    return trim(substr($excerpt, 0, $length)) . '&hellip;';
}

/**
 *  Output a customizable excerpt
 */
function dw_the_excerpt($length = null)
{
    echo dw_get_the_excerpt($length);
}

/**
 * Return the places taxonomy for current post (in the loop)
 */
function dw_get_the_places($glue = '', $prefix = '', $suffix = '')
{
    $terms = wp_get_post_terms(get_the_ID(), 'places', ['orderby' => 'name', 'order' => 'ASC', 'fields' => 'all']);

    if(!$terms) return 'il n\'y a pas d\'endroits associés à ce voyage';

    return implode($glue, array_map(function($term) use ($prefix, $suffix){
        return str_replace(':type', get_field('type', $term), $prefix) . $term->name . $suffix;
    }, $terms));
}

/**
 * Output the places taxonomy for current post (in the loop)
 */
function dw_the_places($glue = '', $prefix = '', $suffix = '')
{
    echo dw_get_the_places($glue, $prefix, $suffix);
}

/**
 * Returns string (empty, singular or plural) based on given number
 */
function dw_chose_singularity($number, $singular, $plural, $empty = null)
{
    switch (intval($number)) {
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


/**
 * Register custom post types on INIT event
 */
function dw_init_types()
{
    register_post_type('trip', [
        'label' => 'Voyages',
        'labels' => [
            'singular_name' => 'voyage',
            'add_new' => 'Ajouter un voyage'
        ],
        'description' => 'Type d\'article permettant d\'ajouter des voyages à la section voyages du site.',
        'menu_position' => 20,
        'menu_icon' => 'dashicons-palmtree',
        'public' => true
    ]);
    register_taxonomy('places', 'trip', [
        'label' => 'Endroits',
        'labels' => [
            'singular_name' => 'Endroit',
            'edit_item' => 'Éditer l\'endroit',
            'add_new_item' => 'Ajouter un nouvel endroit'
        ],
        'description' => 'Endroits dans lesquels le voyage a été effectué.',
        'public' => true,
        'hierarchical' => true
    ]);
}
