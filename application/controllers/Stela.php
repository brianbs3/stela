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

        $data['randomInspiration'] = $this->getRandomInspiration(false);
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

    public function getRandomInspiration($json=true)
    {
        $this->load->model('stela_model');
        $c = $this->stela_model->getInspirationCount();
        if(isset($c[0]['c']))
            $count = $c[0]['c'];
        else
            die('failed to get inspiration count');

        $random = rand() % $count + 1;
        $quote = $this->stela_model->getInspiration($random);
        if(isset($quote[0]['inspiration']))
            return $quote[0]['inspiration'];
        return null;
    }

    function clientSearch($term = ''){
        $this->load->model('clients_model');
        $result = $this->clients_model->clientSearch($term);
        return $result;

    }

    public function buildClientSelect($term = '') {
        $this->load->model('clients_model');
        $clients = $this->clientSearch($term);

        $select = "";
        foreach($clients as $c){
            $select .= "<option value={$c['id']}>{$c['firstName']} {$c['lastName']}</option>";
        }

        return $select;
    }

    public function buildClientSelectAJAX() {
        $term = $this->input->get('term', true);
        echo"term: $term";
        $this->load->model('clients_model');
        $clients = $this->clientSearch($term);

        $select = "";
        foreach($clients as $c){
            $select .= "<option value={$c['id']}>{$c['firstName']} {$c['lastName']}</option>";
        }

        echo $select;
    }

    public function format_dob($m, $d, $y){
        if($m && $d && $y)
            return "$m/$d/$y";
        return "";
    }
}
