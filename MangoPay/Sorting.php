<?php
namespace MangoPay;

/**
 * Base sorting object
 */
class Sorting
{
    /**
     * Fields separator in sort parameters in URL
     */
    const SortFieldSeparator = "_";
    
    /**
     * Fields separator in sort parameters in URL
     */
    const SortUrlParameterName = "Sort";
    
    /**
     * Array with fields to sort
     * @var array
     */
    private $_sortFields;
    
    /**
     * Add filed to sort
     * @param string $filedName Property name to sort
     * @param string $sortDirection Sort direction (ASC | DESC)
     */
    public function AddField($filedName, $sortDirection)
    {
        $this->_sortFields[$filedName] = $sortDirection;
    }

    /**
     * @deprecated Contains typo, kept for backward compatibility
     */
    public function AddFiled($filedName, $sortDirection)
    {
        //for backward compatibility from before typo fix
        $this->AddField($filedName, $sortDirection);
    }
    /**
     * Get sort parametrs to URL
     * @return array
     */
    public function GetSortParameter()
    {
        return array(self::SortUrlParameterName => $this->_getFields());
    }
    
    private function _getFields()
    {
        $sortValues = "";
        foreach ($this->_sortFields as $key => $value) {
            if (!empty($sortValues)) {
                $sortValues .= self::SortFieldSeparator;
            }
            
            $sortValues .= $key . ":" . $value;
        }
        
        return $sortValues;
    }
}
