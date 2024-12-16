document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.slider-frame ul');
    const slides = document.querySelectorAll('.slider-frame li');
    let currentIndex = 0; // Índice de la imagen actual
    const totalSlides = slides.length;

    // Duplica el primer y el último elemento para crear un bucle infinito
    slider.appendChild(slides[0].cloneNode(true));
    slider.insertBefore(slides[slides.length - 1].cloneNode(true), slides[0]);

    // Ajusta la posición inicial del slider para mostrar la primera imagen
    slider.style.transform = `translateX(-100%)`;

    // Función para mover el slider automáticamente
    function moveSlider() {
        currentIndex++;

        // Aplica la transición para mover al siguiente slide
        slider.style.transition = 'transform 1s ease-in-out';
        slider.style.transform = `translateX(-${(currentIndex + 1) * 100}%)`;

        // Reinicia al llegar al final (bucle infinito)
        if (currentIndex === totalSlides) {
            setTimeout(() => {
                slider.style.transition = 'none'; // Elimina la transición
                slider.style.transform = `translateX(-100%)`; // Regresa al inicio
                currentIndex = 0; // Reinicia el índice
            }, 1000); // Espera el final de la transición
        }
    }

    // Ejecuta el slider cada 3 segundos
    setInterval(moveSlider, 3000);
});
