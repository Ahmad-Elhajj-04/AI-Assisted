document.getElementById('sender').onclick =  async function sendData() {

    const response = await axios.post('http://localhost/AI-Assisted/backend/review.php', {
        code: document.getElementById("code").value,
        filename: "app.py"
    })
   const data = response.data;
   console.log(data.reviews);
}
