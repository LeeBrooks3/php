<?php

namespace LeeBrooks3\Utilities;

use Carbon\Carbon;
use DateTimeInterface;

trait Dates
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Return a timestamp as DateTime object with time set to 00:00:00.
     *
     * @param  mixed  $value
     * @return Carbon
     */
    protected function asDate($value)
    {
        return $this->asDateTime($value)->startOfDay();
    }

    /**
     * Return a timestamp as DateTime object.
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
     * Convert a DateTime to a storable string.
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
     * Return a timestamp as unix timestamp.
     *
     * @param  mixed  $value
     * @return int
     */
    protected function asTimestamp($value)
    {
        return $this->asDateTime($value)->getTimestamp();
    }

    /**
     * Get the format for database stored dates.
     *
     * @return string
     */
    protected function getDateFormat() : string
    {
        return $this->dateFormat;
    }
}
