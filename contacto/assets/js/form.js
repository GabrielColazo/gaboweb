document.addEventListener('DOMContentLoaded', function() {
    
    const form = document.getElementById('contactForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const feedback = document.getElementById('formFeedback');
    const fileInput = document.getElementById('adjunto');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    
    // --- Lógica para el Input de Archivo Moderno ---
    if(fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                fileNameDisplay.textContent = 'Archivo seleccionado: ' + fileName;
                fileNameDisplay.style.display = 'block';
                // Opcional: cambiar el estilo del label
                document.getElementById('customFileLabel').style.borderColor = 'var(--color-primary)';
            } else {
                fileNameDisplay.textContent = '';
                fileNameDisplay.style.display = 'none';
                document.getElementById('customFileLabel').style.borderColor = '';
            }
        });
    }

    // --- Lógica de Envío AJAX ---
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // UI Estado Cargando
        const originalBtnText = btnSubmit.innerText;
        btnSubmit.innerText = btnSubmit.getAttribute('data-loading-text');
        btnSubmit.disabled = true;
        feedback.style.display = 'none';
        feedback.className = 'form-feedback'; // Reset clases

        const formData = new FormData(form);

        fetch('procesar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            feedback.innerText = data.message;
            // Usamos las clases 'success' o 'error' definidas en el CSS
            feedback.classList.add(data.success ? 'success' : 'error');
            feedback.style.display = 'block';

            if (data.success) {
                form.reset();
                if(fileNameDisplay) {
                    fileNameDisplay.textContent = '';
                    fileNameDisplay.style.display = 'none';
                }
            }
        })
        .catch(error => {
            feedback.innerText = 'Error de conexión. Por favor, verifica tu internet e inténtalo de nuevo.';
            feedback.classList.add('error');
            feedback.style.display = 'block';
            console.error('Error:', error);
        })
        .finally(() => {
            btnSubmit.innerText = originalBtnText;
            btnSubmit.disabled = false;
        });
    });
});