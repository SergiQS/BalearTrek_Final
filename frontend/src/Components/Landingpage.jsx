import React, { useState, useEffect } from "react";
import "./LandingPage.css"; // estilos opcionales
import { Link } from "react-router-dom"; // para navegación´
import Cardtreks from "./Cardtreks";

export default function LandingPage() {
    const [isla, setIsla] = useState("");
    const [zona, setZona] = useState("");

    return (
        <div className="landing-container">

            {/* HEADER */}
            <header className="landing-header">
                <h1>BALEARTREK</h1>
            </header>

            {/* FILTROS */}
            <div className="filters">
                <select value={isla} onChange={(e) => setIsla(e.target.value)}>
                    <option value="">Isla</option>
                    <option value="mallorca">Mallorca</option>
                    <option value="menorca">Menorca</option>
                    <option value="ibiza">Ibiza</option>
                    <option value="formentera">Formentera</option>
                </select>

                <select value={zona} onChange={(e) => setZona(e.target.value)}>
                    <option value="">Zona</option>
                    <option value="norte">Norte</option>
                    <option value="sur">Sur</option>
                    <option value="este">Este</option>
                    <option value="oeste">Oeste</option>
                </select>
            </div>

            {/* GRID DE TREKS */}
            <div className="treks-grid">
                <Cardtreks />
            </div>
        </div>
    );
}