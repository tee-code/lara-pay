const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: "rgb(16, 25, 136)",
                secondary: "rgb(243, 19, 107)",
            },
            keyframes: {
                shake: {
                    "0%": {
                        backgroundColor: "rgb(243, 19, 107)",
                        boxShadow: '0 0 5px rgb(130, 2, 99)',
                        transform: "rotate(-1deg)"
                    },
                    "50%": {
                        backgroundColor: "rgb(243, 19, 107)",
                        boxShadow: "0 0 20 px rgb(130, 2, 99)",
                        transform: "rotate(-2deg)"
                    },
                    "100%": {
                        backgroundColor: "rgb(243, 19, 107)",
                        boxShadow: "0 0 5 px rgb(130, 2, 99)",
                        transform: "rotate(-3deg)"
                    }
                }
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                shake: "shake 1300ms infinite"
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};