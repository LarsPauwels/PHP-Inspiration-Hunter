<?php
	require_once("bootstrap/bootstrap.php");
?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/locations.css">
</head>
<body>

	<header>
        <a href="index">
            <img src="images/full_logo.png" class="logo">
        </a>
    </header>

	<nav>
		<a href="index">
			<div class="hamburger">
				<i class="fas fa-bars"></i>
			</div>
		</a>

		<ul id="menu">
			<a href="index">
				<li>
					<i class="fas fa-compass"></i>
					<span class="tooltiptext">Explore</span>
				</li>
			</a>
			<a href="locations">
				<li class="active">
					<i class="fas fa-map-marker-alt"></i>
					<span class="tooltiptext">Locations</span>
				</li>
			</a>
			<a href="profile?user=<?php echo htmlspecialchars($_SESSION['user']['username']);?>">
				<li>
					<i class="fas fa-user"></i>
					<span class="tooltiptext">Users</span>
				</li>
			</a>
		</ul>
		<ul id="submenu">
			<li>
				<a href="settings">
					<i class="fas fa-cog"></i>
					<span class="tooltiptext">Settings</span>
				</a>
			</li>
			<li>
				<a href="logout">
					<i class="fas fa-sign-out-alt"></i>
					<span class="tooltiptext">Log Out</span>
				</a>
			</li>
		</ul>
	</nav>

	<div id="map"></div>

<script>
	function escapeHtml(text) {
	  	var map = {
	    	'&': '&amp;',
	    	'<': '&lt;',
	    	'>': '&gt;',
	    	'"': '&quot;',
	    	"'": '&#039;'
	  	};

	  	return text.replace(/[&<>"']/g, function(m) { return map[m]; });
	}
	function initMap() {
		var locations = [
			<?php
				echo Location::getLocations();
			?>
		]

        // create a new google map and center on a default location in Belgium
        var map = new google.maps.Map(document.getElementById('map'), {
        	zoom: 9,
        	center: { lat: 51.0259, lng: 4.4775 }
        });

        // loop over all markers in the array
        for( var i=0; i<locations.length; i++ ){            
        	var infoWindow = new google.maps.InfoWindow;
        	var marker = new google.maps.Marker({
        		position: locations[i],
        		map: map
        	});

           // add an infowindow to the currect marker so that we can click on it for details
           attachInfowindow(marker, locations[i].name, locations[i].id, locations[i].image, locations[i].profile_pic, locations[i].postId, locations[i].filter);
       }
   }

   function attachInfowindow( marker, name, id, image, profile_pic, postId, filter){
       // this function adds an infowindow to the current marker in the loop
       var content = `
       		<div class='maps-container'>
       			<img src="${profile_pic}" class='user'>
	       		<a href="profile.php?user=${name}" class='name'>
	       			${name}
	       		</a>
       		</div>
       		<a href='index?post=${postId}'>
       			<div class='${filter}'>
       				<img src="${image}" class='post-image-maps'>
       			</div>
       		</a>
       `;

       var infowindow = new google.maps.InfoWindow({
       	content: content
       });

       marker.addListener('click', function() {
       	infowindow.open(marker.get('map'), marker);
       });
   }

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq26SiNiH7Qcec_xKTF5NB06VBdvteFE0&callback=initMap"
type="text/javascript"></script>
</body>
</html>