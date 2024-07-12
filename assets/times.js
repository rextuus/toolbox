import './bootstrap.js';
import './scripts/components/WordLine'
import './scripts/components/WordField'
import './scripts/components/Key'
import './scripts/components/KeyBoard'
import './scripts/components/Modal'
import './scripts/components/CookieHandler'
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/wordle_home.scss'
import './styles/times.scss'
import './styles/modal.scss'
import {WordField} from "./scripts/components/WordField";
import {WordLine} from "./scripts/components/WordLine";
import {Key} from "./scripts/components/Key";
import {KeyBoard} from "./scripts/components/KeyBoard";
import {Modal} from "./scripts/components/Modal";
import {CookieHandler} from "./scripts/components/CookieHandler";
import {defined} from "chart.js/helpers";

if (typeof search !== 'undefined') {

    let cookieHandler = new CookieHandler();
    let invalidWordModal = null;
    document.querySelectorAll('#invalidWordModal')
        .forEach(element => {
                invalidWordModal = new Modal(element);
            }
        );

    let successModal = null;
    document.querySelectorAll('#successModal')
        .forEach(element => {
                successModal = new Modal(element);
            }
        );

    let failedModal = null;
    document.querySelectorAll('#failedModal')
        .forEach(element => {
                failedModal = new Modal(element);
            }
        );

    let wordLines = [];
    document.querySelectorAll('.grid-line')
        .forEach(element => {
                wordLines.push(new WordLine(element));
            }
        );

    let wordField = new WordField(wordLines, cookieHandler, search, wordleId);
    wordField.initFromCookie();

    let keyBoard = new KeyBoard(cookieHandler);

// check if user can play or not
    let currentDate = new Date();
    let formattedDate = `${currentDate.getFullYear()}-${(String(currentDate.getMonth() + 1)).padStart(2, '0')}-${(String(currentDate.getDate())).padStart(2, '0')}`;
    let fieldCookieName = 'michu_wordle_field_info' + '_' + formattedDate;
    let fieldInfo = cookieHandler.getCookie(fieldCookieName);
    let disabled = false;

    if (defined(search) && fieldInfo) {
        fieldInfo = JSON.parse(fieldInfo);
        fieldInfo.forEach((info) => {
            if (info['word'] === search) {
                disabled = true;
                successModal.openModal();
            }
        });

        if (fieldInfo.length === totalAttempts) {
            disabled = true;
            failedModal.setSecretText(search);
            failedModal.openModal();
        }
    }

    let keys = [];
    document.querySelectorAll('.key')
        .forEach(element => {
                let key = new Key(element, wordField, keyBoard, invalidWordModal, successModal, failedModal, cookieHandler, disabled);
                keys.push(key);
            }
        );

    keyBoard.setKeys(keys);
    keyBoard.initFromCookie();
}