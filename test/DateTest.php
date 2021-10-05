<?php
namespace Kibo;

class DateTest extends \PHPUnit\Framework\TestCase {
    public function testGet(): void {
        $date = Date::fromString('2021-09-06');
        $this->assertSame(6, $date->getDay());
        $this->assertSame(9, $date->getMonth());
        $this->assertSame(2021, $date->getYear());
    }
}
