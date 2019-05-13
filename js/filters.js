$(document).ready(function() {

	var filters = {
		"1977": "_1977", 
		"Aden": "aden", 
		"Brannan": "brannan", 
		"Brooklyn": "brooklyn",
		"Clarendon": "clarendon",
		"Earlybird": "earlybird",
		"Gingham": "gingham",
		"Hudson": "hudson",
		"Inkwell": "inkwell",
		"Kelvin": "kelvin",
		"Lark": "lark",
		"Lo-Fi": "lofi",
		"Maven": "maven",
		"Mayfair": "mayfair",
		"Moon": "moon",
		"Nashvile": "nashville",
		"Perpetua": "perpetua",
		"Reyes": "reyes",
		"Rise": "rise",
		"Slumber": "slumber",
		"Stinson": "stinson",
		"Toaster": "toaster",
		"Valencia": "valencia",
		"Walden": "walden",
		"Willow": "willow",
		"X-pro ||": "xpro2"
	};

	var i = 0;
	for (var key in filters) {
		i++;
		$(".filters").append(
			'<div class="filter" data-filter="'+i+'">' +
				'<div class="filter-inner '+filters[key]+'"></div>' +
				'<p>'+key+'</p>' +
			'</div>'
		);
	}

	$(".filter").click(function() {
		var key = $(this).find("p").text();
		var filterId = $(this).data("filter");
		$("#filter-image").removeClass();
		$("#filter-image").addClass(filters[key]);
		$("#filter-input").val(filterId);
	});

	const slider = document.querySelector('.scroll');
	let isDown = false;
	let startX;
	let scrollLeft;

	slider.addEventListener('mousedown', (e) => {
		isDown = true;
		slider.classList.add('active');
		startX = e.pageX - slider.offsetLeft;
		scrollLeft = slider.scrollLeft;
	});
	slider.addEventListener('mouseleave', () => {
		isDown = false;
		slider.classList.remove('active');
	});
	slider.addEventListener('mouseup', () => {
		isDown = false;
		slider.classList.remove('active');
	});
	slider.addEventListener('mousemove', (e) => {
		if(!isDown) return;
		e.preventDefault();
		const x = e.pageX - slider.offsetLeft;
	  const walk = (x - startX) * 3; //scroll-fast
	  slider.scrollLeft = scrollLeft - walk;
	  console.log(walk);
	});

});