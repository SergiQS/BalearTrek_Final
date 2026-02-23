// src/api.js
import axios from "axios";

const API_URL = "http://localhost:8000";

const api = axios.create({        // Creamos una instancia de axios con la URL base y configuraciones comunes
  baseURL: API_URL,
  withCredentials: true,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

// Interceptor para agregar el token a cada petición
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");  // Obtenemos el token del localStorage
    if (token) {
      config.headers.Authorization = `Bearer ${token}`; // Agregamos el token al encabezado Authorization
    }
    console.log(" REQUEST:", {
      url: config.url,
      method: config.method,
      headers: config.headers,
      data: config.data,
    });
    return config;
  },
  (error) => {
    console.error(" REQUEST ERROR:", error);
    return Promise.reject(error); // Rechazamos la promesa para que el error pueda ser manejado en los componentes
  },
);

api.interceptors.response.use(
  (response) => {
    console.log(" RESPONSE:", {
      url: response.config.url,
      status: response.status,
      data: response.data,
    });
    return response;
  },
  (error) => {
    if (error.response?.status === 401) {
      // Token inválido o expirado
      localStorage.removeItem("token");
      localStorage.removeItem("user");
      console.error("Token inválido o expirado");
    }
    if (error.response) {
      console.error(" RESPONSE ERROR:", {
        url: error.config?.url,
        status: error.response.status,
        data: error.response.data,
      });
    } else {
      console.error(" NETWORK ERROR:", error);
    }
    return Promise.reject(error);
  },
);

export async function csrf() {
  await api.get("/sanctum/csrf-cookie", {
    withCredentials: true,
  });
}

export async function login(email, password) {
  try {
    const res = await api.post("/api/login", {
      email,
      password,
    });
    
    // Guardar token y usuario
    if (res.data.token) {
      localStorage.setItem("token", res.data.token);
      localStorage.setItem("user", JSON.stringify(res.data.user));
    }
    
    return res;
  } catch (error) {
    console.error("Login error:", error.response?.data);
    throw error;
  }
}

export async function register(formulario) {
  try {
    const res = await api.post("/api/register", formulario);
    return res;
  } catch (error) {
    console.error("Register error:", error.response?.data || error.message);
    throw error;
  }
}

export async function getUser() {
  return api.get("/api/user");
}

export async function deactivateAccount() {
  return api.put("/api/user/deactivate");
}

export async function logout() {
  try {
    await api.post("/api/logout");
  } catch (error) {
    console.error("Logout error:", error);
  } finally {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
  }
}

export default api;
