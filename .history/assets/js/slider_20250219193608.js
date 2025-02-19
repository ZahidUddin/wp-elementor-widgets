document.addEventListener("DOMContentLoaded", function () {
	new Swiper(".wp-elementor-slider", {
		loop: true,
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
		autoplay: {
			delay: 3000,
		},
	});
});
