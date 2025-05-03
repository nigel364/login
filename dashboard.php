<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
<a href="auth/logout.php">Logout</a>
