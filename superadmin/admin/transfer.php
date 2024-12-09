<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Transfer Funds</title>
</head>

<body>
    <h2>Transfer Funds from Disabled RFID Card</h2>
    <form action="transfer_funds.php" method="POST">
        <label for="disabledAccountNumber">Disabled RFID Account Number:</label>
        <input type="text" id="disabledAccountNumber" name="disabledAccountNumber" required><br><br>

        <label for="newAccountNumber">New RFID Account Number:</label>
        <input type="text" id="newAccountNumber" name="newAccountNumber" required><br><br>

        <button type="submit">Transfer Funds</button>
    </form>
</body>

</html>