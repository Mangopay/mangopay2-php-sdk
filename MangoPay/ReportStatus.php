<?php

namespace MangoPay;

final class ReportStatus
{
    const Pending = 'PENDING';
    const Expired = 'EXPIRED';
    const Failed = 'FAILED';
    const ReadyForDownload = 'READY_FOR_DOWNLOAD';

    private function __construct()
    {
    }
}
