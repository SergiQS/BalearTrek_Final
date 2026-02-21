import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { login } from "../api";
import { Link } from "react-router-dom";
import "./Login.css";

export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const res = await login(email, password);

      // Verificar que el token se guardó
      const token = localStorage.getItem("token");
      console.log("✅ Login exitoso. Token guardado:", !!token);

      // Navegar a LandingPage
      navigate("/Landingpage");
    } catch (err) {
      console.error("Login error:", err);
      setError(err.message || "Credenciales incorrectas");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="login-card">
      <h2>Iniciar sesión</h2>

      <form onSubmit={handleSubmit}>
        <div className="login-field">
          <label>Email</label>
          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
            className="login-input"
            disabled={loading}
          />
        </div>

        <div className="login-field">
          <label>Contraseña</label>
          <input
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
            className="login-input"
            disabled={loading}
          />
        </div>

        {error && <p className="login-error">{error}</p>}

        <button
          type="submit"
          disabled={loading}
          className="login-button"
        >
          {loading ? "Cargando..." : "Entrar"}
        </button>

        <button
          type="button"
          className="login-button login-button--register"
        >
          ¿No te has registrado?{" "}
          <Link to="/register" className="login-link">
            Regístrate aquí
          </Link>
        </button>
      </form>
    </div>
  );
}
