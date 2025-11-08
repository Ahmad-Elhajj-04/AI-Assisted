// test.js
// Run this with Node.js after installing dependencies:
// npm install axios ajv

import axios from "axios";
import Ajv from "ajv";
import fs from "fs";

// Load your schema
const schema = JSON.parse(fs.readFileSync("./schema.json", "utf-8"));

// Create validator instance
const ajv = new Ajv({ allErrors: true });
const validate = ajv.compile(schema);

// API endpoint (Person A's PHP file)
const API_URL = "http://localhost/AI-Assisted/backend/review.php";

// Test input (Python code with missing validation)
const testInput = {
  code: "def get_input(): return input('Enter: ')", // simple code sample
  filename: "app.py",
  language: "python"
};

// Function to run the test
async function runTest() {
  try {
    console.log("📤 Sending code snippet to the API...");
    const response = await axios.post(API_URL, testInput, {
      headers: { "Content-Type": "application/json" },
    });

    console.log("✅ API responded!");
    const data = response.data;

    // 1. Check JSON array
    if (!Array.isArray(data)) {
      throw new Error("❌ Response is not an array!");
    }

    // 2. Validate structure using schema
    const valid = validate(data);
    if (!valid) {
      console.error("❌ Schema validation failed:");
      console.error(validate.errors);
    } else {
      console.log("✅ Schema validation passed!");
    }

    // 3. Optional: check for validation mention
    const hasValidationIssue = data.some(item =>
      item.issue.toLowerCase().includes("validation")
    );
    console.log(hasValidationIssue
      ? "✅ Found mention of 'validation' in issues."
      : "⚠️ No 'validation' issue found.");

  } catch (error) {
    console.error("❌ API test failed:", error.message);
  }
}

runTest();
