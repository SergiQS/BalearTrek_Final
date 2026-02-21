import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import Header from "./Header";

export default function PlacesDetails() {
  const { identifier, id } = useParams();
  const [trek, setTrek] = useState(null);
  

  const getPlace = async () => {
    try {
      const res = await fetch(
        `http://localhost:8000/api/treks/${identifier}`,
      );
      const json = await res.json();
      setTrek(json.data);
    } catch (error) {
      console.error("Error al obtener datos:", error);
    }
  };

  useEffect(() => {
    getPlace();
  }, [identifier,id]);

  if (!trek) return <p>Cargando...</p>;

  const place = trek.interestingPlaces?.find(p => p.id === parseInt(id));

  return (
    <>
      <Header></Header>
      <div className="trek-container">
        {place ? (
          <div  className="place-item">
            <h2 className="place-name">{place.name}</h2>
            <div className="place-gps">GPS: {place.gps}</div>
            <div className="place-type">Tipo: {place.type?.name || 'No especificado'}</div>
          </div>
        ) : (
          <p>Lugar no encontrado</p>
        )}
      </div>
    </>
  );
}
