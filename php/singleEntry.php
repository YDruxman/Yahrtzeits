
<!DOCTYPE html>
<html data-bs-theme="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Yahrtzeit Calendar Event Creator</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" rel="stylesheet">
    <link href="../css/MultipleEntries.css" rel="stylesheet" type="text/css">
    <!--    <link rel="stylesheet" type="text/css" href="bootstrap.css">-->
</head>
<body class="vh-100">
<main class="text-center d-flex flex-column justify-content-center h-100">
    <h1 class="text-decoration-underline mb-5">Yahrzeit Calendar Event Creator</h1>
    <form class="mx-auto w-75 needs-validation" id="yahrzeitForm" novalidate>
        <!-- English Name -->
        <div class="form-group mb-4">
            <div class="input-group flex-wrap">
                <span class="input-group-text">English Name</span>
                <input aria-label="Prefix" class="form-control" id="prefix" placeholder="Prefix" type="text">
                <input aria-label="First Name" class="form-control" id="first" placeholder="First"
                       type="text" required>
                <input aria-label="Last Name" class="form-control" id="last" placeholder="Last" type="text">
            </div>
        </div>
        <!-- Hebrew Name -->
        <div class="form-group mb-4 mx-auto">
            <div class="input-group">
                <span class="input-group-text">Hebrew Name</span>
                <input aria-label="Hebrew Name" class="form-control" id="hebrewName" placeholder="Hebrew Name"
                       style="flex-grow: 4;" type="text">
            </div>
        </div>
        <!-- Notes -->
        <div class="form-group mb-4 mx-auto">
            <div class="input-group">
                <span class="input-group-text">Notes</span>
                <input aria-label="Notes" class="form-control" id="notes" placeholder="Notes"
                       style="flex-grow: 4;" type="text">
            </div>
        </div>
        <div class="d-flex flex-row flex-wrap column-gap-5 row-gap-4 mb-4">
            <!-- Related To -->
            <div class="form-group flex-grow-1 " id="relatedToContainer">
                <div class="input-group">
                    <span class="input-group-text">Related To</span>
                    <input aria-label="Related To" class="form-control" id="relatedTo" placeholder="Related To"
                           type="text">
                </div>
            </div>
            <!-- Source -->
            <div class="form-group flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text">Source</span>
                    <input aria-label="Source" class="form-control" id="source" placeholder="Source" type="text">
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-4 mx-auto my-3 w-100 mt-4">
            <input type="radio" class="btn-check" name="dateOptions" id="hebrew-dateOption" autocomplete="off"
                   checked>
            <label class="btn btn-outline-primary" for="hebrew-dateOption">Hebrew Date</label>

            <input type="radio" class="btn-check" name="dateOptions" id="english-dateOption" autocomplete="off">
            <label class="btn btn-outline-primary" for="english-dateOption">English Date</label>

            <input type="radio" class="btn-check" name="dateOptions" id="combo-dateOption" autocomplete="off">
            <label class="btn btn-outline-primary" for="combo-dateOption">Combo Date</label>
        </div>

        <!-- Hebrew Date -->
        <div class="d-flex flex-row flex-wrap justify-content-around gap-4" id="hebrew-dateGroup">
            <div class="form-group mx-auto">
                <div class="input-group">
                    <div class="input-group-text">Hebrew Month</div>
                    <select id="hebrew-hebrewMonth" class="form-control" aria-label="Server">
                        <option selected>Choose a month...</option>
                        <option value="1">Nisan</option>
                        <option value="2">Iyar</option>
                        <option value="3">Sivan</option>
                        <option value="4">Tammuz</option>
                        <option value="5">Av</option>
                        <option value="6">Elul</option>
                        <option value="7">Tishrei</option>
                        <option value="8">Cheshvan</option>
                        <option value="9">Kislev</option>
                        <option value="10">Tevet</option>
                        <option value="11">Shevat</option>
                        <option value="12">Adar</option>
                        <option value="12">AdarII</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text">Hebrew Day</div>
                    <input type="text" id="hebrew-hebrewDay" class="form-control" placeholder="##"
                           aria-label="Username">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text">Hebrew Year</div>
                    <input type="text" id="hebrew-hebrewYear" class="form-control" placeholder="####"
                           aria-label="Username">
                </div>
            </div>
        </div>

        <!-- English Date -->
        <div class="d-flex flex-row flex-wrap d-none justify-content-around gap-4" id="english-dateGroup">
            <!-- Date -->
            <div class="form-group mx-auto">
                <div class="input-group">
                    <label class="input-group-text" for="english-date">English Date</label>
                    <input class="form-control" id="english-date" required type="date">
                </div>
            </div>
            <!-- After Sunset-->
            <div class="form-group mx-auto">
                <div class="input-group">
                    <span class="input-group-text">After Sunset</span>
                    <!-- After Sunset -->
                    <div class="input-group-text">
                        <input aria-label="After Sunset" class="form-check-input mt-0" name="afterSunset"
                               type="radio"
                               value="true">
                        <label class="mx-2">Yes</label>
                    </div>
                    <!-- Before Sunset -->
                    <div class="input-group-text">
                        <input aria-label="Before Sunset" checked class="form-check-input mt-0" name="afterSunset"
                               type="radio"
                               value="false">
                        <label class="mx-2">No</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combo -->
        <div class="d-flex flex-row flex-wrap d-none justify-content-around gap-4" id="combo-dateGroup">
            <div class="form-group mx-auto">
                <div class="input-group">
                    <div class="input-group-text">Hebrew Month</div>
                    <select id="combo-hebrewMonth" class="form-control" aria-label="Server">
                        <option selected>Choose a month...</option>
                        <option value="1">Nisan</option>
                        <option value="2">Iyar</option>
                        <option value="3">Sivan</option>
                        <option value="4">Tammuz</option>
                        <option value="5">Av</option>
                        <option value="6">Elul</option>
                        <option value="7">Tishrei</option>
                        <option value="8">Cheshvan</option>
                        <option value="9">Kislev</option>
                        <option value="10">Tevet</option>
                        <option value="11">Shevat</option>
                        <option value="12">Adar</option>
                        <option value="12">AdarII</option>
                    </select>
                </div>
            </div>


            <div class="form-group mx-auto">
                <div class="input-group">
                    <div class="input-group-text">Hebrew Day</div>
                    <input type="text" id="combo-hebrewDay" class="form-control" placeholder="##" aria-label="Username">
                </div>
            </div>

            <div class="form-group mx-auto">
                <div class="input-group">
                    <label class="input-group-text" for="combo-date">English Date</label>
                    <input class="form-control" id="combo-date" required type="date">
                </div>
            </div>
        </div>
        <div id="result"></div>
        <!-- Submit/Restart -->
        <div class="vstack gap-2 col-4 mx-auto mt-5">
            <button class="btn btn-primary" type="submit">Submit</button>
            <button class="btn btn-secondary" type="reset">Reset</button>  <!-- Needs to clear validation -->
        </div>
    </form>

    <a href="../html/ContactUs.html" class="btn btn-link mt-3"  >Contact Us</a>
</main>
<script crossorigin="anonymous"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/HebCal.js"></script>
<script src="../js/SingleEntry/singleEntrySubmission.js"></script>
<script src="../js/SingleEntry/SingleEntryValidation.js"></script>
<script src="../js/SingleEntry/RadioButtonEvent.js"></script>

</body>
</html>
