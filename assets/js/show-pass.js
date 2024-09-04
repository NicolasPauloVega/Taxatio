// Se carga una vez todo se cargo
document.addEventListener('DOMContentLoaded', function () {
    
    // Seleccionamos la contraseña
    const passwordInput = document.getElementById('pass');
    
    // Seleccionamos el checkbox
    const showPasswordCheckbox = document.getElementById('show-pass');

    // Añadimos un eventos para los cambios del checkbox
    showPasswordCheckbox.addEventListener('change', function () {
        
        // Verificamos si se quiere mostrar o ocultar el checkbox
        if (this.checked) {
            // Cambiamos el input a tipo "text"
            passwordInput.type = 'text';
        } else {
            // Cambiamos el input a tipo "password"
            passwordInput.type = 'password';
        }
    });
});