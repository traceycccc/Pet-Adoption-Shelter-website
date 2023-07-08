
window.addEventListener('DOMContentLoaded', function() {
  //const Email = window.Email;// Initialize Email.js library
  // Check if the current page is register.html
  if (document.getElementById('register-form')) {
    registerPageFunction();
  }

  // Check if the current page is user_login.php
  if (document.getElementById('login-form')) {
    loginPageFunction();
  }

  if (document.getElementById('change-password-form')) {
    changePasswordFormFunction();
  }

  // Log Out functionality
  let logoutLink = document.getElementById('logoutLink');
  logoutLink.addEventListener('click', confirmLogout);

  getProfileData();



});

function confirmLogout(e) {
  e.preventDefault();
  let confirmed = confirm("Are you sure you want to log out?");
  if (confirmed) {
    // Redirect to the login page
    window.location.href = "user_home.php";
  }
}

function registerPageFunction() {
  let registerForm = document.getElementById('register-form');
  let showPasswordCheckbox = document.getElementById('showPassword');
  let passwordInput = document.getElementById('password');
  let sendOTPButton = document.getElementById('send-otp-button');

  let generatedOTP; // Declare a variable to store the generated OTP
  let otpFields = document.getElementById('otp-fields');
  let otpInput = document.getElementById('otp-input');
  let registerButton = document.getElementById('register-button');
  const Email = window.Email; // Initialize Email.js library

  sendOTPButton.addEventListener('click', function () {
      // Get form data
      let email = document.getElementById('email').value;
      let username = document.getElementById('username').value;
      let name = document.getElementById('name').value;
      let password = passwordInput.value;
  
      // Validate form inputs
      if (!email || !username || !name || !password) {
          alert('Please fill in all fields');
          return;
      } else {
          // Validate email format
          let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(email)) {
              alert('Please enter a valid email');
              return;
          }
  
          // Validate password
          let passwordError = validatePassword(password);
          if (passwordError) {
              alert(passwordError);
              return;
          }
      }
      
      // Generate OTP and send email
      generatedOTP = generateOTP();
      console.log('Generated OTP:', generatedOTP);

      

      // SMTPJS configuration
      Email.send({
          SecureToken: 'c9e08eec-0ee6-4ac8-acff-99cbea86b9a0',
          To: email,
          From: 'petamigotwentythree@gmail.com',
          Subject: 'OTP VERIFICATION',
          Body: 'Hello new user! Your OTP is ' + generatedOTP,
      }).then(function () {
          alert('A 4-digit OTP is sent to the register email! Use it to register your user account!');
      });
      
      // Hide register form and show OTP fields
      //registerForm.style.display = 'none';
      otpFields.style.display = 'block';
  
    
  });

  registerButton.addEventListener('click', function () {
      // Validate OTP input
      let otp = otpInput.value;
      console.log('input OTP:', otp);
      if (!otp) {
        alert('Please enter the OTP');
        return;
      }
  
      // Perform OTP validation
      if (validateOTP(otp, generatedOTP)) {
        // Get form data
        let email = document.getElementById('email').value;
        let username = document.getElementById('username').value;
        let name = document.getElementById('name').value;
        let password = passwordInput.value;
  
        // Create user object
        let user = {
          email: email,
          username: username,
          name: name,
          password: password
        };
  
        // Send form data as JSON
        let xhr = new XMLHttpRequest();
        xhr.open('POST', registerForm.action, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
  
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              // Registration successful
              let response = JSON.parse(xhr.responseText);
              alert(response.message);
              registerForm.reset();
              // Redirect to login page or perform any other actions
            } else {
              // Registration failed
              let errorResponse = JSON.parse(xhr.responseText);
              alert(errorResponse.message);
            }
          }
        };
  
        // Send JSON data
        xhr.send(JSON.stringify(user));
        
        //send email that the user has successfully registered
        Email.send({
          SecureToken: 'c9e08eec-0ee6-4ac8-acff-99cbea86b9a0',
          To: email,
          From: 'petamigotwentythree@gmail.com',
          Subject: 'USER ACCOUNT IS REGISTERED',
          Body: 'Hello new user! Your user account has been registered successfully! ',
        });

      } else {
        // Invalid OTP
        alert('Invalid OTP');
      }
  });

  

  showPasswordCheckbox.addEventListener('change', function () {
    if (showPasswordCheckbox.checked) {
      passwordInput.type = 'text';
    } else {
      passwordInput.type = 'password';
    }
  });

  

  function generateOTP() {
    let digits = '0123456789';
    let otp = '';

    for (let i = 0; i < 4; i++) {
      let index = Math.floor(Math.random() * digits.length);
      otp += digits[index];
    }

    return otp;
  }

  function validateOTP(inputOTP, generatedOTP) {
    return inputOTP == generatedOTP;
  }

  function validatePassword(password) {
    if (password.length < 8) {
      return 'Password must be at least 8 characters long';
    }
    if (!/[a-z]/.test(password)) {
      return 'Password must contain at least one lowercase letter';
    }
    if (!/[A-Z]/.test(password)) {
      return 'Password must contain at least one uppercase letter';
    }
    if (!/\d/.test(password)) {
      return 'Password must contain at least one digit';
    }
    if (!/[@$!%*?&]/.test(password)) {
      return 'Password must contain at least one special character (@$!%*?&)';
    }
    return '';
  }
  


}

function loginPageFunction() {
  let loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent default form submission

      // Get form data
      let email = document.getElementById('user-email').value;
      let password = document.getElementById('user-password').value;

      // Create XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Configure request
      xhr.open('POST', 'api/user/login.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');

      // Handle request response
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.message === 'Login Successful') {
              // Start session
              alert('Login Successful!')
              window.location.href = 'user_profile.php';
            } else {

              if(!email || !password){
                alert('Please fill in all the fields!')
              }else{
                alert('Email is not registered, or the password is incorrect!');
              }
              
            }
          } else {
            alert('An error occurred.');
          }
        }
      };

      // Prepare request data
      const data = JSON.stringify({ email: email, password: password });

      // Send request
      xhr.send(data);
    });
}




function changePasswordFormFunction() {
  let changePasswordForm = document.getElementById('change-password-form');
  let currentPasswordInput = document.getElementById('current-password');
  let newPasswordInput = document.getElementById('new-password');
  let changePasswordButton = document.getElementById('change-password-button');

  changePasswordButton.addEventListener('click', function() {
    let currentPassword = currentPasswordInput.value;
    let newPassword = newPasswordInput.value;

    // Validate form inputs
    if (!currentPassword || !newPassword) {
      alert('Please fill in all fields');
      return;
    }

    // Send request to change password
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/user/changepassword.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          let response = JSON.parse(xhr.responseText);
          alert(response.message);
          changePasswordForm.reset();
        } else {
          let errorResponse = JSON.parse(xhr.responseText);
          alert(errorResponse.message);
        }
      }
    };

    let requestData = {
      currentPassword: currentPassword,
      newPassword: newPassword
    };

    xhr.send(JSON.stringify(requestData));
  });
}


function getProfileData() {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'api/user/editprofile.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');

  xhr.onload = function () {
    if (xhr.status === 200) {
      const profileData = JSON.parse(xhr.responseText);

      // Pre-fill the form fields with the retrieved profile data
      document.getElementById('username').value = profileData.username;
      document.getElementById('name').value = profileData.name;
      document.getElementById('email').value = profileData.email;
      document.getElementById('contacts').value = profileData.contacts;
      document.getElementById('about').value = profileData.about;
    } else {
      alert('Failed to retrieve profile data');
    }
  };

  xhr.send();
}
