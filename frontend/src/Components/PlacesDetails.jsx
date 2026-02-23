import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import Header from "./Header";
import Mapa from "./Mapa";

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
  }, [identifier]);

  if (!trek) return <p>Cargando...</p>;

  const placeDetails = trek.interestingPlaces?.find(
    (place) => String(place.id) === String(id), //Para comprobar  que ambos sean strings para la comparación
  );

   console.log(placeDetails);
     const [lat,long] =  placeDetails.gps.split(",").map(coord => parseFloat(coord.trim())); // Convertimos el string "lat,lng" a números

  return (
    <>
      <Header></Header>
      <div className="trek-container">
        {placeDetails ? (
          <div className="place-item">
            <h2 className="place-name">{placeDetails.name}</h2>
            <div className="place-gps">GPS: {placeDetails.gps}</div>
            <Mapa lat={lat} lng={long} />
            <div className="place-type">
              Tipo: {placeDetails.placeType?.name || "No especificado"}
            </div>
          </div>
        ) : (
          <p>Lugar no encontrado</p>
        )}
      </div>
    </>
  );
}
