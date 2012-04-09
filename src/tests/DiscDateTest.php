<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hippyjim
 * Date: 08/04/12
 * Time: 16:09
 */



include(dirname(__FILE__)."/../lib/DiscDate.php");

class DiscDateTest extends PHPUnit_Framework_Testcase {


    private function checkThudYear($thudYear) {
        $seasonNames = DiscDate::seasons();
        $year = $thudYear + DiscDate::GREYFACE_YEAR;
        $isStTibs = date('L', strtotime($thudYear."-01-01")) == "1";
        $seasonNum = 0;
        $day = 1;
        $hadStTibs = FALSE;
        $maxDays = date('z', strtotime($thudYear."-12-31"));
        for ($i = 0; $i <= $maxDays; $i++) {
            $dateTime = DateTime::createFromFormat('z Y', $i.' ' . $thudYear);

            $thudYear = $dateTime->format('Y');
            $thudMonth = $dateTime->format('m');
            $thudDay = $dateTime->format('d');

            $discDate = DiscDate::createFromFormat('z Y', $i.' ' . $thudYear);
            $this->assertEquals($thudYear, $discDate->getThudYear(), 'Failed asserting that ' . $discDate->getThudYear() . " matches expected $thudYear for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($thudMonth, $discDate->getThudMonth(), 'Failed asserting that ' . $discDate->getThudMonth() . " matches expected $thudMonth for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($thudDay, $discDate->getThudDay(), 'Failed asserting that ' . $discDate->getThudDay() . " matches expected $thudDay for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($year, $discDate->getDiscYear(), 'Failed asserting that ' . $discDate->getDiscYear() . " matches expected $year for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($seasonNum, $discDate->getDiscSeasonNum(), 'Failed asserting that ' . $discDate->getDiscSeasonNum() . " matches expected $seasonNum for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($seasonNames[$seasonNum], $discDate->getDiscSeason(), 'Failed asserting that ' . $discDate->getDiscSeason() . " matches expected {$seasonNames[$seasonNum]} for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            if ($isStTibs) {
                if ($day == 60 && $seasonNum == 0 && !$hadStTibs) {
                    $this->assertEquals("St Tib's Day", $discDate->getDiscDay(), 'Failed asserting that ' . $discDate->getDiscDay() . " matches expected 'St Tib's Day' for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
                    $day--;
                    $hadStTibs = TRUE;
                } else {
                    $this->assertEquals($day, $discDate->getDiscDay(), 'Failed asserting that ' . $discDate->getDiscDay() . " matches expected $day for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
                }
            } else {
                $this->assertEquals($day, $discDate->getDiscDay(), 'Failed asserting that ' . $discDate->getDiscDay() . " matches expected $day for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            }


            $day++;
            if ($day == 74) {
                $day = 1;
                $seasonNum++;
            }
        }
    }

    private function checkDiscYear($thudYear) {
        $seasonNames = DiscDate::seasons();
        $year = $thudYear + DiscDate::GREYFACE_YEAR;
        $isStTibs = date('L', strtotime($thudYear."-01-01")) == "1";
        $seasonNum = 0;
        $day = 1;
        $hadStTibs = FALSE;
        $maxDays = date('z', strtotime($thudYear."-12-31"));
        for ($i = 0; $i <= $maxDays; $i++) {
            $dateTime = DateTime::createFromFormat('z Y', $i.' ' . $thudYear);

            $thudYear = $dateTime->format('Y');
            $thudMonth = $dateTime->format('m');
            $thudDay = $dateTime->format('d');

            if ($day == 60 && $seasonNum == 0 && !$hadStTibs && $isStTibs) {
                $discDate = DiscDate::createFromDisc(DiscDate::ST_TIBS, $seasonNames[$seasonNum], $year);
            } else {
                $discDate = DiscDate::createFromDisc($day, $seasonNames[$seasonNum], $year);
            }

            $this->assertEquals($thudYear, $discDate->getThudYear(), 'Failed asserting that ' . $discDate->getThudYear() . " matches expected $thudYear for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($thudMonth, $discDate->getThudMonth(), 'Failed asserting that ' . $discDate->getThudMonth() . " matches expected $thudMonth for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($thudDay, $discDate->getThudDay(), 'Failed asserting that ' . $discDate->getThudDay() . " matches expected $thudDay for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($year, $discDate->getDiscYear(), 'Failed asserting that ' . $discDate->getDiscYear() . " matches expected $year for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($seasonNum, $discDate->getDiscSeasonNum(), 'Failed asserting that ' . $discDate->getDiscSeasonNum() . " matches expected $seasonNum for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            $this->assertEquals($seasonNames[$seasonNum], $discDate->getDiscSeason(), 'Failed asserting that ' . $discDate->getDiscSeason() . " matches expected {$seasonNames[$seasonNum]} for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            if ($isStTibs) {
                if ($day == 60 && $seasonNum == 0 && !$hadStTibs) {
                    $this->assertEquals("St Tib's Day", $discDate->getDiscDay(), 'Failed asserting that ' . $discDate->getDiscDay() . " matches expected 'St Tib's Day' for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
                    $day--;
                    $hadStTibs = TRUE;
                } else {
                    $this->assertEquals($day, $discDate->getDiscDay(), 'Failed asserting that ' . $discDate->getDiscDay() . " matches expected $day for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
                }
            } else {
                $this->assertEquals($day, $discDate->getDiscDay(), 'Failed asserting that ' . $discDate->getDiscDay() . " matches expected $day for $thudYear-$thudMonth-$thudDay / $year-$seasonNum-$day");
            }


            $day++;
            if ($day == 74) {
                $day = 1;
                $seasonNum++;
            }
        }
    }

    public function testFromThudWithoutStTibs() {
        $this->checkThudYear(2011);
    }

    public function testFromThudWithStTibs() {
        $this->checkThudYear(2012);
    }

    public function testFromDiscWithoutStTibs() {
        $this->checkDiscYear(2011);
    }

    public function testFromDiscWithStTibs() {
        $this->checkDiscYear(2012);
    }


    public function testFromThudOneToFiveK() {
        for ($thudYear = 1; $thudYear <= 5000; $thudYear++) {
            $this->checkThudYear($thudYear);
        }
    }

    public function testFromDiscOneToFiveK() {
        for ($thudYear = 1; $thudYear <= 5000; $thudYear++) {
            $this->checkDiscYear($thudYear);
        }
    }
}
