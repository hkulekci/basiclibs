<?php
namespace BasicLibs;
/**
 * Curl
 *
 * Basicly PHP-Curl wrapper for BasicMVC.
 * This class provides this interface:
 *
 * setUseragent( string $useragent )
 * getUserAgent( string $useragent )
 * get( string $url, array $data )
 * post( string $url, array $data )
 *
 * @package BasicLib
 * @author Haydar KULEKCI <haydarkulekci@gmail.com>
 * @version 0.1
 */
class Curl
{
    /**
     *  User Agent information of the request
     *
     *  @var string
     */
    private $useragent = "";

    /**
     *   Setting the useragent information
     *
     *   @param  string      $useragent
     */
    public function setUseragent($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     *   Getting the useragent information
     *
     */
    public function getUserAgent()
    {
        return $this->useragent;
    }

    /**
     *   HTTP GET Request with PHP-Curl
     *
     *   @param  string     $url
     *   @param  array      $data
     *   @param  string     => errors are json formatted string
     */
    public function get($url, $data = array())
    {
        $url = $this->buildURL($url, $data);
        $resp = "";
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => $this->useragent
            ));

            $resp = curl_exec($curl);
            if (curl_errno($curl)) {
                return json_encode(array("error" => "Curl Error : " . curl_errno($curl)));
            }
            curl_close($curl);
        } catch (Exception $e){
            return json_encode(array('error' => "Curl Exception Error"));
        }
        return $resp;
    }

    /**
     *   HTTP POST Request with PHP-Curl
     *
     *   @param  string     $url
     *   @param  array      $data
     *   @param  string     => errors are json formatted string
     */
    public function post($url, $data = array())
    {
        $resp = "";
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => $this->useragent,
                CURLOPT_POST => 1,
                CURLOPT_ENCODING => "UTF-8",
                CURLOPT_POSTFIELDS => http_build_query($data)
            ));

            $resp = curl_exec($curl);
            if (curl_errno($curl)) {
                return json_encode(array("error" => "Curl Error : " . curl_errno($curl)));
            }
            curl_close($curl);
        } catch (Exception $e){
            return json_encode(array('error' => "Curl Exception Error"));
        }
        return $resp;
    }

    /**
     *   Build a HTTP Request Url for PHP-Curl
     *
     *   @param  string     $url
     *   @param  array      $data
     *   @param  string
     */
    public function buildURL($url, $data = array())
    {
        return $url . (empty($data) ? '' : '?' . http_build_query($data));
    }

}
