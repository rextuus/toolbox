export class Key {
    element;
    wordField;
    keyBoard;
    invalidWordModal = null;
    successModal = null;
    cookieHandler = null;

    constructor(element, wordField, keyBoard, invalidWordModal, successModal, cookieHandler) {
        this.element = element;
        this.wordField = wordField;
        this.keyBoard = keyBoard;
        this.invalidWordModal = invalidWordModal;
        this.successModal = successModal;
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

        if (!assigned){
            this.element.addEventListener('click', () => {
                this.addLetter();
            });
        }
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
