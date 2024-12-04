<?php
session_start();
include '../config/connection.php'; // Include your database connection

$user = null;
$error = null;
$success = null;

// Check if the request is POST and handle the RFID input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Reset user variable
    $user = null; // Reset user info
    
    // Check if RFID is submitted
    if (isset($_POST['rfid'])) {
        // Get the RFID from the form
        $rfid_code = trim($_POST['rfid']);

        // Fetch user details based on the RFID
        $stmt = $conn->prepare("SELECT id, firstname, lastname, balance FROM useracc WHERE account_number = ?");
        $stmt->bind_param("s", $rfid_code); // Changed to use rfid_code
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            $error = "RFID not found.";
        }
    }
}
?>

<!-- Sidebar Layout -->
<div class="main-content">
    <h1 class="text-center">Search User Info</h1>
    <!-- Inside your form -->
    <form method="POST" action="search_users.php" class="mt-4" id="manageBalanceForm">
    <div class="form-group">
        <label for="rfid">Scan RFID:</label>
        <input type="text" class="form-control mb-3" id="rfid" name="rfid" autofocus required oninput="submitIfValid(this)">
    </div>
</form>


    <?php if (isset($user)): ?>
        <div class="card">
            <h2 class="text-center">User Info</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></p>
            <p><strong>Current Balance:</strong> P<?php echo number_format($user['balance'], 2); ?></p>
            <p><strong>Card Status:</strong> Active</p>
        </div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger mt-3 text-center"><?php echo $error; ?></div>
    <?php endif; ?>
</div>

<!-- Ensure that the necessary Bootstrap and jQuery libraries are included in your main layout -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function submitIfValid(input) {
    // Replace 10 with the expected length of your RFID codes
    if (input.value.length === 10) { 
        input.form.submit(); 
    }
}
</script>
