<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 06/04/12
 * Time: 16:04
 */
class DiscordSeason extends Season {

    /**
     * @var string
     */
    protected $name = Season::DISCORD;

    /**
     * @var string
     */
    protected $startThudDateString = "-03-15";

    /**
     * @var string
     */
    protected $holyDay = "Discoflux";

    public function buildApostleDay() {
        $this->apostleDay = new Mojoday();
    }
}
