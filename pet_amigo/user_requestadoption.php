<?php
session_start();
$user_id = $_SESSION['ID'];
$shelterID = $_GET['shelterID'];
$animalID = $_GET['animalID'];
//echo($user_id);
//echo($shelterID);
//echo($animalID);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Request Adoption - Pet Amigo</title>
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
                            <h4 class="card-title">Animal Adoption Request</h4>
                            <form id="animal-adoption-form">
                                <br>
                                <div class = "card">
                                <div class="card-body">
                                    <p>Tip: Describe yourself to show that you are a suitable pet adopter!</p>
                                    <p>the more information you provide, the better!</p>
                                </div>
                                </div>
                                <!-- Form fields -->
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Adopter Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Write about your lifestyle, adoption history, expectations & plans!"></textarea>
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
        let animalId = <?php echo $animalID; ?>;

        console.log(userId);
        console.log(shelterId);
        console.log(animalId);
        
        // Form submission
        document.getElementById('animal-adoption-form').addEventListener('submit', function(event) {
            event.preventDefault();

            // Validate form inputs
            if (validateForm()) {
                // Get form value
                let description = document.getElementById('description').value;

                // Display alert message
                alert('All fields are filled!');

                
                
                // Fetch user and shelter details from the server
                Promise.all([
                    fetch(`api/user/get_profiledetails.php?id=${userId}`),
                    fetch(`api/shelter/get_shelterprofiledetails.php?shelterID=${shelterId}`),
                    fetch(`api/animal/get_animalprofiledetails.php?animalID=${animalId}`)
                    
                ]).then(function (responses) {
                    return Promise.all(responses.map(function (response) {
                        if (!response.ok) {
                            throw new Error('Error fetching user and shelter details');
                        }
                        return response.json();
                    }));
                }).then(function([userDetails, shelterDetails, animalDetails]) {
                    console.log('userDetails:', userDetails);
                    console.log('shelterDetails:', shelterDetails);
                    console.log('animalDetails:', animalDetails);

                    let userEmail = userDetails.email;
                    let shelterEmail = shelterDetails.ShelterEmail;
                    
                    console.log(userEmail);
                    console.log(shelterEmail);

                    // Compose the email body
                    let emailBody = `
                        
                        Hi User and Shelter,<br><br>
    
                        Here is the pet adoption request details that the user has sent to the shelter:<br><br><br><br>

                        

                        <b>Pet Adoption Request Details:</b><br><br><br>
                        <b>Adoptee Information:</b><br><br>
                        Animal Name:<br>
                        ${animalDetails.AnimalName}<br><br>
                        Gender: <br>
                        ${animalDetails.Gender}<br><br>
                        Animal Age:<br> 
                        ${animalDetails.Age}<br><br>
                        Vaccinated: <br>
                        ${animalDetails.IsVaccinated}<br><br>
                        Spayed/Neutered: <br>
                        ${animalDetails.IsSpayed}<br><br><br><br><br>

                        <b>User Information:</b><br><br>
                        Name: <br>
                        ${userDetails.name}<br><br>
                        Email: <br>
                        ${userEmail}<br><br>
                        Contacts: <br>
                        ${userDetails.contacts}<br><br>
                        Adopter Description:<br>
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
                        Subject: 'Pet Adoption Request',
                        Body: emailBody
                    }).then(function() {
                        console.log('Email sent successfully');
                        alert('The request has been sent to the shelter email. You will receive an email as well as evidence.');


                        // Update animal status
                        let animalStatus = 'requested'; // Set the desired status value
                        fetch(`api/animal/update_animalstatus.php?animalID=${animalId}&status=${animalStatus}`, { method: 'PUT' })
                            .then(function (response) {
                                if (!response.ok) {
                                    throw new Error('Error updating animal status');
                                }
                                return response.json();
                            })
                            .then(function (data) {
                                console.log('Animal status updated successfully:', data);
                                // Redirect to the animal profile page
                                window.location.href = `user_animalprofile.php?animalID=${animalId}`;
                            })
                            .catch(function (error) {
                                console.error('Error updating animal status:', error);
                                alert('An error occurred while updating the animal status. Please try again later.');
                            });
                        
                        
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
            let requiredFields = ['description'];
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

           

            if (!isValid) {
                alert('Please fill in all the fields!');
            }

            return isValid;
        }

    </script>   

       
</body>

</html>
