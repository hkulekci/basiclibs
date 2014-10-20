<?php
namespace BasicLibs;
/**
 * Language
 *
 * Implementation of the language for BasicMVC.
 * This class provides this interface:
 *
 * setLanguage( string $language )
 * getLanguage()
 * setDirectory( string $directory )
 * getDirector()
 * load( string $file )
 * get( string $param )
 *
 * @package BasicLib
 * @author Haydar KULEKCI <haydarkulekci@gmail.com>
 * @version 0.1
 */
class Language
{
    /**
     *  @var string
     */
    private $current_language = "";

    /**
     *  @var string
     */
    private $language_directory = "";

    /**
     *  Default value is "/" which is linux directory seperator.
     *
     *  @var string
     */
    private $directory_seperator = "/";

    /**
     *  @var array
     */
    private $language_params = array();

    /**
     *  Setting language to library
     *
     *  @param  string              $language
     *  @return boolean
     */
    public function setLanguage($language)
    {
        if (is_dir($this->language_directory . $language) &&
                file_exists($this->language_directory . $language)) {

            $this->current_language = $language;
            $this->load("common.php");
            return true;

        }
        return false;
    }


    /**
     *  Getting current language
     *
     *  @return boolean|string
     */
    public function getLanguage()
    {
        return ($this->current_language ? $this->current_language : false);
    }

    /**
     *  Setting languages directory to library
     *
     *  @param  string              $directory
     *  @return boolean|string
     */
    public function setDirectory($directory)
    {
        if (is_dir($directory) && file_exists($directory)) {
            $this->language_directory = $directory;
            return true;
        }
        return false;
    }

    /**
     *  Getting languages directory from library
     *
     *  @return boolean|string
     */
    public function getDirectory()
    {
        return ($this->language_directory ? $this->language_directory : false);
    }

    /**
     *  Load a Specific Language File and Merge language data to language_params
     *
     *  @param  string              $file
     *  @return boolean
     */
    public function load($file)
    {
        $file_path = $this->language_directory . $this->current_language .
            $this->directory_seperator . $file;

        if (is_file($file_path) && file_exists($file_path)) {
            $include = include($file_path);
            if (is_array($include)) {
                $this->language_params = array_merge($this->language_params, $include);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *  Getting a specific parameter from language_params
     *
     *  @param  string              $param
     *  @return boolean|string
     */
    public function get($param)
    {
        return ( isset($this->language_params[$param]) ? $this->language_params[$param] : false );
    }

} // END Language
