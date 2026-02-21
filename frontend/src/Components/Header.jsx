import { Link } from "react-router-dom";
import "./Header.css";
export default function Header() {

const isLoggedIn = Boolean(localStorage.getItem("token"));

  return (
       <>
      <header className="landing-header">
        <h1>BALEARTREK</h1>

        <Link to="/LandingPage" className="icon-btn link-button">
          Home
        </Link>
        <Link to="/Contacto" className="icon-btn link-button">
          Contacto
        </Link>
        <Link to="/Perfil" className="icon-btn link-button">
          Perfil
        </Link>
        {!isLoggedIn && (
          <Link to="/Login" className="icon-btn link-button">
            Login
          </Link>
        )}
      </header>
    </>

  );
}
