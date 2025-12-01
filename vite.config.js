import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/layouts/modern-light-menu/light/loader.scss',
                'resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss',

                'resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss',
                'resources/scss/light/assets/elements/alert.scss',
                'resources/scss/light/assets/main.scss',
                'resources/scss/light/plugins/autocomplete/css/custom-autoComplete.scss',
                'resources/scss/light/assets/scrollspyNav.scss',
                'resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss',
                'resources/scss/layouts/modern-light-menu/light/structure.scss',
                'resources/scss/layouts/modern-light-menu/light/loader.scss',
                'resources/scss/light/assets/authentication/auth-boxed.scss',
                'resources/scss/light/assets/components/accordions.scss',
                'resources/scss/light/assets/components/tabs.scss',
                'resources/sass/app.scss',
                'resources/sass/datatables.scss',
                'resources/sass/input-inline.scss',
                'resources/sass/colvis.scss',
                'resources/sass/f_fluxes.scss',

                'resources/layouts/modern-light-menu/loader.js',
                'resources/layouts/modern-light-menu/app.js',

                
                'resources/js/app.js',
                'resources/js/autocomplete.js',
                'resources/js/expedients.js',
                'resources/js/validations.js',
                'resources/js/alerts.js',
                'resources/js/filters.js',
                'resources/js/s_general_reports.js',
                'resources/js/s_general_report_graphics.js',
                'resources/js/s_mensual_reports.js',
                'resources/js/s_mensual_report_graphics.js',
                'resources/js/s_institution_report_graphics.js',
                'resources/js/s_institution_reports.js',
                'resources/js/f_fluxes.js',
                'resources/js/f_fluxes_excel.js',
                'resources/js/f_flux_status.js',
                'resources/js/f_clasifications.js',
                'resources/js/s_coordinator_reports.js',
                'resources/js/s_coordinator_report_graphics.js',
                'resources/js/s_promotor_reports.js',
                
                'resources/js/users/generals.js',
                'resources/js/users/departamentSelect.js',
                'resources/js/commissions/generals.js',
                'resources/js/commissions/index.js',
                'resources/js/contracts/c_contentEditor.js',

                'resources/js/tinymce_editor.js',

                'resources/js/requisitions/generals.js',

            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build', // Ruta de salida para los archivos construidos
        manifest: true, // Asegúrate de que se genere el manifiesto
    },
    base: process.env.NODE_ENV === 'production' ? '/build/' : '/',
});
