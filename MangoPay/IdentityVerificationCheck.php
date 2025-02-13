<?php

namespace MangoPay;


use MangoPay\Libraries\Dto;

class IdentityVerificationCheck extends Dto
{
    /**
     * Unique identifier for the entire verification session.
     * @var string
     */
    public $SessionId;

    /**
     * The status of the identity verification session:
     *  <p>PENDING – The session is available on the HostedUrl, to which the user must be redirected to complete it.</p>
     *  <p>VALIDATED – The session was successful.</p>
     *  <p>REFUSED – The session was refused.</p>
     *  <p>REVIEW – The session is under manual review by Mangopay.</p>
     *  <p>OUTDATED – The session is no longer valid (likely due to expired documents used during the session).</p>
     *  <p>TIMEOUT – The session timed out due to inactivity.</p>
     *  <p>ERROR – The session was not completed because an error occurred.</p>
     * @var string
     */
    public $Status;

    /**
     * The date and time at which the session was created.
     * @var int
     */
    public $CreationDate;

    /**
     * The date and time at which the session was last updated.
     * @var int
     */
    public $LastUpdate;

    /**
     * The details of the individual verification checks performed during the session.
     * @var Check[]
     */
    public $Checks;
}
