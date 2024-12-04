<?php
include 'config/connection.php'; // Include database connection

$searchQuery = $_POST['query'] ?? ''; // Get the search query

// Fetch users based on search input
$sql = "SELECT * FROM users WHERE is_disabled = 0 AND (
            firstname LIKE '%$searchQuery%' OR
            middlename LIKE '%$searchQuery%' OR
            lastname LIKE '%$searchQuery%' OR
            address LIKE '%$searchQuery%' OR
            account_number LIKE '%$searchQuery%' OR
            gender LIKE '%$searchQuery%' OR
            balance LIKE '%$searchQuery%'
)";
$result = $conn->query($sql);

// Display results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['firstname']}</td>
                <td>{$row['middlename']}</td>
                <td>{$row['lastname']}</td>
                <td>{$row['birthday']}</td>
                <td>{$row['age']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['address']}</td>
                <td>{$row['account_number']}</td>
                <td>₱" . number_format($row['balance'], 2) . "</td>
                <td>
                    <form method='POST' action='' onsubmit='return confirmDisable();'>
                        <input type='hidden' name='user_id' value='{$row['id']}'>
                        <button type='submit' name='disable_user' class='btn btn-danger btn-sm'>Disable</button>
                    </form>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='11'>No users found</td></tr>";
}
?>