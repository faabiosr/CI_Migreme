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
class Migreme_test extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('migreme');
        
        $results = array(
            'default'               => $this->migreme->call('http://fabiosribeiro.com.br/'),
            'json_string'           => $this->migreme->call('http://fabiosribeiro.com.br/','json'),
            'json_object'           => $this->migreme->call('http://fabiosribeiro.com.br/','json','object'),
            'xml_string'            => $this->migreme->call('http://fabiosribeiro.com.br/'),
            'xml_object'            => $this->migreme->call('http://fabiosribeiro.com.br/','xml','object'),
            'txt'                   => $this->migreme->call('http://fabiosribeiro.com.br/','txt'),
            'url_redirect_string'   => $this->migreme->call_redirect('http://migre.me/5KtT9'),
            'url_redirect_object'   => $this->migreme->call_redirect('http://migre.me/5KtT9','object')            
        );
        
        $this->_dump($results);
    }
    
    private function _dump($results){
        
        $data['results'] = $results;
        
        $this->load->view('dump',$data);
    }
}
