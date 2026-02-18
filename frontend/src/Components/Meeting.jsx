import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

export default function Meeting() {
  //solo inscribirse en el meeting
  const { identifier,id } = useParams();
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
  }, [identifier,id]);

  if (!trek) return <p>Cargando...</p>;

 console.log(trek);
  return (
    <>
      {/* MEETINGS */}
      <div className="meetings-box">
        <h3>MEETINGS DISPONIBLES</h3>

        {trek.meetings?.map((meeting) => (
          <div key={meeting.id} className="meeting-item">
            <div>
              <strong>Día:</strong> {meeting.day}
            </div>
            <div>
              <strong>Hora:</strong> {meeting.hour}
            </div>
            <div>
              <strong>Rating:</strong> {meeting.rating}
            </div>
          </div>
        ))}
      </div>

      <button> Inscribirse </button>
    </>
  );
}
