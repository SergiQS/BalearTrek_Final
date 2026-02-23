import React, { useState, useEffect } from "react";
import "./LandingPage.css"; // estilos opcionales
import { FaStar, FaRegStar, FaStarHalfAlt } from "react-icons/fa";
import { Link } from "react-router-dom";

export default function Cardtreks() {
  const [treks, setTreks] = useState([]);
  const [isla, setIsla] = useState("");
  const [zona, setZona] = useState("");

  const getTreks = async () => {
    try {
      const res = await fetch("http://localhost:8000/api/treks");
      const json = await res.json();
      setTreks(json.data);
    } catch (error) {
      console.error("Error al obtener datos:", error);
    }
  };

  useEffect(() => {
    getTreks();
  }, []);

  const filteredTreks = treks.filter((trek) => {
    const islandName = trek.municipality?.island?.name?.toLowerCase(); // Obtener el nombre de la isla en minúsculas
    const matchIsland = isla ? islandName === isla.toLowerCase() : true; // Comparar con el filtro de isla (si se seleccionó)
    // const matchZona = zona
    //   ? trek.zone?.some((z) => z.name.toLowerCase() === zona.toLowerCase()) // Comparar con el filtro de zona (si se seleccionó)
    //   : true;

    return matchIsland; //&& matchZona;
  });

  const filteredSortedTreks = [...filteredTreks].sort(
    (a, b) => b.rating - a.rating,
  );

  function Stars({ rating }) {
    //Cambiar a una mas sencilla
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

  return (
    <>
      <div className="filters">
        <select value={isla} onChange={(e) => setIsla(e.target.value)}>
          <option value="">Isla</option>
          <option value="mallorca">Mallorca</option>
          <option value="menorca">Menorca</option>
          <option value="ibiza">Ibiza</option>
          <option value="formentera">Formentera</option>
        </select>
      </div>

      {/* <select value={zona} onChange={(e) => setZona(e.target.value)}>
          <option value="">Zona</option>
          <option value="norte">Norte</option>
          <option value="sur">Sur</option>
          <option value="este">Este</option>
          <option value="oeste">Oeste</option>
        </select>
      </div> */}

      <div className="treks-grid">
        {filteredSortedTreks.map((trek) => (
          <Link
            key={trek.identifier}
            to={`/treks/${trek.identifier}`}
            className="trek-card"
          >
            <h3>{trek.name}</h3>
            <p>{trek.rating}</p>
            <Stars rating={trek.rating} />
          </Link>
        ))}
      </div>
    </>
  );
}
