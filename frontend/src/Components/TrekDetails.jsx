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
  
  console.log(trek);

  return (
    <>
      <Header></Header>
      <div className="trek-container">
        {/* TÍTULO */}
        <h2 className="trek-title">{trek.name}</h2>

        {/* RATING  */}
        <div className="trek-info">
          <div className="rating">{trek.rating}</div>
          <Stars rating={trek.rating} />
        </div>

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
                <strong>Guia:</strong> {meeting.user.name}
              </div>
              <div>
                <strong>Rating:</strong> {meeting.rating}
              </div>
              <Link
                to={`/treks/${identifier}/meeting/${meeting.id}`}
                key={meeting.id}
              >
                Inscribirse
              </Link>
            </div>
          ))}
        </div>

        {/* LUGARES DE INTERÉS */}
        <div className="places-box">
          <h3>LUGARES DE INTERÉS</h3>

          {trek.interestingPlaces?.map((place) => (
            <div key={place.id} className="place-item">
              <div className="place-name">{place.name}</div>
              <div className="place-gps">GPSpos: {place.gps}</div>
              <Link
                to={`/treks/${identifier}/places/${place.id}`}
                className="place-link"
              >
                Ver detalles
              </Link>
            </div>
          ))}
        </div>
        {/* Comentarios */}
        <div className="comments-box">
          <h3>COMENTARIOS</h3>

          {trek.meetings?.flatMap((meeting) => meeting.comments || [])
            .length ? (
            trek.meetings
              ?.flatMap((meeting) => meeting.comments || [])
              .sort((a, b) => b.score - a.score)
              .map((comment) => (
                <div key={comment.id} className="comment-item">
                  <div className="comment-user">
                    {comment.user?.name || "Usuario"}
                  </div>
                  <div className="comment-text">{comment.comment}</div>
                  <div className="comment-rating">Rating: {comment.score}</div>
                </div>
              ))
          ) : (
            <p className="comment-empty">Todavia no hay comentarios.</p>
          )}
        </div>
      </div>
    </>
  );
}
