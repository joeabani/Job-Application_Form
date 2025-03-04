<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    // Acknowledgment Message
    $message = "Dear $fullname,\n\nThank you for submitting your application. We have received your details successfully.\n\nBest regards,\nYour Company Name";

    // Send Email Notification  
    $to = $email;
    $subject = "Application Received";
    $headers = "From: no-reply@yourcompany.com\r\n";
    $headers .= "Reply-To: support@yourcompany.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Redirect to thank you page if email is sent successfully
        header("Location: thank-you.html");
        exit();
    } else {
        echo "Error sending email. Please try again.";
    }
}
?>
