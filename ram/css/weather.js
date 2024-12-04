fetch('https://api.openweathermap.org/data/2.5/weather?q=London&appid=YOUR_API_KEY&units=metric')
  .then(response => response.json())
  .then(data => {
    // Extract relevant weather information
    const city = data.name;
    const temperature = data.main.temp;
    const description = data.weather[0].description;

    // Display the weather information on the webpage
    const weatherDiv = document.getElementById('weather');
    weatherDiv.innerHTML = `
      <h2>Weather in ${city}</h2>
      <p>Temperature: ${temperature}°C</p>
      <p>Description: ${description}</p>
    `;
  })
  .catch(error => {
    console.error('Error fetching weather data:', error);
  });