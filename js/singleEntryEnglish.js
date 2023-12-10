const inputFields = [
    {id: "prefix", regex: /^([a-zA-Z0-9.'\- ]{1,25}|)$/}, //Made it so that the prefix is either empty i.e. optional or matching the regex.
    {id: "first", regex: /^[a-zA-Z.]{1,25}$/},
    {id: "last", regex: /^[a-zA-Z.]{1,25}$/},
    {id: "hebrewName", regex: /^[a-zA-Z.]{1,100}$/},
    {id: "notes", regex: /^[a-zA-Z0-9.'\- ]{1,100}$/},
    {id: "relatedTo", regex: /^[a-zA-Z.'\- ]{1,100}$/},
    {id: "source", regex: /^[a-zA-Z.'\- ]{1,100}$/},
    {id: "hebrew-hebrewDay", regex: /^(0[1-9]|[1-2][0-9]|3[0-1])$/},
    {id: "combo-hebrewDay", regex: /^(0[1-9]|[1-2][0-9]|3[0-1])$/}

]

function setUpValidate() {
    inputFields.forEach(function (field) {
        let inputElement = document.getElementById(field.id)
        inputElement.addEventListener('change', event => {
            let inputValue = inputElement.value.trim()

            if (validateStringData(inputValue, field.regex)) {
                markAsValid(inputElement)
            } else {
                markAsInvalid(inputElement)
            }

        })

    })
    //TODO validateHebrewYear()
}

function validateStringData(inputElement, regex) {
    return regex.test(inputElement)

}

function markAsValid(inputElement) {
    inputElement.classList.add("is-valid")
    inputElement.classList.remove("is-invalid")
}

function markAsInvalid(inputElement) {
    inputElement.classList.remove("is-valid")
    inputElement.classList.add("is-invalid")
}

function validateHebrewYear() {
    const currentYear = new Date().getFullYear()  // TODO Change to get Hebrew year
    const inputYearElement = document.getElementById("hebrew-hebrewYear")
    const inputYearValue = inputYearElement.value.trim()
    const regex = /^(?:18|19|20)\d{2}$/
    inputYearElement.addEventListener('change', event => {
        if (regex.test(inputYearValue) && currentYear >= parseInt(inputYearValue, 10))
            markAsValid(inputYearElement)
        else
            markAsInvalid(inputYearElement)

    })


}

setUpValidate() //TODO Validate hebrew month so that one is selected
// Getting all the radio buttons
const dateOptionsRadios = document.querySelectorAll('input[name="dateOptions"]')

// Getting all the date options
const dateOptionsDivs = document.querySelectorAll('#hebrew-dateGroup, #english-dateGroup, #combo-dateGroup')

// Add an event listener to each radio button
dateOptionsRadios.forEach((radio) => {
    radio.addEventListener('change', function () {
        if (this.checked) {
            // When radio button changes, hide all date options
            dateOptionsDivs.forEach((div) => {
                div.classList.remove('d-flex')
                div.classList.add('d-none')
            })

            // Show the element that corresponds to the selected radio button
            const selectedOptionDiv = document.querySelector('#' + this.id.replace('Option', 'Group'))
            selectedOptionDiv.classList.remove('d-none')
            selectedOptionDiv.classList.add('d-flex')
        }
    })
})

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("yahrzeitForm");
    const resultDiv = document.getElementById("result");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission
        let isFormValid = true
        let needsRegexCheck = true //Avoids a unnecessary regex check and a marking of invalid to a tag that will already have it


        //When none of the inputs are typed in, they are not valid or invalid. But if a user tries submitting them as is, they should all be marked as invalid.
        inputFields.forEach(function (field) {
            let inputElement = document.getElementById(field.id)
            let inputValue = inputElement.value.trim()
            //Check if the field is already marked as invalid, or if it needs to be before submission (in the case where it wasn't modified at all by the user)
            if(inputElement.classList.contains("is-invalid")){
                isFormValid = false
                needsRegexCheck = false
            }
            if (needsRegexCheck && !validateStringData(inputValue, field.regex)) {
                markAsInvalid(inputElement)
                isFormValid = false
            }
            needsRegexCheck = true

        })
        //Prevent Form Submission
        if (!isFormValid) {
            resultDiv.textContent = "Please correct the errors before submitting.";
            resultDiv.style.display = 'block';
        } else {



        // TODO Only submit form if valid. THing to fix: The form by default when everything is empty is not valid or invalid- which is a problem. Even though it could be fixed by checking for valid vs looking for invalid, none the less when clicked and left empty the form should be red


        // Create a JSON object from the form data
        var formData = {};
        // Iterate over each input in the form
        form.querySelectorAll('input').forEach(function (input) {
            // Use input ID as key and input value as value

            console.log(formData[input.id] = input.value); //TODO filter out by appropriate radio button. Meaning that the radio buttons that are NOT selected should ot be included in the Dict
        });


        // const formDataObject = {};
        // formData.forEach(function (value, key) {
        //     formDataObject[key] = value;
        // });

        // Make a POST request to the PHP backend with the JSON data
        fetch("singleEntryResponse.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData),
        })
            .then(function (response) {
                if (!response.ok) {throw new Error("Didn't work");}
                return response.json()
            })
            .then(function (data) {
                // Handle the response from the backend
                resultDiv.textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                console.error("Error:", error);
                resultDiv.textContent = "An error occurred while submitting the form.";
            });
        }
    });

});





