<?php
session_start();
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {
        $email = $_SESSION['email'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE employers SET password='$hashed_password' WHERE email='$email'";
        if (mysqli_query($conn, $query)) {
            echo "Password reset successfully.";
            session_unset();
            session_destroy();
            header("Location: employerLogin.html");
            exit(); 
        } else {
            echo "Failed to reset password.";
        }
    } else {
        echo "Passwords do not match.";
    }
}
?>
