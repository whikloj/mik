<?php
// src/filegettermanipulators/FilterCdmNewspaperMasterPaths.php

namespace mik\filegettermanipulators;
use \Monolog\Logger;

/**
 * FilterCdmNewspaperMasterPaths - Filter out paths to master (OBJ) files.
 */
class FilterCdmNewspaperMasterPaths extends Filegettermanipulator
{
    /**
     * Create a new FilterCdmNewspaperMasterPaths instance
     */
    public function __construct($settings = null, $paramsArray, $record_key)
    {
        parent::__construct($settings, $paramsArray, $record_key);

        // Set up logger.
        $this->pathToLog = $settings['LOGGING']['path_to_manipulator_log'];
        $this->log = new \Monolog\Logger('config');
        $this->logStreamHandler = new \Monolog\Handler\StreamHandler($this->pathToLog,
            Logger::INFO);
        $this->log->pushHandler($this->logStreamHandler);

        // This manipulator expects at least 2 parameters. The first either 'out'
        // or 'in' and the rest are regex patterns, without the leading and
        // trialing delimters. These patterns cannot contain pipes.
        if (count($paramsArray) > 1) {
            $this->direction = $paramsArray[0];
            $patterns = array_slice($paramsArray, 1);
            $this->patterns = implode('|', $patterns);
        } else {
          $this->log->addError("FilterCdmNewspaperMasterPaths",
              array('Incorrect number of parameters' => count($paramsArray)));
        }
    }

    /*
     * Filters out filepaths for master files.
     *
     * @param $path string
     *    A file path to test.
     *
     * @return mixed
     *    An array of possible file paths, or false if none can be genreated.
     */
    public function filterMasterFilePath($path)
    {
        $pattern = '#(' . $this->patterns . ')#i';

        if ($this->direction == 'out') {
            if (preg_match($pattern, $path)) {
                $this->log->addInfo("FilterCdmNewspaperMasterPaths",
                    array('Path has been removed from master file path list' => $path));
                return false;
            }
            else {
                return true;
            }
        }
        elseif ($this->direction == 'in') {
            if (preg_match($pattern, $path)) {
                $this->log->addInfo("FilterCdmNewspaperMasterPaths",
                    array('Path has been added to master file path list' => $path));
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return true;
        }
    }

}

