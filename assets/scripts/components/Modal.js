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

    changeImageRandomly = () => {
        const imagePool = [
            'https://res.cloudinary.com/dl4y4cfvs/image/upload/v1721076270/michuworlde/andersson_qibg5u.gif',
            'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExd2tyYTk1cm92NjNqYmk4dHlsZzhsN2ZrMDFwd2N6aGc0NHc4dmR3ciZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/VfEcSBEi18NmCPTIig/giphy.gif',
            'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExbmNna3dxcDR3aXJlaHJnbWp5djhibnZ4MHJ0NHN2N3FyNXI4djYwYiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9cw/iKA51hSRXlC5hX5zbX/giphy.gif',
            'https://media.giphy.com/media/U3yNt3keg9x1SyGQKH/giphy.gif?cid=ecf05e47y4lrnl8zm2n9x5ergqygy44ni1plxmswpygwcqey&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/Qa9uRxlGsFPstMnYXc/giphy.gif?cid=ecf05e47y4lrnl8zm2n9x5ergqygy44ni1plxmswpygwcqey&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/RlHOoHFFTPfj8iwych/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/kc5vtoLKJEF9SEvE7T/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/YlYcxrldLeou2IP9ZM/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/ggooR1yhaR34KNG1Yc/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/fx0Ro4bklMyuQ10e7I/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/UWW9PY4rAyqxKVIzl5/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/ll1gSnb5j0eBVHUM8B/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/JRhCGEkO1b3I9lcg5Y/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/XckR0U1UPGyBE3BewL/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/YqKtw2Blf2agZE471f/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/S9iyCYpr975pCpbNRd/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/WRnyJFXb0ey4zqfDEC/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/YpkXSQ5WODpJtNKLvo/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/TdKuy4Uh2pEx0JD589/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/TdvOXrGckP0OlnTaNm/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/eipMPsRINPeCwpxQK6/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/l4jCZF5mUhpXUCVo0Y/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/LMVt22ZGDMrdOP6hWE/giphy.gif?cid=ecf05e47spjc9822eowje6cbi8tgj4rocsm0mfxxiw2b70hi&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/mBM55zvhY6BfjhbfWB/giphy.gif?cid=ecf05e47pwxtt8ukcy5k2tvye8b71y4vz5xh5c8pecgccouv&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/If17PWqbNcaD8l7ySc/giphy.gif?cid=ecf05e47pwxtt8ukcy5k2tvye8b71y4vz5xh5c8pecgccouv&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/1o1x3Dimg0JTl6aF75/giphy.gif?cid=ecf05e47pwxtt8ukcy5k2tvye8b71y4vz5xh5c8pecgccouv&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/Zw7aRvCLCpM1qde8Uw/giphy.gif?cid=ecf05e47jlm3f646hk618hbr9hlyyy44366yqs4b60iitbbn&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/Tdzty1cLIOf212eqff/giphy.gif?cid=ecf05e47jlm3f646hk618hbr9hlyyy44366yqs4b60iitbbn&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/dZ4L67ll1whlAm1Ltr/giphy.gif?cid=ecf05e47jlm3f646hk618hbr9hlyyy44366yqs4b60iitbbn&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/ls5j0XAT0ElxjwJSV1/giphy.gif?cid=ecf05e47jlm3f646hk618hbr9hlyyy44366yqs4b60iitbbn&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/cAhFMCAVjDpcbxkQbl/giphy.gif?cid=ecf05e47jlm3f646hk618hbr9hlyyy44366yqs4b60iitbbn&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/5b241KAjdAaYNnkIty/giphy.gif?cid=ecf05e47jlm3f646hk618hbr9hlyyy44366yqs4b60iitbbn&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/dSdvNlbhwRA417yYB5/giphy.gif?cid=ecf05e47jlm3f646hk618hbr9hlyyy44366yqs4b60iitbbn&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/lsBdpUe8DcdRMyF4Bb/giphy.gif?cid=ecf05e471p4jevttkiyb5mivy9nwmgp4pxpdspcsopmsd9gz&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/fecJYAVszEgdmBPK5r/giphy.gif?cid=ecf05e47jzyjyjgxxrw2xs47raso3t09hsrg8s0gb123o5b5&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/55gQcg5sA5LyZmmjZ9/giphy.gif?cid=ecf05e47c6wsbdthgts1svr8nz1ex8owzn9ovjpu216xm0u0&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/2sfgi4TxD0S0zRsK9d/giphy.gif?cid=ecf05e47c6wsbdthgts1svr8nz1ex8owzn9ovjpu216xm0u0&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/3zhlL6NjWl99rkNugB/giphy.gif?cid=ecf05e47c6wsbdthgts1svr8nz1ex8owzn9ovjpu216xm0u0&ep=v1_gifs_related&rid=giphy.gif&ct=s',
            'https://media.giphy.com/media/9S5b8gr8srX4GA04gI/giphy.gif?cid=ecf05e47c6wsbdthgts1svr8nz1ex8owzn9ovjpu216xm0u0&ep=v1_gifs_related&rid=giphy.gif&ct=s',
        ];

        const randomIndex = Math.floor(Math.random() * imagePool.length);
        const newImageUrl = imagePool[randomIndex];

        // Get the image element and update it
        const imgElement = document.getElementById('success-modal-img');
        imgElement.src = newImageUrl;
    };
}