<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
</head>
<body>

<h2>Delete Your Account</h2>
<form method="post" action="delete_account_api.php" onsubmit="return submitForm(event)">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br><br>

    <button type="submit">Delete Account</button>
</form>

<div id="response" style="margin-top: 20px;"></div>



</body>
</html>
