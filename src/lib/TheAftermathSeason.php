<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 06/04/12
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */
class TheAftermathSeason extends Season {

    /**
     * @var string
     */
    protected $name = Season::AFTERMATH;

    /**
     * @var string
     */
    protected $startThudDateString = "-10-20";

    /**
     * @var string
     */
    protected $holyDay = "Afflux";

    public function buildApostleDay() {
        $this->apostleDay = new Maladay();
    }
}