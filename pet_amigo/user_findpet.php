<?php
session_start();
$user_id = $_SESSION['ID'];
//echo($user_id);

// Database connection
$servername = "localhost";
$username = "root";
$password = "nb6kNiJsymQASSx4";
$dbname = "pet_amigo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available animals from the database
$query = "SELECT * FROM animal WHERE Status = 'available'";
$result = $conn->query($query);

// Check if any animals are found
if ($result->num_rows > 0) {
    $animals = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $animals = array();
}
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
        .card {
    
            margin: 10px;
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1rem;
        }
    </style>
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


    <!-- Rest of your HTML body content -->
    <main>
        <div class="container mt-3">
            <h2>Find a Pet!</h2>
            <div class="row mb-2">
                <?php foreach ($animals as $animal) : ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <?php
                            // Convert blob image data to base64
                            $imageData = base64_encode($animal['ProfileImage']);
                            $src = 'data:image/jpeg;base64,' . $imageData;
                            ?>
                            <img class="card-img" src="<?php echo $src; ?>" alt="Animal Image">
                            
                            <div class="card-body">
                                
                                <h5 class="card-title"><?php echo $animal['AnimalName']; ?></h5>
                                <p class="card-text"><?php echo $animal['Age']; ?></p>
                                <p class="card-text"><?php echo $animal['Gender']; ?></p>
                                <a href="user_animalprofile.php?animalID=<?php echo $animal['AnimalID']; ?>" class="btn btn-primary mt-2">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
</body>

</html>
