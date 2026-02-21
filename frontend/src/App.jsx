import { useState } from "react";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import "./App.css";
import Login from "./Components/Login";
import Dashboard from "./Components/Dashboard";
import LandingPage from "./Components/Landingpage";
import TrekDetails from "./Components/TrekDetails";
import Perfil from "./Components/Perfil";
import Meeting from "./Components/Meeting";
import ProtectedRoute from "./Components/ProtectedRoute";
import PlacesDetails from "./Components/PlacesDetails";
import Register from "./Components/Register";

export default function App() {
  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<LandingPage />} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/TrekDetails" element={<TrekDetails />} />
          <Route path="/Landingpage" element={<LandingPage />} />
          <Route
            path="/Perfil"
            element={
              <ProtectedRoute>
                <Perfil />
              </ProtectedRoute>
            }
          />
          
          <Route path="/treks/:identifier" element={<TrekDetails />} />
          <Route path="/treks/:identifier/meeting/:id" element={<Meeting />} />
          <Route path="/treks/:identifier/places/:id" element={<PlacesDetails />} />

          {/* <Route path="/dashboard" element={<Dashboard />} /> */}
          {/* Aquí puedes agregar más rutas, como el dashboard */}
        </Routes>
      </BrowserRouter>
    </>
  );
}
