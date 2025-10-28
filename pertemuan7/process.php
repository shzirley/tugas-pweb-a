<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $message = trim($_POST['message']);

    if ($name == '' || $email == '' || $message == '') {
        echo "<span style='color:red;font-weight:bold;'>All fields are required.</span>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<span style='color:red;font-weight:bold;'>Provided email address is incorrect!</span>";
        exit;
    }

    echo "<span style='color:green;font-weight:bold;'>Thank you for contacting us, we will get back to you shortly.</span>";
}
?>
