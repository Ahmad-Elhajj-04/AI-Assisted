document.getElementById('sender').onclick =  async function sendData() {

    const response = await axios.post('http://localhost/AI-Assisted/backend/review.php', {
        code: document.getElementById("code").value,
        filename: "app.py"
    })
   const data = response.data;
   console.log(data.reviews);
}
function myFunction() {
const checkBox = document.getElementById("myCheck");
const text = document.getElementById("text");
if (checkBox.checked == true) {
    text.style.display = "block";
}
else {
    text.style.display = "none";
  }
}

