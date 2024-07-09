import {WordLine} from "./WordLine";

export class Modal {
    element;
    confirm;
    decline;
    ok;

    constructor(element) {
        this.element = element;

        this.confirm = this.element.querySelector('.modal-confirm');
        this.decline = this.element.querySelector('.modal-decline');
        this.ok = this.element.querySelector('.modal-ok');

        if (this.confirm) {
            this.confirm.addEventListener('click', () => {
                this.closeModal();
            });
        }

        if (this.decline) {
            this.decline.addEventListener('click', () => {
                this.closeModal();
            });
        }

        if (this.ok) {
            this.ok.addEventListener('click', () => {
                this.closeModal();
            });
        }
    }

    setSecretText(search) {
        let wordle = this.element.querySelector('#searched-wordle');
        wordle.textContent = search;
    }

    openModal() {
        this.element.style.display = 'block';
        this.element.style.opacity = '1'; // Ensure it's fully visible
        this.element.classList.remove('fade-out'); // Remove fade-out class if present
    }

    closeModal() {
        this.element.classList.add('fade-out');
        setTimeout(() => {
            this.element.style.display = 'none';
            this.element.classList.remove('fade-out'); // Clean up fade-out class
        }, 500); // Match this timeout with the animation duration in CSS
    }

    flashMessage(duration) {
        this.openModal();
        setTimeout(() => {
            this.closeModal();
        }, duration);
    }
}