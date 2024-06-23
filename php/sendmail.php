<?php
// Get the raw POST data
$postData = file_get_contents("php://input");
$request = json_decode($postData, true);

$name = $request['name'];
$email = $request['email'];
$phone = $request['phone'];
$age = $request['age'];
$doctor = $request['doctor'];
$date = $request['date'];
$message = $request['message'];

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

// Email details
$to = 'bhumirocks4eva@gmail.com';  // Replace with your email address
$subject = 'New appointment details';
$headers = "From: " . $email . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Email body
$body = "
    <html>
    <head>
        <title>$subject</title>
    </head>
    <body>
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Date:</strong> $date</p>
        <p><strong>Doctor:</strong> $doctor</p>
        <p><strong>Age:</strong> $age</p>
        <p><strong>Message:</strong><br>$message</p>
    </body>
    </html>
";

// Send email
if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send email.']);
}
?>

