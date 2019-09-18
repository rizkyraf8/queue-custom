<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Worker extends CI_Controller {

	public function start($worker_name = "", $queues = "")
	{
		$this->jobs->worker($worker_name, $queues, 2);
	}

}

/* End of file Worker.php */
/* Location: ./application/controllers/Worker.php */