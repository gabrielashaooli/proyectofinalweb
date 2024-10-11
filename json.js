function showSection(sectionId) {
    // Oculta todas las secciones
    var sections = document.getElementsByClassName('content-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = 'none';
    }

    // Muestra la sección seleccionada
    document.getElementById(sectionId).style.display = 'block';
}
