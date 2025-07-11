<?php
session_start();
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $query = "SELECT * FROM employers WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $otp = rand(1000, 9999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        $subject = "Password Reset OTP";
        $message = "Your OTP to reset password is: " . $otp . " (donot share with anyone)";
        $headers = "From: noumanyt2003@gmail.com";

        if (mail($email, $subject, $message, $headers)) {
            header("Location: employer_verify_otp.html");
        } else {
            echo "Failed to send OTP.";
        }
    } else {
        echo "Email does not exist.";
    }
}
?>
