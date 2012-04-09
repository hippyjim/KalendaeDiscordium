<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 07/04/12
 * Time: 01:14
 */

include('DiscDate.php');

/*$season = new Season(Season::CHAOS, 3178);
$startDay = $season->getStartDay();
$startDate = $season->getStartThudDate();
print_r($season);
print_r($startDate);*/

/*$discDate = DiscDate::createFromDisc(64, DiscDate::SEASON_CHAOS, 3178);
echo $discDate->getThudYear()."-".$discDate->getThudMonth()."-".$discDate->getThudDay();
$discDate = DiscDate::createFromFormat('Y-m-d', '2012-03-02');
echo "\n\n".$discDate->getThudYear()."-".$discDate->getThudMonth()."-".$discDate->getThudDay();
echo "\n".$discDate->getDiscDay() ." ".$discDate->getDiscSeason().", ".$discDate->getDiscYear();
echo "\n\n".$discDate->getDiscWeekDay();*/

/*for ($i = 0; $i <= 365; $i++) {
    $discDate = DiscDate::createFromFormat('z Y', $i.' 2011');
    echo "\n".$discDate->getThudYear()."-".$discDate->getThudMonth()."-".$discDate->getThudDay() . " = " . $discDate->getDiscWeekDay()." ".$discDate->getDiscDay() ." ".$discDate->getDiscSeason().", ".$discDate->getDiscYear();
}*/

/*for ($i = 0; $i <= 364; $i++) {
    $discDate = DiscDate::createFromFormat('z Y', $i.' 2012');
    echo "\n".$discDate->getThudYear()."-".$discDate->getThudMonth()."-".$discDate->getThudDay() . " = " . $discDate->getDiscWeekDay()." ".$discDate->getDiscDay() ." ".$discDate->getDiscSeason().", ".$discDate->getDiscYear();
}*/

/*$seasonNames = DiscDate::seasons();
$errors = array();
$calcThudYear = 1933;
for ($year = 3000; $year<=3200; $year++) {
    $seasonNum = 0;
    $day = 1;
    $prevOut = "";
    $calcThudYear++;

    for ($i = 0; $i <= 364; $i++) {
        $dateTime = DateTime::createFromFormat('z Y', $i.' '.$calcThudYear);

        $thudYear = $dateTime->format('Y');
        $thudMonth = $dateTime->format('m');
        $thudDay = $dateTime->format('d');
        $discDate = DiscDate::createFromDisc($day, $seasonNames[$seasonNum], $year);
        $outString = $discDate->getThudYear()."-".$discDate->getThudMonth()."-".$discDate->getThudDay() . " = " . $discDate->getDiscWeekDay()." ".$discDate->getDiscDay() ." ".$discDate->getDiscSeason().", ".$discDate->getDiscYear();
        if ($prevOut == $outString) {
            $errors[] = $outString;
        }
        echo "\n".$dateTime->format('Y-m-d')." = " . $outString;
        $prevOut = $outString;

        $day++;
        if ($day == 74) {
            $day = 1;
            $seasonNum++;
        }
    }
}*/



$discDate = DiscDate::createFromDisc(1, DiscDate::SEASON_CHAOS, 1167);
echo $discDate->format('Y-m-d H:i:s') . " = " . $discDate->getThudYear() ."-" . $discDate->getThudMonth() . "-" . $discDate->getThudDay() . "\n";

echo $discDate->getDiscDay()."  " .$discDate->getDiscSeason()." (" . $discDate->getDiscSeasonNum() . ")" . $discDate->getDiscYear();
echo "\n";
//print_r($discDate);
