<?php

add_action( 'wp_ajax_post_gallery_get_images', 'post_gallery_get_images' );
add_action( 'wp_ajax_post_gallery_add_images', 'post_gallery_add_images' );
add_action( 'wp_ajax_post_gallery_del_image', 'post_gallery_del_image' );
add_action( 'wp_ajax_post_gallery_sort_images', 'post_gallery_sort_images' );


function post_gallery_filter_not_empty($val) {
    return !empty($val);
}

function post_gallery_unserialize($gid) {
    $gallery = get_post_meta($gid, 'post_gallery')[0];
    $gallery = explode(',', $gallery);
    $gallery = array_filter($gallery, 'post_gallery_filter_not_empty');
    $gallery = array_unique($gallery, SORT_NUMERIC);
    return $gallery;
}

function post_gallery_serialize($gid, $ids) {
    $ids = array_filter($ids, 'post_gallery_filter_not_empty');
    $ids = array_unique($ids, SORT_NUMERIC);
    $ids = implode(',', $ids);

    // empty key to prevent failure on same data.
    update_post_meta($gid, 'post_gallery', '');
    $result = update_post_meta($gid, 'post_gallery', $ids);
    
    if ($result == false) {
        wp_send_json_error($result);
    } else {
        return true;
    }
}

function post_gallery_get_images() {
    $ids = post_gallery_unserialize($_POST['post_id']);
    $gallery = [];

    foreach ($ids as $id) {
        $attachment = [
            'id' => $id,
            'thumb' => wp_get_attachment_thumb_url($id),
        ];
        array_push($gallery, $attachment);
    }

    wp_send_json_success($gallery);
}

function post_gallery_add_images() {
    $before = post_gallery_unserialize($_POST['post_id']);
    $after = array_merge($before, $_POST['ids']);

    post_gallery_serialize($_POST['post_id'], $after);
    post_gallery_get_images();
}

function post_gallery_sort_images() {
    post_gallery_serialize($_POST['post_id'], $_POST['ids']);
    post_gallery_get_images();
}

function post_gallery_del_image() {
    $before = post_gallery_unserialize($_POST['post_id']);
    $after = [];

    foreach ($before as $id) {
        if ($id != $_POST['image_id']) {
            array_push($after, $id);
        }
    }

    post_gallery_serialize($_POST['post_id'], $after);
    post_gallery_get_images();
}
