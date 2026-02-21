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

  const handleLogout = async () => {
    await logout();
    navigate ("/");
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
            <p className="profile-subtitle">Gestiona tu informacion y reservas.</p>
          </div>
          <div className="profile-actions">
            <button className="edit-btn">Editar</button>
            <button className="logout-btn" onClick={handleLogout}>Logout</button>
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
            <div  key={meeting.id} className="meeting-item">
                  <div><strong>Trek:</strong> {meeting.trek?.name}</div>
                 <div>
                  <strong>Día:</strong> {meeting.day}
                </div>
                <div>
                  <strong>Hora:</strong> {meeting.hour}
                </div>
               
            </div>
          ))}
        </div>
      </section>
    </>
  );
}
