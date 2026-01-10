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
                // Brutalist Mono Identity - JetBrains Mono as primary
                sans: ['JetBrains Mono', 'Fira Code', ...defaultTheme.fontFamily.mono],
                mono: ['JetBrains Mono', 'Fira Code', ...defaultTheme.fontFamily.mono],
            },
            boxShadow: {
                // Brutalist Shadows
                'brutal': '4px 4px 0px 0px rgba(0,0,0,1)',
                'brutal-sm': '2px 2px 0px 0px rgba(0,0,0,1)',
                'brutal-lg': '6px 6px 0px 0px rgba(0,0,0,1)',
                'brutal-xl': '8px 8px 0px 0px rgba(0,0,0,1)',
            },
            colors: {
                // Neo-Brutalist Accent Palette
                'brutal': {
                    yellow: '#FDE047',
                    blue: '#60A5FA',
                    pink: '#F472B6',
                    green: '#4ADE80',
                    orange: '#FB923C',
                    purple: '#A78BFA',
                },
            },
            typography: ({ theme }) => ({
                brutal: {
                    css: {
                        '--tw-prose-body': theme('colors.black'),
                        '--tw-prose-headings': theme('colors.black'),
                        fontFamily: '"JetBrains Mono", monospace',
                        maxWidth: 'none',
                        // Headings
                        h1: { fontWeight: '700' },
                        h2: { fontWeight: '700', borderBottom: '2px solid black', paddingBottom: '0.5rem' },
                        h3: { fontWeight: '600' },
                        // Remove rounded corners
                        img: { borderRadius: '0', border: '2px solid black' },
                        pre: {
                            borderRadius: '0',
                            border: '2px solid black',
                            backgroundColor: theme('colors.gray.900'),
                        },
                        // Blockquote as console.log style
                        blockquote: {
                            fontStyle: 'normal',
                            borderLeftWidth: '4px',
                            borderLeftColor: theme('colors.black'),
                            backgroundColor: theme('colors.gray.100'),
                            padding: '1rem',
                            quotes: 'none',
                            borderRadius: '0',
                        },
                        'blockquote p': {
                            fontFamily: '"JetBrains Mono", monospace',
                        },
                        'blockquote p::before': { content: '"// "' },
                        'blockquote p::after': { content: 'none' },
                        // Inline code
                        code: {
                            backgroundColor: theme('colors.gray.900'),
                            color: theme('colors.gray.100'),
                            padding: '0.25rem 0.5rem',
                            borderRadius: '0',
                            fontWeight: '400',
                        },
                        'code::before': { content: 'none' },
                        'code::after': { content: 'none' },
                        // Links
                        a: {
                            color: theme('colors.black'),
                            textDecoration: 'underline',
                            textUnderlineOffset: '4px',
                            textDecorationThickness: '2px',
                            fontWeight: '500',
                        },
                        'a:hover': {
                            backgroundColor: theme('colors.yellow.300'),
                        },
                        // Lists
                        'ul > li::marker': { color: theme('colors.black') },
                        'ol > li::marker': { color: theme('colors.black'), fontWeight: '700' },
                    },
                },
            }),
        },
    },

    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
};
