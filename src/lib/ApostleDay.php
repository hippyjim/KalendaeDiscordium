<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 05/04/12
 * Time: 01:06
 * To change this template use File | Settings | File Templates.
 */
abstract class ApostleDay {

    public function getDayNumber() {
        //TODO: modify this to cope with post St Tib's
        // Check if daynumber is higher than 59, and if it is, check if it's a St Tib's year
        // If so, add 1 to the daynumber
        return $this->dayNumber;
    }

    public function getHolyday() {
        return $this->holyday;
    }

    public function getApostle() {
        return $this->apostle;
    }

    public function getSeason() {
        return $this->season;
    }

    public function getThudDate() {
        return DateTime::createFromFormat('U', strtotime($this->thudDateString));
    }
}
