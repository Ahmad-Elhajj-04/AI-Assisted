<?php 

include("connection/connection.php");

$data = json_decode(file_get_contents("php://input"), true);

$severity_check = ['high', 'medium', 'low'];

if(isset($data["severity"]) && in_array($data["severity"],$severity_check)){
    $severity = $data["severity"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "Severity field has the wrong input.";
    echo json_encode($response);
    return;
}

if(isset($data["file"]) && $data["file"] != ""){
    $file = $data["file"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "File field has the wrong input.";
    echo json_encode($response);
    return;
}

if(isset($data["issue"]) && $data["issue"] != ''){
    $issue = $data["issue"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "Issue field has the wrong input.";
    echo json_encode($response);
    return;
}

if(isset($data["suggestion"]) && $data["suggestion"] != ""){
    $suggestion = $data["suggestion"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "Suggestion field has the wrong input.";
    echo json_encode($response);
    return;
}



$query = $mysql->prepare("INSERT INTO codes(severity,file,issue,suggestion) VALUES (?,?,?,?)");
$query->bind_param("ssss",$severity,$file,$issue,$suggestion);
$query->execute();

$response = [];
$response["success"] = true;
echo json_encode($response);

?>