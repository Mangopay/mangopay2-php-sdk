<?php

namespace MangoPay;

/**
 * Class to manage MangoPay API for settlements (API V3)
 */
class ApiSettlements extends Libraries\ApiBase
{
    /**
     * @param string $file The file to be uploaded (binary string)
     * @param string $idempotencyKey Idempotency key
     * @return Settlement Object returned by the API
     * @throws Libraries\Exception
     */
    public function Upload($file, $idempotencyKey = null)
    {
        return $this->CreateOrUpdateMultipartObject('settlement_create', $file, "settlement_file.csv",
            '\MangoPay\Settlement', null, $idempotencyKey);
    }
}
