import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
                navy: {
                    main: '#0F1729',
                    surface: '#1A2540',
                    card: '#1A2540',
                    border: 'rgba(255, 255, 255, 0.08)',
                    'border-hover': 'rgba(232, 115, 74, 0.3)',
                },
                coral: {
                    DEFAULT: '#E8734A',
                    hover: '#F2A671',
                    soft: 'rgba(232, 115, 74, 0.12)',
                },
                ink: {
                    primary: '#F5F3EE',
                    secondary: '#9BA3B8',
                    muted: '#64748B',
                },
            },
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                card: '8px',
            },
            keyframes: {
                'fade-up-card-1': {
                    '0%': { opacity: '0', transform: 'translateY(24px) rotate(0deg)' },
                    '100%': { opacity: '1', transform: 'translateY(0) rotate(-3deg)' },
                },
                'fade-up-card-2': {
                    '0%': { opacity: '0', transform: 'translateY(24px) rotate(0deg)' },
                    '100%': { opacity: '1', transform: 'translateY(0) rotate(2deg)' },
                },
                'fade-up-card-3': {
                    '0%': { opacity: '0', transform: 'translateY(24px) rotate(0deg)' },
                    '100%': { opacity: '1', transform: 'translateY(0) rotate(0deg)' },
                },
            },
            animation: {
                'card-stack-1': 'fade-up-card-1 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both',
                'card-stack-2': 'fade-up-card-2 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both',
                'card-stack-3': 'fade-up-card-3 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.4s both',
            },
        },
    },

    plugins: [forms],
};
