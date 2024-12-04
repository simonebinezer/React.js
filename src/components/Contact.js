// Contact.js
import React from 'react';

const Contact = () => {
    return (
        <div className="contact-container">
            <h2>Contact Us</h2>
            <p>If you have any questions, please reach out to us!</p>
            <form>
                <div>
                    <label>Name:</label>
                    <input type="text" required />
                </div>
                <div>
                    <label>Email:</label>
                    <input type="email" required />
                </div>
                <div>
                    <label>Message:</label>
                    <textarea required></textarea>
                </div>
                <button type="submit">Send</button>
            </form>
        </div>
    );
};

export default Contact;
