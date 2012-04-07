<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 06/04/12
 * Time: 14:56
 */
class DiscDate extends DateTime {

    const MUNGDAY = "Mungday";
    const MOJODAY = "Mojoday";
    const SYADAY = "Syaday";
    const ZARADAY = "Zaraday";
    const MALADAY = "Maladay";

    const CHAOFLUX = "Chaoflux";
    const DISCOFLUX = "Discoflux";
    const CONFUFLUX = "Confuflux";
    const BUREFLUX = "Bureflux";
    const AFFLUX = "Afflux";

    const MUNG = "Hung Mung";
    const MOJO = "Dr Van Van Mojo";
    const SYA = "Sri Syadasti";
    const ZARA = "Zarathud";
    const MALA = "Malaclypse the Elder";

    const ST_TIBS = "St Tib's Day";


    const OFFICIAL_KALENDAE_DISCORDIUM_TIMEZONE = 'Etc/GMT+5';
    const GREYFACE_YEAR = 1166;

    const MONTH_NUM = 'm';
    const MONTH_NUM_NOLEAD = 'n';
    const MONTH_NAME = 'F';
    const MONTH_NAME_SHORT = 'M';

    const DAY_NUM = 'd';
    const DAY_NUM_NOLEAD = 'j';
    const DAY_NAME = 'l';
    const DAY_NAME_SHORT = 'D';

    private $thudDaynum = null;

    private $thudDay;
    private $thudMonth;
    private $thudYear;

    private $discWeekDay;
    private $discDay;
    private $discSeason = null;
    private $discYear;
    private $apostleDay = null;
    private $holyDay = null;

    protected $discWeekDays = array("Sweetmorn", "Boomtime", "Pungenday", "Prickle-Prickle", "Setting Orange");

    public function __construct($timeString) {
        return parent::__construct($timeString, $this->getTimezone());
    }

    public function getTimezone() {
        return new DateTimeZone(self::OFFICIAL_KALENDAE_DISCORDIUM_TIMEZONE);
    }

    public function createFromThud($thudDay, $thudMonth, $thudYear) {
        return new DiscDate($thudYear.'-'.$thudMonth.'-'.$thudDay);
    }

    private static function isStTibsYear($year) {
        return (date('L', strtotime($year.'-01-01')) == "1");
    }

    public function getThudDaynum() {
        return $this->format('z');
    }

    public static function createFromFormat($format, $time) {
        $dateTime = DateTime::createFromFormat($format, $time);
        return new DiscDate($dateTime->format('Y-m-d'));
    }

    public static function createFromDisc($discDay, $discSeason, $discYear) {
        $thudYear = $discYear - self::GREYFACE_YEAR;
        $discSeason = new Season($discSeason, $discYear);
        $thudDaynum = $discSeason->getStartDay();
        $thudDaynum+=$discDay-1;
        return DiscDate::createFromFormat('z Y', $thudDaynum." ".$thudYear);
    }

    public function getApostleDay() {
        $day = $this->getDiscDay();
        if (is_null($this->apostleDay)) {
            if ($day == 5) {
                $this->apostleDay = $this->getDiscSeason()->getApostleDay();
            } else {
                $this->apostleDay = FALSE;
            }
        }
        return $this->apostleDay;
    }

    public function getHolyDay() {
        $day = $this->getDiscDay();
        if (is_null($this->holyDay)) {
            if ($day == 50) {
                $this->holyDay = $this->getDiscSeason()->getHolyDay();
            } else {
                $this->holyDay = FALSE;
            }
        }
        return $this->holyDay;
    }

    public function getDiscDay() {
        $dayNum = $this->getThudDaynum();
        $season = $this->getDiscSeason();
        $this->discDay = $dayNum - $this->getDiscSeason()->getStartDay()+1;
        return $this->discDay;
    }

    /**
     * @return Season
     */
    public function getDiscSeason() {
        if (is_null($this->discSeason)) {
            $this->thudDaynum = $this->getThudDaynum();
            $this->discSeason = Season::pickSeasonFromDiscDate($this);
        }
        return $this->discSeason;
    }

    public function getDiscWeekDay() {
        return $this->discWeekDay;
    }

    public function getDiscWeekDays() {
        return $this->discWeekDays;
    }

    public function getDiscYear() {
        return $this->getThudYear() + self::GREYFACE_YEAR;
    }

    public function getThudDay($format = self::DAY_NUM) {
            switch($format) {
                case self::DAY_NUM:
                case self::DAY_NUM_NOLEAD:
                case self::DAY_NAME:
                case self::DAY_NAME_SHORT:
                    break;
                default:
                    throw new Exception('Invalid Thud Day format');
                    break;
            }
            return $this->format($format);
    }

    public function getThudMonth($format = self::MONTH_NUM) {
        switch($format) {
            case self::MONTH_NUM:
            case self::MONTH_NUM_NOLEAD:
            case self::MONTH_NAME:
            case self::MONTH_NAME_SHORT:
                break;
            default:
                throw new Exception('Invalid Thud Month format');
                break;
        }
        return $this->format($format);
    }

    public function getThudYear() {
        return $this->format('Y');
    }
}
