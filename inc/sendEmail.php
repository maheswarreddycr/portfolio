<?php

$siteOwnersEmail = 'maheswarreddysai@gmail.com';

if ($_POST) {
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    $error = [];

    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please enter a valid email address.";
    }

    if (strlen($contact_message) < 15) {
        $error['message'] = "Your message must be at least 15 characters.";
    }

    if ($subject == '') { 
        $subject = "Contact Form Submission"; 
    }

    $message = "Email from: " . htmlspecialchars($name) . "<br />";
    $message .= "Email address: " . htmlspecialchars($email) . "<br />";
    $message .= "Message: <br />";
    $message .= nl2br(htmlspecialchars($contact_message));
    $message .= "<br /> ----- <br /> This email was sent from your site's contact form.";

    $headers = "From: " . $siteOwnersEmail . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (empty($error)) {
        ini_set("sendmail_from", $siteOwnersEmail);
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) { 
            echo "OK"; 
        } else { 
            echo "Something went wrong. Please try again."; 
        }
        
    } else {
        echo implode("<br>", $error);
    }
}
?>