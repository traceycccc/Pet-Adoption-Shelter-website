<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password - Pet Amigo</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
              <h4 class="card-title">Reset Password</h4>
              <form id="changepassword-form">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="mb-3">
                  <label for="new-password" class="form-label">New Password</label>
                  <input type="password" class="form-control" id="new-password" placeholder="Enter new password">
                </div>
                <div class="mb-3">
                  <input type="checkbox" id="showPassword">
                  <label for="showPassword" class="form-label">Show Password</label>
                </div>
                <div class="d-grid gap-2">
                  <button type="button" class="btn btn-primary mt-3" id="send-otp-button">Send OTP</button>
                </div>
                <div id="otp-fields" style="display: none;">
                  <hr>
                  <h4 class="card-title">OTP Verification</h4>
                  <div class="mb-3">
                    <label for="otp-input" class="form-label">OTP</label>
                    <input type="text" class="form-control" id="otp-input" placeholder="Enter 4-digit OTP">
                  </div>
                  <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary mt-3" id="change-password-button">Change Password</button>
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
