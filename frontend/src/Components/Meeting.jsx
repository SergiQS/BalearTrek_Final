import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import Header from "./Header";
export default function Meeting() {
  //solo inscribirse en el meeting
  const { identifier, id } = useParams();
  const [trek, setTrek] = useState([]);

  const getMeeting = async () => {
    try {
      const res = await fetch(
        `http://localhost:8000/api/treks/${identifier}/meeting/${id}`,
      );
      const json = await res.json();
      setTrek(json.data);
    } catch (error) {
      console.error("Error al obtener datos:", error);
    }
  };

  useEffect(() => {
    getMeeting();
  }, [identifier, id]);

  if (!trek) return <p>Cargando...</p>;
  //Para pasar el formato de la fecha a dd/mm/yy
  const formatDate = (iso) => {
    return new Date(iso).toLocaleDateString("es-ES");
  };
  console.log(trek);
  return (
    <>
    <Header></Header>
      {/* MEETINGS */}
      <div className="meetings-box">
        <h3>MEETING de {trek.trek?.name}</h3>

        {trek.meeting && (
          <div className="meeting-item">
            <div>
              <strong>Día:</strong> {formatDate(trek.meeting.dateIni)}
            </div>
            <div>
              <div>
                <strong>Día:</strong>
                {formatDate(trek.meeting.dateEnd)}
              </div>
              <strong>Hora:</strong> {trek.meeting.hour}
            </div>
            <div>
              <strong>Rating:</strong> {trek.meeting.rating}
            </div>
          </div>
        )}
      </div>

      <button onClick={() => alert("Te has inscrito en meeting")}>
        {" "}
        Inscribirse{" "}
      </button>
    </>
  );
}
