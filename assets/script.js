const searchInput = document.getElementById("searchInput");
const autocompleteResults = document.getElementById("autocompleteResults");

let airportsData = []; // To store complete rows of airport data

// Fetch CSV data
fetch("/airports.csv")
    .then((response) => response.text())
    .then((data) => {
        const rows = data.split("\n");
        for (const row of rows) {
            const columns = row.split(",");
            if (columns.length >= 18) {
                // Assuming 17 columns in your CSV
                airportsData.push(columns);
            }
        }
    });

// Function to update autocomplete suggestions
function updateSuggestions(query) {
    const filteredAirports = airportsData.filter(
        (airportData) => airportData[3].toLowerCase().includes(query.toLowerCase())
    );

    autocompleteResults.innerHTML = "";

    filteredAirports.forEach((airportData) => {
        const airportElement = document.createElement("div");
        airportElement.textContent = airportData[3].replace(/"/g, "");
        airportElement.classList.add("suggestion");
        airportElement.addEventListener("click", () => {
            calculateArcticDistance(airportData[5], airportData[4])
            searchInput.value = airportData[3].replace(/"/g, "");
            autocompleteResults.innerHTML = "";
            displaySelectedRow(airportData);
        });
        autocompleteResults.appendChild(airportElement);
    });
}

// // Function to display the complete row
function displaySelectedRow(rowData) {
    const selectedRowContainer = document.getElementById("selectedRowContainer");
    // selectedRowContainer.innerHTML = ""; // Clear previous selection

    const selectedRow = document.createElement("div");
    selectedRow.classList.add("selectedRow");

    for (const columnData of rowData) {
        const columnElement = document.createElement("div");
        columnElement.textContent = columnData;
        selectedRow.appendChild(columnElement);
    }

    // selectedRowContainer.appendChild(selectedRow);
}

searchInput.addEventListener("input", () => {
    const query = searchInput.value;
    updateSuggestions(query);
});



function calculateArcticDistance(lat1, lon1, lat2 = 0, lon2 = 0) {
    // Implement your function logic here
    openLayerMap(lat1, lon1)
    const earthRadius = 6371; // Earth's radius in kilometers
    // Convert latitude and longitude from degrees to radians
    const dLat = (Number(lat2) - Number(lat1)) * (Math.PI / 180);
    const dLon = (lon2 - lon1) * (Math.PI / 180);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    const distance = earthRadius * c;
    $("#d_artic").empty().append(distance.toFixed(2) + " KM")
}

function updateWeather() {
    fetch("/welcome/weather")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            // console.log(data.error);
            if (data.error.code == 2008) {
                $("#weatherError").empty().append("<span class='text-danger h5'>" + data.error.message + "</span>")
                return false;
            }
            document.getElementById("temperature").innerText = data.current.temp_c;
            const weatherIconElement = document.getElementById("weather-icon");
            weatherIconElement.innerHTML = "";
            if (data.current.is_day === 1) {
                if (data.current.condition.text.toLowerCase().includes("sunny")) {
                    const sunImage = document.createElement("img");
                    sunImage.src =
                        "https://cdn-icons-png.flaticon.com/512/136/136723.png";
                    sunImage.alt = "Sunny";
                    weatherIconElement.appendChild(sunImage);
                } else if (data.current.condition.text.toLowerCase().includes("rain")) {
                    const cloudImage = document.createElement("img");
                    cloudImage.src =
                        "https://cdn-icons-png.flaticon.com/512/252/252035.png";
                    cloudImage.alt = "Cloud";
                    weatherIconElement.appendChild(cloudImage);
                } else if (data.current.condition.text.toLowerCase().includes("snow")) {
                    const snowflakeImage = document.createElement("img");
                    snowflakeImage.src =
                        "https://cdn-icons-png.flaticon.com/512/5906/5906790.png";
                    snowflakeImage.alt = "Snowflake";
                    weatherIconElement.appendChild(snowflakeImage);
                }
            }
        })
        .catch((error) => {
            console.error("Error fetching weather data:", error);
            $("#weatherError").empty().append("<span class='text-danger h5'>" + error.message + "</span>")
        });
}

function updateTimes() {
    fetch("/welcome/timezone") // Replace with the correct backend route URL
        .then((response) => response.json())
        .then((data) => {
            $("#utc-time").empty().append(data.utc_time);
            $("#london-time").empty().append(data.london_time);
            $("#est-time").empty().append(data.est_time);
            $("#nigeria-time").empty().append(data.nigeria_time);
            $("#pakistan-time").empty().append(data.pakistan_time);
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
}

function openLayerMap(lat, lon) {
    console.log([lat, lon]);
    $('#openlayer-map').empty()
    const map = new ol.Map({
        target: 'openlayer-map',
        view: new ol.View({
            center: ol.proj.fromLonLat([lon, lat]), //(longitude, latitude)
            zoom: 2,
        }),
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ]
    });
}

$(document).ready(function() {
    $('.bg-white').on('click', function() {
        const widgetId = $(this).data('widget-name');
        updateWidget(widgetId);
    });

    function updateWidget(widgetId) {
        $.ajax({
            url: '/api/analytic?widget-name=' + widgetId,
            type: 'GET',
            success: function(response) {
                console.log(response); // Log the server response
            },
            error: function(error) {
                console.error(error); // Log any errors
            }
        });
    }
});

function analytic() {
    $.get("/api/analytic", function(data, status) {
        result = JSON.parse(data)
        $("#no_clicks").empty().text(result.data)
    })
}

$("#calculateButton").click(function() {
    var amount = $("#amount").val();
    $.ajax({
        type: "POST",
        url: "/api/calculate", // Replace with the actual route URL
        data: {
            amount: amount
        },
        success: function(response) {
            var data = JSON.parse(response)
            $("#bill_counts_result").html(data.result);
        }
    });
});

imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        blah.src = URL.createObjectURL(file)
    }
}

// Update times every 5 minutes (300,000 milliseconds)
setInterval(updateTimes, 3000000);
setInterval(updateWeather, 300000);
setInterval(analytic, 60000)

function callAll() {
    updateWeather();
    updateTimes();
    openLayerMap(0, 0)
    analytic()
}

// initial call for all function
callAll();