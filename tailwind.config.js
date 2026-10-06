/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
        './app/Filament/**/*.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                ink: {
                    950: '#080A0E',
                },
                canvas: '#0B0D11',
                surface: {
                    DEFAULT: '#13171F',
                    raised: '#1A2030',
                    hover: '#202738',
                },
                border: {
                    DEFAULT: '#232938',
                    strong: '#323B50',
                },
                'text-primary': '#F1F3F7',
                'text-secondary': '#AEB6C6',
                'text-muted': '#7A8599',
                copper: {
                    300: '#E6B38D',
                    400: '#DB9C6F',
                    500: '#D08A5B',
                    600: '#B06E43',
                    900: '#35241A',
                },
                teal: {
                    300: '#8AD4CB',
                    400: '#6BC4BA',
                    500: '#4FB3A9',
                    600: '#3A948C',
                    700: '#2C7770',
                    900: '#12302E',
                },
                dusk: {
                    400: '#7C9BC2',
                    500: '#5F82AD',
                },
                moss: '#6BBF8E',
                brass: '#E0B04A',
                brick: '#E26D5F',
            },
            fontFamily: {
                serif: ['"Source Serif 4"', 'Georgia', 'serif'],
                sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'monospace'],
            },
            boxShadow: {
                'card-glow': '0 -1px 0 0 rgba(107, 196, 186, 0.15), 0 8px 32px 0 rgba(8, 10, 14, 0.65)',
                'copper-glow': '0 0 24px -4px rgba(208, 138, 91, 0.25)',
                'teal-glow': '0 0 28px -4px rgba(79, 179, 169, 0.25)',
            },
            backgroundImage: {
                'dawn-gradient': 'radial-gradient(ellipse at 15% 0%, rgba(79, 179, 169, 0.08) 0%, transparent 60%), radial-gradient(ellipse at 85% 100%, rgba(208, 138, 91, 0.06) 0%, transparent 65%)',
                'dawn-line': 'linear-gradient(90deg, transparent 0%, #D08A5B 35%, #6BC4BA 65%, transparent 100%)',
                'photo-overlay': 'linear-gradient(to top, #0B0D11 0%, rgba(11, 13, 17, 0.75) 45%, rgba(11, 13, 17, 0.3) 100%)',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};