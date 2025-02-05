import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import daisyui from "daisyui";
import plugin from "tailwindcss/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: "#7e22ce",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        // forms,
        daisyui,
    ],

    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#7e22ce",
                    accent: "#7e22ce",
                    neutral: "#7e22ce",
                    "base-100": "#ffffff",
                },
            },
            "light",
        ],
    },
};
