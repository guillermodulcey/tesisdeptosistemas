<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Docente extends CI_Controller {

    
    public function index() {
        $this->load->view('docente/home');
    }

}