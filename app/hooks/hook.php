<?php

class hook extends CI_Controller
{		
	private $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function manager_log() 
	{
		if( (strpos($this->CI->uri->segment(2), '_process') === false 
			&& $this->CI->uri->segment(2) != 'setting'
			&& $this->CI->uri->segment(2) != 'provider') 
				|| $this->CI->uri->segment(2) == 'market_connector_process') {
                
			$this->CI->load->library('managerlog');
			$this->CI->managerlog->insertData();
		}
	}
}
