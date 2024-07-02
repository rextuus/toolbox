export class KeyBoard {
    keys;

    constructor() {

    }

    setKeyStates(states){
        const statePriority = {
            'correct': 3,
            'present': 2,
            'absent': 1
        };

        for (const [key, state] of Object.entries(states)) {
            const keyElement = this.keys.find(k => k.element.getAttribute('data-key') === key);
            if (keyElement) {
                let element = keyElement.element;
                if (element.getAttribute('data-state') === 'none') {
                    element.setAttribute('data-state', state);
                }

                const currentState = element.getAttribute('data-state');
                if (!currentState || statePriority[state] > statePriority[currentState]) {
                    element.setAttribute('data-state', state);
                }

                console.log(keyElement);
            }
        }
    }

    setKeys(keys) {
        this.keys = keys;
    }

}
