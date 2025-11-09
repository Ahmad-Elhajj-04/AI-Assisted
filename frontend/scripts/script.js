let text = "";

const input = document.getElementById("file");
input.addEventListener("change", saveFile);

function saveFile(event) {
  const file = event.target.files[0];

  if (!file) {
    console.log("No file selected.");
    return;
  }
  if (!file.type.startsWith("text")) {
    console.log("Unsupported file type.");
    return;
  }

  const reader = new FileReader();

  reader.onload = () => {
    text = reader.result;
    console.log(text);
  };

  reader.onerror = () => {
    console.log("Error reading the file.");
  };

  reader.readAsText(file);
}

document.getElementById("sender").onclick = async function sendData() {
  const checkBox = document.getElementById("version-check").checked;

  let check = document.getElementById("file-check").checked;

  if (!check) {
    text = document.getElementById("code").value;
  }
  if(text === "" && check)
  {
    document.getElementById('result').innerHTML = "Please select a file or use text version with a text written.";
  return;
  }
  
  const response = await axios.post(
    "http://localhost/AI-Assisted/backend/review.php",
    {
      code: text,
      filename: "app.py",
      version: checkBox,
    }
  );

  let res = "";
  res += "<strong>Your code:</strong> " + text + "<br>";
  res += "<strong>Language:</strong> ";
  document.getElementById('input-result').innerHTML = res;
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

document.getElementById('file-check').onchange = function () {
    

    let check = document.getElementById('file-check');
    let text_input = document.getElementById('code');
    let file_input = document.getElementById('file');
    text_input.value = "";
    file_input.value = ""; 
    
    text = "";
    if(check.checked)
    {
        text_input.style.display= 'none';
        file_input.style.display= 'block';

    }else {
        file_input.style.display = 'none';
        text_input.style.display = 'block';

    }
}
document.addEventListener('DOMContentLoaded',() => {
    document.getElementById('file').style.display = 'none';}) ;
