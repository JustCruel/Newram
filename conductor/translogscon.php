<?php
session_start();
// transaction_logs.php
include '../config/connection.php'; // Include your database connection file
include 'includes/functions.php'; // Include your functions file

// Assuming you have the user id in session
$account_number = $_SESSION['account_number']; // Fetch account number from session

// Fetch user data based on account_number
$query = "SELECT firstname, lastname, role FROM useracc WHERE account_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $account_number); // Use the account number for fetching user data
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $role);
$stmt->fetch();
$stmt->close(); // Close the prepared statement after fetching user data

// Fetch all transactions
function fetchTransactions($conn)
{
    $transactionQuery = "SELECT 
    t.id, 
    u.firstname, 
    u.lastname, 
    u.account_number, 
    t.amount, 
    t.transaction_type, 
    t.transaction_date, 
    t.conductor_id, 
    c.firstname AS conductor_firstname, 
    c.lastname AS conductor_lastname, 
    c.account_number AS conductor_account_number,
    c.role AS loaded_by_role
    FROM transactions t
    JOIN useracc u ON t.user_id = u.id
    LEFT JOIN useracc c ON t.conductor_id = c.account_number  -- Change here: join on account_number
    ORDER BY t.transaction_date DESC";

    $stmt = $conn->prepare($transactionQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result;
}

$transactions = fetchTransactions($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Transaction Logs</title>

    <style>
        h2{
            color: black;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#transactionTable').DataTable();
        });
    </script>
</head>

<body>
    <?php
    include "../sidebar.php";
    ?>

    <!-- Page Content  -->
    
        <div class="container mt-5">
            <h2 class="text-center">Transaction Logs</h2>
            <table id="transactionTable" class="table table-bordered mt-4">
                <thead class="thead-light">
                    <tr>
                        <th>Account Number</th>
                        <th>User Name</th>
                        <th>Amount</th>
                        <th>Transaction Type</th>
                        <th>Transaction Time</th>
                        <th>Loaded By</th>
                        <th>Role of Loader</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($transactions) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($transactions)): ?>
                            <tr>
                                <td><?php echo $row['account_number']; ?></td>
                                <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                                <td><?php echo number_format($row['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($row['transaction_type'])); ?></td>
                                <td>
                                    <?php echo date('F-d-Y h:i:s A', strtotime($row['transaction_date'])); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['conductor_firstname'] . ' ' . $row['conductor_lastname']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['loaded_by_role']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No transaction records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>

</html>