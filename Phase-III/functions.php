<?php
// get semester and year of the date passed
function semester($date) {
    $month = intval($date->format('m'));
    $year = $date->format('Y');

    if ($month < 5) {
        return 'Winter '.$year;
    } elseif ($month < 9) {
        return 'Summer '.$year;
    } else {
        return 'Fall '.$year;
    }
    
}
?>