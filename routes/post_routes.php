<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require_once '../models/post.php';

$app->get('/post/get', function($request, $response, $args){
    global $payload;
    $post = new Post(); 

    $result = $post->getPost(); 
   
    if($result && count($result) > 0) {
        $payload["data"] = $result;
    }
    else {
        $payload["message"] = "Failed";
    }   
    return $post->apiResponse($response, $payload, $payload['code']);
});





//Insert Post

$app->post('/post/insert', function($request, $response, $args){
    global $payload;
    $err = '';
    $post = new Post(); 

    $input = $request->getBody();
    $input=json_decode($input,true);

    if(!$input['post_name'])  $err = "Post_name is required";
    else if(!$input['user_id'])  $err = "User id is required";
    else {
        $result = $post->insertPost($input['post_name'], $input['user_id']); 
        if($result) {
            $payload["data"] = $result;
            $payload["message"] = "Post inserted successfully";
        }
        else {
            $payload["code"] = 500;
            $payload["message"] = "Failed inserting Post";
        }
    }
    if($err != null) {
        $payload['code'] = 404;
        $payload['message'] = $err;
    }

    return $post->apiResponse($response, $payload, $payload['code']);
});



$app->post('/post/update', function($request, $response, $args){

    global $payload;
    $err = '';
    $post = new Post();

    $input = $request->getBody();
    $input = json_decode($input, true);

    if(!$input['id']) $err = "Id is required";
    else {
        $result = $post->updatePost($input['id'], $input['post_name']); 
        if($result) {
            $payload["data"] = $result;
            $payload["message"] = "Post updated successfully";
        }
        else {
            $payload["code"] = 500;
            $payload["message"] = "Failed inserting Post";
        }
    }
    if($err != null) {
        $payload['code'] = 404;
        $payload['message'] = $err;
    }

    return $post->apiResponse($response, $payload, $payload['code']);
});


$app->delete('/post/delete', function($request, $response, $args){
    global $payload;
    $err = '';

    $post = new Post();
    $input = $request->getBody();
    $input = json_decode($input, true);
    

    if(!$input['id']) 
        $err = "Id id required";
    else{
        $result = $post->deletePost($input['id']);
        if($result){
            $payload['data'] = $result;
            $payload['message'] = "Post Successfully delete";
        }else{
            $payload['code'] = 500;
            $payload['message'] = "Error in Post Deleteing";
        }
    }
    if($err != null){
        $payload['code'] = 404;
        $payload['message'] = "ERROR";
    }
    return $post->apiResponse($response, $payload, $payload['code']);
});





?>