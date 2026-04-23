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
    const menu = document.getElementById('menuNavbar'); 
    const boton = document.querySelector('.navbar-toggler');
    const clickAfuera = !menu.contains(event.target) && !boton.contains(event.target);
    if (clickAfuera && menu.classList.contains('show')) {
        const instanciaBootstrap = bootstrap.Collapse.getOrCreateInstance(menu);
        instanciaBootstrap.hide();
    }
});

// ================================
// SCROLL - Progress bar + Promo bar
// ================================
const progressBar = document.createElement('div');
progressBar.id = 'scroll-progress';
document.body.appendChild(progressBar);

const promoBar = document.getElementById('promo-bar');
const navbar = document.getElementById('navbar');
const promoHeight = promoBar.offsetHeight;

// Inicializar al cargar
navbar.style.top = promoHeight + 'px';
document.body.style.paddingTop = promoHeight + 'px';

window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;

    // Progress bar
    progressBar.style.width = (scrollTop / docHeight * 100) + '%';

    // Promo bar + navbar + body
    if (scrollTop > 80) {
        promoBar.classList.add('oculta');
        navbar.style.top = '0px';
        document.body.style.paddingTop = '0px';
    } else {
        promoBar.classList.remove('oculta');
        navbar.style.top = promoHeight + 'px';
        document.body.style.paddingTop = promoHeight + 'px';
    }
});

// ================================
// SCROLL REVEAL - Servicios
// ================================
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry, index) => {
    if (entry.isIntersecting) {
      setTimeout(() => {
        entry.target.classList.add('visible')
      }, index * 150)
    }
  })
}, { threshold: 0.1 })

document.querySelectorAll('.servicio-card').forEach(card => {
  observer.observe(card)
})