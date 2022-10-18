<?php

namespace MangoPay;

/**
 * Supported versions of 3D Secure.
 * Requesting a specific version is for testing purposes only. Production environments need to use the 3DS2 flow.
 */
class Supported3DSVersion
{
    const V1 = 'V1';
    const V2_1 = 'V2_1';
}
