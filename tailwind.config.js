import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                hijau: {
                    50:  '#f0f9f4',
                    100: '#dcf0e4',
                    200: '#bbe2cc',
                    300: '#8acbaa',
                    400: '#57ad82',
                    500: '#349163',
                    600: '#25734d',
                    700: '#1B6B3A',
                    800: '#185c33',
                    900: '#154d2b',
                },
                emas: {
                    50:  '#fdf9ee',
                    100: '#faf0d0',
                    200: '#f4df9d',
                    300: '#edc864',
                    400: '#e6b23a',
                    500: '#C9A84C',
                    600: '#b8891e',
                    700: '#99691a',
                    800: '#7d531c',
                    900: '#68451b',
                },
                krem: '#FAF7F2',
            },
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms, typography],
};