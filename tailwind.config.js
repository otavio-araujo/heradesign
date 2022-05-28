const colors = require('tailwindcss/colors') 
 
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php', 
    ],
    darkMode: 'class',
    theme: {
        fontFamily: {
            'quicksand' : ['Quicksand', 'sans-serif']
        },
        extend: {
            colors: { 
                danger: colors.rose,
                // primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
                "primary": {
                  DEFAULT: "#BD986E",
                  "50": "#efcaa0",
                  "100": "#e5c096",
                  "200": "#dbb68c",
                  "300": "#d1ac82",
                  "400": "#c7a278",
                  "500": "#bd986e",
                  "600": "#b38e64",
                  "700": "#a9845a",
                  "800": "#9f7a50",
                  "900": "#957046"
                },
                'hera-dark': {
                  DEFAULT: '#09204A',
                  '50': '#93B5F2',
                  '100': '#81A8F0',
                  '200': '#5D8FEB',
                  '300': '#3876E7',
                  '400': '#1B5FDC',
                  '500': '#164FB7',
                  '600': '#123F93',
                  '700': '#0D306E',
                  '800': '#09204A',
                  '900': '#030A18'
                },
            }, 
        },
    },
    plugins: [
        require('@tailwindcss/forms'), 
        require('@tailwindcss/typography'), 
    ],
}