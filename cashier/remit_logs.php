<?php
session_start();
include '../config/connection.php';


if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Cashier' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}


// Fetch the remit logs from the database
$query = "SELECT * FROM remit_logs ORDER BY remit_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remittance Logs</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/sidebars.css">
    <style>
       

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: transparent;
            /* Make the text color transparent */
            background-image: linear-gradient(to right, #f1c40f, #e67e22);
            background-clip: text;
            -webkit-background-clip: text;
            /* WebKit compatibility */
            -webkit-text-fill-color: transparent;
            /* Ensures only the gradient is visible */
            -webkit-text-stroke: 0.5px black;
            /* Outline effect */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }

        h1 {
            color: black;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div id="main-content" class="container mt-5">
    <h1>Remittance Logs</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bus No</th>
                    <th>Conductor ID</th>
                    <th>Total Load</th>
                    <th>Total Cash</th>
                    <th>Total Deductions</th>
                    <th>Net Amount</th>
                    <th>Remit Date</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['bus_no']; ?></td>
                        <td><?php echo $row['conductor_id']; ?></td>
                        <td><?php echo number_format($row['total_load'], 2); ?></td>
                        <td><?php echo number_format($row['total_cash'], 2); ?></td>
                        <td><?php echo number_format($row['total_deductions'], 2); ?></td>
                        <td><?php echo number_format($row['net_amount'], 2); ?></td>
                        <td><?php echo $row['remit_date']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No remittance logs found.</p>
    <?php endif; ?>
    </div>

    <script src="../js/sidebar.js"></script>
</body>

</html>