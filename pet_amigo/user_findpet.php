<?php
session_start();
$user_id = $_SESSION['ID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Find Pet - Pet Amigo</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css">
    <style>
        #return-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        width: 50px;
        height: 50px;
        background: #333;
        color: #fff;
        text-align: center;
        font-size: 18px;
        line-height: 50px;
        cursor: pointer;
        border-radius:20px;
        opacity: 0.7;
        }
    </style>
</head>
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
                <i class="bi bi-search">Toggle Search</i>
                </button>
                <div class="collapse show d-md-block" id="searchCollapse">
                    <form id="find-pet-form">
                        <!--search inputs-->
                        <div class="row">
                        <div class="search-box-element col-md-2 form-group">
                            <select id="gender" name="gender" class="form-select field-height">
                            <option value="">Select Gender</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2 form-group d-flex align-items-center justify-content-center">
                            <button type="submit" class="btn btn-primary field-height">Search</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mt-3">
            <h2>Results</h2>
            <div class="row mb-2" id="animal-cards"></div>
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
    
    <script>
        // Fetch animal data from the server
        function fetchAnimalData(gender) {
            let url = 'api/animal/get_animals.php';

            if (gender) {
                url += '?gender=' + gender;
            }

            return fetch(url)
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Error fetching animal data');
                    }
                    return response.json();
                })
                .then(function(data) {
                    return data;
                });
        }

        // Generate animal cards based on the fetched data
        function generateAnimalCards(animals) {
            let animalCardsContainer = document.getElementById('animal-cards');
            animalCardsContainer.innerHTML = '';

            animals.forEach(function(animal) {
                // Convert blob data to image URL
                let imageURL = URL.createObjectURL(animal.profileImage);

                let card = `
                    <div class="col-lg-4">
                        <div class="card">
                            <img class="card-img" src="${imageURL}" alt="Animal Image">
                            <div class="card-body">
                                <h5 class="card-title">${animal.animalName}</h5>
                                <p class="card-text">Age: ${animal.age}</p>
                                <p class="card-text">Gender: ${animal.gender}</p>
                                <a href="#" class="btn btn-primary mt-2">Request Adoption</a>
                            </div>
                        </div>
                    </div>
                `;

                animalCardsContainer.innerHTML += card;
            });

            // revoke the object URL to release the resources with the images.
            URL.revokeObjectURL(imageURL);
        }

        // Handle form submission
        document.getElementById('find-pet-form').addEventListener('submit', function(event) {
            event.preventDefault();

            let gender = document.getElementById('gender').value;

            fetchAnimalData(gender)
                .then(function(animals) {
                    generateAnimalCards(animals);
                })
                .catch(function(error) {
                    console.error('Error fetching animal data:', error);
                });
        });

        // Fetch all animals on page load
        fetchAnimalData(null)
            .then(function(animals) {
                generateAnimalCards(animals);
            })
            .catch(function(error) {
                console.error('Error fetching animal data:', error);
            });

    </script>
</body>

</html>
