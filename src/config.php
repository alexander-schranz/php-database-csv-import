<?php
/**
 * version 1.0RC
 */

require_once (dirname(__FILE__) . '/config_column.php');

class CsvImporter_Config {
    
    protected $configpath;
    
    // Database
    private $database;
    private $databaseServer;
    private $databaseUsername;
    private $databasePassword;
    
    private $table;
    
    // Convert Settings ( BOOLS )
    private $matchCode;
    private $combine;
    private $trim;
    
    // CSV Settings
    private $ignoredRows;
    private $ignoredColumns;
    
    private $delimiter;
    private $enclosure;
    private $escape;
    
    // Columns
    private $columns = array();
    
    function __construct ($configpath)
    {
        $this->configpath = $configpath;
        
        $configXml = simplexml_load_file ($configpath);
        
        // Database
        $this->setProperty('databaseServer', $configXml->database->connection->server)
            ->setProperty('database', $configXml->database->connection->database)
            ->setProperty('databaseUsername', $configXml->database->connection->username)
            ->setProperty('databasePassword', $configXml->database->connection->password)
            
            ->setProperty('table', $configXml->database->table->name)
        // Convert Settings
            ->setProperty('matchCode', $configXml->match->code)
            ->setProperty('combine', $configXml->match->combine)
            ->setProperty('trim', $configXml->match->trim)
        // CSV Settings
            ->setProperty('delimiter', $configXml->csv->delimiter)
            ->setProperty('enclosure', $configXml->csv->enclosure)
            ->setProperty('escape', $configXml->csv->escape)
            ->setPropertyInt('ignoredRows', $configXml->csv->ignored->rows)
            ->setPropertyInt('ignoredColumns', $configXml->csv->ignored->columns);
            
        // Columns
        foreach ($configXml->columns[0] as $xmlColumn) {        
            $name = $this->convertProperty($xmlColumn->name);
            $matchCode = $this->convertProperty($xmlColumn->matchcode);
            $combineDelimiter = $this->convertProperty($xmlColumn->combinedelimiter);
            
            $column = new CsvImporter_Config_Column($name, $matchCode, $combineDelimiter);
            
            $this->addColumn ($column);
        }
    }
    
    private function setProperty($name, $property)
    {
        $this->$name = $this->convertProperty($property);
        return $this;
    }
    private function setPropertyInt($name, $property)
    {
        $this->$name = intval($property);
        return $this;
    }
    
    private function convertProperty ($property)
    {
        // Convert Bool
        if ($property == 'true') {
            $property = true;
        } else if($property == 'false') {
            $property = false;
        } else {
        // Parse To String
            if (!empty($property)) {
                $property = (string) $property;
            } else {
                $property = null;
            }
        }
        return $property;
    }
    
    /**
     * Columns
     */
     public function getColumns()
     {
        return $this->columns;
     }
     
     public function setColumns($columns)
     {
        $this->columns = $columns;
        return $this;
     }
     
     public function addColumn ($column)
    {
        $this->columns[] = $column;
    }

    /**
     * Convert Settings
     */
    public function hasMatchCodes()
    {
        return $this->matchCode;
    }
    
    public function doCombine()
    {
        return $this->combine;
    }
    
    public function doTrim()
    {
        return $this->trim;
    }
    
    /**
     * CSV Settings
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }
    
    public function getEnclosure()
    {
        return $this->enclosure;
    }
    
    public function getEscape()
    {
        return $this->escape;
    }
    
    public function getIgnoredRows()
    {
        return $this->ignoredRows;
    }
    
    public function getIgnoredColumns()
    {
        return $this->ignoredColumns;
    }
    
    public function setDelimiter ($delimiter)
    {
        $this->delimiter = delimiter;
        return $this;
    }
    
    public function setEnclosure ($enclosure)
    {
        $this->enclosure = enclosure;
        return $this;
    }
    
    public function setEscape ($escape)
    {
        $this->escape = escape;
        return $this;
    }
    
    public function setIgnoredRows($ignoredRows)
    {
        $this->ignoredRows = $ignoredRows;
        return $this;
    }
    
    public function setIgnoredColumns($ignoredColumns)
    {
        $this->ignoredColumns = $ignoredColumns;
        return $this;
    }
    
    /**
     * Database Table
     */
     public function getTable()
     {
        return $this->table;
     }
     
     public function setTable($table)
     {
        $this->table = $table;
        return $this;
     }
    
    /**
     * Database Connection
     */
    public function setDatabaseConnection ($server, $username, $password)
    {
        $this->databaseServer = $server;
        $this->databaseUsername = $username;
        $this->databasePassword = $password;
        return $this;
    }
    
    public function getDatabase()
    {
        return $this->database;
    }
    
    public function getDatabaseServer()
    {
        return $this->databaseServer;
    }
    
    public function getDatabaseUsername()
    {
        return $this->databaseUsername;
    }
    
    public function getDatabasePassword()
    {
        return $this->databasePassword;
    }
    
    /**
     * Config path 
     */
    public function getConfigPath()
    {
        return $this->configpath;
    }
}
