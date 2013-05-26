<?php
/**
 * version 1.0.1
 * Release Candidate
 */

class CsvImporter_csv {
    protected $path = '';
    protected $filename = '';
    protected $data;

    function __construct($csv, $path = '', $filename = '', $delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        $imported = array();
        
        $this->path = $path;
        $this->filename = $filename;
    
        if ($this->filename != '') {
            // Import and Parse CSV from File
            if (($handle = fopen($this->getFilePath(), "r")) !== FALSE) {
                while (($row = fgetcsv($handle, 0, $delimiter, $enclosure, $escape)) !== FALSE) {
                    $imported[] = $row;
                }
            }
        } else {
            // Parse CSV from String
            $csv = str_replace ('\n\r', '\n', $csv); // Reset EoL to "\n"
            $rows = explode ('\n', $csv);
            foreach ($rows as $row) {
                $imported[] = str_getcsv($row, $delimiter, $enclosure, $escape);
            }
        }
        
        $this->data = $imported;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function getFilePath()
    {
        return $this->path . '/' . $this->filename;
    }
}