export class WordLine {
    element;
    evaluated = false;
    cells;

    constructor(element) {
        this.element = element;

        this.cells = this.element.querySelectorAll('.grid-cell');
    }

    shakeWord() {
        return new Promise(resolve => {
            this.element.classList.add('shake');

            this.element.addEventListener('animationend', () => {
                this.element.classList.remove('shake');
                resolve();  // Resolve the promise when animation ends
            }, { once: true });
        });
    }

    getWord () {
        let word = '';
        this.cells.forEach((cell, index) => {
            word = word + cell.textContent;
        });

        return word;
    }

    checkIsReady = function () {
        let containsNonReady = false;
        this.cells.forEach((cell, index) => {
            if (cell.getAttribute('data-state') === 'empty') {

                containsNonReady = true;
            }
        });

        return !containsNonReady;
    }

    addLetterToNextEmptyCell (letter) {
        let placed = false;
        let usedCell = null;
        this.cells.forEach((cell, index) => {
            if (cell.getAttribute('data-state') === 'empty' && !placed) {
                cell.innerHTML = letter;
                cell.setAttribute('data-state', 'placed');
                placed = true;
                usedCell = cell;
            }
        });

        return usedCell;
    }

    evaluate(search) {
        return new Promise((resolve) => {
            // Store the cells that need to be flipped
            const cellsToFlip = Array.from(this.element.querySelectorAll('.grid-cell'));

            // Split the search string into an array of characters
            const characters = search.split('');

            let usedKeys = {};
            let completedFlips = 0;

            // Define the priority order of the states
            const statePriority = {
                'correct': 3,
                'present': 2,
                'absent': 1
            };

            // Flip each cell with a delay, then flip it back instantly
            cellsToFlip.forEach((cell, index) => {
                setTimeout(() => {
                    cell.classList.add('flipped');

                    // Check the state of the cell
                    let state = this.checkCellState(cell, index, characters);

                    // Update usedKeys only if the new state has a higher priority
                    const currentState = usedKeys[cell.textContent];
                    if (!currentState || statePriority[state] > statePriority[currentState]) {
                        usedKeys[cell.textContent] = state;
                    }

                    cell.setAttribute('data-state', state);

                    setTimeout(() => {
                        cell.classList.remove('flipped');
                        completedFlips++;

                        // Check if all flips are completed
                        if (completedFlips === cellsToFlip.length) {
                            resolve(usedKeys);
                        }
                    }, 400); // Delay before flipping back, adjust as needed
                }, index * 800); // Delay for initial flip, adjust as needed
            });

            this.evaluated = true;
        });
    }

    checkCellState(cell, index, characters) {
        let state = 'absent';

        // Check if the character is correct
        if (characters[index] === cell.textContent) {
            return 'correct';
        }

        // If not correct but present in the string, mark as 'present'
        let occurrences = characters.filter(char => char === cell.textContent).length;
        if (state === 'absent' && occurrences > 0) {
            if (occurrences > 1) {
                // character occurs already the second time
                state = 'absent';
            } else {
                state = 'present';
            }
        }

        return state;
    }


    isEvaluated() {
        return this.evaluated;
    }
}

let wordLines = [];
document.querySelectorAll('.grid-line')
    .forEach(element => {
            wordLines.push(new WordLine(element));
        }
    );


wordLines.forEach(wordLine => {
    // wordLine.evaluate();
});