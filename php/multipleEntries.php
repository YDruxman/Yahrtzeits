<?php
    session_start();
    //if (!isset($_SESSION['code'])) header("Location: unauthorized.php?redirect=fromMulti");
?>
<!DOCTYPE html>
<html data-bs-theme="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Yahrzeit Calendar Event Creator</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" rel="stylesheet">
    <link href="../css/MultipleEntries.css" rel="stylesheet" type="text/css">
</head>
<body class="vh-100 overflow-x-auto">
<main class="text-center d-flex flex-column justify-content-center h-100">
    <!-- Title -->
    <h1 class="text-decoration-underline mt-5 mb-5">Yahrzeit Calendar Event Creator</h1>
    <form class="mx-auto w-75 needs-validation" id="yahrzeitForm" novalidate>
        <!-- File Input -->
        <div class="mb-4">
            <label class="fs-4 form-label" for="csvFileInput">CSV of New Yahrzeits</label>
            <input accept=".csv" class="form-control form-control-lg" id="csvFileInput" required type="file">
            <div class="invalid-feedback">
                Please choose a CSV file.
            </div>
        </div>
        <!-- Progress Bar -->
        <div class="progress-stacked d-none w-75 mb-4 mx-auto">
            <div aria-label="Segment one" aria-valuemax="0" aria-valuemin="0" aria-valuenow="0" class="progress"
                 role="progressbar">
                <div class="progress-bar progress-bar-striped progress-bar-animated"></div>
            </div>
            <div aria-label="Segment two" aria-valuemax="0" aria-valuemin="0" aria-valuenow="0" class="progress"
                 role="progressbar">
                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated"></div>
            </div>
        </div>
        <!-- Submit/Restart -->
        <button class="btn btn-lg btn-primary" type="submit">Submit</button>
    </form>
    <!-- Messages are put here dynamically -->
    <div class="container mt-5 h-50 overflow-x-auto" id="msgPanel"></div>
</main>
<script crossorigin="anonymous"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.0/papaparse.min.js"></script>
<script src="../js/multipleEntries.js"></script>
</body>
</html>
