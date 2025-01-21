import ModalEvents from './ModalEvents.js';

const csrf = document.querySelector('meta[name="csrf-token"]')['content'];
const mainUrl = document.querySelector('meta[name="url-base"]')['content'];

const modalEvents = new ModalEvents(mainUrl, csrf);
modalEvents.init();
