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

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $startDay;

    /**
     * @var DateTime
     */
    protected $startThudDate;

    /**
     * @var string
     */
    protected $apostle;

    /**
     * @var ApostleDay
     */
    protected $apostleDay;

    /**
     * @var string
     */
    protected $holyDay;

    /**
     * @var string
     */
    protected $fnord = "FNORD";

    abstract public function __construct();

    /**
     * @return ApostleDay
     */
    public function getApostleDay()
    {
        return $this->apostleDay;
    }

    /**
     * @return string
     */
    public function getHolyDay()
    {
        return $this->holyDay;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStartDay()
    {
        //TODO: modify this to cope with post St Tib's
        // Check if daynumber is higher than 59, and if it is, check if it's a St Tib's year
        // If so, add 1 to the daynumber
        return $this->startDay;
    }

    /**
     * @return mixed
     */
    public function getStartThudDate()
    {
        return DateTime::createFromFormat('U', strtotime($this->startThudDateString));
    }

}
