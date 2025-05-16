import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';
export default class extends Controller {
    static targets = ['dayCheckbox'];

    connect() {
        console.log('Calendar controller connected');
    }

    updateTitle(event) {
        alert('Door clicked');
    }
}