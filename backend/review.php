<?php

header("Content-Type: application/json");

$api_key = "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 ";
$url = 'https://api.openai.com/v1/chat/completions';


$user_prompt = "I need you to check this code for me for any possible mistakes, give me the response in JSON format according to the following instructions. 1. Severity : high,medium,or low. 2. The file name (or nothing if its not a file). 3. A short identifier of the issue. 4. A suggestion to fix the code .The result must be inside an object called 'reviews'.The code is : def greet_and_age(name, age)   print('Hello, ' + name) next_age = age + 1s print('Next year you will be: ' + next_age) greet_and_age('Jesse', '29') ";

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
$response = file_get_contents($url, false, $context);
$response = json_decode($response);
$response = $response->choices[0]->message->content;

echo $response;
?>