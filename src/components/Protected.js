import React, { useEffect, useState } from 'react';
import { getProtectedData } from '../api';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import '../css/Protected.css';
import NavBar from '../components/Navbar';

const Protected = () => {
    const navigate = useNavigate();
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            let accessToken = localStorage.getItem('accessToken');

            try {
                const result = await getProtectedData(accessToken);
                setData(result);
            } catch (error) {
                console.error('Error fetching protected data:', error);
                if (error.response && error.response.status === 403) {
                    try {
                        const refreshToken = localStorage.getItem('refreshToken');
                        if (refreshToken) {
                            const refreshResponse = await axios.post('http://localhost:5000/api/auth/refresh-token', {
                                token: refreshToken,
                            });
                            const newAccessToken = refreshResponse.data.accessToken;
                            localStorage.setItem('accessToken', newAccessToken);
                            const retryResult = await getProtectedData(newAccessToken);
                            setData(retryResult);
                        } else {
                            navigate('/login');
                        }
                    } catch (refreshError) {
                        console.error('Failed to refresh token:', refreshError);
                        navigate('/login');
                    }
                }
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [navigate]);

    if (loading) return <p className="loading">Loading...</p>;

    return (
        <div className="protected-container">
            <NavBar /> 
            <h2>Protected Data</h2>
            <div className="data-card">
                <p>{data.message}</p>
                <p>User: {data.user.username}</p>
            </div>
        </div>
    );
};

export default Protected;
