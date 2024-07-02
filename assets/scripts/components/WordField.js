export class WordField {
    wordLines;
    search;
    lastUsedCell = null;
    lastUsedLine = null;

    constructor(wordLines) {
        this.wordLines = wordLines;
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
                    console.log('The word is valid!');
                    const usedKeys = await wordLine.evaluate(search);
                    console.log(usedKeys);
                    foundUnevaluated = true;

                    usedKeys['isCorrect'] = word === search;

                    return usedKeys;
                } else {
                    console.log('The word is invalid.');
                    return {}; // Return an empty object or handle as needed
                }
            }
            index++;
        }

        return {};
    }

    async checkWord(word) {
        try {
            const response = await fetch('/times/game/check', {
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
            console.log(data.isValid); // Handle the validation result as needed

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

