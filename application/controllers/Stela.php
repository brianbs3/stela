<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stela extends CI_Controller {

    public function index() {
        /*
         *  Set up permissions here...
         *
         */
        $data['data']['user'] = 'bs';
        $data['data']['admin'] = false;

        $this->load->view('stelaMain', $data);
    }

    public function dump_array($a)  {
        echo"<pre>";
        print_r($a);
        echo"</pre>";
    }

    /*
    *    Take in an area code, prefix, and line number and return a formatted string
    *
*/
    public function formatPhoneNumber($a, $p, $l) { return "($a) $p-$l"; }

    public function bool2txt($b) { return ($b) ? "Yes" : "No"; }

    public function getStylists() {
        $this->load->model('stylists_model');
        $c = $this->stylists_model->getStylists();
        return $c;
    }
}
