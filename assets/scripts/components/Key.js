export class Key {
    element;
    wordField;
    keyBoard;
    invalidWordModal = null;
    successModal = null;
    cookieHandler = null;

    constructor(element, wordField, keyBoard, invalidWordModal, successModal, failedModal, cookieHandler, disabled) {
        this.element = element;
        this.wordField = wordField;
        this.keyBoard = keyBoard;
        this.invalidWordModal = invalidWordModal;
        this.successModal = successModal;
        this.failedModal = failedModal;
        this.cookieHandler = cookieHandler;

        this.element.addEventListener('mousedown', function () {
            this.classList.add('clicked');
        });

        this.element.addEventListener('mouseup', function () {
            const keyElement = this;

            setTimeout(function () {
                keyElement.classList.remove('clicked');
            }, 100);  // Adjust time as per your need
        });

        if (disabled){
            return;
        }

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
        if (this.element.classList.contains('half')) {
            assigned = true;
        }

        if (!assigned) {
            this.element.addEventListener('click', () => {
                this.addLetter();
            });
        }
    }

    async submitWord() {
        const usedKeys = await this.wordField.submitCurrentLine(search);

        if (Object.entries(usedKeys).length === 0) {
            this.invalidWordModal.flashMessage(3000);
        } else {
            if (usedKeys['isCorrect']) {
                await this.saveStats(usedKeys);

                this.successModal.openModal();

                return;
            }

            this.keyBoard.setKeyStates(usedKeys);

            if (usedKeys['remainingAttempts'] < 1) {
                await this.saveStats(usedKeys);

                this.failedModal.setSecretText(search);
                this.failedModal.openModal();
                // Todo write cookie info
            }
        }
    }

    async saveStats(usedKeys) {

        let params = {
            'usedAttempts': usedKeys['usedAttempts'],
            'wordleId': usedKeys['wordleId'],
            'result': usedKeys['isCorrect']
        };
        console.log(JSON.stringify(params));
        try {
            // const response = await fetch('/times/game/save', {
                const response = await fetch('https://michuwordle.com/index.php/times/game/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(params)
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            // Return the validation result
            return data.isValid;
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            return false;
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
