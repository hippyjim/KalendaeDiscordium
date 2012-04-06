<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 05/04/12
 * Time: 01:49
 */
class ChaosSeason extends Season {

    /**
     * @var string
     */
    protected $name = Season::CHAOS;

    /**
     * @var string
     */
    protected $startThudDateString = "-01-01";

    /**
     * @var string
     */
    protected $holyDay = "Chaoflux";

    private function buildApostleDay() {
        $this->apostleDay = new Mungday();
    }
}
