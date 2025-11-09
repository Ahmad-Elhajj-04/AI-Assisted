<?php

$data = json_decode(file_get_contents("php://input"), true);
$response = [];
if(isset($data["code"]) && $data["code"] != ""){
    $response['code'] = $data["code"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "Name field is missing";
    echo json_encode($response);
    return;
}



$response["success"] = true;
echo json_encode($response);
?>