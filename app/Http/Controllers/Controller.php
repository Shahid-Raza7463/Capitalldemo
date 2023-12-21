<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	
    public function sendGCMBulk($user, $title, $subTitle, $message, $activeIntent)
    { 
    //dd($user);
        
        foreach ($user as $userAryData) {
            // dd()
            //              $this->GCM($userAryData,$title, $message);
            $device_id[] = $userAryData->fcm;
        }
     //dd(array($device_id));


        $this->GCMBulk($device_id,  $activeIntent,  $title,  $subTitle,  $message);
    }
    public function GCMBulk($userAryData, $intentType, $title, $subTitle, $plainTextBody)
    {

        $deviceId = $userAryData;
        if (!empty($deviceId)) {
            $url = 'https://fcm.googleapis.com/fcm/send';

            $fields = array(
                'registration_ids' => $deviceId,
                'data' => array(
                    "intentType" => $intentType,
                    "mTitle" => $title,
                    "subTitle" => $subTitle,
                    "mBody" => strip_tags($plainTextBody),
                    'vibrate' => 1,
                    'sound' => 1
                ),'notification' => array(
                "body" => strip_tags($plainTextBody),
                'title' => $title,
                "icon" => "myicon"
                 ),
            );
            $fields = json_encode($fields);
            //      echo $fields;
         //   dd($fields);
           $firebase_api='AAAASUr7ctk:APA91bGlllfWPIOkOd4TQqCaJHgkn2M8MGqrWXDHbkIgaxm-GsUsX_G1MeiiCsac_lcrv5JlsfNYLGPjx5jn9FF66qM9FxfoD2_jL14kEfg9V2y_EcgFMuaFWO00h1YX5H6Q_mJuj58g';
            $headers = array(
               'Authorization: key=' . $firebase_api,
			   'Content-Type: application/json'
            );

            $url = 'https://fcm.googleapis.com/fcm/send';
 
						$headers = array(
							'Authorization: key=' . $firebase_api,
							'Content-Type: application/json'
						);
						
						// Open connection
						$ch = curl_init();
 
						// Set the url, number of POST vars, POST data
						curl_setopt($ch, CURLOPT_URL, $url);
 
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
						// Disabling SSL Certificate support temporarily
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
						curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
 
						// Execute post
						$result = curl_exec($ch);
						if($result === FALSE){
							die('Curl failed: ' . curl_error($ch));
						}
 
						// Close connection
						curl_close($ch);
						
						//echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
						//echo json_encode($fields,JSON_PRETTY_PRINT);
						//echo '</pre></p><h3>Response </h3><p><pre>';
						//echo $result;
						//echo '</pre></p>';
						
						
						return $result;
        }
    }
}
