<?php
/**
 * Copyright 2011 Fábio da Silva Ribeiro.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/**
 * This class create a short url using Migre.Me 
 * @author Fábio da Silva Ribeiro
 * @access public
 * @version 1.0
 * @copyright Copyright © 2011, Fábio da Silva Ribeiro.
 */
class migreme {
    
    /**
     * Url for generate a short url.
     * @access private
     * @name $_api_url
     * @var string
     */
    private $_api_url = 'http://migre.me/api.';
    
    /**
     * Url for return a url shortened.
     * @access private
     * @name $_api_redirect_url
     * @var string
     */    
    private $_api_redirect_url = 'http://migre.me/api_redirect2.xml?url=';
    
    /**
     * Curl Handle
     * @access private
     * @name $_ch 
     */
    private $_ch;
    
    /**
     * Curl options
     * @access private
     * @name $_ch_opts
     * @var array 
     */
    private $_ch_opts;
    
    /**
     * Migre.Me result
     * @access private
     * @name $_resutl
     * @var string 
     */
    private $_result;
    
    /**
     * Constructor
     * @access public
     */
    public function __construct() {
        $this->_ch = curl_init();
        
        $this->_ch_opts[CURLOPT_RETURNTRANSFER] = TRUE;
    }
    
    /**
     * This method send the informations to create a short url.
     * @param string $url
     * @param string $type
     * @param string $return
     * @return migreme 
     */
    public function call($url,$type = 'xml',$return = 'string'){
        
        if(!filter_var($url,FILTER_VALIDATE_URL)){
            throw new migremeException('Invalid url',100);
        }
        
        $this->_ch_opts[CURLOPT_URL] = $this->_api_url.$type.'?url='.urlencode($url);
        
        curl_setopt_array($this->_ch, $this->_ch_opts);
        
        $this->_result = curl_exec($this->_ch);
        
        if($return == 'object'){
            return $this->toObject();
        }
        
        return $this->toString();
    }
    
    /**
     * Return the url shortened to default url 
     * @param string $url
     * @param string $return
     * @return migreme 
     */
    public function call_redirect($url,$return = 'string'){
        
        if(!filter_var($url,FILTER_VALIDATE_URL)){
            throw new migremeException('Invalid url',100);
        }
        
        if(preg_match("/(http\:\/\/migre.me\/)([a-zA-Z0-9]+)/",$url)){
            $this->_ch_opts[CURLOPT_URL] = $this->_api_redirect_url.urlencode($url);
            
            curl_setopt_array($this->_ch, $this->_ch_opts);
        
            $this->_result = curl_exec($this->_ch);            
        }
        
        if($return == 'object'){
            return $this->toObject();
        }
        
        return $this->toString();
    }
    
    /**
     * Result to string
     * @return string 
     */
    private function toString(){
        return $this->_result;
    }
    
    /**
     * Result to object
     * @return object
     */
    private function toObject(){
        $result = json_decode($this->_result);
        
        if($result){
            return $result;
        }
        
        if(simplexml_load_string($this->_result,null, LIBXML_NOERROR)){
            return simplexml_load_string($this->_result,null, LIBXML_NOCDATA);
        }
        
        return FALSE;
    }
}

/**
 * migremeException
 * @author Fábio da Silva Ribeiro
 * @access public
 * @version 1.0
 * @copyright Copyright © 2011, Fábio da Silva Ribeiro.
 */
class migremeException extends Exception{
    
    /**
     * Constructor
     * @param string $message
     * @param int $code 
     */
    public function __construct($message,$code){
        parent::__construct($message, $code);
    }
}