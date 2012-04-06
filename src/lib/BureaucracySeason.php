<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 06/04/12
 * Time: 16:12
 */
class BureaucracySeason extends Season {

    /**
     * @var string
     */
    protected $name = Season::BUREAUCRACY;

    /**
     * @var string
     */
    protected $startThudDateString = "-08-08";

    /**
     * @var string
     */
    protected $holyDay = "Bureflux";

    private function buildApostleDay() {
        $this->apostleDay = new Zaraday();
    }
}
