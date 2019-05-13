$(document).ready(function() {
	let key = "67d67a1a3b4042108061f4b0f2c7ed7e";

	navigator.geolocation.getCurrentPosition(position => {
		let lat = position.coords.latitude;
		let lng = position.coords.longitude;
		$("#lat").val(lat);
		$("#lng").val(lng);

		let url = `https://cors-anywhere.herokuapp.com/https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lng}&key=${key}`;
		fetch(url, {
			method: 'get'
		}).then(response => {
			return response.json();
		}).then(json => {
			$("#country").val(json["results"]["0"]["components"]["country"]);
			$("#postcode").val(json["results"]["0"]["components"]["postcode"]);
			$("#town").val(json["results"]["0"]["components"]["town"]);
			$("#streetname").val(json["results"]["0"]["components"]["road"]);
		}).catch(err => {
			console.log("Position: " + err);
		});
	}, err => {
		console.log("Location: " + err);
	});

	$("input").on('change', function() {
		let that = $(this);
		let placename = $("#streetname").val() + ", " + $("#postcode").val() + $("#town").val() + ", " + $("#country").val();
		let url = `https://cors-anywhere.herokuapp.com/https://api.opencagedata.com/geocode/v1/json?q=${placename}&key=${key}`;
		fetch(url, {
			method: 'get'
		}).then(response => {
			return response.json();
		}).then(json => {
			if (json.results.length != 0) {
				that.css({borderColor: "#464b50"});
				that.siblings("label").css({color: "#a5a5a5"});
				$("#send").prop("disabled", false);
				$("#lat").val(json["results"][0]["geometry"]["lat"]);
				$("#lng").val(json["results"][0]["geometry"]["lng"]);
			} else {
				that.css({borderColor: "red"});
				that.siblings("label").css({color: "red"});
				$("#send").prop("disabled", true);
			}
		}).catch(err => {
			console.log("Position: " + err);
		});
	});

});