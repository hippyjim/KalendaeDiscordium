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

$discDate = DiscDate::createFromDisc(64, DiscDate::SEASON_CHAOS, 3178);
echo $discDate->getThudYear()."-".$discDate->getThudMonth()."-".$discDate->getThudDay();
$discDate = DiscDate::createFromFormat('Y-m-d', '2012-03-05');
echo "\n\n".$discDate->getThudYear()."-".$discDate->getThudMonth()."-".$discDate->getThudDay();
echo "\n".$discDate->getDiscDay() ." ".$discDate->getDiscSeason().", ".$discDate->getDiscYear();
echo "\n\n".$discDate->getDiscWeekDay();
