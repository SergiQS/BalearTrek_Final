import { useState,BrowserRouter,Route,Routes } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'
import Login from './Components/Login'
import Dashboard from './Components/Dashboard'

export default function App() {

  return (
    <>
    <BrowserRouter>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/dashboard" element={<Dashboard />} />
        {/* Aquí puedes agregar más rutas, como el dashboard */}
      </Routes>
    </BrowserRouter>
      
    </>
  )
}


