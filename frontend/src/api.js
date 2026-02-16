// src/api.js
import axios from "axios";

const API_URL = "http://localhost:8000";

const api = axios.create({
  baseURL: API_URL,
  withCredentials: true, //Esto es para enviar las cookies
  xsrfCookieName: "XSRF-TOKEN",
  xsrfHeaderName: "X-XSRF-TOKEN",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",

  },

});
// Interceptores para debug
api.interceptors.request.use(
  (config) => {
    console.log("📤 REQUEST:", {
      url: config.url,
      method: config.method,
      headers: config.headers,
      data: config.data,
      withCredentials: config.withCredentials,
    });
    return config;
  },
  (error) => {
    console.error("❌ REQUEST ERROR:", error);
    return Promise.reject(error);
  },
);

api.interceptors.response.use(
  (response) => {
    console.log("📥 RESPONSE:", {
      url: response.config.url,
      status: response.status,
      data: response.data,
      headers: response.headers,
    });
    return response;
  },
  (error) => {
    if (error.response) {
      console.error("❌ RESPONSE ERROR:", {
        url: error.config?.url,
        status: error.response.status,
        data: error.response.data,
        headers: error.response.headers,
      });
    } else {
      console.error("❌ NETWORK ERROR:", error);
    }
    return Promise.reject(error);
  },
);

export async function csrf() {
  await api.get("/sanctum/csrf-cookie",{
    withCredentials: true
  }
  );
}

export async function login(email, password) {
  await csrf();
  try {
    return await api.post("/login", {
      email,
      password,
    });
  } catch (error) {
    console.error("Login error:", error.response.data);
    throw error; // Re-lanza el error para manejarlo en otros lugares si es necesario
  }
}
export async function getUser() {
  return api.get("/api/user");
}
console.log("Cookies actuales:", document.cookie);

export default api;
