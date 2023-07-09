<?php
session_start();
$user_id = $_SESSION['ID'];
//echo($user_id)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Pet Amigo</title>
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
                            <h4 class="card-title">Edit Profile</h4>
                            <form id="editprofile-form">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contacts" class="form-label">Contacts</label>
                                    <input type="text" class="form-control" id="contacts" name="contacts" placeholder="Enter contacts" required>
                                </div>
                                <div class="mb-3">
                                    <label for="about" class="form-label">About</label>
                                    <textarea class="form-control" id="about" name="about" placeholder="Enter about"></textarea>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-3 text-center">
            <a href="user_profile.php" class="btn btn-link">Back to Profile</a>
        </div>
    </main>

    <!-- Footer -->
    <div id="footer-container" class="bg-light text-center py-3"></div>

    <!-- Bootstrap JS (needs Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="footer.js"></script>
    <script src="script.js"></script>

    <script>
        // Fetch and populate the user's profile details
        document.addEventListener("DOMContentLoaded", function () {
            fetchProfileDetails();
        });

        function populateForm(profile) {
            document.getElementById('username').value = profile.username;
            document.getElementById('name').value = profile.name;
            document.getElementById('email').value = profile.email;
            document.getElementById('contacts').value = profile.contacts;
            document.getElementById('about').value = profile.about;
        }

        
        function fetchProfileDetails() {
            let xhr = new XMLHttpRequest();
            let user_id = <?php echo $user_id; ?>;
            let url = `api/user/get_profiledetails.php?id=${user_id}`;

            xhr.open('GET', url, true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                populateForm(response);
                } else {
                console.error('Error fetching profile details:', xhr.status);
                }
            };

            xhr.onerror = function () {
                console.error('Error fetching profile details.');
            };

            xhr.send();
        }


        // Handle form submission
        document.getElementById("editprofile-form").addEventListener("submit", function (event) {
            event.preventDefault();

            // Get form values
            let username = document.getElementById("username").value;
            let name = document.getElementById("name").value;
            let email = document.getElementById("email").value;
            let contacts = document.getElementById("contacts").value;
            let about = document.getElementById("about").value;

            // Create payload
            let payload = {
                username: username,
                name: name,
                email: email,
                contacts: contacts,
                about: about
            };

            let xhr = new XMLHttpRequest();
            let user_id = <?php echo $user_id; ?>;
            xhr.open("POST", "api/user/update_profiledetails.php?id=${user_id}", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    let response = JSON.parse(xhr.responseText);
                    handleProfileUpdateResponse(response);
                }
            };
            xhr.send(JSON.stringify(payload));
        });

        function handleProfileUpdateResponse(response) {
            if (response.success) {
                // Profile update successful
                alert("Profile details updated successfully!");
                window.location.href = "user_profile.php";
            } else {
                // Profile update failed
                alert("Failed to update profile details. Please try again.");
            }
        }
    </script>
</body>

</html>
