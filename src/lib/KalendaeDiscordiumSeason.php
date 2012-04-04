<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 04/04/12
 * Time: 23:50
 */

class KalendaeDiscordiumSeason {

    private $name;
    private $startDay;
    private $startThudDate;
    private $apostleDay;
    private $holyDay;

    public $fnord = "FNORD";

    public function __construct($name, $startDay, $apostleDay, $holyDay) {
        $this->setName($name);
        $this->setStartDay($startDay);
        $this->apostleDay = $apostleDay;
        $this->holyDay = $holyDay;
    }

    public function setApostleDay($apostleDay)
    {
        $this->apostleDay = $apostleDay;
    }

    public function getApostleDay()
    {
        return $this->apostleDay;
    }

    public function setFnord($fnord)
    {
        $this->fnord = $fnord;
    }

    public function getFnord()
    {
        return $this->fnord;
    }

    public function setHolyDay($holyDay)
    {
        $this->holyDay = $holyDay;
    }

    public function getHolyDay()
    {
        return $this->holyDay;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStartDay($startDay)
    {
        $this->startDay = $startDay;
        //TODO: deal with automatically setting start date in thuddite
        $this->startThudDate = 1;
    }

    public function getStartDay()
    {
        return $this->startDay;
    }

    public function setStartThudDate($startThudDate)
    {
        $this->startThudDate = $startThudDate;
    }

    public function getStartThudDate()
    {
        return $this->startThudDate;
    }

}
