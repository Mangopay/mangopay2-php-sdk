<?php

namespace MangoPay;

/**
 * Manages API calls for the UBO declaration entity.
 */
class ApiUboDeclarations extends Libraries\ApiBase
{
    /**
     * Creates a new UBO Declaration for an user.
     * @param string $userId The ID of the user
     * @return \MangoPay\UboDeclaration|object
     */
    public function Create($userId)
    {
        return $this->CreateObject('ubo_declaration_create', null, '\MangoPay\UboDeclaration', $userId);
    }

    public function GetAll($userId, $pagination = null, $sorting = null)
    {
        return $this->GetList("ubo_declaration_all", $pagination, '\MangoPay\UboDeclaration', $userId, null, $sorting);
    }

    /**
     * Gets an UBO Declaration.
     * @param $userId int
     * @param $uboDeclarationId int
     * @return UboDeclaration|object
     */
    public function Get($userId, $uboDeclarationId)
    {
        return $this->GetObject('ubo_declaration_get', $userId, '\MangoPay\UboDeclaration', $uboDeclarationId);
    }

    /**
     * Creates a new UBO for the specified arguments
     * @param $userId int
     * @param $uboDeclarationId int
     * @param $ubo Ubo
     * @return Ubo|object
     */
    public function CreateUbo($userId, $uboDeclarationId, $ubo)
    {
        return $this->SaveObject('ubo_create', $ubo, '\MangoPay\Ubo', $userId, $uboDeclarationId);
    }


    /**
     * Updates an UBO
     * @param $userId int
     * @param $uboDeclarationId int
     * @param $ubo Ubo
     * @return Ubo|object
     */
    public function UpdateUbo($userId, $uboDeclarationId, $ubo)
    {
        return $this->SaveObject('ubo_update', $ubo, '\MangoPay\Ubo', $userId, $uboDeclarationId);
    }


    /**
     * Gets an UBO
     * @param $userId int
     * @param $uboDeclarationId int
     * @param $uboId int
     * @return Ubo|object
     */
    public function GetUbo($userId, $uboDeclarationId, $uboId)
    {
        return $this->GetObject('ubo_get', $userId, '\MangoPay\Ubo', $uboDeclarationId, $uboId);
    }

    /**
     * Updates an UBO Declaration with the status <code>VALIDATION_ASKED</code>.
     * @param $userId int
     * @param $uboDeclarationId int
     * @return Ubo|object
     */
    public function SubmitForValidation($userId, $uboDeclarationId)
    {
        $entity = new UboDeclaration();
        $entity->Id = $uboDeclarationId;
        $entity->Status = UboDeclarationStatus::ValidationAsked;
        return $this->SaveObject('ubo_declaration_submit', $entity, '\MangoPay\UboDeclaration', $userId);
    }
}