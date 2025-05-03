<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- intl-tel-input -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css"/>

  <style>
    body {
      transition: background-color 0.3s, color 0.3s;
    }
    .card {
      border-radius: 1rem;
    }
    .toggle-btn {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 999;
    }
    .profile-pic-container {
      position: relative;
      width: 130px;
      height: 130px;
      margin: 0 auto 1rem;
    }
    .profile-pic {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #ddd;
    }
    .edit-icon {
      position: absolute;
      bottom: 5px;
      right: 5px;
      background-color: #fff;
      border-radius: 50%;
      padding: 5px;
      cursor: pointer;
    }
    .password-toggle {
      cursor: pointer;
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
    }
    @media (min-width: 768px) {
      .form-half {
        display: flex;
        gap: 1rem;
      }
      .form-half > div {
        flex: 1;
      }
    }
	.profile-pic-container {
  position: relative;
  width: 130px;
  height: 130px;
  margin: 0 auto 1rem;
}

.profile-pic-label {
  display: block;
  width: 100%;
  height: 100%;
  position: relative;
  cursor: pointer;
}

.profile-pic {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
  border: 4px solid #ddd;
  transition: transform 0.3s ease;
}

.profile-pic-label:hover .profile-pic {
  transform: scale(1.05);
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: rgba(0, 0, 0, 0.5);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  opacity: 0;
  transition: opacity 0.3s ease;
  text-align: center;
}

.profile-pic-label:hover .overlay {
  opacity: 1;
}

.overlay i {
  font-size: 1.5rem;
}

.overlay span {
  font-size: 0.9rem;
}

  </style>
</head>
<body class="bg-light text-dark">

<!-- Toggle Dark Mode -->
<div class="toggle-btn">
  <button class="btn btn-outline-dark btn-sm" onclick="toggleDarkMode()">🌓 Toggle Dark Mode</button>
</div>

<!-- Sign Up Form -->
<div class="container d-flex align-items-center justify-content-center vh-100">
  <div class="card p-4 shadow-lg w-100" style="max-width: 520px;">
    <form name="signupForm" action="auth/register.php" method="POST" enctype="multipart/form-data" onsubmit="return validateSignupForm()">

      <!-- Profile Picture Upload -->
      <div class="profile-pic-container">
  <label for="profilePicture" class="profile-pic-label">
    <img id="profilePreview" src="https://via.placeholder.com/130" class="profile-pic" alt="Profile Picture">
    <div class="overlay">
      <i class="fa fa-camera"></i><br>
      <span>Change</span>
    </div>
  </label>
  <input type="file" id="profilePicture" name="profilePicture" accept="image/*" onchange="previewProfilePic(event)" hidden required>
</div>


      <!-- Full Name -->
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" required>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" required>
      </div>

      <!-- Passwords -->
      <div class="form-half">
        <div class="mb-3 position-relative">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" required>
          <i class="fa fa-eye password-toggle" onclick="togglePassword('password')"></i>
        </div>
        <div class="mb-3 position-relative">
          <label class="form-label">Confirm Password</label>
          <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
          <i class="fa fa-eye password-toggle" onclick="togglePassword('confirmPassword')"></i>
        </div>
      </div>

      <!-- Phone Number -->
      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="tel" id="phone" name="phone" class="form-control" required>
      </div>

      <!-- Gender -->
      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select class="form-select" name="gender" required>
          <option value="" disabled selected>Select Gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary w-100">Sign Up</button>
      <p class="mt-3 text-center">Already have an account? <a href="index.php">Login</a></p>
    </form>
  </div>
</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"></script>

<script>
  // Phone input with intl-tel-input
  const phoneInputField = document.querySelector("#phone");
  const iti = window.intlTelInput(phoneInputField, {
    initialCountry: "auto",
    geoIpLookup: function (callback) {
      fetch('https://ipinfo.io/json?token=YOUR_TOKEN') // Replace with your token
        .then(response => response.json())
        .then(data => callback(data.country))
        .catch(() => callback("us"));
    },
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
  });

  // Dark mode
  window.onload = function () {
    if (localStorage.getItem('darkMode') === 'enabled') enableDarkMode();
  };
  function toggleDarkMode() {
    const isDark = document.body.classList.toggle("bg-dark");
    document.body.classList.toggle("text-light");
    localStorage.setItem("darkMode", isDark ? "enabled" : "disabled");
  }
  function enableDarkMode() {
    document.body.classList.add("bg-dark", "text-light");
  }

  // Preview profile picture
  function previewProfilePic(event) {
    const reader = new FileReader();
    reader.onload = function () {
      document.getElementById('profilePreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }

  // Toggle password visibility
  function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
  }

  // Validate form
  function validateSignupForm() {
    const name = document.forms["signupForm"]["name"].value.trim();
    const email = document.forms["signupForm"]["email"].value.trim();
    const password = document.forms["signupForm"]["password"].value;
    const confirmPassword = document.forms["signupForm"]["confirmPassword"].value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const strongPassword = /^(?=.*[A-Z])(?=.*\d).{6,}$/;

    if (name.length < 3) {
      alert("Name must be at least 3 characters.");
      return false;
    }
    if (!emailRegex.test(email)) {
      alert("Enter a valid email address.");
      return false;
    }
    if (!strongPassword.test(password)) {
      alert("Password must be at least 6 characters, include 1 uppercase letter and 1 number.");
      return false;
    }
    if (password !== confirmPassword) {
      alert("Passwords do not match.");
      return false;
    }

    const number = iti.getNumber();
    document.querySelector("input[name='phone']").value = number;

    return true;
  }
</script>

</body>
</html>
