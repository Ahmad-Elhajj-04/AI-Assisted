<?php
header('Content-Type: application/json');
$file_path = __DIR__ . '/../frontend/sample.json';
if (file_exists($file_path)) {
    // Read the file contents as a string
    $json_string = file_get_contents($file_path);
    $data = json_decode($json_string, true);
    if ($data !== null) {
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["error" => "Invalid JSON format in sample.json"]);
    }
} else {
    echo json_encode(["error" => "File not found at path: $file_path"]);
}
?>
