import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { register } from "../api";
import "./Register.css";

export default function Register() {
    const [form, setForm] = useState({
        name: "",
        lastname: "",
        email: "",
        dni: "",
        phone: "",
        password: "",
        confirmPassword: "",
    });
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm((prev) => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError("");
        setLoading(true);

        const payload = {
            ...form,
            password_confirmation: form.confirmPassword,
        };

        try {
            await register(payload);
            navigate("/");
        } catch (err) {
            const message =
                err.response?.data?.message ||
                err.response?.data?.errors?.password?.[0] ||
                err.response?.data?.errors?.password_confirmation?.[0] ||
                "No se pudo registrar";
            setError(message);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="register-card">
            <h2>Crear cuenta</h2>
            <p className="register-subtitle">Unete a Baleartrek en menos de un minuto.</p>

            <form onSubmit={handleSubmit}>
                <div className="register-grid">
                    <div className="register-field">
                        <label>Nombre</label>
                        <input
                            type="text"
                            name="name"
                            value={form.name}
                            onChange={handleChange}
                            required
                            className="register-input"
                            disabled={loading}
                        />
                    </div>

                    <div className="register-field">
                        <label>Apellido</label>
                        <input
                            type="text"
                            name="lastname"
                            value={form.lastname}
                            onChange={handleChange}
                            required
                            className="register-input"
                            disabled={loading}
                        />
                    </div>
                </div>

                <div className="register-field">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        value={form.email}
                        onChange={handleChange}
                        required
                        className="register-input"
                        disabled={loading}
                    />
                </div>

                <div className="register-grid">
                    <div className="register-field">
                        <label>DNI</label>
                        <input
                            type="text"
                            name="dni"
                            value={form.dni}
                            onChange={handleChange}
                            className="register-input"
                            disabled={loading}
                        />
                    </div>

                    <div className="register-field">
                        <label>Teléfono</label>
                        <input
                            type="text"
                            name="phone"
                            value={form.phone}
                            onChange={handleChange}
                            className="register-input"
                            disabled={loading}
                        />
                    </div>
                </div>

                <div className="register-field">
                    <label>Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        value={form.password}
                        onChange={handleChange}
                        required
                        className="register-input"
                        disabled={loading}
                    />
                </div>
                <div className="register-field">
                    <label> Confirmar Contraseña</label>
                    <input
                        type="password"
                        name="confirmPassword"
                        value={form.confirmPassword}
                        onChange={handleChange}
                        required
                        className="register-input"
                        disabled={loading}
                    />
                </div>

                {error && <p className="register-error">{error}</p>}

                <button type="submit" className="register-button" disabled={loading}>
                    {loading ? "Creando cuenta..." : "Registrarme"}
                </button>

                <p className="register-footer">
                    ¿Ya tienes cuenta? <Link to="/" className="register-link">Entrar</Link>
                </p>
            </form>
        </div>
    );
}