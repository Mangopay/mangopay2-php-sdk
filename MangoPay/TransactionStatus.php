<?php

namespace MangoPay;

final class TransactionStatus
{
    const Created = 'CREATED';
    const Succeeded = 'SUCCEEDED';
    const Failed = 'FAILED';

    private function __construct()
    {
    }
}
