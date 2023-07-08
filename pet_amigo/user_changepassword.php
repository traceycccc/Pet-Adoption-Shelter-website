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
    <title>Change Password - Pet Amigo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://smtpjs.com/v3/smtp.js"></script>
  
</head>

<body>
  <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="navbar-brand" href="#">Pet Amigo</a>
        </div>
    </nav>

    <main>
        <!-- Main body content -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title">User Change Password</h4>
                            <form id="change-password-form" method="POST">
                                <div class="mb-3">
                                    <label for="current-password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current-password" placeholder="Enter current password">
                                </div>
                                <div class="mb-3">
                                    <label for="new-password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new-password" placeholder="Enter new password">
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary mt-3" id="change-password-button">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-3 text-center">
            <a href="user_profile.php" class="btn btn-link">Back</a>
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
