// URL de tu API
const apiUrl = 'http://localhost/proyectoNivelC/get_niveles.php';

function cargarNiveles() {
    console.log("URL de la API:", apiUrl); // Verifica que la URL de la API sea correcta
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('La respuesta de la API no fue exitosa');
            }
            return response.json();
        })
        .then(data => {
            console.log("Datos recibidos de la API:", data); // Verifica los datos recibidos de la API
            mostrarNiveles(data);
        })
        .catch(error => {
            console.error('Error en la solicitud:', error.message);
        });
}

// Función para mostrar los niveles en la interfaz de usuario
function mostrarNiveles(niveles) {
    const container = document.getElementById('niveles-container');
    container.innerHTML = '';

    niveles.forEach((nivel, index) => {
        const nivelElement = document.createElement('div');
        nivelElement.className = 'juego1';
        nivelElement.innerHTML = `
            <h3>Nivel ${nivel.num_nivel}</h3>
            <button onclick="redirigir(${nivel.id})">Vamos!</button>
            <p>${nivel.descripcion}</p>
       
        `;
        container.appendChild(nivelElement);
    });
}

// Función para redirigir según el nivel
function redirigir(nivelId) {
    // Redirigir a la página de detalles del nivel con el ID en la URL
    window.location.href = `nivel1.html?nivel_id=${nivelId}`;
}

// Llamar a la función para cargar los niveles cuando la página se cargue
window.onload = cargarNiveles;
