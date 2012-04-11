<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 07/04/12
 * Time: 01:14
 */

include('DiscDate.php');

$discDate = DiscDate::createFromDisc(12, DiscDate::SEASON_CHAOS, 1167);
echo $discDate->format('Y-m-d H:i:s') . " = " . $discDate->getThudYear() ."-" . $discDate->getThudMonth() . "-" . $discDate->getThudDay() . "\n";

echo $discDate->getHolyDay()." " . $discDate->getDiscDay(true)."  " .$discDate->getDiscSeason()." (" . $discDate->getDiscSeasonNum() . ")" . $discDate->getDiscYear();
echo "\n";
echo $discDate->format('E q, R, X');

