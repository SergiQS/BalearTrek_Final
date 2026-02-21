import { useState, useEffect } from "react";
import { getUser, logout } from "../api";
import { useNavigate } from "react-router-dom";
import Header from "./Header";
import "./Perfil.css";

export default function Perfil() {
  const navigate = useNavigate();
  const [user, setUser] = useState(
    JSON.parse(localStorage.getItem("user")) || null,
  );
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [verUser, setVerUser] = useState({});

  const handleLogout = async () => {
    await logout();
    navigate("/");
  };

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
            <button className="edit-btn">Editar</button>
            <button className="logout-btn" onClick={handleLogout}>
              Logout
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
          <span className="label">Tlf:</span>
          <span>{user.phone || "No especificado"}</span>
        </div>

        <div className="info-row">
          <span className="label">Contraseña:</span>
          <span>{user.password}*******</span>
        </div>

        <div className="meetings-box">
          <h3>MEETINGS a los que estas inscrito</h3>

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
            <h3>MEETINGS DONDE ERES GUÍA</h3>

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
                      setVerUser((prev) => ({
                        ...prev,
                        [meeting.id]: !prev[meeting.id],
                      }))
                    }
                  >
                    {verUser[meeting.id] ? "Cerrar" : "Ver lista"}
                  </button>
                  {verUser[meeting.id] && (
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
            <div className="meetings-box">
              <h3>Tus Comentarios</h3>

              {user.comments && user.comments.length > 0 ? (
                user.comments.map((comment) => (
                  <div key={comment.id} className="meeting-item">
                    <div>
                      <strong>Trek:</strong>{" "}
                      {comment.trek?.name || "Trek desconocido"}
                    </div>
                    <div>
                      <strong>Comentario:</strong> {comment.comment}
                    </div>
                    <div>
                      <strong>Puntuación:</strong>{" "}
                      {"⭐".repeat(comment.score || 0)}
                    </div>
                    <div style={{ fontSize: "12px", color: "var(--ink-2)" }}>
                      {new Date(comment.created_at).toLocaleDateString("es-ES")}
                    </div>
                  </div>
                ))
              ) : (
                <p style={{ color: "var(--ink-2)", fontStyle: "italic" }}>
                  No hay comentarios aún
                </p>
              )}
            </div>
          </div>
        )}
      </section>
    </>
  );
}
