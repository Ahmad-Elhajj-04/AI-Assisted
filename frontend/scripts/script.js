document.getElementById("sender").onclick = async function sendData() {
  const checkBox = document.getElementById("myCheck");
  const response = await axios.post(
    "http://localhost/AI-Assisted/backend/review.php",
    {
      code: document.getElementById("code").value,
      filename: "app.py",
      version: checkBox.checked,
    }
  );
  const data = response.data;
  console.log(data);
  if (data.Status == "Success") {
    let res = "";
    for (const [key, value] of Object.entries(data)) {
      res += `<strong>${key}:</strong> ${value}<br>`;
    }

    document.getElementById("result").innerHTML = res;
  } else {
    let reviews = data.reviews;
    let res = "";
    reviews.forEach((review) => {
      for (const [key, value] of Object.entries(review)) {
        res += `<strong>${key}:</strong> ${value}<br>`;
      }
      res += "<hr>";
    });

    document.getElementById("result").innerHTML = res;
  }
};
