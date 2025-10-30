(function ($) {
	"use strict";
	var notify = $.notify(
		'<i class="fa fa-bell-o"></i><strong>Loading</strong> halaman, tunggu...',
		{
			type: "theme",
			allow_dismiss: true,
			delay: 2000,
			showProgressbar: true,
			timer: 300,
			animate: {
				enter: "animated fadeInDown",
				exit: "animated fadeOutUp",
			},
		}
	);
	setTimeout(function () {
		notify.update(
			"message",
			'<i class="fa fa-bell-o"></i><strong>Loading</strong> selesai.'
		);
	}, 1000);
})(jQuery);
