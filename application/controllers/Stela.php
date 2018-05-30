<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stela extends CI_Controller {

	public function index()
	{
		$this->load->view('stelaMain');
	}

  public function dump_array($a)
  {
    $data['array'] = $a;
    $this->load->view('dumpArray', $data);
  }

  /*
   *    Take in an area code, prefix, and line number and return a formatted string
   *
   */
  public function formatPhoneNumber($a, $p, $l) { return "($a) $p-$l"; }

  public function bool2txt($b) { return ($b) ? "Yes" : "No"; }
}
