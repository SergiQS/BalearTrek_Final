import { useState, useEffect } from "react";
import { getUser, logout } from "../api";
import { useNavigate } from "react-router-dom";


export default function Perfil() {
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
        setUser(res.data);
        localStorage.setItem("user", JSON.stringify(res.data));
        setError(null);
      } catch (err) {
        console.error("Error fetching user:", err);
        setError("No se pudo cargar el perfil");
      } finally {
        setLoading(false);
      }
    };

    fetchUser();
  }, []);

  if (loading) return <div>Cargando perfil...</div>;
  if (error) return <div className="error">{error}</div>;
  if (!user) return <div>No hay usuario autenticado</div>;
  console.log(user);
  return (
    <>
      <button onClick={handleLogout}>Logout</button>
      {/* USER INFO */}
      <section className="user-info">
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
          <span>********</span>
        </div>

        <button className="edit-btn">Editar</button>

         <div className="meetings-box">
          <h3>MEETINGS a los que estas inscrito</h3>

          {user.meetings?.map((meeting) => (
            <div  key={meeting.id} className="meeting-item">
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
