import { useState, useEffect } from "react";
import { getUser, logout, deactivateAccount } from "../api";
import { useNavigate } from "react-router-dom";
import Header from "./Header";
import "./Perfil.css";

export default function Perfil() {
  const navigate = useNavigate();
  const [user, setUser] = useState(
    JSON.parse(localStorage.getItem("user")) || null,
  ); // Cargar usuario desde localStorage inicialmente para evitar parpadeos al cargar el perfil
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [verUser, setVerUser] = useState({});
  const [deactivating, setDeactivating] = useState(false);

  const handleLogout = async () => {
    await logout();
    navigate("/");
  };

  const handleDeactivate = async () => {
    if (!window.confirm("¿Estás seguro de que deseas desactivar tu cuenta? Esta acción cambiará tu estado a inactivo.")) {
      return;
    }
    
    try {
      setDeactivating(true); 
      await deactivateAccount();
      setUser(prev => ({...prev, status: 'n'})); // Actualizar estado local del usuario a inactivo
      localStorage.setItem("user", JSON.stringify({...user, status: 'n'}));// Actualizar localStorage para reflejar el cambio de estado
      alert("Tu cuenta ha sido desactivada.");
      setTimeout(() => {
        handleLogout();
      }, 2000);
    } catch (err) {
      console.error("Error deactivating account:", err);
      setError("Error al desactivar cuenta. Intenta de nuevo.");
    } finally {
      setDeactivating(false);
    }
  };

    // Cargar datos del usuario al montar el componente
  useEffect(() => {
    const fetchUser = async () => {
      try {
        setLoading(true);
        const res = await getUser();
        setUser(res.data.data);
        localStorage.setItem("user", JSON.stringify(res.data.data));
        setError(null);
      } catch (err) {
        console.error("Error fetching user:", err);
        setError("No se pudo cargar el perfil");
      } finally {
        setLoading(false);
      }
    };
    console.log(user);
    fetchUser();
  }, []);

  if (loading) return <div>Cargando perfil...</div>;
  if (error) return <div className="error">{error}</div>;
  if (!user) return <div>No hay usuario autenticado</div>;
  console.log(user);
  return (
    <>
      <Header></Header>
      {/* USER INFO */}
      <section className="user-info">
        <div className="profile-header">
          <div>
            <h2 className="profile-title">Perfil</h2>
            <p className="profile-subtitle">
              Gestiona tu informacion y reservas.
            </p>
          </div>
          <div className="profile-actions">
            {/* <button className="edit-btn">Editar</button> */}
            <button className="logout-btn" onClick={handleLogout}>
              Cerrar Sesión
            </button>
            <button className="deactivate-btn" onClick={handleDeactivate} disabled={deactivating}>
              {deactivating ? "Desactivando..." : "Desactivar Cuenta"}
            </button>
          </div>
        </div>
        <div className="info-row">
          <span className="label">Nombre:</span>
          <span>{user.name}</span>
        </div>

        <div className="info-row">
          <span className="label">Apellido:</span>
          <span>{user.lastName}</span>
        </div>
        <div className="info-row">
          <span className="label">Rol:</span>
          <span>{user.role?.name}</span>
        </div>

        <div className="info-row">
          <span className="label">Email:</span>
          <span>{user.email}</span>
        </div>
          <div className="info-row">
          <span className="label">Estado de cuenta: </span>
          <span>{user.status === 'n' ? 'Inactivo' : 'Activo'}</span>
        </div>

        <div className="info-row">
          <span className="label">Tlf:</span>
          <span>{user.phone || "No especificado"}</span>
        </div>

        <div className="info-row">
          <span className="label">Contraseña:</span>
          <span>{user.password}*******</span>
        </div>

        <div className="meetings-box">
          <h3>ENCUENTROS a los que estás inscrito</h3>

          {user.meetings?.map((meeting) => (
            <div key={meeting.id} className="meeting-item">
              <div>
                <strong>Trek:</strong> {meeting.trek?.name}
              </div>
              <div>
                <strong>Día:</strong> {meeting.day}
              </div>
              <div>
                <strong>Hora:</strong> {meeting.hour}
              </div>
            </div>
          ))}
        </div>

        {user.role?.name === "guia" && user.meeting?.length > 0 && (
          <div className="meetings-box">
            <h3>ENCUENTROS DONDE ERES GUÍA</h3>

            {user.meeting.map((meeting) => (
              <div key={meeting.id} className="meeting-item">
                <div>
                  <strong>Trek:</strong> {meeting.trek?.name}
                </div>
                <div>
                  <strong>Día:</strong> {meeting.day}
                </div>
                <div>
                  <strong>Hora:</strong> {meeting.hour}
                </div>
                <div className="attendees-section">
                  <strong>Inscritos ({meeting.users?.length || 0}):</strong>
                  <button
                    className="toggle-attendees-btn"
                    onClick={() =>
                      setVerUser((prev) => ({                   //Toggle para mostrar/ocultar la lista de inscritos en cada meeting
                        ...prev,
                        [meeting.id]: !prev[meeting.id],       // Cambia el estado para mostrar u ocultar la lista de inscritos de este meeting
                      }))
                    }
                  >
                    {verUser[meeting.id] ? "Cerrar" : "Ver lista"}
                  </button>
                  {verUser[meeting.id] && (                     // Si el estado indica que se debe mostrar la lista de inscritos para este meeting, se renderiza la sección correspondiente
                    <div>
                      {meeting.users?.length > 0 ? (
                        <ul className="attendees-list">
                          {meeting.users.map((attendee) => (
                            <li key={attendee.id}>
                              {attendee.name} ({attendee.email})
                            </li>
                          ))}
                        </ul>
                      ) : (
                        <p className="no-attendees">Nadie inscrito aún</p>
                      )}
                    </div>
                  )}
                </div>
              </div>
            ))}
          </div>
        )}

        {user.status !== 'n' && (
          <div className="meetings-box">
            <h3>Tus Comentarios</h3>

            {user.comments && user.comments.length > 0 ? (
              user.comments.map((comment) => (
                <div key={comment.id} className="meeting-item">
                  {console.log(comment)}
                  <div>
                    <strong>Comentario:</strong> {comment.comment}
                  </div>
                  <div>
                    <strong>Puntuación:</strong>{" "}
                    {"⭐".repeat(comment.score || 0)}    {/* Mostrar estrellas según la puntuación */}
                  </div>
                  <div style={{ fontSize: "12px", color: "var(--ink-2)" }}>
                    {new Date(comment.created_at).toLocaleDateString("es-ES")} {/* Mostrar fecha del comentario en formato dd/mm/aa */}
                  </div>
                </div>
              ))
            ) : (
              <p style={{ color: "var(--ink-2)", fontStyle: "italic" }}>
                No hay comentarios aún
              </p>
            )}
          </div>
        )}
      </section>
    </>
  );
}
