<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 06/04/12
 * Time: 14:56
 * @TODO: fix the issue with dates being 1 day out.
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

    const SEASON_CHAOS_START_DATE = "-01-01";
    const SEASON_DISCORD_START_DATE = "-03-15";
    const SEASON_CONFUSION_START_DATE = "-05-27";
    const SEASON_BUREAUCRACY_START_DATE = "-08-08";
    const SEASON_AFTERMATH_START_DATE = "-10-20";


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
    private $discSeason;
    private $discSeasonNum = null;
    private $discYear;
    private $apostleDay = null;
    private $holyDay = null;

    private $seasonStartDay;

    protected static $discWeekDays = array("Sweetmorn", "Boomtime", "Pungenday", "Prickle-Prickle", "Setting Orange");
    protected static $seasonNames = array(self::SEASON_CHAOS, self::SEASON_DISCORD, self::SEASON_CONFUSION, self::SEASON_BUREAUCRACY, self::SEASON_AFTERMATH);
    protected static $seasonStarts = array(self::SEASON_CHAOS_START_DATE, self::SEASON_DISCORD_START_DATE, self::SEASON_CONFUSION_START_DATE, self::SEASON_BUREAUCRACY_START_DATE, self::SEASON_AFTERMATH_START_DATE);


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
        $discSeasonNum = array_search($discSeason, self::$seasonNames);
        $thudDaynum = $thudYear.self::$seasonStarts[$discSeasonNum];
        $discDay--;
        $thudStamp = strtotime("+" . $discDay." day",strtotime($thudDaynum));
        return DiscDate::createFromFormat('U', $thudStamp);
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
        echo "\n\n".$dayNum . "-" . $this->getSeasonStartDay();
        $this->discDay = $dayNum - $this->getSeasonStartDay()+1;
        return $this->discDay;
    }

    private function getSeasonStartDay() {
        $startThudDate = new DateTime($this->getThudYear().$this->getSeasonStartThudDateString());
        $this->seasonStartDay = $startThudDate->format('z');
        echo "\n\nseasonstartday: " . $this->seasonStartDay;
        return $this->seasonStartDay;
    }

    private function getSeasonStartThudDateString() {
        if (is_null($this->discSeasonNum)) {
            $this->getDiscSeasonNum();
        }
        return self::$seasonStarts[$this->discSeasonNum-1];
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
        return self::$seasonNames[$this->discSeasonNum-1];
    }

    public function pickSeason() {
        $thudYear = $this->getThudYear();
        $seasonNumber = 0;
        while ($this > DiscDate::createFromFormat('Y-m-d', $thudYear.self::$seasonStarts[$seasonNumber]) && $seasonNumber < 5) {
            $seasonNumber++;
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
}
