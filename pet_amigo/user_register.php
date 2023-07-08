<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Pet Amigo</title>
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
            <div class="col-md-6"> <!--element should occupy 6 columns out of the total 12 columns -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">User Registration</h4>
                        <form id="register-form" action="http://localhost/pet_amigo/api/user/create.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="Enter email">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter username">
                            </div>
                            <div class="mb-3">
                              <label for="name" class="form-label">Name</label>
                              <input type="text" class="form-control" id="name" placeholder="Enter name">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password">
                            </div>
                            <div class="mb-3">
                              <input type="checkbox" id="showPassword">
                              <label for="showPassword" class="form-label">Show Password</label>
                            </div>

                            <!-- Send OTP Button -->
                            <div class="d-grid gap-2">
                              <p>By creating an account you agree to our <a href="terms_policy.php" target="_blank">Terms & Privacy</a>.</p>
                              <button type="button" class="btn btn-primary mt-3" id="send-otp-button">Send OTP</button>
                            </div>

                            <!-- OTP Fields (Initially Hidden) -->
                            <div id="otp-fields" style="display: none;">
                              <hr>
                              <h4 class="card-title">OTP Verification</h4>
                              <div class="mb-3">
                                <label for="otp-input" class="form-label">OTP</label>
                                <input type="text" class="form-control" id="otp-input" placeholder="Enter 4-digit OTP">
                              </div>
                              <!-- Register Button-->
                              <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary mt-3" id="register-button">Register</button>
                              </div>
                            </div>

                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-3 text-center">
        <a href="user_home.php" class="btn btn-link">Back to Home Page</a>
        <a href="user_login.php" class="btn btn-link">Go To Login Page</a>
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
