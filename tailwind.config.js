import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/guava/tutorials/resources/**/*.php',
        './awcodes/filament-versions/resources/**/*.blade.php',
        "./vendor/statikbe/laravel-filament-chained-translation-manager/**/*.blade.php",
        './vendor/kenepa/banner/resources/**/*.php',
        './vendor/filament/forms/resources/**/*.php',
        // './invaders-xx/filament-nested-list/resources/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
