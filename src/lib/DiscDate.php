<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 06/04/12
 * Time: 14:56
 */
class DiscDate extends DateTime {

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

    private function __construct($timeString) {
        return parent::__construct($timeString, $this->getTimezone());
    }

    private function getTimezone() {
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

    public static function createFromDisc($discDay, $discSeason, $discYear) {
        $this->thudYear = $discYear - self::GREYFACE_YEAR;
        $seasonClass = $discSeason . "Season";
        $this->discSeason = new $seasonClass($discYear);
        $this->thudDaynum = $this->discSeason->getStartDay();
        $this->thudDaynum+=$discDay;
        return self::createFromFormat('z#Y', $this->thudDaynum."#".$this->thudYear);
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

    public function getThudDay($format = self::DAY_NAME) {
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
