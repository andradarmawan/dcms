import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./app/Helpers/**/*.php",
    ],

    safelist: [
        // Background Color
        "bg-orange-50",
        "bg-green-50",
        "bg-gray-50",

        // Text Color
        "text-orange-700",
        "text-green-700",
        "text-gray-700",
        "text-gray-50",

        // Gradients
        "from-red-500",
        "to-rose-600",
        "from-blue-500",
        "to-indigo-600",
        "from-green-500",
        "to-emerald-600",
        "from-orange-600",
        "to-amber-700",
        "from-gray-500",
        "to-slate-600",

        // Shadows
        "shadow-red-500/30",
        "shadow-blue-500/30",
        "shadow-green-500/30",
        "shadow-orange-600/30",
        "shadow-gray-500/30",

        // Atau gunakan pattern matching
        {
            pattern: /bg-(red|blue|green|orange|gray)-(50)/,
        },
        {
            pattern: /text-(red|blue|green|orange|gray)-(700|50)/,
        },
        {
            pattern: /from-(red|blue|green|orange|gray)-(500|600)/,
        },
        {
            pattern: /to-(rose|indigo|emerald|amber|slate)-(600|700)/,
        },
        {
            pattern: /shadow-(red|blue|green|orange|gray)-(500|600)\/30/,
        },
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
