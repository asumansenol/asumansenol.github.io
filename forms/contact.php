<?php
/**
 * Simple Contact Form Handler for CODEVIA
 * This version uses PHP's built-in mail() function
 */

// Validate that this is a POST request
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

// Receiving email address
$receiving_email_address = 'asumansenol@gmail.com';

// Get and sanitize form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Basic validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
}

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if (empty($subject)) {
    $errors[] = 'Subject is required';
}

if (empty($message)) {
    $errors[] = 'Message is required';
}

// If there are validation errors, return them
if (!empty($errors)) {
    http_response_code(400);
    echo implode(', ', $errors);
    exit;
}

// Prepare email
$email_subject = "Contact Form: " . $subject;
$email_body = "You have received a new message from the CODEVIA contact form.\n\n";
$email_body .= "Name: " . $name . "\n";
$email_body .= "Email: " . $email . "\n";
$email_body .= "Subject: " . $subject . "\n\n";
$email_body .= "Message:\n" . $message . "\n";

// Email headers
$headers = "From: " . $email . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Attempt to send email
if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
    echo 'OK';
} else {
    http_response_code(500);
    echo 'Failed to send message. Please try again later.';
}
?>
