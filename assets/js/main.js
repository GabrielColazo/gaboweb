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