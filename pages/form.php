<?php
// Start a session for CSRF protection
session_start();

// Generate a CSRF token if one does not exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Check for CSRF token match
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token");
    }

    // Sanitize and validate form inputs
    $vname = trim($_POST['vname'] ?? '');
    $vemail = filter_var(trim($_POST['vemail'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST['sub'] ?? '');
    $message = trim($_POST['msg'] ?? '');

    // Check for blank fields
    if (empty($vname) || empty($vemail) || empty($subject) || empty($message)) {
        echo "Please fill in all required fields.";
    } else {
        // Validate email
        if (!filter_var($vemail, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
        } else {
            // Prepare email headers
            $headers = "From: $vemail\r\n";
            $headers .= "Reply-To: $vemail\r\n";
            $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

            // Word-wrap the message to 70 characters as per PHP mail() requirement
            $message = wordwrap($message, 70);

            // Send the email
            $mail_sent = mail("andersbandt@yahoo.com", $subject, $message, $headers);

            if ($mail_sent) {
                echo "Your message has been sent successfully! Thank you for your feedback.";
            } else {
                echo "There was an error sending your message. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FlavoWorks Contact Form</title>
  <link rel="stylesheet" href="stylesheet.css">
  <link rel="icon" href="favicon.ico">
</head>

<body>

<div id="heading">
  <h1>FlavoWorks</h1>
</div>

<div id="cssmenu">
  <ul id="navbar">
    <li><a href="index.html">Home</a></li>
    <li><a href="projects.html">Personal Projects</a></li>
    <li><a href="programs.html">Programs</a></li>
    <li><a href="server.html">Server Access</a></li>
    <li><a href="about-me.html">About Me</a></li>
  </ul>
</div>

<h3>Contact Information</h3>

<div id="bodytext">
  <p>Please use this form to contact me</p>
</div>

<!-- Feedback Form -->
<form action="form.php" id="form" method="post" name="form">
  <!-- CSRF token for protection -->
  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

  <input name="vname" placeholder="Your Name" type="text" value="<?php echo htmlspecialchars($vname ?? '', ENT_QUOTES); ?>">
  <br>
  <input name="vemail" placeholder="Your Email" type="email" value="<?php echo htmlspecialchars($vemail ?? '', ENT_QUOTES); ?>">
  <br>
  <input name="sub" placeholder="Subject" type="text" value="<?php echo htmlspecialchars($subject ?? '', ENT_QUOTES); ?>">
  <br>
  <label>Your Suggestion/Feedback</label>
  <textarea name="msg" placeholder="Type your text here..."><?php echo htmlspecialchars($message ?? '', ENT_QUOTES); ?></textarea>
  <br>
  <input id="send" name="submit" type="submit" value="Send Feedback">
</form>

<h3><?php include "secure_email_code.php"; ?></h3>

<div id="footer">
  <p>Last Updated - January 2021 <a href="form.php">Contact Me</a> by Anders Bandt</p>
</div>

</body>
</html>
