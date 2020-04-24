<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Google extends Google_Client {
    function __construct($params = array()) {
        parent::__construct();
    }
}