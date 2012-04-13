<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippyjim
 * Date: 12/04/12 / 29th Discord, YOLD 3178
 * Time: 23:36
 */

include_once(dirname(__FILE__)."/lib/KalendaeDiscordium.php");

if (isset($_POST['act'])) {

    switch($_POST['type']) {
        case "thud":
            $discDate = DiscDate::createFromFormat("Y-F-d",$_POST['thudYear']."-".$_POST['thudMonth']."-".$_POST['thudDay']);
            break;
        case "disc":
            $discDate = DiscDate::createFromDisc($_POST['discDay'],$_POST['discSeason'],$_POST['discYear']);
            break;
    }

    switch($_POST['act']) {
        case "update":
            echo KalendaeDiscordium::jsonData($discDate);
            break;
        case "kal":
            echo KalendaeDiscordium::seasonDisplay($discDate, 'kal', 'kalTable', "", "hdr", "", "kalCell", "apostleDayLink", "holyDayLink");
            break;
        default:
            break;
    }
}

/**
 *
 <pre>
     <?php print_r($_POST); ?>
 </pre>
 *
 */