<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styles.css"> <!-- Your custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f0f0f0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            color: #001f3f;
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100vh;
            border-right: 1px solid #e0e0e0;
        }

        .sidebar img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .button-card {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .button-card:hover {
            background-color: yellow;
        }

        .main-content {
            flex: 1;
            margin: 0;
            padding: 20px;
            overflow-y: auto;
            background-color: #ffffff;
            border-left: 1px solid #e0e0e0;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 150px;
            }

            h2 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="images/logoramstar.jpg" alt="Holy Cross College Logo"> <!-- Logo -->
        <h2>Menu</h2>

        <a class="button-card" href="Dashboardadmin.php">
            <i class="fas fa-tachometer-alt"></i> Home
        </a>
        <a class="button-card" href="Register.php">
            <i class="fas fa-user"></i> Registration
        </a>
        <a class="button-card" href="userload.php">
            <i class="fas fa-wallet"></i> Load User
        </a>
        <a class="button-card" href="loadtransaction.php">
            <i class="fas fa-info-circle"></i> Load Transaction
        </a>
        <a class="button-card" href="users.php">
            <i class="fas fa-info-circle"></i> View Registered Users
        </a>
        <a class="button-card" href="activateusers.php">
            <i class="fas fa-info-circle"></i> For Activate Accounts
        </a>
        <a class="button-card" href="revenuefare.php">
            <i class="fas fa-info-circle"></i> Revenue Fare
        </a>
        <a class="button-card" href="Logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>



    <script>
        function showContent(page) {
            const mainContent = document.getElementById('main-content');
            fetch(page)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    mainContent.innerHTML = data; // Inject the content here
                })
                .catch(error => {
                    mainContent.innerHTML = `<h1>Error loading page</h1><p>${error.message}</p>`;
                });
        }
    </script>
</body>

</html>