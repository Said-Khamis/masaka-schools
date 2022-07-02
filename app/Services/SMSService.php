<?php
namespace App\Services;
use GuzzleHttp\Client;      


class SMSService {

    public $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function sendOtp($phone) {
        $url = 'https://messaging-service.co.tz/api/sms/v1/text/single';

        $otp = rand(1000, 9999);
        session(['session_otp'=> $otp]);
        session(['mobile_number'=> $phone]);

        try {
            $response = $this->client->request('POST', $url, [
                "verify" => false,
                "json" => [
                    "from"   => "NOUGAT", 
                    "to"     => $phone, 
                    "text"   => "$otp is your verification code for Africa Safariz"
                ]
            ]);
            $statuscode = $response->getStatusCode();
            if ($statuscode == 200) {
                $responseData = json_decode($response->getBody()->getContents()); 
                echo json_encode($responseData);               
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getMessage();
            // $responseBodyAsString = $response->getBody()->getContents(); 
            return redirect()->route('register')->with('error', $response);           
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            $response = $e->getMessage();            
            return redirect()->route('register')->with('error', $response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getMessage();
            // $responseBodyAsString = $response->getBody()->getContents(); 
            return redirect()->route('register')->with('error', $response);           
        }
    }

    public function resetPassword($phone, $token) {
        $url = 'https://messaging-service.co.tz/api/sms/v1/text/single';

        session(['token'=> $token]);
        session(['mobile_number'=> $phone]);
        $base_url = $this->base_url();

        try {
            $response = $this->client->request('POST', $url, [
                "verify" => false,
                "json" => [
                    "from"   => "NOUGAT", 
                    "to"     => $phone, 
                    "text"   => "You are receiving this sms because we received a password request for your account. Please click ".route('reset.password.get', $token)." to reset your password."
                ]
            ]);
            $statuscode = $response->getStatusCode();
            if ($statuscode == 200) {
                $responseData = json_decode($response->getBody()->getContents()); 
                echo json_encode($responseData);               
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getMessage();
            // $responseBodyAsString = $response->getBody()->getContents(); 
            return redirect()->route('register')->with('error', $response);           
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            $response = $e->getMessage();            
            return redirect()->route('register')->with('error', $response);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getMessage();
            // $responseBodyAsString = $response->getBody()->getContents(); 
            return redirect()->route('register')->with('error', $response);           
        }
    }

    public function base_url(){
        return sprintf(
          "%s://%s%s",
          isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
          $_SERVER['SERVER_NAME'],
          $_SERVER['REQUEST_URI']
        );
      }
}