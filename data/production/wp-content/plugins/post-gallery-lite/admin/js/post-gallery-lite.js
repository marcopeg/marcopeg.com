
;(function($) {

    $.fn.postGalleryLite = function(settings) {
        let $this = $(this);
        let $gallery, $addBtn;

        setTimeout(() => {
            $gallery = $('<div>')
                .addClass('clearfix')
                .append('<p>loading gallery...</p>')
                .appendTo($this);

            $addBtn = $('<button>')
                .addClass('button-primary')
                .on('click', onAddBtnWasClicked)
                .append('Add Image')
                .appendTo($this);

            fetchImages();
        });

        let ajaxAction = (action, data) => new Promise((resolve, reject) => {
            let payload = Object.assign({}, data || {}, {
                post_id: settings.postId,
                action: 'post_gallery_lite_' + action,
            });

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: payload,
                dataType: 'json',
                error: err => reject(err),
                success: res => {
                    if (res.success === true) {

                        // update cache field
                        let cache = res.data.map(image => image.id).join(',');
                        $(settings.cacheField).val(cache);

                        resolve(res.data);
                    } else {
                        reject(res.data);
                    }
                },
            });
        });

        let fetchImages = () => new Promise((resolve, reject) => {
            listDestroy();
            $gallery.append('<p>loading gallery...</p>');

            let images;
            ajaxAction('get_images')
                .then(data => images = data)
                .then(() => listUpdate(images))
                .then(() => resolve(images))
                .catch(err => console.error(err));
        })

        let listDestroy = () => new Promise((resolve, reject) => {
            $gallery.find('ul').sortable('destroy');
            $gallery.empty();
            resolve();
        });

        // Implements sortable behaviour
        let listRender = images => new Promise((resolve, reject) => {
            if (!images.length) {
                $gallery.append("<p>[empty gallery, let's add something here!]</p>");
                return;
            }

            let $list = $('<ul>').appendTo($gallery);
            images.forEach(function(attachment) {
                makeGalleryItem(attachment)
                    .appendTo($list);
            });

            $list.sortable().on('sortstop', function(e, ui) {
                let ids = $list.sortable('toArray').map(id => $('#' + id).data('post-gallery-lite-id'));
                ajaxAction('sort_images', { ids })
                    .catch(err => {
                        alert('Something went wrong, reverting order!');
                        $list.sortable( "cancel" );
                    });
            });
        });

        // unrender / render
        let listUpdate = images => listDestroy().then(() => listRender(images));

        let onAddBtnWasClicked = e => {
            e.preventDefault();
            e.stopPropagation();

            if (wp.media.frames.gk_frame) {
                wp.media.frames.gk_frame.open();
                return;
            }

            wp.media.frames.gk_frame = wp.media({
                title: 'Add images to this post:',
                multiple: true,
                library: {
                    type: 'image'
                },
                button: {
                    text: 'Add to PhotoGallery'
                }
            });

            wp.media.frames.gk_frame.on('select', () => {
                let ids = wp.media.frames.gk_frame.state().get('selection').map(attachment => attachment.attributes.id);
                ajaxAction('add_images', { ids })
                    .then(listUpdate)
                    .catch(err => console.error(err));
            });

            wp.media.frames.gk_frame.open();
        };

        let onDeleteImage = id => ajaxAction('del_image', { image_id: id })
            .then(() => {
                $('#post-gallery-lite-' + id).fadeOut();
            })
            .catch(err => console.error(err));

        let makeGalleryItem = data => {
            let $item = $('<div>');

            $wrapper = $('<li>')
                .attr('id', 'post-gallery-lite-' + data.id)
                .data('post-gallery-lite-id', data.id)
                .on('click', function(e) {
                    onDeleteImage(data.id);
                });

            $thumb = $('<img>')
                .attr('src', data.thumb)
                .appendTo($wrapper);

            return $wrapper;
        };
    };


})(jQuery);
