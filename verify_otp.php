<?php
// verify_otp.php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];

    if ($otp == $_SESSION['otp']) {
        header("Location: reset_password.html");
    } else {
        echo "Invalid OTP.";
    }
}
?>
