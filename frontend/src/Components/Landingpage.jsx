import React, { useState, useEffect } from "react";
import "./LandingPage.css"; // estilos opcionales
import { Link } from "react-router-dom"; // para navegación´
import Cardtreks from "./Cardtreks";
import Header from "./Header";

export default function LandingPage() {

  return (


    <div className="landing-container">
        <Header/>
      <div className="hero-container">
        <img
          src="/assets/north-coast-mallorca.jpg"
          alt="ImagenMallorca"
          className="hero-image"
        />
      </div>

      {/* GRID DE TREKS */}
      <div className="treks-grid">
        <Cardtreks />
      </div>
    </div>
  );
}
