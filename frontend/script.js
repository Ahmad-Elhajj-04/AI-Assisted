// Simple axios example - just the basics

function sendData() {
    axios.post('http://localhost/AI-Assisted/backend/review.php', {
        code: "def get_input() return input('Enter: ')",
        filename: "app.py"
    })
    .then(function (response) {
        console.log(response.data);
    })
    .catch(function (error) {
        console.log(error.message);
    });
}
