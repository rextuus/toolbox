import './bootstrap.js';
// import interact from 'interactjs';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/esc.scss'

console.log('This log comes from assets/scss.js - welcome to AssetMapper! 🎉')

document.addEventListener("DOMContentLoaded", function () {
    let choices = document.querySelectorAll('.choice');
    let targets = document.querySelectorAll('.target');

    let choiceToFields = {};

    let errorModal = document.getElementById('errorModal');
    let errorMessage = document.getElementById('errorMessage');
    let modalClose = document.querySelector('.modal-close');
    let submit = document.getElementById('approval');
    submit.addEventListener('click', function () {



        if (Reflect.ownKeys(choiceToFields).length < targets.length){
            errorMessage.textContent = "There is an error!";
            errorModal.style.display = "block";
        }
        sendDataToServer();

    });

    modalClose.addEventListener('click', function() {
        errorModal.style.display = "none";
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', function(event) {
        if (event.target === errorModal) {
            errorModal.style.display = "none";
        }
    });




    let input = document.getElementById('name');
    fetchName();
    // Add event listener for input event
    input.addEventListener('input', function() {
        let enteredValue = input.value;
        setCookieWithObject('name', enteredValue, 365);
    });

    // swipe functionallity
    let container = document.getElementById('container');
    let pool = document.getElementById('pool');
    let targetContainer = document.getElementById('targets');
    let startX;

    function hidePool(){
        pool.classList.add('hidden');
        pool.classList.remove('visible');
        targetContainer.classList.add('visible');
        targetContainer.classList.remove('hidden');
    }

    function hideTargets(){
        pool.classList.add('visible');
        pool.classList.remove('hidden');
        targetContainer.classList.add('hidden');
        targetContainer.classList.remove('visible');
    }

    container.addEventListener('touchstart', function(e) {
        var touchobj = e.changedTouches[0];
        startX = touchobj.pageX;
    }, false);

    let tolerance = 300;
    container.addEventListener('touchend', function(e) {
        let touchobj = e.changedTouches[0];
        let distX = touchobj.pageX - startX;
        if (distX > tolerance) { // Minimum swipe distance
            hidePool();
        }
        if (distX < -1*tolerance) { // Minimum swipe distance
            hideTargets();
        }
    }, false);


    // load content and add functionallity
    let currentlyCheckedChoice = null;
    let currentlyCheckedTarget = null;

    fetchUserChoices();
    for (let targetId in choiceToFields) {
        if (choiceToFields.hasOwnProperty(targetId)) {
            let selectedChoiceId = choiceToFields[targetId];

            let target = document.querySelector('#' + targetId);
            let selectedChoice = document.querySelector('#' + selectedChoiceId);

            target.textContent = selectedChoice.textContent;
            target.classList.add('choosen');

            selectedChoice.classList.remove('selected');
            selectedChoice.classList.add('hidden');
            choiceToFields[target.id] = selectedChoice.id;
        }
    }

    // choice
    choices.forEach(choice => {
        choice.addEventListener('click', function () {
            if (currentlyCheckedChoice !== null && currentlyCheckedChoice !== this) {
                currentlyCheckedChoice.classList.remove('selected');
            }

            if (!choice.classList.contains('hidden')) {
                // check if any target is in selection currently
                if (currentlyCheckedTarget !== null){

                    currentlyCheckedTarget.textContent = choice.textContent;
                    currentlyCheckedTarget.classList.add('choosen');

                    choice.classList.remove('selected');
                    choice.classList.add('hidden');
                    choiceToFields[currentlyCheckedTarget.id] = choice.id;


                    setCookieWithObject('choices', choiceToFields, 365);

                    currentlyCheckedTarget = null;
                    hidePool();
                }else{
                    // if not set selected to choice and swipe to targets
                    choice.classList.add('selected');
                    currentlyCheckedChoice = this;
                }
            }
        });
    });

    // target
    targets.forEach(target => {
        target.addEventListener('click', function () {
            // free already filled targets if clicked on it and restore choice
            if (target.classList.contains('choosen')) {
                target.textContent = '';
                target.classList.remove('choosen');

                const hiddenChoice = document.querySelector('#' + choiceToFields[target.id]);
                if (hiddenChoice) {
                    hiddenChoice.classList.remove('hidden');
                    delete choiceToFields[target.id];
                }
            }

            const selectedChoice = document.querySelector('.choice.selected');

            // store choice in target field if there was one
            if (selectedChoice) {
                target.textContent = selectedChoice.textContent;
                target.classList.add('choosen');

                selectedChoice.classList.remove('selected');
                selectedChoice.classList.add('hidden');
                choiceToFields[target.id] = selectedChoice.id;
            }else{
                targets.forEach(target => {
                    target.classList.remove('selected');
                });
                target.classList.add('selected');
                currentlyCheckedTarget = target;
                hideTargets();
            }

            setCookieWithObject('choices', choiceToFields, 365);
            console.log(choiceToFields);
        });
    });

    function setCookieWithObject(name, value, days) {
        let expires = '';
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + encodeURIComponent(JSON.stringify(value)) + expires + '; path=/';
    }

    // Function to get a cookie
    function getCookie(name) {
        let nameEQ = name + '=';
        let cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return decodeURIComponent(cookie.substring(nameEQ.length, cookie.length));
            }
        }
        return null;
    }

    // Function to fetch user choices from the cookie
    function fetchUserChoices() {
        let userChoicesCookie = getCookie('choices');
        if (userChoicesCookie) {
            try {
                choiceToFields = JSON.parse(decodeURIComponent(userChoicesCookie));
            } catch (error) {
                console.error('Error parsing user choices from cookie:', error);
            }
        } else {
            console.log('No user choices found in the cookie.');
        }
    }

    function fetchName() {
        let name = getCookie('name');
        if (name) {
            let parsed = JSON.parse(decodeURIComponent(name));
            let input = document.getElementById('name');
            input.value = parsed;
        }
    }

    function sendDataToServer() {
        let jsonData = JSON.stringify(choiceToFields);

        // Send data to the server using AJAX
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/esc/save', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                // Handle server response
            }
        };
        xhr.send(jsonData);
    }
});
