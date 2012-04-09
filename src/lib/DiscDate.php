<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippyjim
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

    const SEASON_CHAOS = 'Chaos';
    const SEASON_DISCORD = "Discord";
    const SEASON_CONFUSION = "Confusion";
    const SEASON_BUREAUCRACY = "Bureaucracy";
    const SEASON_AFTERMATH = "The Aftermath";

    const SEASON_CHAOS_START_DATE = "-01-01 00:00:00";
    const SEASON_DISCORD_START_DATE = "-03-15 00:00:00";
    const SEASON_CONFUSION_START_DATE = "-05-27 00:00:00";
    const SEASON_BUREAUCRACY_START_DATE = "-08-08 00:00:00";
    const SEASON_AFTERMATH_START_DATE = "-10-20 00:00:00";
    const INTERNAL_DATE_FORMAT = "Y-m-d H:i:s";

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
    private $discSeason;
    private $discSeasonNum = null;
    private $discYear;
    private $apostleDay;
    private $apostle;
    private $holyDay;

    private $seasonStartDay;

    protected static $discWeekDays = array("Sweetmorn", "Boomtime", "Pungenday", "Prickle-Prickle", "Setting Orange");
    protected static $seasonNames = array(self::SEASON_CHAOS, self::SEASON_DISCORD, self::SEASON_CONFUSION, self::SEASON_BUREAUCRACY, self::SEASON_AFTERMATH);
    protected static $seasonStarts = array(self::SEASON_CHAOS_START_DATE, self::SEASON_DISCORD_START_DATE, self::SEASON_CONFUSION_START_DATE, self::SEASON_BUREAUCRACY_START_DATE, self::SEASON_AFTERMATH_START_DATE);

    protected static $apostles = array("Hung Mung", "Dr. Van Van Mojo", "Sri Syadasti", "Zarathud", "The Elder");
    protected static $apostleDays = array("Mungday", "Mojoday", "Syaday", "Zaraday", "Maladay");
    protected static $holydays = array("Chaoflux", "Discoflux", "Confuflux", "Bureflux", "Afflux");

    public function __construct($timeString) {
        return parent::__construct($timeString);
    }

    public function createFromThud($thudDay, $thudMonth, $thudYear) {
        return new DiscDate($thudYear.'-'.$thudMonth.'-'.$thudDay);
    }

    private static function isStTibsYear($year) {
        return (DateTime::createFromFormat(self::INTERNAL_DATE_FORMAT, $year."-01-01 00:00:00")->format('L') == "1");
    }

    public function getThudDaynum() {
        return $this->format('z');
    }

    public static function createFromFormat($format, $time) {
        $dateTime = DateTime::createFromFormat($format, $time);
        return new DiscDate($dateTime->format(self::INTERNAL_DATE_FORMAT));
    }

    public static function createFromDisc($discDay, $discSeason, $discYear) {
        $thudYear = str_pad($discYear - self::GREYFACE_YEAR, 4, "0", STR_PAD_LEFT);
        $discSeasonNum = array_search($discSeason, self::$seasonNames);
        $discDate = new DiscDate($thudYear.self::$seasonStarts[$discSeasonNum]);
        $discDayForStamp = $discDay-1;
        if (self::isStTibsYear($thudYear) && $discSeason == self::SEASON_CHAOS) {
            if ($discDay == self::ST_TIBS) {
                $discDayForStamp = 59;
            } elseif ($discDay >= 60) {
                $discDayForStamp = $discDay;
            }
        }

        if ($discDayForStamp > 0) {
            $daysToAdd = new DateInterval('P' . $discDayForStamp . 'D');
            $discDate->add($daysToAdd);
        }
        $discDate->discYear = $discYear;
        $discDate->discSeason = $discSeason;
        $discDate->discSeasonNum = $discSeasonNum;
        $discDate->discDay = $discDay;
        return $discDate;
    }

    public function getApostle() {
        $this->apostle = self::$apostles[$this->getDiscSeasonNum()];
        return $this->apostle;
    }

    public function getApostleDay() {
        $day = $this->getDiscDay();
        if ($day == 5) {
            $this->apostleDay = self::$apostleDays[$this->getDiscSeasonNum()];
        } else {
            $this->apostleDay = FALSE;
        }
        return $this->apostleDay;
    }

    public function getHolyDay() {
        $day = $this->getDiscDay();
        if ($day == 50) {
            $this->holyDay = self::$holydays[$this->getDiscSeasonNum()];
        } else {
            $this->holyDay = FALSE;
        }
        return $this->holyDay;
    }

    public function getDiscDay() {
        $dayNum = $this->getThudDaynum();
        $this->discDay = $dayNum - $this->getSeasonStartDay()+1;

        if ($dayNum >= 59) {
            if (self::isStTibsYear($this->getThudYear())) {
                if ($dayNum == 59) {
                    $this->discDay = self::ST_TIBS;
                }
                if ($dayNum > 59 && $dayNum < 74) {
                    $this->discDay--;
                }
            }
        }

        return $this->discDay;
    }

    private function getSeasonStartDay() {
        $startThudDate = new DateTime($this->getThudYear().$this->getSeasonStartThudDateString());
        $this->seasonStartDay = $startThudDate->format('z');
        return $this->seasonStartDay;
    }

    private function getSeasonStartThudDateString() {
        if (is_null($this->discSeasonNum)) {
            $this->getDiscSeasonNum();
        }
        return self::$seasonStarts[$this->discSeasonNum];
    }

    public function getDiscSeasonNum() {
        if (is_null($this->discSeasonNum)) {
            $this->thudDaynum = $this->getThudDaynum();
            $this->discSeasonNum = $this->pickSeason();

        }
        return $this->discSeasonNum;
    }

    public function getDiscSeason() {
        if (is_null($this->discSeasonNum)) {
            $this->getDiscSeasonNum();
        }
        return self::$seasonNames[$this->discSeasonNum];
    }

    public function pickSeason() {
        $thudYear = $this->getThudYear();
        $seasonNumber = 0;
        $timeStamp = $this->format('U');
        while ($seasonNumber <= 4 && ($timeStamp > DateTime::createFromFormat(self::INTERNAL_DATE_FORMAT,$thudYear.self::$seasonStarts[$seasonNumber])->format('U'))) {
            $seasonNumber++;
        }
        if ($seasonNumber >0) {
            $seasonNumber--;
        }
        return $seasonNumber;
    }

    public function getDiscWeekDay() {
        $dayNum = $this->getThudDaynum();
        $weekdayNum = $dayNum % 5;
        $this->discWeekDay = FALSE;
        if ($this->isStTibsYear($this->getThudYear())){
            if ($dayNum > 59) {
                $weekdayNum--;
                if ($weekdayNum < 0) {
                    $weekdayNum = 5 + $weekdayNum;
                }
            } elseif($dayNum == 59) {
                $this->discWeekDay = self::ST_TIBS;
            }
        }

        if (!$this->discWeekDay) {
            $this->discWeekDay = self::$discWeekDays[$weekdayNum];
        }
        return $this->discWeekDay;
    }

    public function getDiscWeekDays() {
        return self::$discWeekDays;
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

    public static function getSeasons() {
        return self::$seasonNames;
    }

    public static function getApostles() {
        return self::$apostles;
    }

    public static function getApostleDays() {
        return self::$apostleDays;
    }

    public static function getHolydays() {
        return self::$holydays;
    }
}
