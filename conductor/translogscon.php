<?php
session_start();
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

// Pagination Setup
$limit = 15; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from query string
$offset = ($page - 1) * $limit; // Calculate the offset

// Fetch total number of transactions for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM transactions t";
$totalResult = $conn->query($totalQuery);
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit); // Calculate total pages

// Fetch transactions with pagination
function fetchTransactions($conn, $limit, $offset)
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
    LEFT JOIN useracc c ON t.conductor_id = c.account_number
    ORDER BY t.transaction_date DESC
    LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($transactionQuery);
    $stmt->bind_param('ii', $limit, $offset); // Bind limit and offset
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result;
}

$transactions = fetchTransactions($conn, $limit, $offset);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="../css/sidebars.css">
    <title>Transaction Logs</title>
    <style>
        h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: transparent;
            background-image: linear-gradient(to right, #f1c40f, #e67e22);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            -webkit-text-stroke: 0.5px black;
        }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <!-- Page Content  -->
    <div id="main-content" class="container mt-5">
        <h2 class="text-center">Transaction Logs</h2>

      

        <!-- Transactions Table -->
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
                            <td><?php echo date('F-d-Y h:i:s A', strtotime($row['transaction_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['conductor_firstname'] . ' ' . $row['conductor_lastname']); ?></td>
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

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page == $totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>

    </div>

    <script src="../js/sidebar.js"></script>
</body>

</html>
