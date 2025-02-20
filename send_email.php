<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "portfolio");
$message = ""; // Initialize message variable

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Handle Registration
if (isset($_POST['register'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phno = $_POST['message'];

    // Insert data if email and phone number do not exist
    $sql = "INSERT INTO user (name, email, message) VALUES ('$username', '$email', '$phno')";
    if (mysqli_query($con, $sql)) {
        // Send Confirmation Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'basavacharan85900@gmail.com'; // Your Gmail address
            $mail->Password = 'pghpuedzqdpzfgbf'; // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
            $mail->Port = 587; // TCP port to connect to

            // Set sender and recipient
            $mail->setFrom('basavacharan85900@gmail.com', 'Your Name'); // Replace with your name
            $mail->addAddress($email, $username); // Add recipient email

            // Email content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Query from the portfolio';
            $mail->Body    = "Candidate details are:<br>Candidate name: $username<br>Email: $email<br>Message: $phno";

            // Send email
            $mail->send();
            $message = "Successfully email sent.";
        } catch (Exception $e) {
            $message = "Failed to send confirmation email: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Error in sending the email!";
    }
}

// Output the message as an alert and redirect
if ($message) {
    echo '<script>alert("' . addslashes($message) . '"); window.location.href = "index.html";</script>'; // Change 'your-page.php' to your current page URL
}
?>
