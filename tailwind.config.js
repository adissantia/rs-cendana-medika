import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                sidebar: {
                    DEFAULT: '#0f172a',
                    hover: '#1e293b',
                    active: '#2563eb',
                    border: '#1e293b',
                    text: '#94a3b8',
                    'text-active': '#ffffff',
                },
                brand: {
                    blue: '#2563eb',
                    'blue-light': '#3b82f6',
                    'blue-dark': '#1d4ed8',
                },
            },
        },
    },

    plugins: [forms],
};