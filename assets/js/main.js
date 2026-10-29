// 1. Inicializar GSAP ScrollTrigger
gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {
  
  // 2. Animación de Entrada (Hero Section)
  const heroTl = gsap.timeline();

  heroTl.fromTo(".hero-meta-top", 
    { opacity: 0, y: -20 }, 
    { opacity: 1, y: 0, duration: 0.8, ease: "power3.out", delay: 0.2 }
  )
  // Animación en cascada para cada palabra/símbolo del título
  .fromTo(".hero-title > span", 
    { opacity: 0, y: 60, rotationX: -20 }, 
    { opacity: 1, y: 0, rotationX: 0, duration: 0.8, stagger: 0.15, ease: "back.out(1.2)" },
    "-=0.4"
  )
  .fromTo(".hero-meta-bottom", 
    { opacity: 0, y: 20 }, 
    { opacity: 1, y: 0, duration: 0.8, ease: "power3.out" },
    "-=0.4"
  );

  // 3. Revelado de Secciones al hacer Scroll
  gsap.utils.toArray('.section-header').forEach(header => {
    gsap.fromTo(header,
      { opacity: 0, x: -40 },
      {
        opacity: 1, x: 0, duration: 0.8, ease: "power3.out",
        scrollTrigger: {
          trigger: header,
          start: "top 85%", // Se activa cuando el elemento toca el 85% de la pantalla
        }
      }
    );
  });

  // 4. Revelado fluido de las Tarjetas de Proyectos
  gsap.utils.toArray('.project-card').forEach((card, index) => {
    gsap.fromTo(card,
      { opacity: 0, y: 40 },
      {
        opacity: 1, y: 0, duration: 0.7, ease: "power3.out",
        scrollTrigger: {
          trigger: card,
          start: "top 90%",
        }
      }
    );
  });

  // 4.5. Efecto Tilt 3D magnético para tarjetas de proyectos
  const projectCards = document.querySelectorAll('.project-card');

  projectCards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      // Inclinación máxima de 6 grados
      const rotateX = ((y - centerY) / centerY) * -6;
      const rotateY = ((x - centerX) / centerX) * 6;

      // Aplicar perspectiva, rotación y zoom sutil
      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.03)`;
      card.style.transition = 'none'; // Movimiento instantáneo siguiendo el mouse
    });

    card.addEventListener('mouseleave', () => {
      // Restaurar estado original con transición suave
      card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
      card.style.transition = 'transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
    });
  });

  // 5. Funcionalidad del Menú Móvil
  const mobileToggle = document.getElementById('mobileToggle');
  const mainNav = document.getElementById('mainNav');
  
  if (mobileToggle && mainNav) {
    mobileToggle.addEventListener('click', () => {
      mobileToggle.classList.toggle('active');
      mainNav.classList.toggle('open');
    });

    // Cerrar menú al hacer clic en un enlace
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileToggle.classList.remove('active');
        mainNav.classList.remove('open');
      });
    });
  }
  
  // 7. Funcionalidad del Formulario (Web3Forms con Fetch API en JSON)
  const contactForm = document.getElementById('contactForm');
  const formStatus = document.getElementById('formStatus');

  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault(); // Evitamos que la página se recargue

      // Mostrar mensaje de carga
      formStatus.textContent = "Enviando mensaje...";
      formStatus.style.color = "#FF6A00"; // Naranja

      // Recopilar todos los datos del formulario usando FormData
      const formData = new FormData(contactForm);
      
      // Convertimos el FormData a un objeto normal, y luego a JSON (Requerido por la API en este modo)
      const object = Object.fromEntries(formData);
      const json = JSON.stringify(object);

      try {
        // Enviar a Web3Forms usando Fetch
        const response = await fetch("https://api.web3forms.com/submit", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: json
        });

        const data = await response.json();

        if (response.status === 200) {
          // Éxito
          formStatus.textContent = "¡Mensaje enviado! Te responderé a la brevedad.";
          formStatus.style.color = "#10B981"; // Verde
          contactForm.reset(); // Limpiar campos
        } else {
          // Error de Web3Forms
          console.log(data);
          formStatus.textContent = data.message || "Hubo un error. Por favor, intentá de nuevo.";
          formStatus.style.color = "#ef4444"; // Rojo
        }
      } catch (error) {
        // Error de conexión a internet
        console.error(error);
        formStatus.textContent = "Error de conexión. Intentá escribirme por WhatsApp.";
        formStatus.style.color = "#ef4444"; // Rojo
      }

      // Borrar el mensaje de estado después de 4 segundos
      setTimeout(() => {
        formStatus.textContent = "";
      }, 4000);
    });
  }
});