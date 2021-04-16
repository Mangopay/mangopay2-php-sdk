<?php

namespace MangoPay;

/**
 * Address Verification System result
 */
class AVSResult
{
    const FULL_MATCH = "FULL_MATCH";

    const ADDRESS_MATCH_ONLY = "ADDRESS_MATCH_ONLY";

    const POSTAL_CODE_MATCH_ONLY = "POSTAL_CODE_MATCH_ONLY";

    const NO_MATCH = "NO_MATCH";

    const NO_CHECK = "NO_CHECK";
}
