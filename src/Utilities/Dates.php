<?php

namespace LeeBrooks3\Utilities;

use Carbon\Carbon;
use DateTimeInterface;

trait Dates
{
    /**
     * The date format.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Returns a carbon instance for the given date value.
     *
     * @param mixed $value
     * @return Carbon
     */
    protected function asDate($value)
    {
        return $this->asDateTime($value)->startOfDay();
    }

    /**
     * Returns a carbon instance for the given datetime value.
     *
     * @param  mixed  $value
     * @return Carbon
     */
    protected function asDateTime($value)
    {
        if ($value instanceof Carbon) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return new Carbon(
                $value->format('Y-m-d H:i:s.u'), $value->getTimezone()
            );
        }

        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value);
        }

        return Carbon::parse($value);
    }

    /**
     * Returns the given date in the defined or given format.
     *
     * @param \DateTime|int $value
     * @param string|null $format
     * @return string
     */
    protected function asDateFormat($value, string $format = null) : string
    {
        $format = $format ?: $this->getDateFormat();

        return empty($value) ? $value : $this->asDateTime($value)->format($format);
    }

    /**
     * Returns the given value as a unix timestamp.
     *
     * @param  mixed  $value
     * @return int
     */
    protected function asTimestamp($value)
    {
        return $this->asDateTime($value)->getTimestamp();
    }

    /**
     * Returns the date format.
     *
     * @return string
     */
    protected function getDateFormat() : string
    {
        return $this->dateFormat;
    }
}
