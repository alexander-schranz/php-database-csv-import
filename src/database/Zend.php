<?php

class CsvImporter_Database_Zend implements CsvImporter_Database
{
    protected $db;

    function __construct ($db)
    {
        $this->db = $db;
    }

    public function insert ($table, $data)
    {
        foreach ($data as $line) {
            $this->db->insert($table, $line);
        }
        return true;
    }
}