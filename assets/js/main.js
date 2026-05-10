// ================================
// MATRIX HERO
// ================================
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

// ================================
// NAVBAR - Cerrar al click afuera
// ================================
document.addEventListener('click', (event) => {
    const menu = document.getElementById('menuNavbar');
    const boton = document.querySelector('.navbar-toggler');
    if (!menu.contains(event.target) && !boton.contains(event.target) && menu.classList.contains('show')) {
        bootstrap.Collapse.getOrCreateInstance(menu).hide();
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

navbar.style.top = promoHeight + 'px';
document.body.style.paddingTop = promoHeight + 'px';

window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    progressBar.style.width = (scrollTop / docHeight * 100) + '%';

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
                entry.target.classList.add('visible');
            }, index * 150);
        }
    });
}, { threshold: 0.2 });

document.querySelectorAll('.servicio-card').forEach(card => observer.observe(card));

// ================================
// GABOWEB - Reviews Carousel
// ================================

(function () {

  const track   = document.getElementById('gr-track');
  const dotsWrap = document.getElementById('gr-dots');
  const btnPrev  = document.getElementById('gr-prev');
  const btnNext  = document.getElementById('gr-next');

  if (!track) return; // Si no existe la sección, no hacer nada

  const cards = Array.from(track.querySelectorAll('.gr-card'));
  let currentIndex = 0;

  const calcVisible = () =>
    window.innerWidth < 576 ? 1 : window.innerWidth < 992 ? 2 : 3;

  function buildDots() {
    dotsWrap.innerHTML = '';
    const pages = Math.ceil(cards.length / calcVisible());
    for (let i = 0; i < pages; i++) {
      const dot = document.createElement('button');
      dot.className = `gr-dot${i === 0 ? ' active' : ''}`;
      dot.setAttribute('aria-label', `Página ${i + 1}`);
      dot.dataset.i = i;
      dot.addEventListener('click', function () { goTo(parseInt(this.dataset.i)); });
      dotsWrap.appendChild(dot);
    }
  }

  function goTo(index) {
    const vis = calcVisible();
    const max = Math.max(0, Math.ceil(cards.length / vis) - 1);
    currentIndex = Math.min(Math.max(index, 0), max);
    const w = cards[0] ? cards[0].offsetWidth + 18 : 328;
    track.style.transform = `translateX(-${currentIndex * vis * w}px)`;
    dotsWrap.querySelectorAll('.gr-dot').forEach((d, i) =>
      d.classList.toggle('active', i === currentIndex)
    );
    btnPrev.disabled = currentIndex === 0;
    btnNext.disabled = currentIndex >= max;
  }

  btnPrev.addEventListener('click', () => goTo(currentIndex - 1));
  btnNext.addEventListener('click', () => goTo(currentIndex + 1));
  window.addEventListener('resize', () => { buildDots(); goTo(currentIndex); });

  buildDots();
  goTo(0);

})();
