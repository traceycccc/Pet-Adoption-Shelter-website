<?php
session_start();
$user_id = $_SESSION['ID'];

if (isset($_GET['shelterID'])) {
    $shelterID = $_GET['shelterID'];

    // Fetch shelter profile details from the API
    $url = "http://localhost/pet_amigo/api/shelter/get_shelterprofiledetails.php?shelterID=$shelterID";
    $response = file_get_contents($url);
    $shelterDetails = json_decode($response, true);

    // Fetch shelter profile picture from the API
    $url = "http://localhost/pet_amigo/api/shelter/get_shelterprofilepicture.php?shelterID=$shelterID";
    $shelterPicture = file_get_contents($url);
    $shelterPictureBase64 = base64_encode($shelterPicture);
} else {
    // Redirect to the shelters page if shelterID is not provided
    header("Location: user_findshelter.php");
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
                    <h1>Shelter Profile</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mt-4 d-flex flex-column align-items-center">
                    <div class="profile-picture-container">
                        <?php if ($shelterPictureBase64) : ?>
                            <img class="profile-picture" src="data:image/jpeg;base64,<?php echo $shelterPictureBase64; ?>" alt="Shelter Profile Picture">
                        <?php else : ?>
                            <p>No profile picture available</p>
                        <?php endif; ?>
                    </div>
                    <br>
                    <a href="user_requestsubmission.php?shelterID=<?php echo $shelterID; ?>" class="btn btn-primary mt-2">Request Animal Submission</a>
                </div>
            

                <div class="col-lg-8 mt-4 shelter-info">
                    <h4>Shelter Information</h4><br>
                    <p><strong>Shelter Name</strong> <span><?php echo $shelterDetails['ShelterName']; ?></span></p>
                    <p><strong>Owner</strong> <span><?php echo $shelterDetails['OwnerName']; ?></span></p>
                    <p><strong>Contacts</strong> <span><?php echo $shelterDetails['Contacts']; ?></span></p>
                    <p><strong>Email</strong> <span><?php echo $shelterDetails['ShelterEmail']; ?></span></p>
                    <p><strong>Address</strong> <span><?php echo $shelterDetails['Address']; ?></span></p>
                    <p><strong>State</strong> <span><?php echo $shelterDetails['State']; ?></span></p>
                    <p><strong>City</strong> <span><?php echo $shelterDetails['City']; ?></span></p>
                    <br><br>
                    <p><strong>About</strong></p>
                    <p><?php echo nl2br($shelterDetails['About']); ?></p><br><br><br>
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
