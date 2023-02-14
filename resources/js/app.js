import './bootstrap';
import './main';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);
