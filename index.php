<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            background-color: #576BED;
            /* Updated color */
            color: white;
            padding: 15px 0;
        }

        header .logo h1 {
            font-size: 32px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: flex-end;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            color: white;
            font-size: 16px;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #34495e;
        }

        /* Hero Section */
        .hero {
            background: url('assets/logo/background.jpg') no-repeat center center/cover;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero .hero-text {
            background-color: rgba(0, 0, 0, 0.5);
            /* Add a semi-transparent black background */
            padding: 30px;
            display: inline-block;
            /* Optional: Keeps the background limited to the text */
            border-radius: 10px;
        }

        .hero h2 {
            font-size: 40px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .cta-buttons a {
            margin-top: auto;
            background-color: #3498db;
            color: white;
            padding: 20px 50px;
            font-size: 18px;
            border-radius: 5px;
            margin: 10px;
            transition: background-color 0.3s;
        }

        .cta-buttons a:hover {
            background-color: #2980b9;
        }

        /* Features Section */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 60px 0;
            background-color: #ecf0f1;
        }

        .feature {
            background-color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .feature h3 {
            margin-top: 20px;
            font-size: 22px;
            font-weight: 600;
        }

        .feature p {
            font-size: 16px;
            color: #7f8c8d;
        }

        .feature i {
            color: #3498db;
        }

        footer {
            background-color: #576BED;
            /* Updated color */
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        footer p {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>Ramstar Bus Transportation Cooperative</h1> <!-- Updated text -->
            </div>
            <nav>

            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h2>Welcome to the Bus Fare Management System</h2>
                <p>Your seamless and efficient bus fare tracking solution. Manage journeys, fares, and more in
                    real-time!</p>
            </div>
            <div class="cta-buttons">
                <a href="login.php" class="cta-btn">Login</a>
                <!--<a href="" class="cta-btn">Register</a> -->
            </div>
        </div>
    </section>

    <section class="features">
        <div class="feature">
            <i class="fas fa-calculator fa-3x"></i>
            <h3>Real-time Fare Calculation</h3>
            <p>Automatically calculate the fare based on distance traveled, passenger type, and more.</p>
        </div>
        <div class="feature">
            <i class="fas fa-credit-card fa-3x"></i> <!-- Changed icon -->
            <h3>RFID-based Payment</h3> <!-- Updated title -->
            <p>Track your journey with RFID scanning and make automatic payments based on distance and passenger type.
            </p> <!-- Updated description -->
        </div>
        <div class="feature">
            <i class="fas fa-users fa-3x"></i>
            <h3>Passenger Discounts</h3>
            <p>Apply discounts for students, seniors, and other passenger types automatically.</p>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 Ramstar Bus Transportation Cooperative | All rights reserved</p> <!-- Updated text -->
        </div>
    </footer>

</body>

</html>