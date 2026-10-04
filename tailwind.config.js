import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                surface: {
                    base: 'var(--surface-base, #0F1115)',
                    card: 'var(--surface-card, #1A1D24)',
                    hover: 'var(--surface-hover, #232731)',
                    border: 'var(--surface-border, #2A2E39)',
                },
                content: {
                    primary: 'var(--content-primary, #E6E8EC)',
                    secondary: 'var(--content-secondary, #9BA1B0)',
                    muted: 'var(--content-muted, #626978)',
                },
                tactical: {
                    olive: '#4D5E43',
                    steel: '#38BDF8',
                    amber: '#F59E0B',
                    danger: '#EF4444',
                    success: '#10B981',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', 'Fira Code', ...defaultTheme.fontFamily.mono],
            },
        },
    },
    plugins: [forms, typography],
};