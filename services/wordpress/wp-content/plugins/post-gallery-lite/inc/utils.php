<?php
define('POST_GALLERY_LITE_FNAME', 'post_gallery_lite');

// Only gallery post formats have post-galleries
function post_gallery_lite_is_disabled() {
    global $post;
    return get_post_format($post->ID) != 'gallery';
}

function post_gallery_lite_filter_not_empty($val) {
    return !empty($val);
}

function post_gallery_lite_implode_ids($ids) {
    return implode(',', $ids);;
}

function post_gallery_lite_explode_ids($ids) {
    return explode(',', $ids);
}

function post_gallery_lite_unserialize($gid) {
    $gallery = get_post_meta($gid, POST_GALLERY_LITE_FNAME)[0];
    $gallery = post_gallery_lite_explode_ids($gallery);
    $gallery = array_filter($gallery, 'post_gallery_lite_filter_not_empty');
    $gallery = array_unique($gallery, SORT_NUMERIC);
    return $gallery;
}

function post_gallery_lite_unserialize_to_string($gid) {
    $ids = post_gallery_lite_unserialize($gid);
    return post_gallery_lite_implode_ids($ids);
}

function post_gallery_lite_serialize($gid, $ids) {
    $ids = array_filter($ids, 'post_gallery_lite_filter_not_empty');
    $ids = array_unique($ids, SORT_NUMERIC);
    $ids = post_gallery_lite_implode_ids($ids);

    // empty key to prevent failure on same data.
    $result = update_post_meta($gid, POST_GALLERY_LITE_FNAME, '');

    // update content only if is not empty.
    if (!empty($ids)) {
        $result = update_post_meta($gid, POST_GALLERY_LITE_FNAME, $ids);
    }

    if ($result == false) {
        // wp_send_json_error($result);
        return false;
    } else {
        return true;
    }
}

function post_gallery_lite_fetch_images($ids) {
    $gallery = [];

    foreach ($ids as $id) {
        $attachment = [
            'id' => $id,
            'thumb' => wp_get_attachment_thumb_url($id),
            'src' => wp_get_attachment_image_src($id, 'full')[0],
        ];
        array_push($gallery, $attachment);
    }

    return $gallery;
}

// includes a partial template from the theme with fallback into
// the plugin folder
function post_gallery_lite_render_template($name) {
    $plugin_template = plugin_dir_path(POST_GALLERY_LITE_ROOT) . 'templates/' . $name . '.php';
    $theme_template = locate_template('post-gallery-lite/' . $name . '.php');

    // from active theme folder
    if ($theme_template) {
        require($theme_template);

    // from plugin folder
    } elseif (file_exists($plugin_template)) {
        require($plugin_template);

    // debug message
    // TODO: how to show this in development mode only?
    } else {
        echo "Template missing: " . $name;
    }
}
