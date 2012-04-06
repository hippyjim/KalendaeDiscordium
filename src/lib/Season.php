<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 04/04/12
 * Time: 23:50
 */

/**
 *
 */
abstract class Season {

    const CHAOS = 'Chaos';
    const DISCORD = "Discord";
    const CONFUSION = "Confusion";
    const BUREAUCRACY = "Bureaucracy";
    const AFTERMATH = "The Aftermath";

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $startDay = null;

    /**
     * @var DateTime
     */
    protected $startThudDate;

    /**
     * @var string
     */
    protected $startThudDateString;

    /**
     * @var string
     */
    protected $apostle;

    /**
     * @var ApostleDay
     */
    protected $apostleDay = null;

    /**
     * @var string
     */
    protected $holyDay;

    /**
     * @var int
     */
    protected $year;

    /**
     * @var string
     */
    protected $fnord = "FNORD";


    protected static $seasonNames = array(self::CHAOS, self::DISCORD, self::CONFUSION, self::BUREAUCRACY, self::AFTERMATH);

    public function __construct($year) {
        $this->year = $year;
    }

    private function getThudYear() {
        return $this->year - DiscDate::GREYFACE_YEAR;
    }

    /**
     * @return ApostleDay
     */
    public function getApostleDay() {
        if (is_null($this->apostleDay)) {
            $this->buildApostleDay();
        }
        return $this->apostleDay;
    }

    protected abstract function buildApostleDay();

    /**
     * @return string
     */
    public function getHolyDay() {
        return $this->holyDay;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getApostle() {
        if (is_null($this->apostleDay)){
            $this->apostleDay = $this->getApostleDay();
        }
        return $this->apostleDay->getApostle();
    }


    /**
     * @return string
     */
    public function getStartDay() {
        if (!$this->startDay) {
            $startThudDate = $this->getStartThudDate();
            $this->startDay = $startThudDate->format('z');
        }
        return $this->startDay;
    }

    /**
     * @return DateTime
     */
    public function getStartThudDate() {
        return new DateTime($this->getThudYear().$this->startThudDateString);
    }

    public static function pickSeasonFromDiscDate(DiscDate $discDate) {
        $year = $discDate->getDiscYear();
        $chosenDay = $discDate->getThudDaynum();
        $returnSeason = new ChaosSeason($year);
        $nextSeason = new DiscordSeason($year);
        $seasonNumber = 1;
        while($nextSeason->getStartDay() >= $chosenDay && $seasonNumber < 5) {
            $nextSeasonName = self::$seasonNames[$seasonNumber]."Season";
            $nextSeason = new $nextSeasonName($year);
            $seasonNumber++;
        }
        return $returnSeason;
    }
}
