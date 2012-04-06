<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 06/04/12
 * Time: 16:10
 */
class ConfusionSeason extends Season {

    /**
     * @var string
     */
    protected $name = Season::CONFUSION;

    /**
     * @var string
     */
    protected $startThudDateString = "-05-27";

    /**
     * @var string
     */
    protected $holyDay = "Confuflux";

    public function buildApostleDay() {
        $this->apostleDay = new Syaday();
    }
}
