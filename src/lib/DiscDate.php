<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippyjim
 * Date: 2012-04-06 / 23rd Discord, YOLD 3178
 * Time: 14:56
 */

/**
 * Extends the default PHP DateTime class to provide Discordian date functionality
 */
class DiscDate extends DateTime {

    /**
     * Apostle day names
     */
    const MUNGDAY = "Mungday";
    const MOJODAY = "Mojoday";
    const SYADAY = "Syaday";
    const ZARADAY = "Zaraday";
    const MALADAY = "Maladay";

    /**
     * Holyday names
     */
    const CHAOFLUX = "Chaoflux";
    const DISCOFLUX = "Discoflux";
    const CONFUFLUX = "Confuflux";
    const BUREFLUX = "Bureflux";
    const AFFLUX = "Afflux";

    /**
     * Apostle names
     */
    const MUNG = "Hung Mung";
    const MOJO = "Dr Van Van Mojo";
    const SYA = "Sri Syadasti";
    const ZARA = "Zarathud";
    const MALA = "Malaclypse the Elder";

    /**
     * St Tib's day name
     */
    const ST_TIBS = "St Tib's Day";

    /**
     * Season names
     */
    const SEASON_CHAOS = 'Chaos';
    const SEASON_DISCORD = "Discord";
    const SEASON_CONFUSION = "Confusion";
    const SEASON_BUREAUCRACY = "Bureaucracy";
    const SEASON_AFTERMATH = "The Aftermath";

    /**
     * Thuddite dates for the start of each season
     */
    const SEASON_CHAOS_START_DATE = "-01-01 00:00:00";
    const SEASON_DISCORD_START_DATE = "-03-15 00:00:00";
    const SEASON_CONFUSION_START_DATE = "-05-27 00:00:00";
    const SEASON_BUREAUCRACY_START_DATE = "-08-08 00:00:00";
    const SEASON_AFTERMATH_START_DATE = "-10-20 00:00:00";

    /**
     * Default date format for use internally
     */
    const INTERNAL_DATE_FORMAT = "Y-m-d H:i:s";

    /**
     * The year of the curse of Greyface - Discordian year when the Thuddite calendar started
     */
    const GREYFACE_YEAR = 1166;

    /**
     * Date formatting constants
     * @see DiscDate::getThudMonth()
     * @see DiscDate::getThudDay()
     */
    const MONTH_NUM = 'm';
    const MONTH_NUM_NOLEAD = 'n';
    const MONTH_NAME = 'F';
    const MONTH_NAME_SHORT = 'M';
    const DAY_NUM = 'd';
    const DAY_NUM_NOLEAD = 'j';
    const DAY_NAME = 'l';
    const DAY_NAME_SHORT = 'D';

    const ORDINAL_TH = 'th';
    const ORDINAL_ST = 'st';
    const ORDINAL_ND = 'nd';
    const ORDINAL_RD = 'rd';

    /**
     * The daynumber for the year calculated from the thuddite date
     * @var int
     */
    private $thudDaynum = null;

    /**
     * The thuddite day of the month
     * @var int
     */
    private $thudDay;

    /**
     * The thuddite month number
     * @var int
     */
    private $thudMonth;

    /**
     * The thuddite year
     * @var int
     */
    private $thudYear;

    /**
     * The discordian day of the week
     * @var string
     */
    private $discWeekDay;

    /**
     * The discordian day of the season
     * @var int
     */
    private $discDay;

    /**
     * The discordian season name
     * @var string
     */
    private $discSeason;

    /**
     * The discordian season number
     * @var int
     */
    private $discSeasonNum = null;

    /**
     * The discordian year
     * @var int
     */
    private $discYear;

    /**
     * The discordian apostle day name or false if it's not currently an apostle day
     * @var string|bool
     */
    private $apostleDay;

    /**
     * The discordian apostle for this season
     * @var string
     */
    private $apostle;

    /**
     * The discordian holy day name, or false if it's not a holy day.
     * @var string|bool
     */
    private $holyDay;

    /**
     * The thuddite daynumber for the start of the current discordian season
     * @var int
     */
    private $seasonStartDay;

    /**
     * List of discordian weekdays, in order
     * @var array
     */
    protected static $discWeekDays = array("Sweetmorn",
                                           "Boomtime",
                                           "Pungenday",
                                           "Prickle-Prickle",
                                           "Setting Orange");

    /**
     * List of discordian season names in order
     * @var array
     */
    protected static $seasonNames = array(self::SEASON_CHAOS,
                                          self::SEASON_DISCORD,
                                          self::SEASON_CONFUSION,
                                          self::SEASON_BUREAUCRACY,
                                          self::SEASON_AFTERMATH);

    /**
     * List of discordian season start dates in order
     * @var array
     */
    protected static $seasonStarts = array(self::SEASON_CHAOS_START_DATE,
                                           self::SEASON_DISCORD_START_DATE,
                                           self::SEASON_CONFUSION_START_DATE,
                                           self::SEASON_BUREAUCRACY_START_DATE,
                                           self::SEASON_AFTERMATH_START_DATE);

    /**
     * List of discoridan apostles in order of season
     * @var array
     */
    protected static $apostles = array(self::MUNG,
                                       self::MOJO,
                                       self::SYA,
                                       self::ZARA,
                                       self::MALA);

    /**
     * List of discordian apostle days in order
     * @var array
     */
    protected static $apostleDays = array(self::MUNGDAY,
                                          self::MOJODAY,
                                          self::SYADAY,
                                          self::ZARADAY,
                                          self::MALADAY);

    /**
     * List of discordian holy days in order
     * @var array
     */
    protected static $holydays = array(self::CHAOFLUX,
                                       self::DISCOFLUX,
                                       self::CONFUFLUX,
                                       self::BUREFLUX,
                                       self::AFFLUX);


    /**
     * List of english ordinal suffixes
     * @var array
     */
    protected static $ordinals = array(self::ORDINAL_TH,
                                       self::ORDINAL_ST,
                                       self::ORDINAL_ND,
                                       self::ORDINAL_RD,
                                       self::ORDINAL_TH,
                                       self::ORDINAL_TH,
                                       self::ORDINAL_TH,
                                       self::ORDINAL_TH,
                                       self::ORDINAL_TH,
                                       self::ORDINAL_TH);

    /**
     * Constructor, acts exactly as DateTime::__construct;
     * @param $timeString
     */
    public function __construct($timeString) {
        return parent::__construct($timeString);
    }

    /**
     * Creates an instance of DiscDate from the given thuddite date details
     *
     * @param string $thudDay leading zero day of the thuddite month
     * @param string $thudMonth leading zero thuddite month
     * @param string $thudYear thuddite year
     * @return DiscDate
     */
    public function createFromThud($thudDay, $thudMonth, $thudYear) {
        return new DiscDate($thudYear.'-'.$thudMonth.'-'.$thudDay);
    }

    /**
     * Checks if given thuddite year is a leap/StTib's year
     * @static
     * @param int|string $year
     * @return bool
     */
    private static function isStTibsYear($year) {
        return (DateTime::createFromFormat(self::INTERNAL_DATE_FORMAT, $year."-01-01 00:00:00")->format('L') == "1");
    }

    /**
     * Returns the thuddite day number
     * @return string
     */
    public function getThudDaynum() {
        return $this->format('z');
    }

    /**
     * Extends DateTime::createFromFormat to return a DiscDate instance
     * @static
     * @param string $format
     * @param int|string $time
     * @return DiscDate
     */
    public static function createFromFormat($format, $time) {
        $dateTime = DateTime::createFromFormat($format, $time);
        return new DiscDate($dateTime->format(self::INTERNAL_DATE_FORMAT));
    }

    /**
     * Creates a DiscDate from a given discordian date
     * @static
     * @param int $discDay
     * @param string $discSeason one of the DiscDate::Season_* constants
     * @param int $discYear
     * @return DiscDate
     */
    public static function createFromDisc($discDay, $discSeason, $discYear) {
        //Calculate our four digit thuddite year based on the given discordian one
        $thudYear = str_pad($discYear - self::GREYFACE_YEAR, 4, "0", STR_PAD_LEFT);
        //Look up the given season name and find the season number from it
        $discSeasonNum = array_search($discSeason, self::$seasonNames);
        //Create a DiscDate object for the start of the given season
        $discDate = new DiscDate($thudYear.self::$seasonStarts[$discSeasonNum]);
        $discDayForStamp = $discDay-1;
        //If it's a St Tib's year,check if it's St Tib's day and adjust our day number accordingly
        if (self::isStTibsYear($thudYear) && $discSeason == self::SEASON_CHAOS) {
            //If it's st tib's day, our day number is actually between 59 and 60, but for thuddite purposes it's 59.
            if ($discDay == self::ST_TIBS) {
                $discDayForStamp = 59;
            } elseif ($discDay >= 60) {
                //If it's after st'tib's - don't substract 1 from the given day number
                $discDayForStamp = $discDay;
            }
        }

        //If our discday (minus 1 if we're not post- st tib's) is greater than 0, then add the amount of days since
        //the start of the season onto our DiscDate
        if ($discDayForStamp > 0) {
            $daysToAdd = new DateInterval('P' . $discDayForStamp . 'D');
            $discDate->add($daysToAdd);
        }

        //We've been given the discordian date info, so let's store it.
        $discDate->discYear = $discYear;
        $discDate->discSeason = $discSeason;
        $discDate->discSeasonNum = $discSeasonNum;
        $discDate->discDay = $discDay;
        return $discDate;
    }

    /**
     * Returns the season's apostle name
     * @return string
     */
    public function getApostle() {
        $this->apostle = self::$apostles[$this->getDiscSeasonNum()];
        return $this->apostle;
    }

    /**
     * Returns the apostle day name, or false if not an apostle day.
     * @return bool|string
     */
    public function getApostleDay() {
        $day = $this->getDiscDay();
        if ($day == 5) {
            $this->apostleDay = self::$apostleDays[$this->getDiscSeasonNum()];
        } else {
            $this->apostleDay = FALSE;
        }
        return $this->apostleDay;
    }

    /**
     * Returns the holy day name, or false if not a holy day
     * @return bool|string
     */
    public function getHolyDay() {
        $day = $this->getDiscDay();
        if ($day == 50) {
            $this->holyDay = self::$holydays[$this->getDiscSeasonNum()];
        } else {
            $this->holyDay = FALSE;
        }
        return $this->holyDay;
    }

    /**
     * Returns the discordian day of the season
     *
     * If includeOrdinal is set to true, returns a string that includes the English ordinal
     *
     * @param bool $includeOrdinal [optional] defaults to false
     * @return int|string
     */
    public function getDiscDay($includeOrdinal = FALSE) {
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

        if ($includeOrdinal) {
            if ($this->discDay != self::ST_TIBS) {
                if (($this->discDay %100) >= 11 && ($this->discDay%100) <= 13) {
                    $this->discDay.='th';
                } else {
                    $this->discDay.=self::$ordinals[$this->discDay % 10];;
                }
            }
        }

        return $this->discDay;
    }

    /**
     * Returns the daynumber for the start of the season
     * @return int
     */
    private function getSeasonStartDay() {
        $startThudDate = new DateTime($this->getThudYear().$this->getSeasonStartThudDateString());
        $this->seasonStartDay = $startThudDate->format('z');
        return $this->seasonStartDay;
    }

    /**
     * Returns the string that describes the season;s thuddite start date
     * @return string
     */
    private function getSeasonStartThudDateString() {
        if (is_null($this->discSeasonNum)) {
            $this->getDiscSeasonNum();
        }
        return self::$seasonStarts[$this->discSeasonNum];
    }

    /**
     * Returns the discordian season number
     * @return int
     */
    public function getDiscSeasonNum() {
        if (is_null($this->discSeasonNum)) {
            $this->thudDaynum = $this->getThudDaynum();
            $this->discSeasonNum = $this->pickSeason();

        }
        return $this->discSeasonNum;
    }

    /**
     * Returns the discordian season name
     * @return string
     */
    public function getDiscSeason() {
        if (is_null($this->discSeasonNum)) {
            $this->getDiscSeasonNum();
        }
        return self::$seasonNames[$this->discSeasonNum];
    }

    /**
     * Returns the discordian season number
     * @return int
     */
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

    /**
     * Returns the discordian weekday name
     * @return string
     */
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

    /**
     * Returns the array of discordian weekdays
     * @return array
     */
    public function getDiscWeekDays() {
        return self::$discWeekDays;
    }

    /**
     * Returns the discordian year
     * @return string
     */
    public function getDiscYear() {
        return $this->getThudYear() + self::GREYFACE_YEAR;
    }

    /**
     * Returns the thuddite day based on given format
     *
     * Uses the DiscDate::DAY_* constants to choose the format returned
     *
     * DiscDate::DAY_NUM - numeric day of the month, with leading zero
     * DiscDate::DAY_NUM_NOLEAD - numeric day of the month, no leading zero
     * DiscDate::DAY_NAME - full textual representation of the day of the week
     * DiscDate::DAY_NAME_SHORT - textual representation of a day, three letters
     *
     * @param string $format
     * @return string
     * @throws Exception
     */
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

    /**
     * Returns the thuddite month based on given format
     *
     * Uses the DiscDate::MONTH_* constant to choose the format returned
     *
     * DiscDate::MONTH_NUM - numeric representation of the month, with leading zero
     * DiscDate::MONTH_NUM_NOLEAD - numeric representation of the month, no leading zero
     * DiscDate::MONTH_NAME - full textual representation of a month
     * DiscDate::MONTH_NAME_SHORT - short textual representation of a month, three letters
     *
     * @param string $format
     * @return string
     * @throws Exception
     */
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

    /**
     * Returns the 4 digit thuddite year
     * @return string
     */
    public function getThudYear() {
        return $this->format('Y');
    }

    /**
     * Returns the array of discordian season names
     * @static
     * @return array
     */
    public static function getSeasons() {
        return self::$seasonNames;
    }

    /**
     * Returns the array of discordian apostle names
     * @static
     * @return array
     */
    public static function getApostles() {
        return self::$apostles;
    }

    /**
     * Returns the array of discordian apostle days
     * @static
     * @return array
     */
    public static function getApostleDays() {
        return self::$apostleDays;
    }

    /**
     * Returns the array of discordian holy days
     * @static
     * @return array
     */
    public static function getHolydays() {
        return self::$holydays;
    }
}
