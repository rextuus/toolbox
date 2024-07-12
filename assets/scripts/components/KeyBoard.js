export class KeyBoard {
    keys;
    cookieHandler;

    constructor(cookieHandler) {
        this.cookieHandler = cookieHandler;
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
            }
        }

        // cookie handling
        let currentDate = new Date();
        let formattedDate = `${currentDate.getFullYear()}-${(String(currentDate.getMonth() + 1)).padStart(2, '0')}-${(String(currentDate.getDate())).padStart(2, '0')}`;
        let cookieName = 'michu_wordle_keyboard_info' + '_' + formattedDate;

        let keysStatesArray = this.keys.map(k => {
            return {
                key: k.element.getAttribute('data-key'),
                state: k.element.getAttribute('data-state')
            };
        });
        this.cookieHandler.setCookieWithObject(cookieName, keysStatesArray, 1);
    }

    setKeys(keys) {
        this.keys = keys;
    }

    initFromCookie() {
        let currentDate = new Date();
        let formattedDate = `${currentDate.getFullYear()}-${(String(currentDate.getMonth() + 1)).padStart(2, '0')}-${(String(currentDate.getDate())).padStart(2, '0')}`;
        let fieldCookieName = 'michu_wordle_keyboard_info' + '_' + formattedDate;
        let keyBoardCookie = this.cookieHandler.getCookie(fieldCookieName);

        if (keyBoardCookie) {
            const keysStatesArray = JSON.parse(keyBoardCookie);
            for(const keyState of keysStatesArray) {
                const keyElement = this.keys.find(k => k.element.getAttribute('data-key') === keyState['key']);

                if (keyElement) {
                    keyElement.element.setAttribute('data-state', keyState['state']);
                }
            }
        }
    }
}
