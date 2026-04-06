// Matrix Hero
const canvas = document.getElementById('matrix');
const ctx = canvas.getContext('2d');

function resize() {
    canvas.width = window.innerWidth;
    canvas.height = canvas.offsetHeight;
}
resize();
window.addEventListener('resize', resize);

const chars = 'HTMLCSSJSSASSBootstrap{}[]<>/=();const let var function return';
const fontSize = 13;
let drops = Array(Math.floor(canvas.width / fontSize)).fill(1);

function draw() {
    ctx.fillStyle = 'rgba(10,10,15,0.07)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.font = fontSize + 'px monospace';

    drops.forEach((y, i) => {
        const char = chars[Math.floor(Math.random() * chars.length)];
        ctx.fillStyle = Math.random() > 0.5 ? 'rgba(234,88,12,0.7)' : 'rgba(234,88,12,0.2)';
        ctx.fillText(char, i * fontSize, y * fontSize);
        if (y * fontSize > canvas.height && Math.random() > 0.975) drops[i] = 0;
        drops[i]++;
    });
}

setInterval(draw, 40);

document.addEventListener('click', function (event) {
    const menu = document.getElementById('navbarNav'); // Asegúrate que este sea el ID de tu menú
    const boton = document.querySelector('.navbar-toggler');
    const isClickInside = menu.contains(event.target) || boton.contains(event.target);

  
});

document.addEventListener('click', function (event) {
    // 1. Identificamos los elementos con TUS IDs actuales
    const menu = document.getElementById('menuNavbar'); 
    const boton = document.querySelector('.navbar-toggler');
    
    // 2. Verificamos si el clic fue fuera del menú y fuera del botón
    const clickAfuera = !menu.contains(event.target) && !boton.contains(event.target);

    // 3. Si el menú está abierto (tiene la clase 'show') y clickeaste afuera, lo cerramos
    if (clickAfuera && menu.classList.contains('show')) {
        const instanciaBootstrap = bootstrap.Collapse.getOrCreateInstance(menu);
        instanciaBootstrap.hide();
    }
});