<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use yidas\queue\worker\Controller as WorkerController;

class My_worker extends WorkerController {
	
	// Setting for that a listener could fork up to 10 workers
    public $workerMaxNum = 10;
    
    // Enable text log writen into specified file for listener and worker
    // public $logPath = 'tmp/my-worker.log';

	    // Initializer
	protected function init() {
		// $this->load->library('MyjobsWithRedis');
	}

    // Worker
	protected function handleWork() {
		        // Your own method to get a job from your queue in the application
		$job = $this->myjobswithredis->popJob();

        // return `false` for job not found, which would close the worker itself.
		// if (!$job)
		// 	return false;

        // Your own method to process a job
		$this->myjobswithredis->processJob($job);

        // return `true` for job existing, which would keep handling.
		return true;
	}

    // Listener
	protected function handleListen() {
		return $this->myjobswithredis->exists();
	}

}

/* End of file My_worker.php */
/* Location: ./application/controllers/My_worker.php */