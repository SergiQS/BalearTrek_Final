import { useState, useEffect } from "react";

export default function Perfil() {
  const [user, setUser] = useState([]);

  const getUser = async () => {
    try {
      const res = await fetch("http://localhost:8000/api/user");
      const json = await res.json();
      console.log("Respuesta del backend:", json);

      setUser(json.data);
    } catch (error) {
      console.error("Error al obtener datos:", error);
    }
  };
  useEffect(() => {
    getUser();
  }, []);
  console.log(user);

  return (
    <>
      {/* USER INFO */}
      {user.map((u) => (
        <section className="user-info">
          <div className="info-row">
            <span className="label">Nombre:</span>
            <span>{user.name}</span>
          </div>

          <div className="info-row">
            <span className="label">Apellido:</span>
            <span>{user.lastname}</span>
          </div>

          <div className="info-row">
            <span className="label">Tlf:</span>
            <span>{user.phone}</span>
          </div>

          <div className="info-row">
            <span className="label">Contraseña:</span>
            <span>********</span>
          </div>

          <button className="edit-btn">Editar</button>
        </section>
      ))}
    </>
  );
}
