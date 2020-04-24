<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = '482205672789-flab0s8c0o2q5844v4h1mqlgdagcmvuj.apps.googleusercontent.com';
$config['google']['client_secret']    = '3j8-qpvRXVhvgV51towcEqi0';
$config['google']['redirect_uri']     = base_url() . 'user/index';
$config['google']['application_name'] = 'IdEA';
$config['google']['api_key']          = 'AIzaSyCDCCeQqtEizwc7JKj608ueozYKz9w0Lj0';
$config['google']['scopes']           = array('email', 'profile');