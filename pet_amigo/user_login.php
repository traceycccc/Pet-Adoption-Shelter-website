<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pet Amigo</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">Pet Amigo</a>
    </div>
  </nav>

  <main>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Login</h4>
              <form id="login-form" method="POST">

                <div class="mb-3">
                  <label for="user-email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="user-email" name="user-email" placeholder="Enter email" >
                </div>
                <div class="mb-3">
                  <label for="user-password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="user-password" name="user-password" placeholder="Enter password" >
                </div>
                <div class="d-grid gap-2">
                  <button  class="btn btn-primary">Login</button>
                </div>
              </form>
              <hr>
              <div class="text-center mt-3">
                <a href="user_forgotpassword.php">Forgot password?</a>
                <span class="mx-2">|</span>
                <a href="user_register.php">New User? Register!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container my-3 text-center">
      <a href="user_home.php" class="btn btn-link">Back to Home Page</a>
    </div>
  </main>

  <!-- Footer -->
  <div id="footer-container" class="bg-light text-center py-3"></div>

  <!-- Bootstrap JS (needs Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="footer.js"></script>
  <script src="script.js"></script>


</body>

</html>
