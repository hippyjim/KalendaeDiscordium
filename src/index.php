<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippyjim
 * Date: 04/04/12 / 22nd Discord, YOLD 3178
 * Time: 23:46
 */

include_once(dirname(__FILE__)."/lib/KalendaeDiscordium.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" href="favicon.ico" >
    <meta charset="utf-8">
    <title>Kalendae Discordium - Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="webassets/style.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script src="webassets/kal.js" type="text/javascript"></script>
  </head>
  <body>
  <div id="pageContainer">
      <h1>Kalendae Discordium - Example</h1>
      <div id="headerContainer">
        <img src="webassets/discordipedia.png" width="135" height="136" />
        <div id="pageBlurb">Below is an example usage for Kalendae Discordium and DiscDate. Feel free to use it in any way you see fit, as long as you include a link back to the BitBucket project for the original source. If you do anything interesting with it, please let me know via bitbucket.</div>
      </div>
      <form id="kalForm">
            <div>
              <?php echo KalendaeDiscordium::monthPicker("thudMonth", "thudMonth", date('F')); ?>
              <?php echo KalendaeDiscordium::dayPicker("thudDay", "thudDay", date('d'), TRUE); ?>
              <input type="text" name="thudYear" id="thudYear" value="<?php echo date('Y');?>" size="3" >
              <span> = </span>
              <?php echo KalendaeDiscordium::seasonPicker("discSeason", "discSeason", null); ?>
              <?php echo KalendaeDiscordium::dayPicker("discDay", "discDay", null); ?>
              <input type="text" name="discYear" id="discYear" size="3" >
            </div>
        </form>
        <div id="chosenDate">
            Chosen date: <span id="chosenDateThudDisplay"></span> = <span id="chosenDateDiscDisplay"></span>
        </div>
        <div id="holyDay"></div>
        <div id="apostleDay"></div>
        <div id="kalDisplay">
              <?php echo KalendaeDiscordium::seasonDisplay(new DiscDate('now'), 'kal', 'kalTable', "", "hdr", "", "kalCell", "apostleDayLink", "holyDayLink"); ?>
        </div>
  </div>
  </body>
</html>
