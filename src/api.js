// import axios from 'axios';

// export const getProtectedData = async (accessToken) => {
//     const response = await axios.get('http://localhost:5000/api/auth/protected', {
//         headers: {
//             Authorization: `Bearer ${accessToken}`, // Set the Authorization header
//         },
//     });
//     return response.data; // Return the response data
// };

// export const refreshAccessToken = async (refreshToken) => {
//     return await axios.post('http://localhost:5000/api/auth/refresh', {
//         token: refreshToken,
//     }).then(response => response.data.accessToken);
// };

import axios from 'axios';

export const getProtectedData = async (accessToken) => {
    const response = await axios.get('http://localhost:5000/api/auth/protected', {
        headers: {
            Authorization: `Bearer ${accessToken}`, // Set the Authorization header
        },
    });
    return response.data; // Return the response data
};

export const refreshAccessToken = async (refreshToken) => {
    const response = await axios.post('http://localhost:5000/api/auth/refresh-token', {
        token: refreshToken,
    });
    return response.data.accessToken; // Return the new access token
};
