import "./TrekDetails.css";
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import LandingPage from "../Components/Landingpage";
import Header from "./Header";
import { Link } from "react-router-dom";

export default function TrekDetail() {
  const { identifier } = useParams();
  const [trek, setTrek] = useState([]);
  console.log(identifier);

  const getTrek = async () => {
    try {
      const res = await fetch(`http://localhost:8000/api/treks/${identifier}`);
      const json = await res.json();
      setTrek(json.data);
    } catch (error) {
      console.error("Error al obtener datos:", error);
    }
  };

   useEffect(() => {
      getTrek();
    }, [identifier]);

  if (!trek) return <p>Cargando...</p>;

  console.log(trek);

  return (
    <>
      <Header></Header>
      <div className="trek-container">
        {/* TÍTULO */}
        <h2 className="trek-title">{trek.name}</h2>

        {/* RATING + GUÍA */}
        <div className="trek-info">
          <div className="rating">⭐ {trek.rating}</div>
          <div className="guide">Guía: </div>
        </div>

        {/* BOTÓN */}
        <button className="availability-btn">VER DISPONIBILIDAD</button>
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

        {/* LUGARES DE INTERÉS */}
        {/* <div className="places-box">
        <h3>LUGARES DE INTERÉS</h3>

        {trek.places.map((place) => (
          <div key={place.id} className="place-item">
            <div className="place-name">{place.name}</div>
            <div className="place-type">{place.type}</div>
            <div className="place-gps">GPSpos: {place.gps}</div>
          </div>
        ))}
      </div> */}
      </div>
    </>
  );
}
