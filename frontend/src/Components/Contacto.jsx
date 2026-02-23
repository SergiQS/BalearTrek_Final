import React from 'react';
import { useForm, ValidationError } from '@formspree/react';
import './Contacto.css';
import Header from './Header';

export default function ContactForm() {
  const [state, handleSubmit] = useForm("mreaoaqp");
  
  if (state.succeeded) {
    return (
      <div className="contact-container">
        <p className="success-message">Thanks for joining!</p>
      </div>
    );
  }
  
  return (
    <>
    <Header></Header>
    <div className="contact-container">
      <div className="contact-header">
        <h1 className="contact-title">Contacto</h1>
        <p className="contact-subtitle">Envíanos tu mensaje</p>
      </div>
      
      <div className="contact-form-wrapper">
        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label htmlFor="name" className="form-label">
              Nombre
            </label>
            <input
              id="name"
              type="text" 
              name="name"
              className="form-input"
            />
            <ValidationError 
              prefix="Name" 
              field="name"
              errors={state.errors} //Gestiona los errores de validación para el campo "name"
            />
          </div>

          <div className="form-group">
            <label htmlFor="email" className="form-label">
              Email Address
            </label>
            <input
              id="email"
              type="email" 
              name="email"
              className="form-input"
            />
            <ValidationError 
              prefix="Email" 
              field="email"
              errors={state.errors} //Gestiona los errores de validación para el campo "email"  
            />
          </div>

          <div className="form-group">
            <label htmlFor="subject" className="form-label">
              Asunto
            </label>
            <input
              id="subject"
              type="text" 
              name="subject"
              className="form-input"
            />
            <ValidationError 
              prefix="Subject" 
              field="subject"
              errors={state.errors} //Gestiona los errores de validación para el campo "subject"
            />
          </div>
          
          <div className="form-group">
            <label htmlFor="message" className="form-label">
              Message
            </label>
            <textarea
              id="message"
              name="message"
              className="form-textarea"
            />
            <ValidationError 
              prefix="Message" 
              field="message"
              errors={state.errors} //Gestiona los errores de validación para el campo "message"    
            />
          </div>
          
          <div className="form-actions">
            <button type="submit" disabled={state.submitting} className="submit-btn">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
    </>
  );
}