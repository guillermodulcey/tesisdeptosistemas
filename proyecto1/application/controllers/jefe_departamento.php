<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jefe_Departamento extends CI_Controller {

    
     public function tmp($pag) {
        $this->$pag();
    }

    private function index() {
        $this->load->view('jefe_departamento/home');
    }
}