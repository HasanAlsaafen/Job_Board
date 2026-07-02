import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                display: ['Hanken Grotesk', 'ui-sans-serif', 'sans-serif'],
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
            },
            colors: {
                brand: {
                    primary: '#4F46E5',
                    'primary-dark': '#3525CD',
                    'primary-light': '#EEF2FF',
                    surface: '#F9F9FF',
                    'surface-low': '#F1F3FF',
                    border: '#E5E7EB',
                    ink: '#141B2B',
                    muted: '#464555',
                },
            },
        },
    },
}
