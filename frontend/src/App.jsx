import { useState } from 'react'
import { BrowserRouter,Route,Routes } from 'react-router-dom'
import './App.css'
import Login from './Components/Login'
import Dashboard from './Components/Dashboard'
import LandingPage from './Components/Landingpage'
import Treks from './Components/Treks'
export default function App() {

  return (
    <>
    <BrowserRouter>
      <Routes>
        
        <Route path="/" element={<Login/>} />
        <Route path="/treks" element={<Treks />} />
        {/* <Route path="/Landingpage" element={<LandingPage />} /> */}
          <Route path="/dashboard" element={<Dashboard />} />
        {/* Aquí puedes agregar más rutas, como el dashboard */}
      </Routes>
    </BrowserRouter>
      
    </>
  )
}


