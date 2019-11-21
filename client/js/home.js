$(document).ready(function($) {
	// Start of use strict
	"use strict"; // Start of use strict

	// Smooth scrolling using jQuery easing
	$('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: (target.offset().top - 70)
				}, 1000, "easeInOutExpo");
				return false;
			}
		}
	});

	// Scroll to top button appear
	$(document).scroll(function () {
		var scrollDistance = $(this).scrollTop();
		if (scrollDistance > 100) {
			$('.scroll-to-top').fadeIn();
		} else {
			$('.scroll-to-top').fadeOut();
		}
	});

	// Closes responsive menu when a scroll trigger link is clicked
	$('.js-scroll-trigger').click(function () {
		$('.navbar-collapse').collapse('hide');
	});

	// Activate scrollspy to add active class to navbar items on scroll
	$('body').scrollspy({
		target: '#mainNav',
		offset: 80
	});

	// Collapse Navbar
	var navbarCollapse = function () {
		if ($("#mainNav").offset().top > 100) {
			$("#mainNav").addClass("navbar-shrink");
		} else {
			$("#mainNav").removeClass("navbar-shrink");
		}
	};
	
	// Collapse now if page is not at top
	navbarCollapse();
	
	// Collapse the navbar when page is scrolled
	$(window).scroll(navbarCollapse);

	// Table Structure
	$('.dataTables_length').addClass('bs-select');

	var dataTableId = "dataTableList";
	carregarTabelaDados(dataTableId);
	
	var solicitationsTableId = "solicitationsTableList";
	var solicitationsDetailTableId = "solicitationsDetailsTableList";
	carregarTabelaSolicitacoes(solicitationsTableId,solicitationsDetailTableId);
	
	$("#botaoSair").on("click", function (e) {
		e.preventDefault();
		$.confirm({
			title: '',
			content: '<h6>Deseja sair do Waiter?</h6>',
			buttons: {
				confirma: {
					btnClass: "btn-red",
					action: function () {
						setCookie("idUsuario", "", -1);
						setCookie("identificadorUsuario", "", -1);
						setCookie("senha", "", -1);
						
						location.href = "login.html";
					}
				},
				cancela: {}
			}
		});
	});
})