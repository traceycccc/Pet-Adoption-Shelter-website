<?php
session_start();
$user_id = $_SESSION['ID'];

//echo($user_id);

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
    <main>
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <h2>User Profile</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mt-4 d-flex flex-column align-items-center">
                    <div class="profile-picture-container">
                        <img class="profile-picture" alt="Profile Picture">
                        <input type="file" id="profile-picture-upload" style="display: none;">
                    </div>
                    <br>
                    <a class="btn btn-primary mt-2">Upload New Profile Image</a>
                    <a href="user_editprofiledetails.php" class="btn btn-primary mt-2">Edit Profile</a>
                    
                </div>
        
                <div class="col-lg-8 mt-4 user-info">
                    <h4>User Information</h4><br>
                    <p><strong>Username</strong> <span id="username"></span></p>
                    <p><strong>Name</strong> <span id="name"></span></p>
                    <p><strong>Email</strong> <span id="email"></span></p>
                    <p><strong>Contacts</strong> <span id="contacts"></span></p>
                    <br><br>
                    <p><strong>About</strong></p>
                    <div id="about"></div>
                    
                </div>
                  
            </div>
        </div>
    </main>
    <br><br><br><br><br><br>


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

    <script>
        // Event listener for "Upload New Profile Image" button
        document.querySelector('.btn-primary.mt-2').addEventListener('click', function() {
            document.getElementById('profile-picture-upload').click();
        });

        // Event listener for file selection
        document.getElementById('profile-picture-upload').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                // File selected, handle the upload
                handleProfilePictureUpload(file);
            }
        });

        // Function to handle profile picture upload
        function handleProfilePictureUpload(file) {
            // Create a new FormData object
            var formData = new FormData();

            // Append the file to the FormData object
            formData.append('profilePicture', file);

            // Send the file to the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'api/user/upload_profilepicture.php?id=<?php echo $user_id; ?>', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // File uploaded successfully
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Reload the page to display the updated profile picture
                        location.reload();
                    } else {
                        alert('Failed to upload profile picture. Please try again.');
                    }
                } else {
                    alert('Error uploading profile picture. Please try again.');
                }
            };
            xhr.send(formData);
        }

        
        
        window.addEventListener('DOMContentLoaded', function() {
        // Fetch user profile data
        fetch('api/user/get_profiledetails.php?id=<?php echo $user_id; ?>')
            .then(response => response.json())
            .then(data => {
            if (data.message === 'User details not found') {
                alert('User details not found');
                return;
            }
            
            // Populate user information in the HTML elements
            document.getElementById('username').innerText = data.username;
            document.getElementById('name').innerText = data.name;
            document.getElementById('email').innerText = data.email;
            document.getElementById('contacts').innerText = data.contacts;
            document.getElementById('about').innerText = data.about;
            
            // Set profile picture source
            document.querySelector('.profile-picture').src = 'api/user/get_profilepicture.php?id=<?php echo $user_id; ?>';
            });
        });
    </script>


</body>

</html>
