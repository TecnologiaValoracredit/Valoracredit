<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Dashboard
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <style>
            #calendar {
                height: 800px;
                width: 1000px;
            }

            .fc-toolbar-title {
                text-transform: uppercase;
            }

            :root {
            --fc-today-bg-color: #abc6ff; /* Replace with your desired color */
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <p class="text-center">
            Hola, {{ auth()->user()->name }}
        </p>
    </div>

    <div class="d-flex justify-content-center align-items-center">
        <div id="calendar"></div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite('resources/js/fullCalendar.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>