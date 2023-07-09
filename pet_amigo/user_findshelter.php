<?php
session_start();
$user_id = $_SESSION['ID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Find Shelter - Pet Amigo</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="user_loggedin_home.php">Pet Amigo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="user_loggedin_home.php">Home</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="user_profile.php">Profile</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="user_findpet.php">Find a Pet</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="user_findshelter.php">Find a Shelter</a>
                    </li>

                    <li class="nav-item ms-3">
                        <a class="nav-link" href="#" id="logoutLink">Log Out</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <!-- Main body content -->
    <main>
        <div class="sticky-top">
            <div class="search-box bg-light py-2 px-4">
                <button class="search-box-element btn btn-primary d-md-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#searchCollapse" aria-expanded="false" aria-controls="searchCollapse">
                    Toggle Search
                </button>
                <div class="collapse show d-md-block" id="searchCollapse">
                    <form onsubmit="submitForm(event)">
                        <!--search inputs-->
                        <div class="row">

                            <div class="search-box-element col-md-4 form-group">
                                <input type="text" class="form-control field-height" id="address-input"
                                    name="address-input" placeholder="Enter your location to search nearby shelters!">

                            </div>


                            <div class="col-md-1 form-group d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn btn-primary field-height">Search</button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container mt-3">
            <h2>Map</h2>
            <div id="map"></div>
        </div>

        <div class="container mt-3">
            <h2>Results</h2>
            <div id="shelter-results" class="row mb-2">
                <!-- Results will be dynamically populated here -->
            </div>
        </div>


    </main>

    <!-- Footer -->
    <div id="footer-container" class="bg-light text-center py-3"></div>

    <a href="#top" id="return-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
            $('#return-to-top').fadeIn();
            } else {
            $('#return-to-top').fadeOut();
            }
        });

        $('#return-to-top').click(function() {
            $('html, body').animate({ scrollTop: 0 }, 500);
            return false;
        });
        });
    </script>

    <!-- Bootstrap JS (needs Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
   
    <script src="footer.js"></script>
    <script src="script.js"></script>

    <!-- Google Maps API Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCehgkktyRjqG50xRLDHBuXayDpbJfGaxM&callback=initMap" async defer></script>

    <script>
        function submitForm(event) {
            event.preventDefault();

            let addressInput = document.getElementById('address-input');
            let address = addressInput.value;

            // Perform geocoding using the address
            let encodedAddress = encodeURIComponent(address);
            let apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" + encodedAddress + "&key=AIzaSyCehgkktyRjqG50xRLDHBuXayDpbJfGaxM";

            let xhr = new XMLHttpRequest();
            xhr.open('GET', apiUrl, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);

                    if (response.status === 'OK') {
                        if (response.results.length > 0) {
                            let firstResult = response.results[0];
                            let latitude = firstResult.geometry.location.lat;
                            let longitude = firstResult.geometry.location.lng;

                            // Call the initMap function with the obtained coordinates
                            initMap(latitude, longitude);
                            fetchNearbyShelters(latitude, longitude);
                        } else {
                            alert('No results found for the provided address.');
                        }
                    } else {
                        alert('Geocoding failed. Status: ' + response.status);
                    }
                }
            };
            xhr.send();
        }

        function initMap(latitude, longitude) {
            let locations = [
                { lat: latitude, lng: longitude }, // Location 1
                { lat: 5.400050624844993, lng: 100.3201994555294 }, // Location 5 5.400050624844993, 100.3201994555294
                { lat: 5.329724059987668, lng: 100.27247761830051 }, // Location 2 5.329724059987668, 100.27247761830051
                { lat: 5.361486530040286, lng: 100.27302584252075 }, // Location 3 5.361486530040286, 100.27302584252075
                { lat: 5.376522601346885, lng: 100.2178442559778 } // Location 4  5.376522601346885, 100.2178442559778
                  
            ];
            
            let names = [
                'Your location',
                'SPCA Penang',
                'SAFE Animal Shelter',
                'Penang Animal Sanctuary',
                'Meowy Cat Shelter'                
            ];

            let map = new google.maps.Map(document.getElementById('map'), {
                center: locations[0],
                zoom: 12.2
            });

            for (let i = 0; i < locations.length; i++) {
                let markerOptions = {
                    position: locations[i],
                    map: map,
                    title: names[i] // Set the marker title
                };


                // Check if it's the first marker
                if (i === 0) {
                    // Customize the first marker icon
                    markerOptions.icon = {
                        url: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        scaledSize: new google.maps.Size(32, 32)
                    };
                }

                let marker = new google.maps.Marker(markerOptions);
            }
        }
    
        function fetchNearbyShelters(lat, long) {
            let apiUrl = `api/shelter/get_nearby_shelters.php?lat=${lat}&long=${long}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                if (data && data.length > 0) {
                    // Clear existing results
                    document.getElementById('shelter-results').innerHTML = '';

                    // Loop through each shelter and create a result card
                    data.forEach(shelter => {
                    const { ShelterID, ShelterName, Address, State, City, Distance } = shelter;

                    // Create a new result card element
                    const card = document.createElement('div');
                    card.className = 'col-lg-4';
                    card.innerHTML = `
                    <!-- Create a new result card element -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${ShelterName}</h5>
                            <p class="card-text">${State}</p>
                            <p class="card-text">${City}</p>
                            <p class="card-text">Distance: ${Distance.toFixed(2)} km</p>
                            <a class="btn btn-primary mt-2" onclick="viewShelterProfile(${ShelterID})">View Details</a>
                        </div>
                    </div>
                    `;

                    // Append the result card to the results container
                    document.getElementById('shelter-results').appendChild(card);
                    });
                } else {
                    // No shelter results found
                    document.getElementById('shelter-results').innerHTML = '<p>No shelters found.</p>';
                }
                })
                .catch(error => {
                console.log('Error:', error);
                // Display an error message if the request fails
                document.getElementById('shelter-results').innerHTML = '<p>Error fetching shelters.</p>';
            });
        }

        function viewShelterProfile(shelterID) {
            // Redirect to the shelter profile page with the ShelterID as a query parameter
            window.location.href = `user_shelterprofile.php?shelterID=${shelterID}`;
        }

    </script>
</body>
</html>
