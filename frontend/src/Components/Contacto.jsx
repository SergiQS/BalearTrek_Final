import { useState } from "react";
import Header from "./Header";
import "./Contacto.css";

export default function Contacto() {
  const [formData, setFormData] = useState({
    nombre: "",
    correo: "",
    asunto: "",
    mensaje: ""
  });

  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState(null);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    // Validar campos
    if (!formData.nombre.trim() || !formData.correo.trim() || !formData.asunto.trim() || !formData.mensaje.trim()) {
      setError("Por favor completa todos los campos");
      return;
    }

    // Validar email básico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(formData.correo)) {
      setError("Por favor ingresa un correo válido");
      return;
    }

    setLoading(true);
    setError(null);
    setSuccess(false);

    try {
      // Aquí puedes añadir la lógica para enviar el formulario a tu backend
      // Por ahora simularemos una respuesta exitosa
      console.log("Enviando formulario:", formData);
      
      // Simulamos un delay de envío
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      setSuccess(true);
      setFormData({
        nombre: "",
        correo: "",
        asunto: "",
        mensaje: ""
      });

      // Ocultar el mensaje de éxito después de 3 segundos
      setTimeout(() => setSuccess(false), 3000);
    } catch (err) {
      setError("Hubo un error al enviar el mensaje. Por favor intenta de nuevo.");
      console.error("Error:", err);
    } finally {
      setLoading(false);
    }
  };

  const handleReset = () => {
    setFormData({
      nombre: "",
      correo: "",
      asunto: "",
      mensaje: ""
    });
    setError(null);
    setSuccess(false);
  };

  return (
    <>
      <Header />
      <section className="contact-container">
        <div className="contact-header">
          <h1 className="contact-title">Contacto</h1>
          <p className="contact-subtitle">¿Tienes preguntas? Nos encantaría escucharte. Envíanos un mensaje.</p>
        </div>

        <div className="contact-form-wrapper">
          {success && (
            <div className="success-message">
              ✓ Mensaje enviado correctamente. Pronto nos pondremos en contacto.
            </div>
          )}

          {error && (
            <div className="error-message">
              ✕ {error}
            </div>
          )}

          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label className="form-label" htmlFor="nombre">Nombre</label>
              <input
                id="nombre"
                type="text"
                name="nombre"
                className="form-input"
                placeholder="Tu nombre completo"
                value={formData.nombre}
                onChange={handleChange}
              />
            </div>

            <div className="form-group">
              <label className="form-label" htmlFor="correo">Correo Electrónico</label>
              <input
                id="correo"
                type="email"
                name="correo"
                className="form-input"
                placeholder="tu@correo.com"
                value={formData.correo}
                onChange={handleChange}
              />
            </div>

            <div className="form-group">
              <label className="form-label" htmlFor="asunto">Asunto</label>
              <input
                id="asunto"
                type="text"
                name="asunto"
                className="form-input"
                placeholder="¿Cuál es el asunto de tu mensaje?"
                value={formData.asunto}
                onChange={handleChange}
              />
            </div>

            <div className="form-group">
              <label className="form-label" htmlFor="mensaje">Mensaje</label>
              <textarea
                id="mensaje"
                name="mensaje"
                className="form-textarea"
                placeholder="Cuéntanos tu mensaje..."
                value={formData.mensaje}
                onChange={handleChange}
              ></textarea>
            </div>

            <div className="form-actions">
              <button 
                type="submit" 
                className="submit-btn"
                disabled={loading}
              >
                {loading ? "Enviando..." : "Enviar Mensaje"}
              </button>
              <button 
                type="button" 
                className="reset-btn"
                onClick={handleReset}
                disabled={loading}
              >
                Limpiar
              </button>
            </div>
          </form>
        </div>
      </section>
    </>
  );
}
