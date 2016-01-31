<?php

namespace mik\filegettermanipulators;

/**
 * @file
 * Filegettermanipulator Abstract class.
 */

abstract class Filegettermanipulator
{

    /**
     * Create a new Filegettermanipulator instance.
     *
     * @param array $settings configuration settings.
     * @param array $paramsArray array of manipulator paramaters provided in the configuration
     * @param string $record_key the record_key (CONTENTdm pointer, CSV row id)
     */
    public function __construct($settings = null, $paramsArray = array(), $record_key)
    {
       $this->settings = $settings;
       $this->paramsArray = $paramsArray;
       $this->record_key = $record_key;
    }

    /**
     * Generates possible filepaths for master files.
     *
     * @return mixed
     *    An array of possible file paths, or false if none can be genreated.
     */
    public function getMasterFilePaths()
    {
    }

    /**
     * Tests filepath for master file to see if it matches parmaterized patterns.
     *
     * @return bool
     *    True if it is to be included in the list of all valid
     *    paths, false if the path is not to be included.
     */
    public function filterMasterFilePath($path)
    {
    }


}
