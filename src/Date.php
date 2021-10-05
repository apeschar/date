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
        $jd = gregoriantojd($m, $d, $y);
        if (!$jd) {
            throw new InvalidArgumentException("Date out of valid range: $y-$m-$d");
        }
        return new static($jd);
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

    private function getGregorianField(string $field): int {
        return cal_from_jd($this->d, CAL_GREGORIAN)[$field];
    }

    public function __toString(): string {
        return $this->toIsoString();
    }

    public function toIsoString(): string {
        return date('Y-m-d', jdtounix($this->d));
    }
}
