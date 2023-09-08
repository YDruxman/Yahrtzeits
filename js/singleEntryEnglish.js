// Getting all the radio buttons
const dateOptionsRadios = document.querySelectorAll('input[name="dateOptions"]');

// Getting all the date options
const dateOptionsDivs = document.querySelectorAll('#hebrew-dateGroup, #english-dateGroup, #combo-dateGroup');

// Add an event listener to each radio button
dateOptionsRadios.forEach((radio) => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            // When radio button changes, hide all date options
            dateOptionsDivs.forEach((div) => {
                div.classList.remove('d-flex');
                div.classList.add('d-none');
            });

            // Show the element that corresponds to the selected radio button
            const selectedOptionDiv = document.querySelector('#' + this.id.replace('Option', 'Group'));
            selectedOptionDiv.classList.remove('d-none');
            selectedOptionDiv.classList.add('d-flex');
        }
    });
});