<?php

use LDAP\Result;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require_once '../models/user.php';



$app->post('/users/login', function ($request, $response, $args) {
    global $payload;
    $err = '';
    $user = new User();

    $input = $request->getBody();
    $input = json_decode($input, true);

    if (!$input['name']) $err = "Invalid name";
    elseif (!$input['email']) $err = "email Invalid";
    else {

        $result = $user->userLogin($input['name'], $input['email']);
        if (count((array)$result) > 0) {
            function randomString(){
                $char = "dadsklfjasodsfhas9er30292390842ojfowae";
                $token = "";
                for($i=0; $i<10; $i++){
                    $token = $char[rand(10, strlen($char))];
                }
                return $token;
            }
             $token = randomString();  
            $payload["data"] = $token;
            
        } else {
            $payload['code'] = 404;
            $payload["message"] = "Invaild credentials";

        }


        if ($err != null) {
            $payload['code'] = 404;
            $payload['message'] = "ERROR";
        }
        return $user->apiResponse($response, $payload, $payload['code']);
    }
});


$app->get('/users/get', function ($request, $response, $args) {
    global $payload;
    $user = new User();

    $result = $user->getUser();

    if ($result && count($result) > 0) {
        $payload["data"] = $result;
    } else {
        $payload["message"] = "Failed";
    }
    return $user->apiResponse($response, $payload, $payload['code']);
});


//
$app->post('/users/insert', function ($request, $response, $args) {
    global $payload;
    $err = '';
    $user = new User();

    $input = $request->getBody();
    $input = json_decode($input, true);

    if (!$input['name'])  $err = "Name is required";
    elseif (!$input['email']) $err = "Email is required";
    elseif (!$input['number']) $err = "number is required";
    else {

        $userExist = $user->userExist(trim($input['email']));
        if (count($userExist) > 0) {
            $err = "Email alredy exist.";
            $payload['code'] = 404;
        } else {
            $result = $user->insertUser($input['name'], $input['email'], $input['number']);
            if ($result) {
                $payload["data"] = $result;
                $payload["message"] = "User inserted successfully";
            } else {
                $payload["code"] = 500;
                $payload["message"] = "Failed inserting user";
            }
        }
    }

    if ($err != null) {
        $payload['code'] = 404;
        $payload['message'] = $err;
    }

    return $user->apiResponse($response, $payload, $payload['code']);
});


//DELETE APIs

$app->delete('/users/delete', function ($request, $response, $args) {

    global $payload;
    $err = '';
    $user = new User();

    $input = $request->getBody();
    $input = json_decode($input, true);

    if (!$input['id'])  $err = "Id is required";
    else {
        $result = $user->deleteUser($input['id']);
        if ($result) {
            $payload["data"] = $result;
            $payload["message"] = "User deleted successfully";
        } else {
            $payload["code"] = 500;
            $payload["message"] = "Failed deleting user";
        }
    }

    if ($err != null) {
        $payload['code'] = 404;
        $payload['message'] = $err;
    }

    return $user->apiResponse($response, $payload, $payload['code']);
});


//PUT

$app->put('/users/update', function ($request, $response, $args) {

    global $payload;
    $err = '';
    $user = new User();

    $input = $request->getBody();
    $input = json_decode($input, true);

    // print_r($input);
    // exit;

    if (!$input['id'])  $err = "Id is required";
    else {
        $result = $user->updateUser($input['id'], $input['name'], $input['email'], $input['password'], $input['phone_number']);

        if ($result) {
            $payload["data"] = $result;
            $payload["message"] = "User update successfully";
        } else {
            $payload["code"] = 500;
            $payload["message"] = "Failed Upadteing user";
        }
    }

    if ($err != null) {
        $payload['code'] = 404;
        $payload['message'] = $err;
    }

    return $user->apiResponse($response, $payload, $payload['code']);
});

$app->get('/user/getById', function ($request, $response, $args) {

    global $payload;
    $err = '';
    $user = new User();

    $input = $request->getQueryParams();
    // $input=json_decode($input,true);
    if (!$input['id'])  $err = "Id is required";
    else {
        $result = $user->getUserById($input['id']);

        if ($result) {
            $payload["data"] = $result;
            $payload["message"] = "User update successfully";
        } else {
            $payload["code"] = 500;
            $payload["message"] = "Failed Upadteing user";
        }
    }

    if ($err != null) {
        $payload['code'] = 404;
        $payload['message'] = $err;
    }

    return $user->apiResponse($response, $payload, $payload['code']);
});
