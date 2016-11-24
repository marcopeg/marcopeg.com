<?php

add_action( 'wp_ajax_post_gallery_lite_get_images', 'post_gallery_lite_get_images' );
add_action( 'wp_ajax_post_gallery_lite_add_images', 'post_gallery_lite_add_images' );
add_action( 'wp_ajax_post_gallery_lite_del_image', 'post_gallery_lite_del_image' );
add_action( 'wp_ajax_post_gallery_lite_sort_images', 'post_gallery_lite_sort_images' );

function post_gallery_lite_get_images() {
    $ids = post_gallery_lite_unserialize($_POST['post_id']);
    $gallery = post_gallery_lite_fetch_images($ids);
    wp_send_json_success($gallery);
}

function post_gallery_lite_add_images() {
    $before = post_gallery_lite_unserialize($_POST['post_id']);
    $after = array_merge($before, $_POST['ids']);

    post_gallery_lite_serialize($_POST['post_id'], $after);
    post_gallery_lite_get_images();
}

function post_gallery_lite_sort_images() {
    post_gallery_lite_serialize($_POST['post_id'], $_POST['ids']);
    post_gallery_lite_get_images();
}

function post_gallery_lite_del_image() {
    $before = post_gallery_lite_unserialize($_POST['post_id']);
    $after = [];

    foreach ($before as $id) {
        if ($id != $_POST['image_id']) {
            array_push($after, $id);
        }
    }

    post_gallery_lite_serialize($_POST['post_id'], $after);
    post_gallery_lite_get_images();
}
