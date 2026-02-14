const API_URL = "http://localhost:8000";

export async function csrf() {                  // Llamada para obtener la cookie de CSRF
    await fetch(`${API_URL}/sanctum/csrf-cookie`, {
        credentials: "include",
    });
}

export async function login(email, password) {    
    await csrf();

    const response = await fetch(`${API_URL}/login`, {      // Llamada para iniciar sesión
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        credentials: "include", // Guarda las cookies (incluida la de sesión)
        body: JSON.stringify({ email, password }),
    });

    if (!response.ok) {
        const error = await response.json();
        throw error;
    }

    return await response.json();
}

export async function getUser() {                   // Llamada para obtener los datos del usuario autenticado   
    const response = await fetch(`${API_URL}/api/user`, {
        credentials: "include",
        headers: {
            "Accept": "application/json",
        },
    });

    if (!response.ok) {
        throw new Error("No autenticado");
    }

    return await response.json();
}