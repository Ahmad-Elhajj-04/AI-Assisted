<?php

include("connection/connection.php");

$severity_check = ["high", "medium", "low"];

if(isset($_POST["severity"]) && in_array($_POST["severity"],$severity_check)){
    $severity = $_POST["severity"];
}else{
    $response = [];

    $response["success"] = false;
    $response["error"] = "Severity field has the wrong input.";
    echo json_encode($response);
    return;
}

if(isset($_POST["file"]) && $_POST["file"] != "" && (str_contains($_POST["file"],"."))){
    $file = $_POST["file"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "File field has the wrong input.";
    echo json_encode($response);
    return;
}

if(isset($_POST["issue"]) && $_POST["issue"] != ''){
    $issue = $_POST["issue"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "Issue field has the wrong input.";
    echo json_encode($response);
    return;
}

if(isset($_POST["suggestion"]) && $_POST["suggestion"] != ""){
    $suggestion = $_POST["suggestion"];
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