import React, { useState, useEffect } from "react";
import "./LandingPage.css"; // estilos opcionales

export default function Cardtreks() {
    const [treks, setTreks] = useState([]);
     // Datos mock (sin backend)
        const mockTreks = [
            { id: 1, name: "Serra", rating: 4.5, img: "https://via.placeholder.com/150" },
            { id: 2, name: "Torrent de Pareis", rating: 4.8, img: "https://via.placeholder.com/150" },
            { id: 3, name: "Camí de Cavalls", rating: 4.6, img: "https://via.placeholder.com/150" },
            { id: 4, name: "Sa Dragonera", rating: 4.4, img: "https://via.placeholder.com/150" },
            { id: 5, name: "Es Vedrà", rating: 4.7, img: "https://via.placeholder.com/150" },
            { id: 6, name: "Puig Major", rating: 4.9, img: "https://via.placeholder.com/150" }
        ];
    
        useEffect(() => {
            setTreks(mockTreks);
        }, []);
    return (
        <div className="treks-grid">
            {mockTreks.map(trek => (
                <div key={trek.id} className="trek-card">
                    <img src={trek.img} alt={trek.name} />
                    <h3>{trek.name}</h3>
                    <p>{trek.rating} ★</p> 
                </div>
            ))}
        </div>
    );
}       