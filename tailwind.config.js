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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'body-md': ['Inter', 'sans-serif'],
                'body-lg': ['Inter', 'sans-serif'],
                'headline-lg': ['Inter', 'sans-serif'],
                'headline-md': ['Inter', 'sans-serif'],
                'display-lg': ['Inter', 'sans-serif'],
                'label-md': ['Inter', 'sans-serif'],
                'label-sm': ['Inter', 'sans-serif'],
                'title-lg': ['Inter', 'sans-serif'],
            },

            colors: {
                // Primary Colors
                'primary': '#00522c',
                'primary-container': '#006d3c',
                'on-primary': '#ffffff',
                'on-primary-container': '#92ecae',
                'primary-fixed': '#9bf6b7',
                'primary-fixed-dim': '#80d99d',
                'on-primary-fixed': '#00210e',
                'on-primary-fixed-variant': '#00522c',

                // Secondary Colors
                'secondary': '#0058bc',
                'secondary-container': '#0070eb',
                'on-secondary': '#ffffff',
                'on-secondary-container': '#fefcff',
                'secondary-fixed': '#d8e2ff',
                'secondary-fixed-dim': '#adc6ff',
                'on-secondary-fixed': '#001a41',
                'on-secondary-fixed-variant': '#004493',

                // Tertiary Colors
                'tertiary': '#735c00',
                'tertiary-container': '#cca72f',
                'on-tertiary': '#ffffff',
                'on-tertiary-container': '#4e3d00',
                'tertiary-fixed': '#ffe088',
                'tertiary-fixed-dim': '#e9c349',
                'on-tertiary-fixed': '#241a00',
                'on-tertiary-fixed-variant': '#574500',

                // Surface Colors
                'surface': '#f8f9fa',
                'surface-dim': '#d9dadb',
                'surface-bright': '#f8f9fa',
                'surface-container-lowest': '#ffffff',
                'surface-container-low': '#f3f4f5',
                'surface-container': '#edeeef',
                'surface-container-high': '#e7e8e9',
                'surface-container-highest': '#e1e3e4',
                'on-surface': '#191c1d',
                'on-surface-variant': '#3f4941',
                'surface-variant': '#e1e3e4',

                // Background
                'background': '#f8f9fa',
                'on-background': '#191c1d',

                // Error
                'error': '#ba1a1a',
                'error-container': '#ffdad6',
                'on-error': '#ffffff',
                'on-error-container': '#93000a',

                // Outline
                'outline': '#6f7a70',
                'outline-variant': '#bec9be',

                // Inverse
                'inverse-surface': '#2e3132',
                'inverse-on-surface': '#f0f1f2',
                'inverse-primary': '#80d99d',
                'surface-tint': '#006d3c',
            },

            spacing: {
                'margin-mobile': '16px',
                'margin-desktop': '80px',
                'gutter': '24px',
                'xs': '4px',
                'sm': '12px',
                'md': '24px',
                'lg': '40px',
                'xl': '64px',
            },

            fontSize: {
                // Display
                'display-lg': ['48px', { lineHeight: '56px', letterSpacing: '-0.02em', fontWeight: '700' }],
                
                // Headline
                'headline-lg': ['32px', { lineHeight: '40px', letterSpacing: '-0.01em', fontWeight: '600' }],
                'headline-md': ['24px', { lineHeight: '32px', fontWeight: '600' }],
                'headline-lg-mobile': ['24px', { lineHeight: '32px', fontWeight: '600' }],
                
                // Title
                'title-lg': ['20px', { lineHeight: '28px', fontWeight: '500' }],
                
                // Body
                'body-lg': ['18px', { lineHeight: '28px', fontWeight: '400' }],
                'body-md': ['16px', { lineHeight: '24px', fontWeight: '400' }],
                
                // Label
                'label-md': ['14px', { lineHeight: '20px', letterSpacing: '0.01em', fontWeight: '600' }],
                'label-sm': ['12px', { lineHeight: '16px', fontWeight: '500' }],
            },

            borderRadius: {
                'DEFAULT': '0.25rem',
                'lg': '0.5rem',
                'xl': '0.75rem',
                'full': '9999px',
            },

            boxShadow: {
                'soft': '0px 4px 20px rgba(0, 0, 0, 0.04)',
                'soft-hover': '0px 8px 30px rgba(0, 0, 0, 0.08)',
            },

            screens: {
                'xs': '475px',
            },
        },
    },

    plugins: [
        forms,
        // Plugin untuk line-clamp jika dibutuhkan
        function({ addUtilities }) {
            addUtilities({
                '.line-clamp-2': {
                    display: '-webkit-box',
                    '-webkit-line-clamp': '2',
                    '-webkit-box-orient': 'vertical',
                    overflow: 'hidden',
                },
                '.line-clamp-3': {
                    display: '-webkit-box',
                    '-webkit-line-clamp': '3',
                    '-webkit-box-orient': 'vertical',
                    overflow: 'hidden',
                },
            });
        }
    ],
};