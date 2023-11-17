const inputFields = [
    {id: "prefix", regex: /^[a-zA-Z.]{1,15}$/}, //TODO Should not be req
    {id: "first", regex: /^[a-zA-Z.]{1,25}$/},
    {id: "last", regex: /^[a-zA-Z.]{1,25}$/},
    {id: "hebrewName", regex: /^[a-zA-Z.]{1,100}$/},
    {id: "notes", regex: /^[a-zA-Z.'\- ]{1,100}$/}, //TODO Should allow number
    {id: "relatedTo", regex: /^[a-zA-Z.'\- ]{1,100}$/},
    {id: "source", regex: /^[a-zA-Z.'\- ]{1,100}$/},
    {id: "hebrew-hebrewDay", regex: /^(0[1-9]|[1-2][0-9]|3[0-1])$/},
    {id: "combo-hebrewDay", regex: /^(0[1-9]|[1-2][0-9]|3[0-1])$/}
    //TODO make dropdown for hebrew moth
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
    }) //Add event listeners to actually trigger the check. Best to have it on a 'click away'
    //validateHebrewYear()
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
    const currentYear = new Date().getFullYear()  // TODO Change to Hebrew year
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

setUpValidate()
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

        // TODO Only submit form if valid

        // Create a JSON object from the form data
        var formData = {};
        // Iterate over each input in the form
        form.querySelectorAll('input').forEach(function(input) {
            // Use input ID as key and input value as value

            console.log(formData[input.id] = input.value); //TODO filter out by appropriate radio button. Meaning that the radio buttons that are NOT selcted should ot be included in the Dict
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
                if (!response.ok) {
                    throw new Error("Didn't work");
                }

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
    });
});





