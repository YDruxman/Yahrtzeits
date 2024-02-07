<!DOCTYPE html>
<html data-bs-theme="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Contact Us</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" rel="stylesheet">
    <!-- Add any additional CSS files here -->
</head>
<body class="vh-100">
<main class="text-center d-flex flex-column justify-content-center h-100">

    <?php

    if(isset($_GET["error"])) {
        if ($_GET["error"] == "emptyFields") {
            echo "<div class=\"alert alert-danger text-center\"><p> Fill in all fields. </p></div>";
        }
        if ($_GET["error"] == "invalidEmail") {
            echo "<div class=\"alert alert-danger text-center\"><p> Please enter a valid email. </p></div>";
        }
        if ($_GET["error"] == "mailNotSent") {
            echo "<div class=\"alert alert-danger text-center\"><p> There was an issue sending your message! Try again. </p></div>";
        }
        if ($_GET["error"] == "mailSent") {
            echo "<div class=\"alert alert-success text-center\"><p> Message Sent. </p></div>";
        }
    }
    ?>

    <h1 class="text-decoration-underline mb-5">Contact Us</h1>
    <form class="mx-auto w-75" action="ProcessEmail.php" method="POST">
        <!-- Name Input -->
        <div class="mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
        </div>
        <!-- Email Input -->
        <div class="mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
        </div>
        <!-- Message Textarea -->
        <div class="mb-3">
            <textarea class="form-control" id="message" name = message rows="3" placeholder="Your Message"></textarea>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</main>
<script crossorigin="anonymous"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add any additional JS files here -->
</body>
</html>



