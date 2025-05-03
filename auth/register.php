<?php
require '../config/db.php';

// Get and sanitize form input
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$phone = trim($_POST['phone']);
$countryCode = trim($_POST['countryCode']);
$gender = $_POST['gender'];

// Handle profile picture upload
$targetDir = "../uploads/profile_pics/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$profilePicName = basename($_FILES["profilePicture"]["name"]);
$targetFile = $targetDir . time() . "_" . $profilePicName;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

if (!in_array($imageFileType, $allowedTypes)) {
    die("Invalid image type. Only JPG, JPEG, PNG & GIF files are allowed.");
}

if (!move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
    die("Failed to upload profile picture.");
}

// Store relative path to DB
$profilePicturePath = str_replace("../", "", $targetFile);

// Prepare and execute insert statement
$sql = "INSERT INTO users (name, email, password, phone, country_code, gender, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $email, $password, $phone, $countryCode, $gender, $profilePicturePath);

if ($stmt->execute()) {
    header("Location: ../index.php?success=registered");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
