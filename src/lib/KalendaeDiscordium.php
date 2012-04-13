<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippyjim
 * Date: 04/04/12 / 21st Discord, YOLD 3178
 * Time: 23:47
 */

include_once('DiscDate.php');

/**
 * Helper class for DiscDate
 */
class KalendaeDiscordium {

    /**
     * Produces the HTML for a day picker select
     *
     * @static
     * @param $name
     * @param $id
     * @param $selected
     * @param bool $isThud [optional] set to true if it's thuddite so it stops at 31, otherwise it goes to 73
     * @return string
     */
    public static function dayPicker($name, $id, $selected, $isThud = FALSE) {
        $numDays = 73;
        if ($isThud) {
            $numDays = 31;
        }
        $outString = "<select id=\"{$id}\" name=\"{$name}\">";
        for ($day = 1; $day <= $numDays; $day++) {
            if ($day == 60) {
                $selected = ($selected == "St Tib's Day") ? " selected " : "";
                $outString.= "<option {$selected} value=\"St Tib's Day\">St Tib's</option>";
            }
            $isSelected = ($selected == $day) ? " selected " : "";
            $outString.= "<option {$isSelected} value=\"" . str_pad($day, 2, "0", STR_PAD_LEFT). "\">" . DiscDate::addOrdinal($day) . "</option>";
        }
        $outString.="</select>";
        return $outString;
    }

    /**
     * Produces the HTML for a month picker select
     *
     * @static
     * @param $name
     * @param $id
     * @param $selected
     * @return string
     */
    public static function monthPicker($name, $id, $selected) {
        $outString = "<select id=\"{$id}\" name=\"{$name}\">";
        for($monthNum = 1; $monthNum <= 12; $monthNum++) {
            $monthName = date('F', strtotime('2000-' . str_pad($monthNum, 2, "0", STR_PAD_LEFT) ."-1"));
            $isSelected = ($selected == $monthName) ? " selected " : "";
            $outString.= "<option {$isSelected} value=\"{$monthName}\">{$monthName}</option>";
        }

        $outString.= "</select>";
        return $outString;
    }

    /**
     * Produces the HTML for a season picker select
     *
     * @static
     * @param $name
     * @param $id
     * @param $selected
     * @return string
     */
    public static function seasonPicker($name, $id, $selected) {
        $outString = "<select id=\"{$id}\" name=\"{$name}\">";
        $seasons = DiscDate::getSeasons();
        foreach($seasons as $season) {
            $isSelected = ($selected == $season) ? " selected " : "";
            $outString.="<option {$selected} value=\"{$season}\">$season</option>";
        }
        $outString.= "</select>";
        return $outString;
    }

    /**
     * Returns JSON encoded data for the given Discordian Date
     * @static
     * @param DiscDate $discDate
     * @return string
     */
    public static function jsonData(DiscDate $discDate) {

        $output = array('chosenDateThudDisplay' => $discDate->format('l F jS, Y'),
                        'chosenDateDiscDisplay' => ($discDate->format('Q') === "St Tib's Day") ? $discDate->format('E R, \Y\O\L\D X') : $discDate->format('E R Q, \Y\O\L\D X'),
                        'thudMonth' => $discDate->getThudMonth(DiscDate::MONTH_NAME),
                        'thudDay' => $discDate->getThudDay(),
                        'thudYear' => $discDate->getThudYear(),
                        'discSeason' => $discDate->getDiscSeason(),
                        'discDay' => str_pad($discDate->getDiscDay(), 2, "0", STR_PAD_LEFT),
                        'discYear' => $discDate->getDiscYear(),
                        'apostleDay' => $discDate->getApostleDay(),
                        'holyDay' => $discDate->getHolyDay(),
                        'apostle' => $discDate->getApostle(),
                    );

        return json_encode($output);
    }

    /**
     * Returns the HTML to display a full season, based on the given DiscDate
     *
     * @static
     * @param DiscDate $discDate
     * @param string $tableClass [optional]
     * @param string $tableId [optional]
     * @param string $headerCellClass [optional]
     * @param string $headerCellIdPrefix [optional]
     * @param string $cellClass [optional]
     * @param string $cellIdPrefix [optional]
     * @param string $linkClass [optional]
     * @param string $linkIdPrefix [optional]
     * @return string
     */
    public static function seasonDisplay(DiscDate $discDate, $tableClass = "", $tableId  = "", $headerCellClass = "", $headerCellIdPrefix = "", $cellClass = "", $cellIdPrefix = "", $apostleDayClass = "", $holyDayClass = "") {

        $season = $discDate->getDiscSeason();
        $seasonNum = $discDate->getDiscSeasonNum();
        $apostles = DiscDate::getApostles();
        $apostleDays = DiscDate::getApostleDays();
        $holyDays = DiscDate::getHolydays();
        $apostleName = $apostles[$seasonNum];
        $apostleDayName = $apostleDays[$seasonNum];
        $holyDayName = $holyDays[$seasonNum];
        $startDate = DiscDate::createFromDisc(1, $season, $discDate->getDiscYear());

        $offsetDays = $startDate->getDiscWeekDayNum();
        $currentDate = 0 - $offsetDays;

        $outString = "<table class=\"{$tableClass}\" id=\"{$tableId}\"><thead><tr>";
        $days = DiscDate::getWeekdays();

        foreach($days as $index => $day) {
            $outString.="<th colspan=\"2\"  class=\"{$headerCellClass}\" id=\"{$headerCellIdPrefix}_{$index}\">" . $day. "</th>";
        }
        $outString.= "</tr></thead><tbody>";

        for ($y = 1; $y <= 16; $y++) {
           $outString.="<tr>";
           for($x =1; $x <= 5; $x++) {
                $currentDate++;
               $displayDate = "";
               if ($currentDate > 0 && $currentDate < 74) {
                   $displayDate = $currentDate;
               }
               if ($currentDate == 59 && $discDate->getDiscSeason() == DiscDate::SEASON_CHAOS && $discDate->format('L') == "1") {
                   $outString.="<td class=\"{$cellClass}\" id=\"{$cellIdPrefix}_{$y}_{$x}\">59</td><td class=\"{$cellClass}\" id=\"{$cellIdPrefix}_ST\"><a class=\"holyDayLink\" title=\"Celebrate St Tib's Day\">ST</a></td>";
               } else {
                   if ($displayDate == "5") {
                      $displayDate = "<a class=\"{$apostleDayClass}\" title=\"Celebrate {$apostleDayName} for patron apostle {$apostleName}\">5</a>";
                   }
                   if ($displayDate == "50") {
                      $displayDate = "<a class=\"{$holyDayClass}\" title=\"Celebrate {$holyDayName}\">50</a>";
                   }
                   if ($currentDate == $discDate->getDiscDay()) {
                      $displayDate = "<span class=\"todayLink\">*" . $displayDate ."*</span>";
                   }
                   $outString.="<td colspan=\"2\" class=\"{$cellClass}\" id=\"{$cellIdPrefix}_{$y}_{$x}\">" . $displayDate . "</td>";
               }

           }
           $outString.="</tr>";
        }

        $outString.="</tbody></table>";
        return $outString;
    }
}


