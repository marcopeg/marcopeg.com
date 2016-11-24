<?php

include_once('advanced-custom-fields/general-post.php');

add_theme_support( 'title-tag' );
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'status', 'link' ) );

function the_author_full_name() {
    echo get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
}

function the_custom_field($name) {
    if (function_exists("get_field")) {
        echo get_field($name);
    }
}

function custom_field_has_value($name) {
    if (function_exists("get_field")) {
        return get_field($name) != '';
    }
    return false;
}

/*
add_action( 'pre_get_posts', 'docker_pre_get_posts');
function docker_pre_get_posts( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        // $query->set( 'cat', '-1,-1347' );
        // $query->set( 'posts_per_page', 3 );
        // echo '<pre>';
        // var_dump($query->query_vars);
        // echo '</pre>';
        // wp_die();

        // $query->set('tax_query', array(
        //     array(
        //         'taxonomy' => 'post_format',
        //         'field' => 'slug',
        //         'terms' => array(
        //             'post-format-aside',
        //             'post-format-audio',
        //             'post-format-chat',
        //             'post-format-gallery',
        //             'post-format-image',
        //             'post-format-link',
        //             'post-format-quote',
        //             'post-format-status',
        //             'post-format-video'
        //         ),
        //         'operator' => 'NOT IN'
        //     )
        // ));
    }
}
*/
