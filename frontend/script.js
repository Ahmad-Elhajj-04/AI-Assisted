document.getElementById('sender').onclick =  async function sendData() {
    await axios.post('http://localhost/AI-Assisted/backend/add_code.php', {
        code: document.getElementById('code').value,
        filename: "app.py"
    })
    .then(function (response) {
        console.log(response.data.code);
    })
    .catch(function (error) {
        console.log(error.message);
    });

    
}
