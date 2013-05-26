<?php
/**
 * version 1.0RC
 */

class CsvImporter_Config_Column {
    protected $name;
    protected $matchCode = '';
    protected $combineDelimiter = '';
    
    function __construct ($name, $matchCode = '', $combineDelimiter = '') {
        $this->name = $name;
        $this->matchCode = $matchCode;
        $this->combineDelimiter = $combineDelimiter;
    }
    
    /**
     * Getters
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function getMatchCode()
    {
        return $this->matchCode;
    }
    
    public function getCombineDelimiter()
    {
        return $this->combineDelimiter;
    }
    
    /**
     * Setters
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function setMatchCode($matchCode)
    {
        $this->matchCode = $matchCode;
        return $this;
    }
    public function setCombineDelimiter($combineDelimiter)
    {
        $this->combineDelimiter = $combineDelimiter;
        return $this;
    }
}