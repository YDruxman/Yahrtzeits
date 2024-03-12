<?php

class ApiCalls{


    public static function getCurrentHebrewDateFromAPI(String $timezone): mixed
    {
        $curl = curl_init();
        date_default_timezone_set($timezone);


        // get Hebrew Year from API
        curl_setopt($curl, CURLOPT_URL, $apiUrl = "https://www.hebcal.com/converter?cfg=json&gy=" . date("Y") . "&gm=" . date("m") . "&gd=" . date("d") . "&g2h=1&strict=1");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        if (curl_errno($curl))
            echo 'Error:' . curl_error($curl);
        $response = curl_exec($curl);
        $HebrewDateFromAPI = json_decode($response, true);

        $currentHebrewYear = $HebrewDateFromAPI['hy'];
        curl_close($curl);
        return $currentHebrewYear;

    }

//(patterns, data) run for each loop with these details.

//Then have a user call the CheckAgainstCurrentHebYear

}

