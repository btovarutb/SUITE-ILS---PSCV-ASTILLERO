import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.{blade.php,js,vue,jsx,ts,tsx}',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                'sans': ['Inter', 'sans-serif'],
                'inter': ['Inter', 'sans-serif'],
            },
            colors: {
                azulCotecmar: '#003366',
                grisCotecmar: '#74767D',
                grisClaro: '#e5e7eb',
                grisHover: '#c2c3c5',
            },
        },        
    },

    plugins: [forms, typography],
};
