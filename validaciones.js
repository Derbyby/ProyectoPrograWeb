document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener('submit', function(event) {
        let formIsValid = true;

        // Obtener todos los inputs del formulario
        form.querySelectorAll('input').forEach(function(input) {
            let errorElement = document.querySelector(`#error-${input.name}`);
            let inputValue = input.value.trim();
            let fieldName = input.name;

            // Validación según el tipo de campo
            if (input.required && inputValue === '') {
                formIsValid = false;
                errorElement.textContent = `${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)} es obligatorio.`;
            } else {
                errorElement.textContent = '';
            }

            // Validación de email
            if (fieldName === 'email') {
                let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (inputValue !== '' && !emailPattern.test(inputValue)) {
                    formIsValid = false;
                    errorElement.textContent = "Por favor ingresa un correo electrónico válido.";
                }
            }

            // Validación de teléfono
            if (fieldName === 'telefono') {
                let telefonoPattern = /^\d{10}$/; // Verifica que el teléfono tenga 10 dígitos
                if (inputValue !== '' && !telefonoPattern.test(inputValue)) {
                    formIsValid = false;
                    errorElement.textContent = "El teléfono debe tener 10 dígitos.";
                }
            }

            // Validación de contraseñas
            if (fieldName === 'password' || fieldName === 'repassword') {
                let password = form.querySelector('input[name="password"]').value.trim();
                let repassword = form.querySelector('input[name="repassword"]').value.trim();
                
                if (fieldName === 'repassword') {
                    if (repassword !== password) {
                        formIsValid = false;
                        errorElement.textContent = "Las contraseñas no coinciden.";
                    }
                } else if (fieldName === 'password' && password === '') {
                    formIsValid = false;
                    errorElement.textContent = "La contraseña es obligatoria.";
                }
            }
            
        });

        // Si el formulario no es válido, evitar su envío
        if (!formIsValid) {
            event.preventDefault();
        }
    });
});

