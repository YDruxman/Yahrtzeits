const submissionFields = [{id: "prefix"}, {id: "first"}, {id: "last"}, {id: "hebrewName"}, {id: "notes"}, {id: "relatedTo"}, {id: "source"}];
let hebYear;
let hebMonth;
let hebDay;

const resultDiv = document.getElementById("result");


//Perhaps this  pre submission validation can be majorly simplified by introducing an empty tag to the ID instead of just valid and invalid
function PreSubmissionValidation() {
    let isFormValid = true
    let needsRegexCheck = true //Avoids an unnecessary regex check and a marking of invalid to a tag that will already have it from the prev validation check


    //When none of the inputs are typed in, they are not valid or invalid. But if a user tries submitting them as is, they should all be marked as invalid.
    inputFieldsForValidation.forEach(function (field) {
        //A field 'needs Validation' when it is visible on the screen aka its button is pressed. The text boxes that are not visible do not get checked at all and thus do not stop the form from being submitted.
        if (field.needValidation) { //See the line 89 to see when a field's need validation will be set to false.
            let inputElement = document.getElementById(field.id)
            let inputValue = inputElement.value.trim()
            //Check if the field is already marked as invalid, or if it needs to be before submission (in the case where it wasn't modified at all by the user)
            if (inputElement.classList.contains("is-invalid")) {
                isFormValid = false
                needsRegexCheck = false
            }
            if (needsRegexCheck && !validateStringData(inputValue, field.regex)) {
                markAsInvalid(inputElement)
                isFormValid = false
            }
            needsRegexCheck = true
        }
    })
    return isFormValid;
}

async function getHebrewDateFromAPI(day, month, year) {
    let response = await myHebCal.generateHebrewDate(day, month, year)
    return response.items[0].hdate //ignore this warning
}

function GetHebDateFromEngDate(resultDiv) {
    let hebrewDate;
    let dateValue = document.getElementById('english-date').value;
    //let afterSunBool = document.getElementById('').value;

    // Split the date into year, month, and day
    let dateParts = dateValue.split('-');
    let day = dateParts[2];
    let month = dateParts[1];
    let year = dateParts[0];
    getHebrewDateFromAPI(day, month, year, true)//TODO this true needs tobe replaced with the actual user input
        .then(hdate => {
            hebrewDate = hdate
            console.log("Got the Hebrew Date using the API: " + hdate)
            resultDiv.textContent = "Hebrew Date: " + hebrewDate;
        })
        .catch(error => {
            console.error(error);
            resultDiv.textContent = "There was an issue getting the Hebrew Date";
        });
    let hebrewDateParts = hebrewDate.split(" ");
    hebYear = hebrewDateParts[2];
    hebMonth = hebrewDateParts[1];
    hebDay = hebrewDateParts[0];
}

async function fetchSingleEntryResponse(formData) {
    const response = await fetch("singleEntryResponse.php", {
        method: "POST", headers: {
            "Content-Type": "application/json",
        }, body: JSON.stringify(formData),
    })
    if (!response.ok) {
        throw new Error(await response.text()); //Allows the error to be shown as text vs trying to force in into a JSON which will result in an ambiguous syntax error
    }
    return await response.json();
}


async function doA (formData) {
    try {

        console.log("Inside doA() before the await")
        const data = await fetchSingleEntryResponse(formData);
        console.log("Inside doA() after the await")
        resultDiv.textContent = JSON.stringify(data, null, 2); //TODO Modify JSON Data so that it does not look JSONy
    } catch (error) {
        console.error("Error:", error);
        resultDiv.textContent = "An error occurred while submitting the form.";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const myHebCal = new HebCal()
    const form = document.getElementById("yahrzeitForm");
    form.addEventListener("submit", function (event) {

        event.preventDefault(); // Prevent the default form submission
        let isFormValid = PreSubmissionValidation();

        //Prevent Form Submission
        if (!isFormValid) {
            resultDiv.textContent = "Please correct the errors before submitting.";
            resultDiv.style.display = 'block';
        } else {
            //At this point the submit button has been pressed and ALL the boxes have been validated.

            if (currentSelectedRadio === 'hebrew-dateOption') {
                hebYear = document.getElementById("hebrew-hebrewYear").value
                hebMonth = document.getElementById("hebrew-hebrewMonth").value
                hebDay = document.getElementById("hebrew-hebrewDay").value

            } else if (currentSelectedRadio === 'english-dateOption') {
                GetHebDateFromEngDate();
            } else if (currentSelectedRadio === 'english-dateOption') {
                console.log("Finish this calc") //TODO Fin
            }
            // Create a JSON object from the form data
            let formData = {};

            submissionFields.forEach(function (field) {
                let element = document.getElementById(field.id);
                formData[field.id] = element.value;
            });
            formData["hebrewYear"] = hebYear
            formData["hebrewMonth"] = hebMonth
            formData["hebrewDay"] = hebDay

            console.log(formData)
            console.log(JSON.stringify(formData))
            // Make a POST request to the PHP backend with the JSON data
            void doA(formData);
            // a

            console.log("after doA")
        //     ///
        }
    });

});