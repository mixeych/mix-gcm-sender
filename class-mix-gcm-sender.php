<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('MIXGCMSender')){
    
    class MIXGCMSender
    {
        private $apiKey;
        private $message;
        
        public function __construct()
        {
            $val = get_option('MIXGCMAPI');
            $this->apiKey = $val['input'];
            $val = get_option('MIXGCMMessage');
            $this->message = $val['input'];
            
        }
        
        public function sendMessage($ids = array())
        {
            if(!is_array($ids)||empty($ids)){
                return false;
            }
            if(empty($this->apiKey)||empty($this->message)){
                return false;
            }
            $headers = array(
                'Authorization: key=' . $this->apiKey,
                'Content-Type: application/json'
            );
            $data = array( 'message' => $this->message );
            $post = array(
                'registration_ids' => $ids,
                'data' => $data,
            );
            
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send' );
            // Set request method to POST       
            curl_setopt( $ch, CURLOPT_POST, true );
            // Set custom request headers       
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
            // Get the response back as string instead of printing it       
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            // Set JSON post data
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
            // Actually send the request    
            $result = curl_exec( $ch );
            // Handle errors
            if ( curl_errno( $ch ) )
            {
                return 'GCM error: ' . curl_error( $ch );
            }
            // Close curl handle
            curl_close( $ch );
            return $result;
        }
    }
}