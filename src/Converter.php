<?php

class CsvImporter_Converter {
    protected $csv;
    protected $config;
    
    protected $data = array();
    
    function __construct($path, $file, $config, $csv = '')
    {
        $this->config = $config;
        
        $delimiter = $this->config->getDelimiter();
        $enclosure = $this->config->getEnclosure();
        $escape = $this->config->getEscape();
        
        $this->csv = new CsvImporter_csv($csv,  $path, $file, $delimiter, $enclosure, $escape);
    }
    
    public function convert()
    {
        $convertedData = array();
        
        $data = $this->csv->getData();
        
        if (count($data) > 0) {
            $matchCodes = $this->getMatchCodes($data);
            
            $lineCounter = 0;
            // Get Every Line vom CSS
            foreach ($data as $line) {
                // Only get Lines where not Ignored
                if ($lineCounter >= $this->config->getIgnoredRows()) {
                    $data = array();
                    
                    $counter = 0;
                    // Get Confic Columns
                    foreach ($this->config->getColumns() as $column) {
                        // Get Line Column Property
                        if ($this->config->hasMatchCodes()) {
                            $property = $line[$matchCodes[$column->getMatchCode()]];
                        } else {
                            $property = $line[$matchCodes[$counter]];
                        }
                        
                        // Trim Data
                        if ($this->config->doTrim()) {
                            $property = trim ($property);
                        }
                        
                        // Combine Data
                        if ($this->config->doCombine()) {
                            if (isset($data[$column->getName()])) {
                                $data[$column->getName()] = $data[$column->getName()] . $column->getCombineDelimiter() . $property;
                            } else {
                                $data[$column->getName()] = $property;
                            }
                        } else {
                            $data[$column->getName()] = $property;
                        }
                        $counter++;
                    }
                    $convertedData[] = $data;
                }
                $lineCounter++;
            }
        }
        
        $this->data = $convertedData;
        
        return $this->data;
    }
    
    protected function getMatchCodes($data) {
        $matchCodes = array();
        if (count($data[0]) > 0) {
            $counter = 0;
            foreach ($data[0] as $column) {
                if ($this->config->hasMatchCodes()) {
                    if ($this->config->doTrim()) {
                        $column = trim($column);
                    }
                    $matchCodes[$column] = $counter + $this->config->getIgnoredColumns();
                } else {
                    $matchCodes[$counter] = $counter + $this->config->getIgnoredColumns();
                }
                $counter++;
            }
        }
        
        return $matchCodes;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function getCsv()
    {
        return $this->csv;
    }
    
    public function getConfig()
    {
        return $this->config;
    }

}