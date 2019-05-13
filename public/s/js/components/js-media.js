(function(){
    var currentMediaItem = false;
    // console.log($('#modal-video'));

    function media_next_picture(th) {
        var currentIndex = currentMediaItem.index(),
            mediaItems = currentMediaItem.parent().find('.media-item'),
            totalLength = mediaItems.length,
            url = mediaItems.eq(currentIndex + 1).attr('data-url');
        if ((currentIndex + 1 < totalLength) && url) {
            currentMediaItem = mediaItems.eq(currentIndex + 1);
            th.closest('.modal').find('.modal-picture__inner img').attr('src', url);
            if (Modernizr.objectfit === false) {
                objectfit();
            };
        };
    }
    function media_prev_picture(th) {
        var currentIndex = currentMediaItem.index(),
            mediaItems = currentMediaItem.parent().find('.media-item'),
            url = mediaItems.eq(currentIndex - 1).attr('data-url');
        if ((currentIndex > 0) && url) {
            currentMediaItem = mediaItems.eq(currentIndex - 1);
            th.closest('.modal').find('.modal-picture__inner img').attr('src', url);
            if (Modernizr.objectfit === false) {
                objectfit();
            };
        };
    }
    function media_next_video(th) {
        var currentIndex = currentMediaItem.index(),
            mediaItems = currentMediaItem.parent().find('.media-item'),
            totalLength = mediaItems.length,
            url = mediaItems.eq(currentIndex + 1).attr('data-url');
        if ((currentIndex + 1 < totalLength) && url) {
            currentMediaItem = mediaItems.eq(currentIndex + 1);
            th.closest('.modal').find('.modal-video__inner iframe').attr('src', url);
        };
    }
    function media_prev_video(th) {
        var currentIndex = currentMediaItem.index(),
            mediaItems = currentMediaItem.parent().find('.media-item'),
            url = mediaItems.eq(currentIndex - 1).attr('data-url');
        if ((currentIndex > 0) && url) {
            currentMediaItem = mediaItems.eq(currentIndex - 1);
            th.closest('.modal').find('.modal-video__inner iframe').attr('src', url);
        };
    }
    $('#modal-picture')
        .on('show.bs.modal', function (e) {
            var btn = $(e.relatedTarget),
                url = btn.attr('data-url');
            currentMediaItem = btn;
            if(url) {
                $(this).find('.modal-picture__inner img').attr('src', url);
                setTimeout(function () {
                    if (Modernizr.objectfit === false) {
                        objectfit();
                    };
                }, 0);
            };
        })
        .on('hidden.bs.modal', function (e) {
            $(this).find('.modal-picture__inner img').attr('src', '');
        });
    $('#modal-video')
        .on('show.bs.modal', function (e) {
            var btn = $(e.relatedTarget),
                url = btn.attr('data-url');
            currentMediaItem = btn;
            if(url) {
                $(this).find('.modal-video__inner iframe').attr('src', url);
            };
        })
        .on('hidden.bs.modal', function (e) {
            $(this).find('.modal-video__inner iframe').attr('src', '');
        });
    $('#modal-picture .btn-next').on('click', function () {
        media_next_picture($(this));
    });
    $('#modal-picture .btn-prev').on('click', function () {
        media_prev_picture($(this));
    });
    $('#modal-video .btn-next, .close-video-modal').on('click', function () {
        media_next_video($(this));
    });
    $('#modal-video .btn-prev').on('click', function () {
        media_prev_video($(this));
    });

    $("#modal-picture .swipe_block").swipe( {
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            if (direction == 'left') {
                media_next_picture($(this));
            };
            if (direction == 'right') {
                media_prev_picture($(this));
            };
        },
        threshold:0
    });
    $("#modal-video .swipe_block").swipe( {
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            if (direction == 'left') {
                media_next_video($(this));
            };
            if (direction == 'right') {
                media_prev_video($(this));
            };
        },
        threshold:0
    });
})();
