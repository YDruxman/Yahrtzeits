const submissionFields = [
    {id: "prefix"},
    {id: "first"},
    {id: "last"},
    {id: "hebrewName"},
    {id: "notes"},
    {id: "relatedTo"},
    {id: "source"}
];
let hebMonth;
let hebDay;
let hebYear;
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
    hebDay = hebrewDateParts[0];
    hebMonth = hebrewDateParts[1];
    hebYear = hebrewDateParts[2];
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

            if(currentSelectedRadio === 'hebrew-dateOption'){
                hebMonth = document.getElementById("hebrew-hebrewMonth")
                hebDay = document.getElementById("hebrew-hebrewDay")
                hebMonth = document.getElementById("hebrew-hebrewYear")
            }

            else if (currentSelectedRadio === 'english-dateOption') {
                GetHebDateFromEngDate();
            }
            else if(currentSelectedRadio === 'english-dateOption'){
                console.log("Finish this calc") //TODO Fin
            }
            // Create a JSON object from the form data
            let formData = {};


            submissionFields.forEach(function (field) {
                formData[field.id] = document.getElementById(field.id)
            });
            formData["Hebrew Month"] = hebMonth
            formData["Hebrew Day"] = hebDay
            formData["Hebrew Year"] = hebYear

            console.log(formData)



            // Make a POST request to the PHP backend with the JSON data
            fetch("singleEntryResponse.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(formData),
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error("Didn't work");
                    }
                    return response.json()
                })
                .then(function (data) {
                    // Handle the response from the backend
                    resultDiv.textContent = JSON.stringify(data, null, 2); //TODO Modify JSON Data so that it does not look JSONy
                })
                .catch(error => {
                    console.error("Error:", error);
                    resultDiv.textContent = "An error occurred while submitting the form.";
                });
        }
    });

});




