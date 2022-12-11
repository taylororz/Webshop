<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credit Card Verification</title>
    
</head>
<body>
    <input type="text" onkeyup="update(this.value);" /><br />
    <img src="1.png" id="img" style="padding:5px;" /><br />
    <span style="color:red;" id="valid">card fails luhn test</span>

    <script src="../javaScript/validCreditCardNumber.js"></script>
</body>
</html>