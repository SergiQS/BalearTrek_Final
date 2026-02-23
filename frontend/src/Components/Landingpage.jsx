
import "./LandingPage.css"; 

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
      <Cardtreks />
    </div>
  );
}
