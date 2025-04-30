document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const loginForm = document.getElementById('loginForm');
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    // Función para mostrar/ocultar contraseña
    function togglePassword() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }
    
    // Evento para el botón de mostrar/ocultar contraseña
    togglePasswordBtn.addEventListener('click', togglePassword);
    
    // Evento para el envío del formulario
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        
        // Validación básica (debes reemplazar esto con tu lógica real)
        if (username === 'AlexUCA' && password === 'alex123') {
            localStorage.setItem('loggedIn', 'true');
            window.location.href = 'admin.html';
        } else {
            alert('Credenciales incorrectas. Por favor intente nuevamente.');
        }
    });
});