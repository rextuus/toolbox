export class Key {
    element;
    wordField;
    keyBoard;
    invalidWordModal = null;
    successModal = null;
    cookieHandler = null;

    constructor(element, wordField, keyBoard, invalidWordModal, successModal, failedModal, cookieHandler) {
        this.element = element;
        this.wordField = wordField;
        this.keyBoard = keyBoard;
        this.invalidWordModal = invalidWordModal;
        this.successModal = successModal;
        this.failedModal = failedModal;
        this.cookieHandler = cookieHandler;

        // enter
        let assigned = false;
        if (this.element.getAttribute('data-key') === '↵') {
            this.element.addEventListener('click', () => {
                this.submitWord();
            });
            assigned = true;
        }

        // delete
        if (this.element.getAttribute('data-key') === '←') {
            this.element.addEventListener('click', () => {
                this.deleteLetter();
            });
            assigned = true;
        }

        // placeholders should have no function
        if (this.element.classList.contains('half')){
            assigned = true;
        }

        if (!assigned){
            this.element.addEventListener('click', () => {
                this.addLetter();
            });
        }

        this.element.addEventListener('mousedown', function () {
            this.classList.add('clicked');
        });

        this.element.addEventListener('mouseup', function () {
            const keyElement = this;

            setTimeout(function () {
                keyElement.classList.remove('clicked');
            }, 100);  // Adjust time as per your need
        });
    }

    async submitWord() {
        const usedKeys = await this.wordField.submitCurrentLine(search);

        if (Object.entries(usedKeys).length === 0) {
            this.invalidWordModal.flashMessage(3000);
        }else{
            if (usedKeys['isCorrect']){
                this.successModal.openModal();
                // Todo write cookie info
            }
            this.keyBoard.setKeyStates(usedKeys);
            console.log(usedKeys);

            if (usedKeys['remainingAttempts'] < 1){
                this.failedModal.setSecretText(search);
                this.failedModal.openModal();
            }
        }
    }

    deleteLetter() {
        this.wordField.deleteLetter();
    }

    addLetter() {
        this.wordField.addLetter(this.element.getAttribute('data-key'));
    }

    setWordField(value) {
        this.wordField = value;
    }
}
