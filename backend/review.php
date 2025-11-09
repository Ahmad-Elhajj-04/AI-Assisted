<?php

header("Content-Type: application/json");

$api_key = "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 ";

//$api_key = "kPEJEyDz6qfdMYXLhON0O1yQXToMSvAeJBYJVTYo";

$url = 'https://api.openai.com/v1/chat/completions';
//$url = 'https://api.cohere.ai/compatibility/v1/chat/completions';

$category_rules = [
        'Security'=> ['SQL-injection'=> 'SEC-SQLI','Input Validation'=> 'SEC-VALIDATION', 'Hardcoded Secret' => 'SEC-SECRET'],
        'Bug risk'=> ['Might be Null'=> 'BUG-NULL-REF','Unsafe Type Comparison' => 'BUG-TYPE-COMPARE','Uninitizialized Variable' => 'BUG-UNINIT-VAR','Infinite Loop' => 'BUG-INIFINITE-LOOP',
        'Loop Boundary' => 'BUG-LOOP-BOUNDARY'] ,
        'Maintainability' => ['Long Function' => 'MAIN-LONG-FUNC', 'Dupe Code' => 'MAIN-DUPE-CODE', 'Define Constant' => 'MAIN-DEFINE-CONST', 'Global State' => 'MAIN-GLOBAL-STATE'],
        'Generic'=> ['Refactor' => 'GEN-REFACTOR','Complex' => 'GEN-COMPLEX', 'Performance'  => 'GEN-PERFORMANCE','Documentation' => 'GEN-DOCUMENTATION', 'Naming Convention' => 'GEN-NAME-CONV']
];

$category_rules = json_encode($category_rules);

$user_prompt = "I need you to check this code for me for any possible mistakes, give me the response in JSON format according to the following instructions. 1. Severity : high,medium,or low. 2. The file name (or nothing if its not a file). 3. A short identifier of the issue with the category and rule-id according to this array : $category_rules. 4. A suggestion to fix the code .Which means there should be six columns : Severity, File Name, Identifier,Category, Rule-ID, and Suggestion. Security problems are high severity, bug risk problems are medium severity, and the rest are low severity, The result must be inside an object called 'reviews',no other data should be included in the answer.The code is : def greet_and_age(name, age)   print('Hello, ' + name) next_age = age + 1s print('Next year you will be: ' + next_age) greet_and_age('Jesse', '29') ";

$data = [
        'model'    => 'gpt-4o', //'command-a-03-2025'
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