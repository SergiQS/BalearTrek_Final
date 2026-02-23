import "./TrekDetails.css";
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { FaStar, FaRegStar, FaStarHalfAlt } from "react-icons/fa";
import Header from "./Header";
import { Link } from "react-router-dom";


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


   function RenderStars(rating) {
      const stars = [];
  
      const fullStars = Math.floor(rating);
      const halfStar = rating % 1 >= 0.5;
      const emptyStars = 5 - fullStars - (halfStar ? 1 : 0); // calcula el número de estrellas vacías
  
      for (let i = 0; i < fullStars; i++) {
        stars.push(<FaStar key={`full-${i}`} />);
      }
  
      if (halfStar) {
        stars.push(<FaStarHalfAlt key="half" />); 
      }
  
      for (let i = 0; i < emptyStars; i++) {
        stars.push(<FaRegStar key={`empty-${i}`} />); 
      }
  
      return stars;
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
          <span>{RenderStars(trek.rating)}</span>
        </div>

        {/* ENCUENTROS DISPONIBLES */}
        <div className="meetings-box">
          <h3>ENCUENTROS DISPONIBLES</h3>

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

          {trek.meetings?.flatMap((meeting) => meeting.comments)    //Revisar
            .length ? (
            trek.meetings
              ?.flatMap((meeting) => meeting.comments)
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
