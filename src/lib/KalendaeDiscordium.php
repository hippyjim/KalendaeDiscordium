<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 04/04/12
 * Time: 23:47
 */
class KalendaeDiscordium {

    public $seasons = array();

    private $apostles = array("Hung Mung", "Dr. Van Van Mojo", "Sri Syadasti", "Zarathud", "The Elder");

    // Apostle holydays - to display on the 5th of each season
    private $apostleDays = array("Mungday", "Mojoday", "Syaday", "Zaraday", "Maladay");

    // Seasonal holydays. to display on 50th day of season
    private $holydays = array("Chaoflux", "Discoflux", "Confuflux", "Bureflux", "Afflux");

    private $seasonStarts = array("Chaos" => 0,
                                 "Discord" => 73,
                                 "Confusion" => 146,
                                 "Bureaucracy" => 219,
                                 "The Aftermath" => 292);

    private $days = array("Sweetmorn", "Boomtime", "Pungenday", "Prickle-Prickle", "Setting Orange");

    public function __construct() {

    }
}


