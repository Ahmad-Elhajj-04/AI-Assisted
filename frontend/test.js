var myObject = { severity: 'high', file: 'app.py' };
var str_json = JSON.stringify(myObject); 
fetch("JSON_Handler.php", {
    method: "POST",
    headers: {
        "Content-type": "application/json" 
    },
    body: str_json 
})
.then(response => {
    if (!response.ok) {
        throw new Error(`HTTP Error! Status: ${response.status}`);
    }
    return response.json(); 
})
.then(data => {
    console.log("Success! Data:", data);
})
.catch(error => {
    console.error("Fetch failed:", error);
});
