import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                // Structural "storm slate" — operational/dark surfaces
                ink: {
                    900: '#0B1220',
                    800: '#131C2E',
                    700: '#1C2840',
                    600: '#2A3A57',
                    500: '#3D5277',
                },
                // Light surfaces — public + citizen side
                paper:   '#F7F8FB',
                surface: '#FFFFFF',
                line:    '#E4E8F0',

                // Brand "Bay" teal — Bay of Bengal, trust, calm
                bay: {
                    50:  '#E6F6F7',
                    100: '#CCF0F1',
                    400: '#2BB7C2',
                    500: '#109AA6',
                    600: '#0E7C86',
                    700: '#0B626B',
                },

                // SEVERITY SCALE — the one place color is loud
                sev: {
                    low:      '#2E9E6B',
                    medium:   '#E0A100',
                    high:     '#E5611F',
                    critical: '#D62839',
                },

                // STATUS — report lifecycle, quieter
                status: {
                    pending:  '#B7791F',
                    verified: '#157F6B',
                    rejected: '#B03A4A',
                },
            },

            fontFamily: {
                display: ['Archivo', ...defaultTheme.fontFamily.sans],
                sans:    ['Inter', ...defaultTheme.fontFamily.sans],
                bangla:  ['"Hind Siliguri"', ...defaultTheme.fontFamily.sans],
                data:    ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },

            borderRadius: {
                sm:    '4px',
                DEFAULT: '8px',
                md:    '8px',
                lg:    '12px',
                xl:    '16px',
                '2xl': '20px',
            },

            boxShadow: {
                card:  '0 1px 2px rgba(13,22,38,.04), 0 4px 12px rgba(13,22,38,.06)',
                lift:  '0 8px 28px rgba(13,22,38,.12)',
                focus: '0 0 0 3px rgba(16,154,166,.35)',
            },

            animation: {
                'pulse-ring': 'pulse-ring 2s cubic-bezier(.4,0,.6,1) infinite',
                'fade-in':    'fade-in 250ms ease forwards',
                'slide-in':   'slide-in 250ms cubic-bezier(.2,.7,.2,1) forwards',
            },

            keyframes: {
                'pulse-ring': {
                    '0%, 100%': { opacity: '1' },
                    '50%':      { opacity: '.4' },
                },
                'fade-in': {
                    from: { opacity: '0', transform: 'translateY(4px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
                'slide-in': {
                    from: { opacity: '0', transform: 'translateX(16px)' },
                    to:   { opacity: '1', transform: 'translateX(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
