<?php

namespace Kibo;

use InvalidArgumentException;

class Date {
    private $d;

    private function __construct(int $d) {
        $this->d = $d;
    }

    public static function today(): self {
        return new static(unixtojd());
    }

    public static function fromString(string $date): self {
        if (sscanf($date, '%d-%d-%d', $y, $m, $d) !== 3) {
            throw new InvalidArgumentException('Could not parse date');
        }
        return static::fromDate($y, $m, $d);
    }

    public static function fromDate(int $year, int $month, int $day): self {
        $jd = gregoriantojd($month, $day, $year);
        if (!$jd) {
            throw new InvalidArgumentException("Date out of valid range: $year-$month-$day");
        }
        return new static($jd);
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): self {
        return self::fromDate(
            (int) $dateTime->format('Y'),
            (int) $dateTime->format('m'),
            (int) $dateTime->format('d')
        );
    }

    public function addDays(int $delta): self {
        return new static($this->d + $delta);
    }

    public function diffDays(self $other): int {
        return $this->d - $other->d;
    }

    public function getDay(): int {
        return $this->getGregorianField('day');
    }

    public function getMonth(): int {
        return $this->getGregorianField('month');
    }

    public function getYear(): int {
        return $this->getGregorianField('year');
    }

    public function getFirstDateOfQuarter(): self {
        $date = $this->getFirstDateOfMonth();
        while (($date->getMonth() - 1) % 3) {
            $date = $date->addMonths(-1);
        }
        return $date;
    }

    public function getLastDateOfQuarter(): self {
        return $this->getFirstDateOfQuarter()->addMonths(3)->addDays(-1);
    }

    public function getFirstDateOfMonth(): self {
        return $this->withDay(1);
    }

    private function withDay(int $date): self {
        return static::fromDate($this->getYear(), $this->getMonth(), 1);
    }

    public function addMonths(int $months): self {
        $year = $this->getYear();
        $month = $this->getMonth() + $months;
        while ($month > 12) {
            $year++;
            $month -= 12;
        }
        while ($month < 1) {
            $year--;
            $month += 12;
        }
        return static::fromDate($year, $month, $this->getDay());
    }

    private function getGregorianField(string $field): int {
        return cal_from_jd($this->d, CAL_GREGORIAN)[$field];
    }

    public function __toString(): string {
        return $this->toIsoString();
    }

    public function toIsoString(): string {
        return sprintf(
            '%04d-%02d-%02d',
            $this->getYear(),
            $this->getMonth(),
            $this->getDay()
        );
    }
}
