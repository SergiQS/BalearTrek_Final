import { useState } from "react";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import "./App.css";
import Login from "./Components/Login";
import Dashboard from "./Components/Dashboard";
import LandingPage from "./Components/Landingpage";
import TrekDetails from "./Components/TrekDetails";
import Perfil from "./Components/Perfil";
import Meeting from "./Components/Meeting";
export default function App() {
  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Login />} />
          <Route path="/TrekDetails" element={<TrekDetails/>} />
          <Route path="/Landingpage" element={<LandingPage />} />
          <Route path="/Perfil" element={<Perfil />} />
          <Route path="/treks/:identifier" element={<TrekDetails />} />
          <Route path="/treks/:identifier/meeting/:id" element={<Meeting />} />
          
          {/* <Route path="/dashboard" element={<Dashboard />} /> */}
          {/* Aquí puedes agregar más rutas, como el dashboard */}
        </Routes>
      </BrowserRouter>
    </>
  );
}
