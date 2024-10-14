document.addEventListener('DOMContentLoaded', () => {
    // Filtrar la lista de cadenas hoteleras al escribir en la barra de búsqueda
    const inputSearch = document.getElementById('mySearch');
    inputSearch.addEventListener('keyup', () => {
        const filter = inputSearch.value.toUpperCase();
        const listItems = document.querySelectorAll('#myMenu li');

        listItems.forEach(item => {
            const text = item.textContent || item.innerText;
            item.style.display = text.toUpperCase().includes(filter) ? '' : 'none';
        });
    });

    // Mostrar contenido dinámico basado en la cadena seleccionada
    const contentArea = document.getElementById('contentArea');
    const menuLinks = document.querySelectorAll('#myMenu a');

    menuLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const chain = event.target.getAttribute('onclick').split("'")[1];
            showContent(chain);

            // Remover la clase 'active' de todos los enlaces
            menuLinks.forEach(link => link.classList.remove('active'));
            // Añadir la clase 'active' al enlace clickeado
            event.target.classList.add('active');
        });
    });

    function showContent(chain) {
        const content = {
            marriott: `<h2>Marriott Bonvoy</h2><p>Incluye marcas como Marriott, JW Marriott, Sheraton, Westin, entre otras.</p>`,
            aman: `<h2>Aman Resorts</h2><p>Aman Resorts es sinónimo de exclusividad y serenidad.</p>`,
            // Añade más contenido para cada cadena...
        };

        contentArea.innerHTML = content[chain] || '<p>Contenido no disponible.</p>';
    }
});
