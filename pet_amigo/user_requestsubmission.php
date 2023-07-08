<?php
session_start();
$user_id = $_SESSION['ID'];
$shelterID = $_GET['shelterID'];

echo($user_id);
echo($shelterID);
echo($user_id);
echo($shelterID);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Request Submission - Pet Amigo</title>
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

    <!-- Main body content -->
    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Animal Submission Request</h4>
                            <form id="animal-submission-form">
                                <!-- Form fields -->
                                <div class="mb-3">
                                    <label for="animal-name" class="form-label">Animal Name</label>
                                    <input type="text" class="form-control" id="animal-name" name="animal-name" placeholder="Enter the animal's name" >
                                </div>
                                <div class="mb-3">
                                    <label>Gender</label>
                                    <div>
                                        <input type="radio" id="male" name="gender" value="male" class="form-check-input">
                                        <label for="male" class="form-check-label radio-label">Male</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="female" name="gender" value="female" class="form-check-input">
                                        <label for="female" class="form-check-label radio-label">Female</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="animal-age" class="form-label">Animal Age (If unsure, it's okay to guess!)</label>
                                    <input type="text" class="form-control" id="animal-age" name="animal-age" placeholder="Enter age (e.g. 2 months, 3 weeks)">
                                </div>
                                
                                <div class="mb-3">
                                    <label>Is vaccinated</label>
                                    <div>
                                        <input type="radio" id="vaccinated-yes" name="vaccinated" value="yes" class="form-check-input">
                                        <label for="vaccinated-yes" class="form-check-label radio-label">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="vaccinated-no" name="vaccinated" value="no" class="form-check-input">
                                        <label for="vaccinated-no" class="form-check-label radio-label">No</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Is spayed / neutered</label>
                                    <div>
                                        <input type="radio" id="spayed-yes" name="spayed-neutered" value="yes" class="form-check-input">
                                        <label for="spayed-yes" class="form-check-label radio-label">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="spayed-no" name="spayed-neutered" value="no" class="form-check-input">
                                        <label for="spayed-no" class="form-check-label radio-label">No</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Describe what's the animal behaviour, their conditions, and so on!"></textarea>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary mt-3" >Submit</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-3 text-center">
            <a href="javascript:window.history.back();" class="btn btn-link">Cancel</a>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3">
        <!-- Footer content -->
    </footer>

    <!-- Bootstrap JS (needs Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    
    <script>
        // Fetch shelter and user information
        let userId = <?php echo $user_id; ?>;
        let shelterId = <?php echo $shelterID; ?>;

        console.log(userId);
        console.log(shelterId);
        
        // Form submission
        document.getElementById('animal-submission-form').addEventListener('submit', function(event) {
            event.preventDefault();

            // Validate form inputs
            if (validateForm()) {
                // Get form values
                let animalName = document.getElementById('animal-name').value;
                let gender = document.querySelector('input[name="gender"]:checked').value;
                let animalAge = document.getElementById('animal-age').value;
                let vaccinated = document.querySelector('input[name="vaccinated"]:checked').value;
                let spayedNeutered = document.querySelector('input[name="spayed-neutered"]:checked').value;
                let description = document.getElementById('description').value;

                // Display alert message
                alert('All fields are filled!');

                
                
                // Fetch user and shelter details from the server
                Promise.all([
                    fetch(`api/user/get_profiledetails.php?id=${userId}`),
                    fetch(`api/shelter/get_shelterprofiledetails.php?shelterID=${shelterId}`)
                ]).then(function (responses) {
                    return Promise.all(responses.map(function (response) {
                        if (!response.ok) {
                            throw new Error('Error fetching user and shelter details');
                        }
                        return response.json();
                    }));
                }).then(function([userDetails, shelterDetails]) {
                    console.log('userDetails:', userDetails);
                    console.log('shelterDetails:', shelterDetails);

                    let userEmail = userDetails.email;
                    let shelterEmail = shelterDetails.ShelterEmail;
                    
                    console.log(userEmail);
                    console.log(shelterEmail);

                    // Compose the email body
                    let emailBody = `
                        
                        Hi User and Shelter,<br><br>
    
                        Here is the animal submission details that the user has sent to the shelter:<br><br><br><br>

                        <b>User Information:</b><br><br>
                        Name: ${userDetails.name}<br>
                        Email: ${userEmail}<br>
                        Contacts: ${userDetails.contacts}<br><br><br><br><br>

                        <b>Animal Submission Details:</b><br><br>
                        
                        Animal Name:<br>
                        ${animalName}<br><br>
                        Gender: <br>
                        ${gender}<br><br>
                        Animal Age:<br> 
                        ${animalAge}<br><br>
                        Vaccinated: <br>
                        ${vaccinated}<br><br>
                        Spayed/Neutered: <br>
                        ${spayedNeutered}<br><br>
                        Description:<br>
                        ${description}<br><br>

                        If you have any enquiries, do not hesitate to contact us via petamigotwentythree@gmail.com.<br>
                        Thank you.<br><br>

                        Regards,<br>
                        The Pet Amigo Team
                    `;

                    

                    console.log('Before sending email');
                    console.log(shelterEmail);
                    console.log(userEmail);
                    console.log(emailBody);

                    Email.send({
                        SecureToken: 'c9e08eec-0ee6-4ac8-acff-99cbea86b9a0',
                        To: shelterEmail + ', ' + userEmail,
                        From: 'petamigotwentythree@gmail.com',
                        Subject: 'Stray Animal Submission Request',
                        Body: emailBody
                    }).then(function() {
                        console.log('Email sent successfully');
                        alert('The request has been sent to the shelter email. You will receive an email as well as evidence.');
                        
                        //go back to that shelter's profile page
                        window.location.href = `user_shelterprofile.php?shelterID=${shelterId}`; 
                    }).catch(function(error) {
                        console.error('Error sending email:', error);
                        alert('An error occurred while sending the email. Please try again later.');
                    });

                    console.log('After sending email');

                }).catch(function(error) {

                    console.error('Error fetching user and shelter details:', error);
                    alert('An error occurred while submitting the request. Please try again later.');
                });
            }
        });

        // Validate form inputs
        // Validate form inputs
        function validateForm() {
            // Validate required fields
            let requiredFields = ['animal-name', 'animal-age', 'description'];
            let isValid = true;

            for (let field of requiredFields) {
                let input = document.getElementById(field);

                // Check if the input element exists
                if (input) {
                    let inputValue = input.value.trim();

                    if (inputValue === '') {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                }
            }

            // Validate radio buttons
            let radioGroups = ['gender', 'vaccinated', 'spayed-neutered'];

            for (let group of radioGroups) {
                let checkedInputs = document.querySelectorAll(`input[name="${group}"]:checked`);

                if (checkedInputs.length === 0) {
                    let radioButtons = document.getElementsByName(group);
                    radioButtons.forEach(button => button.classList.add('is-invalid'));
                    isValid = false;
                } else {
                    let radioButtons = document.getElementsByName(group);
                    radioButtons.forEach(button => button.classList.remove('is-invalid'));
                }
            }

            if (!isValid) {
                alert('Please fill in all the fields!');
            }

            return isValid;
        }

    </script>   

       
</body>

</html>
