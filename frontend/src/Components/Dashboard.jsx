import { useEffect, useState } from "react";
import {  getUser } from "../api"; 

export default function Dashboard() {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        setLoading(true);
        getUser()
            .then((data) => setUser(data))
            .catch(() => {
                
                alert("No estás autenticado. Redirigiendo al login...");
                window.location.href = "/login";
            })
            .finally(() => setLoading(false));
    }, []);

    if (loading) {
        return <p>Cargando...</p>;
    }

    return (
        <div style={{ padding: "20px" }}>
            <h1>Bienvenido, {user.name}</h1>
            <p>Este es tu dashboard.</p>
        </div>
    );
}