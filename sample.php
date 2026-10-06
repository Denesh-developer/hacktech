<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alphabetic Input Only</title>
  <script>
    function validateInput(event) {
      const inputField = event.target;
      const invalidChars = /[^a-zA-Z]/g;
      if (invalidChars.test(inputField.value)) {
        alert('Only alphabets are allowed.');
        inputField.value = inputField.value.replace(invalidChars, '');
      }
    }
  </script>
</head>
<body>
  <label for="alphaInput">Enter text (alphabets only):</label>
  <input type="text" id="alphaInput" oninput="validateInput(event)" />
</body>
</html>
