<?php
use Concerns\InteractsWithInput;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

function apiReturn ($data = [], $message = 'Success', $status = 'success', $errors = []) {

    $return = [
        'data' => $data,
        'message' => $message,
        'status' => $status,
    ];

    if(!empty($errors)){
        $return['errors'] = $errors;
    }

    return response()->json($return);
}


// Guzzle for API
function guzzle($method, $link, $params = []){

    $client = new Client();

    $headers = [];
    if(!empty(getLoggedUser())){
        $headers = [
            'Authorization' => 'Bearer ' . getLoggedUser()['jwt_token'],
        ];
    }

    $data = json_decode($client->request($method, $link, [
        'headers' => $headers,
        "json"=> $params,
    ])->getBody(), true);

    return $data;

}

function storeLoggedUser($data){
    // Cookie::queue(Cookie::forever('authUser', 'sad'));
    session()->put('authUser', $data);
    return session()->get('authUser');

}

function getLoggedUser(){

    return session()->get('authUser');
    // $header = $this->header('Authorization', '');
    // if (Str::startsWith($header, 'Bearer ')) {
    //     return Str::substr($header, 7);
    // }
}
