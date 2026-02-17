import { Link } from "react-router-dom";
import "./Header.css";
export default function Header() {
  return (
       <>
      <header className="landing-header">
        <h1>BALEARTREK</h1>

        <Link to="/Perfil" className="icon-btn link-button">
          Home
        </Link>

        <Link to="/LandingPage" className="icon-btn link-button">
          Perfil
        </Link>
      </header>
    </>

  );
}
