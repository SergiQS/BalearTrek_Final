import "./TrekDetails.css";
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { FaStar, FaRegStar, FaStarHalfAlt } from "react-icons/fa";
import Header from "./Header";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";

export default function TrekDetail() {
  const { identifier } = useParams();
  const [trek, setTrek] = useState([]);
  const navigate = useNavigate();

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
  function Stars({ rating }) {
      return (
        <span>
          {[1, 2, 3, 4, 5].map((star) => {
            if (star <= rating) return <FaStar key={star} />;
            if (star - 0.5 === rating) return <FaStarHalfAlt key={star} />;
            return <FaRegStar key={star} />;
          })}
        </span>
      );
    }

  if (!trek) return <p>Cargando...</p>;

  console.log(identifier);

  return (
    <>
      <Header></Header>
      <div className="trek-container">
        {/* TÍTULO */}
        <h2 className="trek-title">{trek.name}</h2>

        {/* RATING + GUÍA */}
        <div className="trek-info">
          <div className="rating"> 
            {trek.rating}
         
          </div>
           <Stars rating={trek.rating} />
        </div>

        <button className="availability-btn"></button>
        {/* MEETINGS */}
        <div className="meetings-box">
          <h3>MEETINGS DISPONIBLES</h3>

          {trek.meetings?.map((meeting) => (
            <div className="meeting-item">
                 <div>
                  <strong>Día:</strong> {meeting.day}
                </div>
                <div>
                  <strong>Hora:</strong> {meeting.hour}
                </div>
                <div>
                  <strong>Hora:</strong> {meeting.user.name}
                </div>
                <div>
                  <strong>Rating:</strong> {meeting.rating}
                </div>
              <Link to={`/treks/${identifier}/meeting/${meeting.id}`} key={meeting.id}>Inscribirse</Link>
            </div>
          ))}
        </div>

        {/* LUGARES DE INTERÉS */}
        <div className="places-box">
          <h3>LUGARES DE INTERÉS</h3>

          {trek.interestingPlaces?.map((place) => (
            <div key={place.identifier} className="place-item">
              <div className="place-name">{place.name}</div>
              <div className="place-gps">GPSpos: {place.gps}</div>
            </div>
          ))}
        </div>
      </div>
    </>
  );
}
