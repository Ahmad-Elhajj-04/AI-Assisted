<?php

header("Content-Type: application/json");

$api_key = "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 ";
$url = 'https://api.openai.com/v1/chat/completions';


$user_prompt = "Write me a simple python code to add 2 numbers.";

$data = [
        'model'    => 'gpt-4o',
        'messages' => [
                ['role' => 'user', 'content' => $user_prompt],
        ],
];

$options = [
        'http' => [
                'header'  => "Content-Type: application/json\r\nAuthorization: Bearer $api_key",
                'method'  => 'POST',
                'content' => json_encode($data),
        ],
];

$context  = stream_context_create($options);
$response = file_get_contents('https://api.openai.com/v1/chat/completions', false, $context);
$response = json_decode($response);
$response = $response->choices[0]->message->content;
echo $response;
?>