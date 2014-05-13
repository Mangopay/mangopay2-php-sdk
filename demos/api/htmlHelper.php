<?php
namespace MangoPay\Demo;

class HtmlHelper {
    
    public static function getHeader($module) {
        foreach ($GLOBALS['MangoPay_Demo_Menu'] as $moduleText => $subMenu) {
            $key = array_search($module, $subMenu);
            if ($key) {
                echo '<h2 style="margin: 0 0 20px 0;">' . $key . '</h2>';
                return;
            }
        }
    }
    
    public static function renderForm($entityName, $operation, $subEntityName, $filterName) {
        
        echo '<form name="input" action="" method="post" enctype="multipart/form-data">';
        echo '<table>';
        
        switch ($operation) {
            case 'Create':
                self::renderEntity($entityName);
                break;
            case 'Get':
                self::renderId($entityName);
                break;
            case 'Save':
                self::renderId($entityName);
                self::renderEntity($entityName);
                break;
            case 'All':
                if (isset($filterName) && $filterName != "") {
                    self::renderFormRow('<i>Optional filters:</i>');
                    self::renderEntity($filterName);
                }
                
                self::renderFormRow('<i>Pagination:</i>');
                self::renderEntity('Pagination');
                break;
            case 'CreateSubEntity':
                self::renderId($entityName);
                self::renderEntity($subEntityName[0]);
                break;
            case 'CreateSubSubEntity':
                self::renderId($entityName);
                self::renderId($subEntityName[1], 'IdSubEntity');
                self::renderEntity($subEntityName[0]);
                break;
            case 'GetSubEntity':
                self::renderId($entityName);
                self::renderId($subEntityName[0], 'IdSubEntity');
                break;
            case 'SaveSubEntity':
                self::renderId($entityName, 'IdSubEntity');
                self::renderId($subEntityName[0]);
                self::renderEntity($subEntityName[0]);
                break;
            case 'ListSubEntity':
                self::renderId($entityName);
                if (isset($filterName) && $filterName != "") {
                    self::renderFormRow('<i>Optional filters:</i>');
                    self::renderEntity($filterName);
                }
                
                self::renderFormRow('<i>Pagination:</i>');
                self::renderEntity('Pagination');
                break;
            case 'CreateKycPageByFile':
                self::renderId($entityName);
                self::renderId($subEntityName[1], 'IdSubEntity');
                self::renderFormRow('<tr><td></td><td><input type="file" name="kyc_page" /></td></tr>');
                break;
        }
        
        // special cases
        /*switch ($module) {
            case 'Wallet_Wallets_ListSubEntity_GetTransaction':
                self::renderFormRow('<i>Optional filters:</i>');
                self::renderEntity('FilterTransactions');
                self::renderFormRow('<i>Pagination:</i>');
                self::renderEntity('Pagination');
                break;
            case 'Event_Events_ListEntity_GetAll':
                self::renderFormRow('<i>Optional filters:</i>');
                self::renderEntity('FilterEvents');
                self::renderFormRow('<i>Pagination:</i>');
                self::renderEntity('Pagination');
                break;
        }*/
        
        echo '<tr><td></td><td><input type="submit" value="' . $operation . '" /></td></tr>';
        echo '</table>';
        echo '<input type="hidden" name="_postback" value="1"/>';
        echo '</form>';
    }
    
    public static function renderEntity($entityName, $prefix = '') {

        $className = '\\MangoPay\\' . $entityName;
        $entity = new $className();
        $blackList = $entity->GetReadOnlyProperties();
        $entityObject = new \ReflectionObject($entity);
        
        $module = @$_GET['module'];
        $subObjects = $entity->GetSubObjects();
        $dependsObjects = $entity->GetDependsObjects();
        $depTypesInModule = explode(':', $module);

        $properties = $entityObject->getProperties();
        foreach ($properties as $property) {

            $name = $property->getName();
            
            if (in_array($name, $blackList))
                continue;
            
            // is sub object?
            $cls = @$subObjects[$name];
            if ($cls) {
                self::renderEntity(str_replace('\\MangoPay\\', '', $cls), "$name:");
                continue;
            }

            // is dependent object?
            $handled = false;
            foreach ($dependsObjects as $dep) {
                if ($dep['_property_name'] == $name) {
                    foreach ($depTypesInModule as $dt) {
                        $cls = @$dep[$dt];
                        if ($cls) {
                            self::renderEntity(str_replace('\\MangoPay\\', '', $cls), "$name:");
                            $handled = true;
                            break;
                        }
                    }
                    break;
                }
            }
            if ($handled) continue;

            // special fields
            if ($entityName == 'Pagination' && in_array($name, array('Links', 'TotalPages', 'TotalItems')))
                    continue;
            
            // normal fields
            $value = '';
            if (isset($entity->$name))
                $value = $entity->$name;
            
            echo '<tr><td>';
            echo $prefix . $name . ':</td><td>';
            if ($className == "\\MangoPay\\Hook" && $name == "EventType"){
                self::renderEnum("\\MangoPay\\EventType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\FilterEvents" && $name == "EventType"){
                self::renderEnum("\\MangoPay\\EventType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\KycDocument" && $name == "Type") {
                self::renderEnum("\\MangoPay\\KycDocumentType", $name, $prefix);
            } elseif ($className == "\\MangoPay\\KycDocument" && $name == "Status") {
                self::renderEnum("\\MangoPay\\KycDocumentStatus", $name, $prefix);
            } elseif ($className == "\\MangoPay\\Card" && $name == "Validity") {
                self::renderEnum("\\MangoPay\\CardValidity", $name, $prefix);
            }
            else
                echo '<input type="text" name="' . $prefix . $name . '" value="' . $value . '"/>';
            echo '</td></tr>';
        }
    }
    
    public static function renderEnum($enumClassName, $name, $prefix) {
        
        $enum = new $enumClassName();
        $enumObject = new \ReflectionObject($enum);
        $constants = $enumObject->getConstants();
        
        echo '<select name="' . $prefix . $name . '">';
        foreach ($constants as $constant) {
            echo '<option value="' . $constant . '">' . $constant . '</option>';
        }
        echo '</select>';
    }
    
    public static function renderFormRow($label = null, $field = null) {
        
        echo '<tr><td>';
        echo $label ? $label : '&nbsp;';
        echo '</td><td>';
        echo $field ? $field : '&nbsp;';
        echo '</td></tr>';
    }

    public static function renderId($entityName, $fieldName = 'Id') {
        
        $value = '';
        if (isset($_POST[$fieldName]))
            $value = $_POST[$fieldName];
        
        echo '<tr><td>';
        echo $entityName . ' Id:</td><td>';
        echo '<input type="text" name="' . $fieldName . '" value="' . $value . '"/></td></tr>';
    }
    
    public static function getEntity($entityName, $entityId = 0, $returnNullIfNoPropertyTouched = false, $prefix = '') {
        $touchedAnyProp = false;

        $className = '\\MangoPay\\' . $entityName;
        $entity = new $className($entityId);
        
        $entityObject = new \ReflectionObject($entity);
        $properties = $entityObject->getProperties();

        $module = @$_GET['module'];
        $subObjects = $entity->GetSubObjects();
        $dependsObjects = $entity->GetDependsObjects();
        $depTypesInModule = explode(':', $module);

        foreach ($properties as $property) {
            if (!$property->isPublic())
                continue;
            
            $name = $property->getName();

            $frmName = $prefix . $name;
            if (isset($_POST[$frmName]) && strlen($_POST[$frmName]) > 0) {

                // special fields for Owners property
                if ($entityName == 'Wallet' && $name == 'Owners')
                    $entity->$name = explode(';', $_POST[$frmName]);
                // special cast to int for Birthday property in UserNatural class
                elseif ($entityName == 'UserNatural' && $name == 'Birthday')
                    $entity->$name = (int)$_POST[$frmName];
                // normal fields
                else
                    $entity->$name = $_POST[$frmName];

                $touchedAnyProp = true;
            }
        }

        // sub objects
        foreach ($subObjects as $name => $cls) {
            $entity->$name = self::getEntity(str_replace('\\MangoPay\\', '', $cls), 0, true, "$name:");
        }

        // dependent objects
        foreach ($dependsObjects as $dep) {
            $name = $dep['_property_name'];
            foreach ($depTypesInModule as $dt) {
                $cls = @$dep[$dt];
                if ($cls) {
                    $entity->$name = self::getEntity(str_replace('\\MangoPay\\', '', $cls), 0, false, "$name:");
                    break;
                }
            }
        }

        if ($returnNullIfNoPropertyTouched && !$touchedAnyProp)
            return null;

        return $entity;
    }
}