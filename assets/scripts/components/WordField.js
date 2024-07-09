export class WordField {
    wordLines;
    cookieHandler;
    search;
    lastUsedCell = null;
    lastUsedLine = null;

    constructor(wordLines, cookieHandler) {
        this.wordLines = wordLines;
        this.cookieHandler = cookieHandler;
        this.search = search;
    }

    async submitCurrentLine(search) {
        let foundUnevaluated = false;
        let index = 0;

        while (!foundUnevaluated && index < this.wordLines.length) {
            const wordLine = this.wordLines[index];
            if (!wordLine.isEvaluated() && wordLine.checkIsReady()) {
                const word = wordLine.getWord();
                const isValid = await this.checkWord(word);

                if (isValid) {
                    const usedKeys = await wordLine.evaluate(search);
                    foundUnevaluated = true;

                    // cookie handling
                    let currentDate = new Date();
                    let formattedDate = `${currentDate.getFullYear()}-${(String(currentDate.getMonth() + 1)).padStart(2, '0')}-${(String(currentDate.getDate())).padStart(2, '0')}`;
                    let cookieName = 'currentGameInfo' + '_' + formattedDate;

                    let currentGameInfo = [];
                    if (index === 0){
                        currentGameInfo = [{
                            'line': index,
                            'usedKeys': usedKeys,
                            'word': word,
                        }];
                    }else{
                        let currentGameInfoString = this.cookieHandler.getCookie(cookieName);
                        if (currentGameInfoString) {
                            currentGameInfo = JSON.parse(currentGameInfoString);
                        } else {
                            currentGameInfo = [];
                        }
                        currentGameInfo.push({
                            'line': index,
                            'usedKeys': usedKeys,
                            'word': word,
                        });
                    }

                    this.cookieHandler.setCookieWithObject(cookieName, currentGameInfo, 1);

                    usedKeys['isCorrect'] = word === search;

                    let remainingAttempts = 0;
                    if (index < this.wordLines.length) {
                        remainingAttempts = this.wordLines.length - index - 1;
                    }
                    usedKeys['remainingAttempts'] = remainingAttempts;

                    return usedKeys;
                } else {
                    return {}; // Return an empty object or handle as needed
                }
            }
            index++;
        }

        return {};
    }

    async checkWord(word) {
        try {
            // const response = await fetch('/times/game/check', {
            const response = await fetch('https://michuwordle.com/index.php/times/game/check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ word })
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


    addLetter(letter) {
        let added = false;
        let blocked = false;
        this.wordLines.forEach((wordLine) => {
            // get next evaluatable word line
            if (!wordLine.isEvaluated() && !added && !blocked) {
                // check if there is space for a new letter
                if (wordLine.checkIsReady()){
                    blocked = true;
                }

                if (!blocked){
                    let cell = wordLine.addLetterToNextEmptyCell(letter);
                    if (cell !== null){
                        added = true;
                        this.lastUsedCell = cell;
                        this.lastUsedLine = wordLine;
                    }
                }
            }
        })
    }

    deleteLetter() {
        let cell = this.lastUsedCell;
        if (cell === null || this.lastUsedLine === null) {
            return;
        }
        cell.innerHTML = '';
        cell.setAttribute('data-state', 'empty');
        const str = cell.id;
        const parts = str.split("-");
        const cellNumber = parseInt(parts[2], 10);

        if (cellNumber >= 2){
            const newCellNumber = cellNumber - 1;
            const cellNumberString = parts[0] + "-" + parts[1] + "-" + newCellNumber;
            this.lastUsedCell = this.lastUsedLine.element.querySelector('#' + cellNumberString);
        }
    }
}

