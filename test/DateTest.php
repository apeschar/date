<?php

namespace Kibo;

use InvalidArgumentException;

class DateTest extends \PHPUnit\Framework\TestCase {
    public function testToday(): void {
        $this->assertSame(date('Y-m-d'), Date::today()->toIsoString());
    }

    public function testFromString(): void {
        $this->assertSame('2021-01-01', Date::fromString('2021-01-01')->toIsoString());
    }

    public function testFromStringInvalidDate(): void {
        $this->expectException(InvalidArgumentException::class);
        Date::fromString('2021-13-01');
    }

    public function testFromStringInvalidFormat(): void {
        $this->expectException(InvalidArgumentException::class);
        Date::fromString('abcd');
    }

    public function testDiffDays(): void {
        $this->assertSame(366, Date::fromString('2021-01-01')->diffDays(Date::fromString('2020-01-01')));
    }

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

    public function testToString(): void {
        $this->assertSame('1830-11-30', (string) Date::fromString('1830-11-30'));
    }

    public function testFromDateTime() {
        $this->assertEquals(
            Date::fromString('2022-08-22'),
            Date::fromDateTime(new \DateTimeImmutable('2022-08-22'))
        );
        $this->assertEquals(
            Date::fromString('2022-08-22'),
            Date::fromDateTime(new \DateTime('2022-08-22'))
        );
    }
}
