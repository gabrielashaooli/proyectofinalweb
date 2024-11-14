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
    flightSearchForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const origin = document.getElementById('origin').value;
        const destination = document.getElementById('destination').value;
        const departureDate = document.getElementById('departureDate').value;

        searchFlights(origin, destination, departureDate);
    });

    function searchFlights(origin, destination, departureDate) {
        const url = `vuelos.php?origin=${origin}&destination=${destination}&departureDate=${departureDate}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                displayFlightData(data);
            })
            .catch(error => console.error('Error al obtener los datos de vuelo:', error));
    }

    function displayFlightData(data) {
        const flightResultsList = document.getElementById('flightResultsList');
        flightResultsList.innerHTML = ''; // Limpia resultados anteriores

        if (!data || !data.data || data.data.length === 0) {
            flightResultsList.innerHTML = '<p>No se encontraron vuelos para esta búsqueda.</p>';
            return;
        }

        data.data.forEach(flight => {
            const flightElement = document.createElement('div');
            flightElement.classList.add('flight');
            flightElement.innerHTML = `
                <p><strong>Vuelo:</strong> ${flight.flight.iata}</p>
                <p><strong>Origen:</strong> ${flight.departure.iata} - ${flight.departure.airport}</p>
                <p><strong>Destino:</strong> ${flight.arrival.iata} - ${flight.arrival.airport}</p>
                <p><strong>Hora de salida:</strong> ${flight.departure.scheduled}</p>
                <p><strong>Hora de llegada:</strong> ${flight.arrival.scheduled}</p>
                <p><strong>Aerolínea:</strong> ${flight.airline.name}</p>
            `;
            flightResultsList.appendChild(flightElement);
        });
    }
});



