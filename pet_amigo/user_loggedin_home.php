<?php
session_start();
$user_id = $_SESSION['ID'];

echo($user_id);

if (!isset($user_id)) {
  header('Location: user_login.php');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pet Amigo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Pet Amigo</a>
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
  <main>
    <div class="container mt-4">
      <div class="row">
        <div class="col-lg-12">
          <h2>Welcome to Pet Amigo!</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 mt-4">
          <h4>Vision</h4>
          <p>Our vision is to create a world where every pet finds a loving home and where pet shelters are supported and empowered in their mission to care for animals.</p>
        </div>
        <div class="col-lg-6 mt-4">
          <h4>Mission</h4>
          <p>Our mission is to connect pet adopters with shelters, making the adoption process easier and promoting responsible pet ownership. We aim to provide a platform that showcases adoptable pets and facilitates the adoption process, while also supporting and collaborating with pet shelters to improve the welfare of animals.</p>
        </div>
      </div>
    </div>
  </main>


  <!-- Footer -->
  <div id="footer-container" class="bg-light text-center py-3"></div>

  <!-- Bootstrap JS (needs Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
  <script src="footer.js"></script>
</body>

</html>
