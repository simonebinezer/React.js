import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import '../css/Login.css';

const Login = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate(); // Use useNavigate instead of useHistory

  // const handleLogin = async (e) => {
  //   e.preventDefault();

  //   try {
  //     const response = await axios.post('http://localhost:5000/api/auth/login', {
  //       username,
  //       password,
  //     });
  //     console.log('Login successful:', response.data);
      
  //     // Store tokens or user data as needed
  //     localStorage.setItem('accessToken', response.data.accessToken); // Save access token to localStorage

  //     // Redirect to the protected route
  //     navigate('/protected'); // Use navigate to redirect to the protected route
  //   } catch (err) {
  //     setError(err.response.data.message || 'Login failed');
  //     console.error('Login error:', err);
  //   }
  // };

  const handleLogin = async (e) => {
    e.preventDefault();

    try {
        const response = await axios.post('http://localhost:5000/api/auth/login', {
            username,
            password,
        });
        console.log('Login successful:', response.data);
        
        // Store access and refresh tokens in local storage
        localStorage.setItem('accessToken', response.data.accessToken); // Save access token
        localStorage.setItem('refreshToken', response.data.refreshToken); // Save refresh token

        // Redirect to the protected route
        navigate('/protected'); // Use navigate to redirect to the protected route
    } catch (err) {
        setError(err.response.data.message || 'Login failed');
        console.error('Login error:', err);
    }
};

  return (
    <form onSubmit={handleLogin}>
      <div>
        <label>Username:</label>
        <input
          type="text"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
        />
      </div>
      <div>
        <label>Password:</label>
        <input
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
      </div>
      <button type="submit">Login</button>
      {error && <p style={{ color: 'red' }}>{error}</p>}
    </form>
  );
};

export default Login;
