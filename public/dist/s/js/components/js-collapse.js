(function () {
	var $body = $('body');
	$body
		.on('click', '.js-collapse .clickToOpen', function(event){
			var th = $(this),
				th_collapse = th.closest('.js-collapse'),
				th_content = th_collapse.find('.js-collapse-content');
            th_collapse.toggleClass('js-collapse_opened');
            if (th_collapse.hasClass('js-collapse_opened')) {
                th
                    .closest('.js-collapse-wrap')
                    .find('.js-collapse-content')
                    .not(th_content)
                    .stop(true,true).slideUp('300');
                th_content.stop(true,true).slideDown('300', function(){
                    $('html,body').animate({scrollTop:th_collapse.offset().top - 5}, 300, 'swing');
                });
            } else {
                th
					.closest('.js-collapse')
					.find('.js-collapse-content')
					.stop(true,true).slideUp('300');
			}
		});
})();