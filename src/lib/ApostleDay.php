<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 05/04/12
 * Time: 01:06
 */
abstract class ApostleDay {

    protected $holyDay;
    protected $apostle;
    protected $season;

    public function getHolyday() {
        return $this->holyDay;
    }

    public function getApostle() {
        return $this->apostle;
    }

    public function getSeason() {
        return $this->season;
    }


}
