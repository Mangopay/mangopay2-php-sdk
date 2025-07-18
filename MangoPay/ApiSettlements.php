<?php

namespace MangoPay;

/**
 * Class to manage MangoPay API for settlements (API V3)
 */
class ApiSettlements extends Libraries\ApiBase
{
    /**
     * Upload a settlement file
     * @param string $file The file to be uploaded (binary string)
     * @param string $idempotencyKey Idempotency key
     * @return Settlement Object returned by the API
     * @throws Libraries\Exception
     */
    public function Upload($file, $idempotencyKey = null)
    {
        return $this->CreateOrUpdateMultipartObject(
            'settlement_create',
            $file,
            "settlement_file.csv",
            '\MangoPay\Settlement',
            null,
            $idempotencyKey
        );
    }

    /**
     * Get a settlement
     * @param string $settlementId
     * @return Settlement Recipient object returned from API
     * @throws Libraries\Exception
     */
    public function Get($settlementId)
    {
        return $this->GetObject('settlement_get', '\MangoPay\Settlement', $settlementId);
    }

    /**
     * Update a settlement file
     * @param string $settlementId
     * @param string $file The file to be uploaded (binary string)
     * @param string $idempotencyKey Idempotency key
     * @return Settlement Object returned by the API
     * @throws Libraries\Exception
     */
    public function Update($settlementId, $file, $idempotencyKey = null)
    {
        return $this->CreateOrUpdateMultipartObject(
            'settlement_update',
            $file,
            "settlement_file.csv",
            '\MangoPay\Settlement',
            $settlementId,
            $idempotencyKey
        );
    }
}
