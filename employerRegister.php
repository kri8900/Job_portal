<?php
session_start();
include("config.php");
error_log(print_r($_POST, true));

// OTP sending code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if it's an OTP sending request
    if (isset($_POST['email']) && isset($_POST['name']) && empty($_POST['otp'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $name = $conn->real_escape_string($_POST['name']);
        $otp = rand(1000, 9999);

        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;

        $subject = "OTP Verification";
        $message = "Hey $name, your OTP for verification on CarrierUP is $otp";
        $headers = "From: krishna8900kumar@gmail.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "OTP sent successfully";
        } else {
            $error = error_get_last();
            echo "Error sending OTP: " . ($error ? $error['message'] : "Unknown error");
        }
    } 
    // Check if it's an OTP verification request
    elseif (isset($_POST['otp']) && isset($_POST['email'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $enteredOtp = $_POST['otp'];

        if (isset($_SESSION['otp']) && isset($_SESSION['otp_email'])) {
            $storedOtp = $_SESSION['otp'];
            $storedEmail = $_SESSION['otp_email'];

            if ($email == $storedEmail && $enteredOtp == $storedOtp) {
                // Data entry code
                $dbname = 'Job_Portal';
                $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
                $conn->select_db($dbname);

                $conn->query("CREATE TABLE IF NOT EXISTS Employers (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    mobile VARCHAR(15) NOT NULL UNIQUE,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL
                )");

                // Initialize variables
                $name = $conn->real_escape_string($_POST['name'] ?? '');
                $mobile = $conn->real_escape_string($_POST['mobile'] ?? '');
                $email = $conn->real_escape_string($_POST['email'] ?? '');
                $password = $conn->real_escape_string($_POST['password'] ?? '');

                // Check if email already exists
                $stmt = $conn->prepare("SELECT * FROM Employers WHERE email = ?");
                if ($stmt) {
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Email already registered
                        echo "Email already registered!";
                    } else {
                        // Email not found, proceed with registration
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        $stmt = $conn->prepare("INSERT INTO Employers (name, mobile, email, password) VALUES (?, ?, ?, ?)");
                        if ($stmt) {
                            $stmt->bind_param("ssss", $name, $mobile, $email, $hashedPassword);

                            if ($stmt->execute()) {
                                echo "Registration successful!";
                                unset($_SESSION['otp']);
                                unset($_SESSION['otp_email']);
                            } else {
                                echo "Error executing statement: " . $stmt->error;
                            }

                            $stmt->close();
                        } else {
                            echo "Error preparing statement: " . $conn->error;
                        }
                    }
                } else {
                    echo "Error preparing statement: " . $conn->error;
                }
            } else {
                echo "Invalid OTP";
            }
        } else {
            echo "OTP not found in session";
        }
    } else {
        echo "Invalid request";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
