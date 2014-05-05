<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public $email;
    public $password;

    function __construct() {
        parent::__construct();
    }

}
