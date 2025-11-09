var data = { severity: 'high', file: 'app.py' };
var takes_object = JSON.stringify(data); 
fetch("JSON_Handler.php", {
    method: "POST",
    headers: {
        "Content-type": "../frontend/sample.json" 
    },
    body: takes_object 
})
.then(response => {
    if (!response.ok) {
        throw new Error(`HTTP error Status: ${response.status}`);
    }
    return response.json(); 
})
.then(data => {
    console.log("success Data:", data);
})
.catch(error => {
    console.error("fetch failed:", error);
});
