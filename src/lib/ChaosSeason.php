<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jim
 * Date: 05/04/12
 * Time: 01:49
 * To change this template use File | Settings | File Templates.
 */
class ChaosSeason extends Season {

    /**
     * @var string
     */
    protected $name = 'Chaos';

    /**
     * @var int
     */
    protected $startDay = 1;

    /**
     * @var DateTime
     */
    protected $startThudDateString = "January 1st";

    /**
     * @var string
     */
    protected $holyDay;

    public function  __construct() {
        $this->apostleDay = new Mungday();
        //TODO: make the holydays and add the holyday here
    }
}
