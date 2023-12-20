const inputFieldsForValidation = [
    {id: "prefix", regex: /^([a-zA-Z0-9.'\- ]{1,25}|)$/, needValidation: true}, //Made it so that the prefix is either empty i.e. optional or matching the regex.
    {id: "first", regex: /^[a-zA-Z.]{1,25}$/, needValidation: true},
    {id: "last", regex: /^[a-zA-Z.]{1,25}$/, needValidation: true},
    {id: "hebrewName", regex: /^[a-zA-Z.]{1,100}$/, needValidation: true},
    {id: "notes", regex: /^([a-zA-Z0-9.'\- ]{1,100}|)$/, needValidation: true},
    {id: "relatedTo", regex: /^([a-zA-Z.'\- ]{1,100}|)$/, needValidation: true},
    {id: "source", regex: /^[a-zA-Z.'\-]{1,100}$/, needValidation: true},
    {id: "hebrew-hebrewDay", regex: /^(0[1-9]|[1-2][0-9]|3[0-1])$/, needValidation: true},
    {id: "combo-hebrewDay", regex: /^(0[1-9]|[1-2][0-9]|3[0-1])$/, needValidation: false}
]

setUpValidate() //TODO Validate hebrew month so that one is selected
//TODO cant allow future dates for english date
function setUpValidate() {
    inputFieldsForValidation.forEach(function (field) {
        let inputElement = document.getElementById(field.id)
        inputElement.addEventListener('change', event => {
            let inputValue = inputElement.value.trim()

            if (!field.needValidation || validateStringData(inputValue, field.regex)) {
                markAsValid(inputElement)
            } else {
                markAsInvalid(inputElement)
            }

        })

    })
    // Each Method needs an eventlistener on change to then set up a validiation. Validate Calendar, dropdown and afterSundown button
    //TODO validateHebrewYear()
    //TODO set up a validate for the english date box, the after sunset box and the month box. Essentially, if something was selected it should be green and valid
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

