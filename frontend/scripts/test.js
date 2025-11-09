let text = `
age_input = input("What is your age? ")

age = int(age_input) 

current_year = 2024
birth_year = current_year - age

print(f"You were born in {birth_year}.")`;

document.getElementById("sender").onclick = async function sendData() {
  const checkBox = document.getElementById("version-check").checked;

  let check = document.getElementById("file-check").checked;

  if (!check) {
    text = document.getElementById("code").value;
  }
  if (text === "" && check) {
    document.getElementById("result").innerHTML =
      "Please select a file or use text version with a text written.";
    return;
  }

  const response = await axios.post(
    "http://localhost/AI-Assisted/backend/review.php",
    {
      code: text,
      filename: document.getElementById("file").value,
      version: checkBox,
    }
  );

  let res = "";
  const data = response.data;
  res = text;
  document.getElementById("input-result").innerHTML = res;
  res = data.Language;
  document.getElementById("language").innerHTML = res;

  console.log(data);
  if (data.Status == "Success" || data.Status == "Failure") {
    let res = "";
    let i = 0;
    for (const [key, value] of Object.entries(data)) {
      if (i != 2) {
        res += `<strong>${key}:</strong> ${value}<br>`;
      }
      i++;
    }

    document.getElementById("result").innerHTML = res;
  } else {
    let reviews = data.reviews;
    /* result :
     { => It has valid JSON format.
    "reviews": [ => it is an array
        {
            "Severity": "high",
            "File Name": "",
            "Issue": "Potential ValueError",
            "Suggestion": "Ensure that the input is a valid integer before converting." => mentions ensuring a valid integer.
        }
    ],
    "Language": "Python"
    } 
     The object contains all the required fields (severity,file name, issue, and suggestion). 
    */
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
