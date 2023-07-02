<?php

// an email address that will be in the From field of the email.
$from = $_POST["email"];

// an email address that will receive the email with the output of the form
// change this email address to test the email sender 
// if you cannot find the email check your spam folder
$sendTo = 'mp.detailing.ltd@gmail.com';

// subject of the email
$subject = $_POST["subject"];

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'email' => 'Email', 'subject' => 'Subject', 'message' => 'Message'); 

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted.';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(0);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "You have a new message from your contact form\n\r";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // All the neccessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
    
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {

    header( 'Location: ../../index.html' ) ;
}