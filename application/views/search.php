<!DOCTYPE html>
<html>

<head>
    <title>Autocomplete Search</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <h1>Autocomplete Search</h1>
    <input type="text" id="searchInput" placeholder="Type here...">
    <div id="autocompleteResults"></div>
    <script>
        
    </script>
    <!-- 
    <script>
        const searchInput = document.getElementById('searchInput');
        const autocompleteResults = document.getElementById('autocompleteResults');

        let airports = []; // To store airport names

        // Fetch CSV data
        fetch('airports.csv')
            .then(response => response.text())
            .then(data => {
                const rows = data.split('\n');
                for (const row of rows) {
                    const columns = row.split(',');
                    if (columns.length >= 18) { // Assuming 17 columns in your CSV
                        airports.push(columns[3]); // Adjust the index as needed for the airport name column
                    }
                }
            });

        // Function to update autocomplete suggestions
        function updateSuggestions(query) {
            const filteredAirports = airports.filter(airport =>
                airport.toLowerCase().includes(query.toLowerCase())
            );

            autocompleteResults.innerHTML = ''; // Clear previous suggestions

            filteredAirports.forEach(airport => {
                const airportElement = document.createElement('div');
                airportElement.textContent = airport;
                airportElement.classList.add('suggestion');
                airportElement.addEventListener('click', () => {
                    searchInput.value = airport;
                    autocompleteResults.innerHTML = ''; // Clear suggestions on selection
                });
                autocompleteResults.appendChild(airportElement);
            });
        }

        searchInput.addEventListener('input', () => {
            const query = searchInput.value;
            updateSuggestions(query);
        });
    </script> -->
</body>

</html>