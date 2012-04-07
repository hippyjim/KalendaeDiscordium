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
class Season {

    const CHAOS = 'Chaos';
    const DISCORD = "Discord";
    const CONFUSION = "Confusion";
    const BUREAUCRACY = "Bureaucracy";
    const AFTERMATH = "The Aftermath";

    const CHAOS_START_DATE = "-01-01";
    const DISCORD_START_DATE = "-03-15";
    const CONFUSION_START_DATE = "-05-27";
    const BUREAUCRACY_START_DATE = "-08-08";
    const AFTERMATH_START_DATE = "-10-20";

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
    protected $startThudDate = null;

    /**
     * @var string
     */
    protected $startThudDateString;

    /**
     * @var string
     */
    protected $apostle;

    /**
     * @var string
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
    protected static $seasonStarts = array(self::CHAOS_START_DATE, self::DISCORD_START_DATE, self::CONFUSION_START_DATE, self::BUREAUCRACY_START_DATE, self::AFTERMATH_START_DATE);

    public function __construct($name, $year) {
        $this->year = $year;
        switch($name) {
            case self::CHAOS:
                $this->name = self::CHAOS;
                $this->startThudDateString = self::CHAOS_START_DATE;
                $this->holyDay = DiscDate::CHAOFLUX;
                $this->apostle = DiscDate::MUNG;
                $this->apostleDay = DiscDate::MUNGDAY;
                break;
            case self::DISCORD:
                $this->name = self::DISCORD;
                $this->startThudDateString = self::DISCORD_START_DATE;
                $this->holyDay = DiscDate::DISCOFLUX;
                $this->apostle = DiscDate::MOJO;
                $this->apostleDay = DiscDate::MOJODAY;
                break;
            case self::CONFUSION:
                $this->name = self::CONFUSION;
                $this->startThudDateString = self::CONFUSION_START_DATE;
                $this->holyDay = DiscDate::CONFUFLUX;
                $this->apostle = DiscDate::SYA;
                $this->apostleDay = DiscDate::SYADAY;
                break;
            case self::BUREAUCRACY:
                $this->name = self::BUREAUCRACY;
                $this->startThudDateString = self::BUREAUCRACY_START_DATE;
                $this->holyDay = DiscDate::BUREFLUX;
                $this->apostle = DiscDate::ZARA;
                $this->apostleDay = DiscDate::ZARADAY;
                break;
            case self::AFTERMATH:
                $this->name = self::AFTERMATH;
                $this->startThudDateString = self::AFTERMATH_START_DATE;
                $this->holyDay = DiscDate::AFFLUX;
                $this->apostle = DiscDate::MALA;
                $this->apostleDay = DiscDate::MALADAY;
                break;
            default:
                break;
        }
    }

    private function getThudYear() {
        return $this->year - DiscDate::GREYFACE_YEAR;
    }

    /**
     * @return string
     */
    public function getApostleDay() {
        return $this->apostleDay;
    }

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
        return $this->apostle;
    }


    /**
     * @return string
     */
    public function getStartDay() {
        if (is_null($this->startDay)) {
            $startThudDate = $this->getStartThudDate();
            $this->startDay = $startThudDate->format('z');
        }
        return $this->startDay;
    }

    /**
     * @return DateTime
     */
    public function getStartThudDate() {
        if (is_null($this->startThudDate)) {
            $this->startThudDate = new DateTime($this->getThudYear().$this->startThudDateString);
        }
        return $this->startThudDate;
    }

    public static function pickSeasonFromDiscDate(DiscDate $discDate) {
        $thudYear = $discDate->getThudYear();
        $seasonNumber = 0;
        while ($discDate >= DiscDate::createFromFormat('Y-m-d', $thudYear.self::$seasonStarts[$seasonNumber]) && $seasonNumber < 5) {
            $seasonNumber++;
        }
        return new Season(self::$seasonNames[$seasonNumber-1], $discDate->getDiscYear());
    }
}
