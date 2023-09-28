import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const cacheKey = 'cache_' + this.element.id;
        const storage = window.sessionStorage;
        const hit = storage.getItem(cacheKey);

        if (hit !== null) {
            this.element.innerHTML = hit;
        }

        this.element.addEventListener('turbo:frame-render', function (event) {
            storage.setItem(cacheKey, event.target.innerHTML);
        });
    }
}
