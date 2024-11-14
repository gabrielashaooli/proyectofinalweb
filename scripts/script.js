document.addEventListener('DOMContentLoaded', () => {

    const inputSearch = document.getElementById('mySearch');
    inputSearch.addEventListener('keyup', () => {
        const filter = inputSearch.value.toUpperCase();
        const listItems = document.querySelectorAll('#myMenu li');

        listItems.forEach(item => {
            const text = item.textContent || item.innerText;
            item.style.display = text.toUpperCase().includes(filter) ? '' : 'none';
        });
    });


    const contentArea = document.getElementById('contentArea');
    const menuLinks = document.querySelectorAll('#myMenu a');

    menuLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const chain = event.target.getAttribute('onclick').split("'")[1];
            showContent(chain);


            menuLinks.forEach(link => link.classList.remove('active'));
            // Añadir la clase 'active' al enlace clickeado
            event.target.classList.add('active');
        });
    });

    function showContent(chain) {
        const content = {
            marriott: `<h2>Marriott Bonvoy</h2><p>Incluye marcas como Marriott, JW Marriott, Sheraton, Westin, entre otras.</p>`,
            aman: `<h2>Aman Resorts</h2><p>Aman Resorts es sinónimo de exclusividad y serenidad.</p>`,

        };

        contentArea.innerHTML = content[chain] || '<p>Contenido no disponible.</p>';
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const flightSearchForm = document.getElementById('flightSearchForm');
    const flightResultsList = document.getElementById('flightResultsList');

    flightSearchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        fetchFlightData();
    });

    function fetchFlightData() {
        const url = `fetch_flight_data.php`;

        fetch(url)
            .then(response => response.json())
            .then(data => displayFlightResults(data))
            .catch(error => {
                console.error('Error fetching flight data:', error);
                flightResultsList.innerHTML = "<h6>Error al obtener los datos del vuelo. Inténtelo de nuevo más tarde.</h6>";
            });
    }

    function displayFlightResults(data) {
        flightResultsList.innerHTML = '';  // Clear any previous results

        if (data && data.data && data.data.length > 0) {
            data.data.forEach(flight => {
                const flightItem = document.createElement('div');
                flightItem.classList.add('flight-item', 'hero p ');
                flightItem.innerHTML = `
                    <p><strong>Fecha de Vuelo:</strong> ${flight.flight_date}</p>
                    <p><strong>Estado del Vuelo:</strong> ${flight.flight_status}</p>
                    <p><strong>Aerolínea:</strong> ${flight.airline.name}</p>
                    <p><strong>Número de Vuelo:</strong> ${flight.flight.iata}</p>
                    <p><strong>Origen:</strong> ${flight.departure.airport} (${flight.departure.iata})</p>
                    <p><strong>Destino:</strong> ${flight.arrival.airport} (${flight.arrival.iata})</p>
                    <p><strong>Hora de Salida Programada:</strong> ${flight.departure.scheduled}</p>
                    <p><strong>Hora de Llegada Programada:</strong> ${flight.arrival.scheduled}</p>
                `;
                flightResultsList.appendChild(flightItem);
            });
        } else {
            flightResultsList.innerHTML = "<p>No se encontraron vuelos para esta búsqueda.</p>";
        }
    }
});
