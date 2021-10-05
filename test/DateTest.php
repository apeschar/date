<?php
namespace Kibo;

class DateTest extends \PHPUnit\Framework\TestCase {
    public function testGet(): void {
        $date = Date::fromString('2021-09-06');
        $this->assertSame(6, $date->getDay());
        $this->assertSame(9, $date->getMonth());
        $this->assertSame(2021, $date->getYear());
    }

    public function testQuarter(): void {
        $date = Date::fromString('2021-11-05')->getFirstDateOfQuarter();
        $this->assertSame('2021-10-01', $date->toIsoString());

        $date = $date->getLastDateOfQuarter();
        $this->assertSame('2021-12-31', $date->toIsoString());
    }

    public function testAddMonths(): void {
        $date = Date::fromDate(2021, 1, 31)->addMonths(1);
        $this->assertSame('2021-03-03', $date->toIsoString());

        $date = Date::fromDate(2021, 12, 31)->addMonths(1);
        $this->assertSame('2022-01-31', $date->toIsoString());

        $date = Date::fromDate(2021, 1, 31)->addMonths(-1);
        $this->assertSame('2020-12-31', $date->toIsoString());

        $date = Date::fromDate(2021, 1, 31)->addMonths(-13);
        $this->assertSame('2019-12-31', $date->toIsoString());
    }
}
