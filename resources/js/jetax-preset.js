/**
 * Jetax Design System — Tailwind CSS Preset
 *
 * Exporta os tokens visuais do Jetax como um preset Tailwind.
 * Uso: presets: [require('./vendor/jksantos/jetax/resources/js/jetax-preset')]
 *
 * @see config/jetax.php para os valores padrão em PHP
 */
module.exports = {
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                'primary': '#00497e',
                'primary-container': '#0061a5',
                'primary-fixed': '#d2e4ff',
                'primary-fixed-dim': '#9fcaff',
                'secondary': '#0061a5',
                'secondary-container': '#0397fd',
                'secondary-fixed-dim': '#9fcaff',
                'tertiary': '#40465e',
                'error': '#ba1a1a',
                'error-container': '#ffdad6',
                'surface': '#faf8ff',
                'surface-dim': '#d0d8ff',
                'surface-container-lowest': '#ffffff',
                'surface-container-low': '#f3f2ff',
                'surface-container': '#ebedff',
                'surface-container-high': '#e3e7ff',
                'surface-container-highest': '#dce1ff',
                'surface-input': '#f3f3ff',
                'on-surface': '#111a37',
                'on-surface-variant': '#414750',
                'on-primary': '#ffffff',
                'on-primary-fixed': '#001d36',
                'outline': '#717782',
                'outline-variant': '#c1c7d2',
                'inverse-surface': '#262f4d',
                'success': '#16a34a',
                'warning': '#f59e0b',
                'info': '#0d99ff',
                'sidebar': '#141A30',
            },
            fontFamily: {
                'headline': ['Manrope', 'system-ui', 'sans-serif'],
                'body': ['Inter', 'system-ui', 'sans-serif'],
                'label': ['Inter', 'system-ui', 'sans-serif'],
            },
            borderRadius: {
                'DEFAULT': '0.125rem',
                'lg': '0.25rem',
                'xl': '0.5rem',
                'full': '0.75rem',
            },
            boxShadow: {
                'ambient': '0 4px 24px rgba(17, 26, 55, 0.04)',
                'ambient-lg': '0 8px 32px rgba(17, 26, 55, 0.04)',
                'sidebar': '16px 0 32px rgba(17, 26, 55, 0.04)',
            },
        },
    },
};
