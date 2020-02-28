<?php

namespace App\Extras;

class Curl{
    protected $_useragent = 'Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0';
    protected $_url;
	protected $_followlocation;
	protected $_timeout;
	protected $_httpheaderData = array();
	protected $_httpheader = array('Expect:');
	protected $_maxRedirects;
	protected $_cookieFileLocation;
	protected $_post;
	protected $_postFields;
	protected $_referer ="https://www.google.com/";

	protected $_session;
	protected $_webpage;
	protected $_includeHeader;
	protected $_noBody;
	protected $_status;
	protected $_binary;
    protected $_binaryFields;
    private $_curl;

	public    $authentication = false;
	public    $auth_name      = '';
    public    $auth_pass      = '';

    public function __construct(
                                $followlocation = true,
                                $timeOut = 30,
                                $maxRedirecs = 4,
                                $binary = false,
                                $includeHeader = false,
                                $noBody = false )
        {
            $this->_followlocation = $followlocation;
            $this->_timeout = $timeOut;
            $this->_maxRedirects = $maxRedirecs;
            $this->_noBody = $noBody;
            $this->_includeHeader = $includeHeader;
            $this->_binary = $binary;

            $this->_cookieFileLocation = app_path().'/../files/cookie.txt';

            $this-> _curl = curl_init();
        }

        public function load_params($url,$data = array()){
            $this->_url = $url;
            curl_setopt($this->_curl,CURLOPT_URL,$this->_url);
			curl_setopt($this->_curl,CURLOPT_HTTPHEADER,$this->_httpheader);
			curl_setopt($this->_curl,CURLOPT_TIMEOUT,$this->_timeout);
			curl_setopt($this->_curl,CURLOPT_MAXREDIRS,$this->_maxRedirects);
			curl_setopt($this->_curl,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($this->_curl,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
			curl_setopt($this->_curl,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
			curl_setopt($this->_curl,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);

            curl_setopt($this->_curl,CURLOPT_USERAGENT,$this->_useragent);
            curl_setopt($this->_curl,CURLOPT_REFERER,$this->_referer);
        }

        public function exec(){
            $this->_webpage = curl_exec($this->_curl);
            $this->_status = curl_getinfo($this->_curl,CURLINFO_HTTP_CODE);
            curl_close($this->_curl);
            return $this->_webpage;
        }

        public function setPost($postFields = array() ){
            $this->_binary = false;
            $this->_post = true;
            $this->_postFields = http_build_query($postFields);
            curl_setopt($this->_curl,CURLOPT_POST,true);
            curl_setopt($this->_curl,CURLOPT_POSTFIELDS,$this->_postFields);
        }
}
