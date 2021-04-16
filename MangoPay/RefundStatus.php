<?php

namespace MangoPay;

final class RefundStatus
{
    const Created = 'CREATED';
    const Succeeded = 'SUCCEEDED';
    const Failed = 'FAILED';

    private function __construct()
    {
    }
}
