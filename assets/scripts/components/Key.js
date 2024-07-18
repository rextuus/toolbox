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

                if (usedKeys['usedAttempts'] === 1){
                    const text = document.getElementById('modal-won');
                    text.innerText = 'Fucking genius';
                    const imgElement = document.getElementById('success-modal-img');
                    imgElement.src = 'https://res.cloudinary.com/dl4y4cfvs/image/upload/v1721329304/michuworlde/Kritek_match.gif';
                }else{

                    this.successModal.changeImageRandomly();
                }
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

            // easter egg handling
            if (usedKeys['easterEgg']){
                let newImageUrl = 'https://res.cloudinary.com/dl4y4cfvs/image/upload/v1721329305/michuworlde/20231210_162646.jpg';
                let newText = 'Easter';
                if (usedKeys['easterEgg'] === 'michi' || usedKeys['easterEgg'] === 'michu'){
                    newImageUrl = 'https://res.cloudinary.com/dl4y4cfvs/image/upload/c_scale,w_580/v1721329304/michuworlde/20210828_183911.jpg';
                    newText = 'Nice guy';
                }

                if (usedKeys['easterEgg'] === 'hanna'){
                    newImageUrl = 'https://res.cloudinary.com/dl4y4cfvs/image/upload/c_scale,w_523/v1721329304/michuworlde/20210515_235203.jpg';
                    newText = 'Hools girl';
                }

                let currentDate = new Date();
                let formattedDate = `${currentDate.getFullYear()}-${(String(currentDate.getMonth() + 1)).padStart(2, '0')}-${(String(currentDate.getDate())).padStart(2, '0')}`;
                let cookieName = 'michu_wordle_field_info' + '_' + formattedDate;
                let currentGameInfoString = this.cookieHandler.getCookie(cookieName);

                let currentGameInfo = [];

                if (currentGameInfoString) {
                    currentGameInfo = JSON.parse(currentGameInfoString);
                }

                let words = currentGameInfo.map(item => item.word);
                let isMichiAndHannaExist = (words.includes('michi') && words.includes('hanna')) || (words.includes('michu') && words.includes('hanna'));
                if (isMichiAndHannaExist){
                    newImageUrl = 'https://res.cloudinary.com/dl4y4cfvs/image/upload/c_scale,w_516/v1721329303/michuworlde/IMG-20240601-WA0003.jpg';
                    newText = 'Dream couple';
                }

                const imgElement = document.getElementById('success-modal-img');
                imgElement.src = newImageUrl;
                const text = document.getElementById('modal-won');
                text.innerText = newText;
                this.successModal.flashMessage(5000);
            }
        }
    }

    async saveStats(usedKeys) {

        let params = {
            'usedAttempts': usedKeys['usedAttempts'],
            'wordleId': usedKeys['wordleId'],
            'result': usedKeys['isCorrect']
        };
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
