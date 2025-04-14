document.getElementById('loginForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    // Credenciales del administrador
    const adminCredentials = {
        email: 'admisalecars@car.com',
        password: 'thebestcars'
    };
    
    // Verificar si las credenciales son del administrador
    if (email === adminCredentials.email && password === adminCredentials.password) {
        // Redirigir al panel de administración si son las credenciales del administrador
        window.location.href = '/admin.html';  // Asegúrate de tener una página de administración
        return;
    }

    // Si no es administrador, hacer la petición al microservicio de login
    const response = await fetch('http://192.168.100.3:3001/api/usuarios/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, contraseña: password })
    });
    
    const result = await response.json();
    if (response.ok) {
        // Si login es exitoso, guarda el token y redirige a la página de usuario
        alert('Login exitoso!');
        localStorage.setItem('token', result.token);
        window.location.href = '/dashboard.html';  // Redirigir a otra página de usuario
    } else {
        alert(`Error en login: ${result.message}`);
    }
});
