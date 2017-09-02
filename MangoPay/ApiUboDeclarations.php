<?php

namespace MangoPay;

/**
 * Manages API calls for the UBO declaration entity.
 */
class ApiUboDeclarations extends Libraries\ApiBase
{
    /**
     * Retrieve a UBO declaration.
     * @param string $id Unique ID of the UBO declaration to be retrieved
     * @return \MangoPay\UboDeclaration
     */
    public function Get($id)
    {
        return $this->GetObject('ubo_declaration_get', $id, '\MangoPay\UboDeclaration');
    }

    /**
     * Updates a UBO declaration's data.
     * @param \MangoPay\UboDeclaration $declaration Updated UBO declaration data
     * @return \MangoPay\UboDeclaration Newly-updated UBO declaration object
     */
    public function Update($declaration)
    {
        return $this->SaveObject('ubo_declaration_update', $declaration, '\MangoPay\UboDeclaration');
    }
}