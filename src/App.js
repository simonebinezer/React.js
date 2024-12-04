// import React from 'react';
// import Login from './components/Login';
// import ProtectedComponent from './components/Protected';

// function App() {
//   return (
//     <div className="App">
//       <Login /> 
//       <ProtectedComponent />
//     </div>
//   );
// }

// export default App;

import React from 'react';
import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom';
import Login from './components/Login';
import Protected from './components/Protected';
import Contact from './components/Contact';

const App = () => {
  return (
    <Router>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/protected" element={<Protected />} />
        <Route path="*" element={<Navigate to="/login" />} />
        <Route path="/contact" element={<Contact />} />
      </Routes>
    </Router>
  );
};

export default App;
