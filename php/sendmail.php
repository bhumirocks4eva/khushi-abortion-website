phpinfo();
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $date = htmlspecialchars(trim($_POST["date"]));
    $age = htmlspecialchars(trim($_POST["age"]));
    $doctor = htmlspecialchars(trim($_POST["doctor"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Email address where you want to receive the appointment details
    $to = "adhikari.hilen@gmail.com"; // Replace with your email address
    $subject = "New Appointment Request";
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Create email body
    $body = "You have received a new appointment request.\n\n" .
            "Details:\n" .
            "Name: " . $name . "\n" .
            "Email: " . $email . "\n" .
            "Phone: " . $phone . "\n" .
            "Appointment Date: " . $date . "\n" .
            "Age: " . $age . "\n" .
            "Doctor: " . $doctor . "\n" .
            "Message: " . $message;

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "Appointment request sent successfully.";
    } else {
        echo "Failed to send appointment request.";
    }
} else {
    echo "Invalid request method.";
}
