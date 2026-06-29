import Alpine from 'alpinejs';
import { animate } from 'motion';
import ApexCharts from 'apexcharts';
import { Notyf } from 'notyf';
import Swal from 'sweetalert2';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.animate = animate;

window.refreshIcons = () => createIcons({ icons });

window.notyf = new Notyf({
    duration: 4000,
    position: { x: 'right', y: 'top' },
    types: [
        {
            type: 'success',
            background: '#0B8F4D',
            icon: false,
        },
        {
            type: 'error',
            background: '#dc2626',
            icon: false,
        },
    ],
});

window.Swal = Swal.mixin({
    confirmButtonColor: '#0B8F4D',
    cancelButtonColor: '#64748b',
});

document.addEventListener('alpine:initialized', () => window.refreshIcons());

Alpine.start();

window.refreshIcons();
