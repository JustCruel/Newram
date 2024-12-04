<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Welcome to the home page. Click to start your journey.">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="homestyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

	<style>
		body {
			margin: 0;
			padding: 0;
			font-family: Arial, sans-serif;
			overflow: hidden;
			/* Prevent scrollbars */
		}

		.flex-container {
			display: flex;
			flex-direction: column;
			justify-content: center;
			/* Center vertically */
			align-items: center;
			/* Center horizontally */
			height: 100vh;
			/* Full viewport height */
			width: 100vw;
			/* Full viewport width */
			position: relative;
		}

		.flex-container img {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
			/* Ensures the image covers the full screen without distortion */
			z-index: -1;
			/* Send image behind other content */
		}

		.container {
			background: rgba(87, 107, 237, 0.8);
			/* Slightly transparent background */
			height: 100px;
			width: 200px;
			border-radius: 50px;
			margin: 20px 0;
			/* Margin to push the button away from the edges */
			border: solid 1px white;
			display: flex;
			justify-content: center;
			/* Center the text inside */
			align-items: center;
			/* Center the text inside */
			z-index: 1;
			/* Keep the button above the image */
			transition: background 0.3s;
			/* Smooth transition for hover effect */
		}

		.container:hover {
			background: rgba(255, 255, 255, 0.8);
			/* Change on hover */
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
			/* Add shadow effect */
		}

		header {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			display: flex;
			background-color: rgb(87, 107, 237);
			justify-content: space-between;
			align-items: center;
			padding: 10px 10px;
			transition: 0.2s;
			z-index: 1;
		}

		nav ul,
		li {
			display: inline-block;
			padding: 0px 15px;
		}

		li {
			list-style-type: none;
		}

		li .aheader {
			text-decoration: none;
			color: black;
			font-size: 0.9em;
		}

		li .aheader:hover {
			color: white;
		}

		.aheader-container {
			font-size: 24px;
			color: white;
			text-decoration: none;
		}

		/* Media Query for responsiveness */
		@media (max-width: 600px) {
			.container {
				width: 150px;
				/* Adjust button width on smaller screens */
			}

			.aheader-container {
				font-size: 20px;
				/* Smaller font size for buttons */
			}
		}
	</style>
</head>

<header>
	<nav>
		<ul>
			<li><a href="Home.php" target="_self" class="aheader">Home</a></li>
			<li><a href="log-in.php" target="_self" class="aheader">Login</a></li>
		</ul>
	</nav>
</header>

<body>


	<div class="flex-container">
		<img src="images/bghome.jpg" alt="A business-themed background image">
		<div class="container">
			<a href="log-in.php" target="_self" class="aheader-container" aria-label="Start the login process">Let's
				Start</a>
		</div>
	</div>
</body>

</html>