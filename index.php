<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Firebase -->
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>

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
    }
    .password-toggle {
      cursor: pointer;
      position: absolute;
      right: 15px;
      top: 38px;
      z-index: 10;
    }
  </style>
</head>

<body class="bg-light text-dark">

  <!-- Dark Mode Toggle -->
  <div class="toggle-btn">
    <button class="btn btn-outline-dark btn-sm" onclick="toggleDarkMode()">🌓 Dark Mode</button>
  </div>

  <!-- Login Form -->
  <div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow w-100" style="max-width: 420px;">
		<div class="text-center mb-3">
		<img src="img/logo.jpg" alt="Logo" style="width: 100px; height: 100px; border-radius: 50%;">
		</div>
		<h3 class="text-center mb-4">Login</h3>
      <form name="loginForm" action="auth/login.php" method="POST" onsubmit="return validateLoginForm()">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" placeholder="you@example.com" required>
        </div>
        <div class="mb-3 position-relative">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="passwordField" placeholder="********" required>
          <span class="password-toggle" onclick="togglePasswordVisibility()">
            👁️
          </span>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>
            <input type="checkbox" name="remember" id="rememberMe">
            <label for="rememberMe" class="form-label">Remember Me</label>
          </div>
          <div>
            <a href="forgot-password.php">Forgot Password?</a>
          </div>
        </div>
        <button class="btn btn-primary w-100" type="submit">Login</button>
      </form>

      <hr class="my-3">

      <button onclick="googleLogin()" class="btn btn-outline-danger w-100 mb-2">
        <img src="https://developers.google.com/identity/images/g-logo.png" width="20" class="me-2">
        Login with Google
      </button>

      <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
  </div>

  <script>
    // Dark Mode Persistence
    window.onload = function () {
      if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("bg-dark", "text-light");
      }
    };

    function toggleDarkMode() {
      const isDark = document.body.classList.toggle("bg-dark");
      document.body.classList.toggle("text-light");
      localStorage.setItem("darkMode", isDark ? "enabled" : "disabled");
    }

    // Login validation
    function validateLoginForm() {
      const email = document.forms["loginForm"]["email"].value.trim();
      const password = document.forms["loginForm"]["password"].value;
      if (!email || !password) {
        alert("All fields are required.");
        return false;
      }
      return true;
    }

    // Password visibility toggle
    function togglePasswordVisibility() {
      const field = document.getElementById("passwordField");
      field.type = field.type === "password" ? "text" : "password";
    }

    // Firebase Config (Replace with yours)
    const firebaseConfig = {
      apiKey: "YOUR_API_KEY",
      authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
      projectId: "YOUR_PROJECT_ID",
      appId: "YOUR_APP_ID"
    };
    firebase.initializeApp(firebaseConfig);

    // Google Login
    function googleLogin() {
      const provider = new firebase.auth.GoogleAuthProvider();
      firebase.auth().signInWithPopup(provider)
        .then(result => {
          // Example: send result.user info to PHP if needed
          window.location.href = "dashboard.php";
        })
        .catch(error => {
          alert("Google Sign-in failed: " + error.message);
        });
    }
  </script>

</body>
</html>
