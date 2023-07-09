<?php
session_start();
$user_id = $_SESSION['ID'];

if (isset($_GET['animalID'])) {
    $animalID = $_GET['animalID'];

    // Fetch shelter profile details from the API
    $url = "http://localhost/pet_amigo/api/animal/get_animalprofiledetails.php?animalID=$animalID";
    $response = file_get_contents($url);
    $animalDetails = json_decode($response, true);

    // Fetch shelter profile picture from the API
    $url = "http://localhost/pet_amigo/api/animal/get_animalprofilepicture.php?animalID=$animalID";
    $animalPicture = file_get_contents($url);
    $animalPictureBase64 = base64_encode($animalPicture);
} else {
    // Redirect to the shelters page if animalID is not provided
    header("Location: user_findpet.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Pet Amigo</title>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
    <a id="top"></a>
    <main>
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Animal Profile</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mt-4 d-flex flex-column align-items-center">
                    <div class="profile-picture-container">
                        <?php if ($animalPictureBase64) : ?>
                            <img class="profile-picture" src="data:image/jpeg;base64,<?php echo $animalPictureBase64; ?>" alt="Animal Profile Picture">
                        <?php else : ?>
                            <p>No profile picture available</p>
                        <?php endif; ?>
                    </div>
                    <br>
                    <a href="user_requestadoption.php?animalID=<?php echo $animalID; ?>&shelterID=<?php echo $animalDetails['ShelterID']; ?>" class="btn btn-primary mt-2">Request Pet Adoption</a>
                </div>
            

                <div class="col-lg-8 mt-4 shelter-info">
                    <h4>Animal Information</h4><br>
                    <p><strong>Animal Name</strong> <span><?php echo $animalDetails['AnimalName']; ?></span></p>
                    <p><strong>Shelter</strong> <span><?php echo $animalDetails['ShelterName']; ?></span></p>
                    <p><strong>Status</strong> <span><?php echo $animalDetails['Status']; ?></span></p>
                    <p><strong>Gender</strong> <span><?php echo $animalDetails['Gender']; ?></span></p>
                    <p><strong>Age</strong> <span><?php echo $animalDetails['Age']; ?></span></p>
                    <p><strong>Is Vaccinated</strong> <span><?php echo $animalDetails['IsVaccinated']; ?></span></p>
                    <p><strong>Is Spayed</strong> <span><?php echo $animalDetails['IsSpayed']; ?></span></p>
                    
                    <br><br>
                    <p><strong>About</strong></p>
                    <p><?php echo nl2br($animalDetails['About']); ?></p><br><br><br>
                </div>
                  
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
    <script src="script.js"></script>
    <script src="footer.js"></script>

</body>

</html>
