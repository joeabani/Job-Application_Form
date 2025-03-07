<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $institution = $_POST['institution'];
    $completion_date = $_POST['completion_date'];
    $vision = $_POST['vision'];

    // Save data to database (Assuming you have a database connection)
    $conn = new mysqli("localhost", "root", "", "your_database_name");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO applicants (fullname, email, phone, address, gender, institution, completion_date, vision) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fullname, $email, $phone, $address, $gender, $institution, $completion_date, $vision);

    if ($stmt->execute()) {
        // Send confirmation email
        sendConfirmationEmail($email, $fullname);
        echo "Application submitted successfully. A confirmation email has been sent.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function sendConfirmationEmail($toEmail, $toName) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.mailgun.org'; // Mailgun SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'abanijoseph07@gmail.com'; // Replace with your Mailgun SMTP user
        $mail->Password = 'Chiji_7@joey'; // Replace with your Mailgun SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('noreply@yourdomain.com', 'Company Name');
        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);
        $mail->Subject = 'Application Received';
        $mail->Body    = "<h3>Hello $toName,</h3><p>Thank you for submitting your application. We will review it and get back to you soon.</p>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
?>
