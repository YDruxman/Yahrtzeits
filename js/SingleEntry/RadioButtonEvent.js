// Getting all the radio buttons
const dateOptions = document.querySelectorAll('input[name="dateOptions"]')

// Getting all the date options
const dateGroups = document.querySelectorAll('#hebrew-dateGroup, #english-dateGroup, #combo-dateGroup')

let currentSelectedRadio = 'hebrew-dateOption'

// Add an event listener to each radio button

dateOptions.forEach((radio) => {
    radio.addEventListener('change', event => {
        const radioButton = event.target
        
            // Hide all date groups
            dateGroups.forEach(hideElement)

            // Show the group that corresponds to the selected radio button
            const selectedOptionDiv = document.querySelector('#' + radioButton.id.replace('Option', 'Group'))
            showElement(selectedOptionDiv)

            switch (radioButton.id) {
                case 'hebrew-dateOption':
                    // Perform action specific to Hebrew Date radio button
                    currentSelectedRadio = radioButton.id;
                    inputFieldsForValidation[8].needValidation = false;
                    inputFieldsForValidation[7].needValidation = true;
                    break;
                case 'english-dateOption':
                    // Perform action specific to English Date radio button
                    currentSelectedRadio = radioButton.id;
                    inputFieldsForValidation[8].needValidation = false;
                    inputFieldsForValidation[7].needValidation = false;
                    break;
                case 'combo-dateOption':
                    // Perform action specific to Combo Date radio button
                    currentSelectedRadio = radioButton.id;
                    inputFieldsForValidation[8].needValidation = true;
                    inputFieldsForValidation[7].needValidation = false;
                    break;
            }
        }
    )
})

function hideElement(div) {
    div.classList.remove('d-flex')
    div.classList.add('d-none')
}

function showElement(div) {
    div.classList.remove('d-none')
    div.classList.add('d-flex')
}

