<?php

/**
 * myjobs sample code using Redis
 * 
 * This sample library mixed Redis client connection, which you can separate into components in
 * actual development.
 * 
 * @author  Nick Tsai <myintaer@gmail.com>
 * @package https://github.com/nrk/predis
 */
class MyjobsWithRedis
{
    /**
     * Redis key
     */
    const QUEUE_KEY = 'job';
    
    /**
     * Redis client
     *
     * @var Predis\Client
     */
    protected $redisClient;
    
    function __construct() 
    {
        // You can store Redis config into application config, for example: `$this->CI->config->item('redis', 'services');`
        $this->redisClient = new Predis\Client(['host'=>'45.76.151.122', 'scheme'=>'tcp', 'port'=>6379], ['parameters'=>['password'=>'rizkyrafcode8498']]);

        // Connection check
        try {

            $this->redisClient->type('test');

        } catch (Predis\Connection\ConnectionException $e) {

            if (ENVIRONMENT=='development') {
                throw $e;
            }
            // Prevent further error
            exit;
        }
    }

    /**
     * Check if there are any jobs from Redis queue
     *
     * @return boolean
     */
    public function exists()
    {
        return $this->redisClient->exists(self::QUEUE_KEY);
    }

    /**
     * Pop up a job from Redis queue
     *
     * @return array
     */
    public function popJob()
    {
        // Assume storing JSON string data in queue
        // Using LPOP or RPOP depends on your producer push
        $taskJSON = $this->redisClient->lpop(self::QUEUE_KEY);

        return json_decode($taskJSON, true);
    }

    /**
     * Process a job
     *
     * @param array $job
     * @return boolean
     */
    public function processJob($job)
    {
        // Your own job process here
        $this->sendNotification("fjBT7DwkD-g:APA91bFdsFJqLpxHIGrva7ABbGsWOqE8waL6EqJw56HYj385lGoJIVEIDlZk3Rrm0vqklmBldlbY4e6TRnKXrNIxcPO5OLqqF_8q3oSpbN9kG9oDcc2E0Ph1S4k0NpBMq62DfVnYZ-j1", "tes");

        return true;
    }

    function sendNotification($tokenUser, $msg){
        $registrationIds = array($tokenUser);
        // prep the bundle
        $pesanData = array
        (
            'title'     => "Pesan",
            'body'      => "$msg",
        );

        $fields = array
        (
            'registration_ids'  => $registrationIds,
            'notification'      => $pesanData,
            'data'              => array(
                'message'       => "$msg"
            )
        );

        $headers = array
        (
            'Authorization: key=AAAAcgqFh90:APA91bFDtxx7CFzrXnEY1tayjdX2iBBd7MtW0q2FDZKWrG7nZaWs4GsGza7BCxqvvGVtjkh59fUp39hU6B0XRVmrkmXxLbpRBU8SBm2n03njXSjLv92FDA1W55JJznyqidhIaQbnNuBu',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
    }
}
