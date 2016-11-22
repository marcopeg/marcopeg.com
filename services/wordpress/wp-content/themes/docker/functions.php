<?php

include_once('advanced-custom-fields/general-post.php');
include_once('inc/post-gallery/functions.php');

add_theme_support( 'title-tag' );

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
