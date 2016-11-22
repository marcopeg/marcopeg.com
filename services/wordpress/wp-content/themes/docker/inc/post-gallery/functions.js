
;(function($) {

    $.fn.postGallery = function(settings) {
        var $this = $(this);

        var $gallery = $('<div>')
            .addClass('clearfix')
            .append('<p>loading gallery...</p>')
            .appendTo($this);

        var $addBtn = $('<button>')
            .addClass('button-primary')
            .on('click', onAddBtnWasClicked)
            .append('Add Image')
            .appendTo($this);

        fetchImages();

        function fetchImages() {
            $gallery.empty().append('<p>loading gallery...</p>');
            $.post(ajaxurl, {
                action: 'postGallery_getImages',
                post_id: settings.postId,
            }, onImagesWereRetrieved, 'json');
        }

        function onImagesWereRetrieved(data) {
            $gallery.empty();
            if (!data.length) {
                $gallery.append("<p>[empty gallery, let's add something here!]</p>");
                return;
            }
            data.forEach(function(attachment) {
                makeGalleryItem(attachment)
                    .appendTo($gallery);
            });
        }

        function onAddBtnWasClicked(e) {
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

            wp.media.frames.gk_frame.on('select', onImagesWereSelected);
            wp.media.frames.gk_frame.open();
        }

        function onImagesWereSelected() {
            var data = {
                action: 'postGallery_addImages',
                post_id: settings.postId,
                ids: [],
            };

            wp.media.frames.gk_frame.state().get('selection').each(function(attachment) {
                data.ids.push(attachment.attributes.id);
            });

            $.post(ajaxurl, data, function(response) {
    			console.log('Got this from the server: ', response);
                fetchImages();
    		});
        }

        function onDeleteImage(id) {
            $.post(ajaxurl, {
                action: 'postGallery_delImage',
                post_id: settings.postId,
                image_id: id,
            }, function() {
                $('#post-gallery-' + id).fadeOut();
            }, 'json');

        }

        function makeGalleryItem(data) {
            var $item = $('<div>');

            $thumb = $('<img>')
                .attr('id', 'post-gallery-' + data.id)
                .attr('src', data.thumb)
                .css({
                    float: 'left',
                    marginRight: 10,
                    marginBottom: 10,
                })
                .on('click', function(e) {
                    onDeleteImage(data.id);
                })
                .appendTo($item);

            return $item;
        }

    };




})(jQuery);
