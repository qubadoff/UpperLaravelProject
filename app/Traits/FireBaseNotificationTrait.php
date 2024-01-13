<?php

namespace App\Traits;

trait FireBaseNotificationTrait
{
    public function __construct(){}

    public function sendNotification($fmc_token): void
    {

        $data_string = array(
            'to' => $fmc_token,
            'notification' => [
                'title' => 'Ticket Operation',
                'body' => 'New ticket operation !',
            ]
        );

        $headers = array(
            'Authorization: key=' . env('FCM_SERVER_KEY'),
            'Content-Type: application/json',
        );

        $url= 'https://fcm.googleapis.com/fcm/send';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($data_string));
        curl_exec($ch);
        curl_close($ch);
    }
}
