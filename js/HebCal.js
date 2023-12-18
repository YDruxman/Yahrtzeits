class HebCal {






    /**
     * Uses hebcal.com to retrieve the yahrzeits for the given person based on the given information
     * @param p Person whose yahrzeits are to be retrieved.
     * Required fields (taken as is):
     * - fullName
     * - occasion ("Yahrzeit", "Birthday", "Anniversary")
     * - day (English)
     * - month (English)
     * - year (English)
     * - afterSunset (boolean)
     * @param startYear The first hebrew year to get the yahrzeits (inclusive)
     * @param years The number of years to get (default is 50)
     * @returns {Promise<Response>} The hebcal.com response of all the yahrzeits requested
     */


    // Retrieves data from hebcal.com with the given subdirectory and body
    async testTheData() {
        let myHebCal = new HebCal();
        let first = await myHebCal.testTheDate()

        console.log(first)

    }

    async generateHebrewDate(day, month, year, afterSun) {

        const query = `n1=Ploni Almoni&t1=Yahrzeit&d1=${day}&m1=${month}&y1=${year}&s1=${afterSun}`
        return this.#requestData('yahrzeit', 'cfg=json&g2h=1' + query)

    }

    #requestData(subdirectory, body) {
        this.delay += 75
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                fetch("https://www.hebcal.com/" + subdirectory, {
                    method: 'POST', headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }, body: body
                })
                    .then(response => {
                        // Handle the response here
                        if (response.ok) {
                            return response.json()
                        } else {
                            throw new Error(`Error while retrieving yahrzeits: ${response}`)
                        }
                    })
                    .then(data => {
                        // Handle the parsed response data here
                        console.log("Success!")
                        resolve(data)
                    })
                    .catch(error => {
                        // Handle any errors that occurred during the request
                        console.error(error)
                        reject(error)
                    })
            }, this.delay)
        })
    }

    /**
     * Queries hebcal.com for the next 100 English dates for the given person
     * @param person Person whose yahrzeits are to be gotten
     * @param progress The object to update the progress
     * @returns {Promise<Response>} The person with a new property 'yarzeits'
     */


    /* 2023-06-05T01:25:52.128Z */



}

// let myHebCal = new HebCal();
// myHebCal.testTheData() .then(() => console.log("Test completed"))
//     .catch(error => console.error(error));
