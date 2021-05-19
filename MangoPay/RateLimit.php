<?php

namespace MangoPay;

class RateLimit
{
    /**
     * @var integer the number of minutes in this time interval.
     */
    public $IntervalMinutes;

    /**
     * @var integer the number of API calls already made in this time interval.
     */
    public $CallsMade;

    /**
     * @var integer the number of calls still allowed to be made in this time interval.
     */
    public $CallsRemaining;

    /**
     * @var integer the time in unix timestamp when the number of allowed calls in this time interval will be reset.
     */
    public $ResetTimeTimestamp;

    /**
     * RateLimit constructor.
     * @param int $IntervalMinutes
     */
    public function __construct($IntervalMinutes = null)
    {
        $this->IntervalMinutes = $IntervalMinutes;
    }
}
