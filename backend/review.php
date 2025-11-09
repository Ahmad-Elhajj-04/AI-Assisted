<?php

header("Content-Type: application/json");

$api_key = "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 ";

//$api_key = "kPEJEyDz6qfdMYXLhON0O1yQXToMSvAeJBYJVTYo";

$url = 'https://api.openai.com/v1/chat/completions';
//$url = 'https://api.cohere.ai/compatibility/v1/chat/completions';

$input = json_decode(file_get_contents("php://input"), true);

if(isset($input["code"]) && $input["code"] != ""){
    $code = $input["code"];
}else{
    $response = [];
    $response["success"] = false;
    $response["error"] = "No code to review.";
    echo json_encode($response);
    return;
}

$version =$input["version"];


$category_rules = [
        'Security'=> ['SQL-injection'=> 'SEC-SQLI','Input Validation'=> 'SEC-VALIDATION', 'Hardcoded Secret' => 'SEC-SECRET'],
        'Bug risk'=> ['Might be Null'=> 'BUG-NULL-REF','Unsafe Type Comparison' => 'BUG-TYPE-COMPARE','Uninitizialized Variable' => 'BUG-UNINIT-VAR','Infinite Loop' => 'BUG-INIFINITE-LOOP',
        'Loop Boundary' => 'BUG-LOOP-BOUNDARY'] ,
        'Maintainability' => ['Long Function' => 'MAIN-LONG-FUNC', 'Dupe Code' => 'MAIN-DUPE-CODE', 'Define Constant' => 'MAIN-DEFINE-CONST', 'Global State' => 'MAIN-GLOBAL-STATE'],
        'Generic'=> ['Refactor' => 'GEN-REFACTOR','Complex' => 'GEN-COMPLEX', 'Performance'  => 'GEN-PERFORMANCE','Documentation' => 'GEN-DOCUMENTATION', 'Naming Convention' => 'GEN-NAME-CONV','Messy Code' => 'GEN-MESSY']
];

$category_rules = json_encode($category_rules);

if($version){
$user_prompt = <<<PROMPT
I need you to check this code for me for any possible mistakes,find the programming language and give me the response in JSON format according to the following instructions.

"reviews" that includes:

1. Severity : high,medium,or low. 
2. The file name (or nothing if its not a file). 
3. A short identifier of the issue with the category and rule-id according to this array : $category_rules. 
4. Which line the error is in. 
5. A suggestion to fix the code .

Which means there should be seven columns : Severity, File Name, Identifier,Category, Rule-ID,Line and Suggestion. 

Security problems are high severity, bug risk problems are medium severity, and the rest are low severity, The result must be inside an object called 'reviews'.

And another "Language": with the programming language inside this code, if there is no programming language it is set to none.

If there are no errors in the code you should return a JSON object with "Status" : "Success","Reason" : "No errors detected in this code." .

If there are any errors that are not included in the rules, include it in generic and give it a severity of your own jurisdiction (high,medium,low).

If there is no readable or understandable code you should return a JSON object with "Status" : "Failure","Reason" : "No code detected.".
The code is : $code
PROMPT; 
      
} else{
$user_prompt = <<<PROMPT

I need you to check this code for me for any possible mistakes,find the programming language and give me the response in JSON format according to the following instructions:

"reviews": that includes:

1. Severity : high,medium,or low. 
2. The file name (or nothing if its not a file). 
3. A short identifier of the issue. 
4. A suggestion to fix the code.

Which means there should be four columns : Severity, File Name, Issue, and Suggestion. 

Security problems are high severity, bug risk problems are medium severity, and the rest are low severity, The result must be inside an object called 'reviews',no other data should be included in the answer.

And another "Language": with the programming language inside this code,if there is no programming language it is set to none.

If there are no errors in the code you should return a JSON object with "Status" : "Success","Reason" : "No errors detected in this code."

If there are any errors that are not included in the rules, include it in generic and give it a severity of your own jurisdiction (high,medium,low).

If there is no readable or understandable code you should return a JSON object with "Status" : "Failure","Reason" : "No code detected." and language.
The code is : $code
PROMPT;     
}


$data = [
        'model'    => 'gpt-4o', //'command-a-03-2025'
        'messages' => [
                ['role' => 'user', 'content' => $user_prompt],
        ],
        'response_format' => ['type' => 'json_object']
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
$response = json_decode($response);

echo json_encode($response);
?>