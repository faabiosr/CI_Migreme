<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author fabio
 */
class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('migreme');
        
        
        $url = $this->migreme->call('http://falapapai.com.br/','json');  
        $url_redirect = $this->migreme->call_redirect('http://migre.me/5KrZE');  
        
        $this->_dump($url->toString());
        $this->_dump($url_redirect->toObject());
    }
    
    private function _dump($result){
        var_dump($result);
    }
}