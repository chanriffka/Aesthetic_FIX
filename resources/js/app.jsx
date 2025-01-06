import './bootstrap';
// resources/js/app.js

import React from 'react';
import ReactDOM from 'react-dom/client';
import '../css/app.css'; // Import Tailwind CSS

function App() {
    return (
        <div className="container mx-auto p-4">
            <h1 className="text-3xl font-bold text-blue-600">Hello from React and Tailwind!</h1>
            <p className="mt-2 text-gray-600">This is a React component styled with Tailwind CSS.</p>
        </div>
    );
}

ReactDOM.createRoot(document.getElementById('app')).render(<App />);

