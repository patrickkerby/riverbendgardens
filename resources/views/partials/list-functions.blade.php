@php

//List of global variables
$pickup_weeks = get_post_meta(59432, '_bto_data', true); // This gets all the composite weeks by component ID! This is special.

function weekCheck($prevWeek, $nextWeek) {
    // Check current date, set select value to selected if current date is between week x and y.
    // Function arguments are supplied by ACF in Ymd format

    $currentDate = date('Ymd');
    $currentDate=date('Ymd', strtotime($currentDate));;

    var_dump( $currentDate );

    $weeklyDateBegin = date('Ymd', strtotime("$prevWeek"));
    $weeklyDateEnd = date('Ymd', strtotime("$nextWeek"));

    if (($currentDate > $weeklyDateBegin) && ($currentDate <= $weeklyDateEnd))
    {
    echo "selected";
    }
    else
    {
    //nothin
    }
}

// ------------------------- Get pickup dates for current year, set in Global Options -------------------------    
// TODO: see if these dates can be provided on composite product item _rather_ than global options.

$rows = get_field('pickup_dates','options' );

$week1_row = $rows[0];
$week1 = 'Week 1: ' . $week1_row['week'];

$week2_row = $rows[1];
$week2 = 'Week 2: ' . $week2_row['week'];

$week3_row = $rows[2];
$week3 = 'Week 3: ' . $week3_row['week'];

$week4_row = $rows[3];
$week4 = 'Week 4: ' . $week4_row['week'];

$week5_row = $rows[4];
$week5 = 'Week 5: ' . $week5_row['week'];

$week6_row = $rows[5];
$week6 = 'Week 6: ' . $week6_row['week'];

$week7_row = $rows[6];
$week7 = 'Week 7: ' . $week7_row['week'];

$week8_row = $rows[7];
$week8 = 'Week 8: ' . $week8_row['week'];

$week9_row = $rows[8];
$week9 = 'Week 9: ' . $week9_row['week'];

$week10_row = $rows[9];
$week10 = 'Week 10: ' . $week10_row['week'];

$week11_row = $rows[10];
$week11 = 'Week 11: ' . $week11_row['week'];

$week12_row = $rows[11];
$week12 = 'Week 12: ' . $week12_row['week'];

$week13_row = $rows[12];
$week13 = 'Week 13: ' . $week13_row['week'];

$week14_row = $rows[13];
$week14 = 'Week 14: ' . $week14_row['week'];

$week15_row = $rows[14];
$week15 = 'Week 15: ' . $week15_row['week']; 

@endphp
