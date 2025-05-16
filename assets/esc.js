import './bootstrap.js';
// import interact from 'interactjs';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/esc.scss'
import "/node_modules/flag-icons/css/flag-icons.min.css";
import JSConfetti from 'js-confetti'
const jsConfetti = new JSConfetti()
console.log('This log comes from assets/scss.js - welcome to AssetMapper! 🎉')

document.addEventListener("DOMContentLoaded", function () {

    if (document.getElementById('active-giveaway')){
        function sort() {
            console.log('sort');
            const list = document.getElementById('participants-list');
            const items = [...list.querySelectorAll('li')];

            items.sort((a, b) => {
                const pointsA = parseInt(a.lastElementChild.textContent);
                const pointsB = parseInt(b.lastElementChild.textContent);
                return pointsB - pointsA;
            });

            items.forEach(item => list.appendChild(item));
        }


// Define an async function to process the data
        let showModal  = document.getElementById('show-modal').style.display = 'block';

        async function processData(data) {
            // Process the data
            closeModal();
            for (const user of data) {
                await new Promise(resolve => setTimeout(resolve, 300));

                let html = '<span class="summary">';
                html = html + '<span class="user-name">'+ user.name+'</span> is giving ';
                let counter = 0;
                for (const key in user.votes) {
                    if (counter < 7){
                        html = html + '<span class="summary-entry"><span class="flag fi fi-'+flags[key]+' fis"></span><span class="summary-points">'+user.votes[key]+'</span><span class="summary-name">'+key+'</span></span>';
                    }
                    counter++;
                }
                html = html + '</span>';
                setModalText(html);

                jsConfetti.addConfetti()

                openModal(); // Open the modal before processing user's votes


                // Wait until the modal is closed
                await new Promise(resolve => {
                    const closeModalListener = () => {
                        closeModal();
                        window.removeEventListener('click', closeModalListener);
                        resolve();
                    };
                    window.addEventListener('click', closeModalListener);
                });

                let count = 0;
                for (const key in user.votes) {
                    if (count < 7){
                        updateActiveGiveaway(user.name, user.votes[key], key);
                        // sort();
                    }
                    count++;
                }
                await new Promise(resolve => setTimeout(resolve, 2000));
                sort();

                count = 0;
                for (const key in user.votes) {
                    if (count >= 7) {
                        // Asynchronous delay using Promise and setTimeout
                        await new Promise(resolve => setTimeout(resolve, 3000));
                        let html =
                            '<span class="user-name">'+ user.name+'</span> is giving ' +
                            '<span class="points">'+ user.votes[key]+ '</span> points to ' +
                            '<span class="country">'+key+ ' <span class="flag fi fi-'+flags[key]+' fis"></span></span>';
                        setModalText(html);
                        jsConfetti.addConfetti()
                        openModal();



                        await new Promise(resolve => {
                            const closeModalListener = () => {
                                closeModal();

                                // Call your updateActiveGiveaway function with appropriate arguments
                                updateActiveGiveaway(user.name, user.votes[key], key);

                                // Sort the list after each user by points


                                window.removeEventListener('click', closeModalListener);
                                resolve();
                            };
                            window.addEventListener('click', closeModalListener);
                        });
                        await new Promise(resolve => setTimeout(resolve, 2000));
                        sort();
                    }
                    count++;

                }

                resetCurrentGivenPoints();
                await new Promise(resolve => setTimeout(resolve, 5000));


            }

            // Sort the list again after all users have been processed
            sort();

            // Reset the points and cleanup after completing all votes processing
            resetCurrentGivenPoints();

        }


        // show modal
        function setModalText(html) {
            let content = document.getElementById('show-modal-content');
            content.innerHTML = html;
        }
        function openModal() {
            document.getElementById('show-modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('show-modal').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            if (event.target == document.getElementById('show-modal')) {
                closeModal();
            }
        });

        // Parse the JSON string stored in the data variable
        const jsonData = JSON.parse(data);

        // Call the processData function with the parsed JSON data
        processData(jsonData).catch(error => console.error(error));




        function sortEntries() {
            const entries = Array.from(document.querySelectorAll('#vote-table tr'))
                .slice(1) // exclude header row
                .sort((a, b) => {
                    const aPoints = parseInt(a.querySelector('.points').textContent);
                    const bPoints = parseInt(b.querySelector('.points').textContent);
                    return bPoints - aPoints; // sort in descending order
                });

            const tbody = document.querySelector('#vote-table tbody');
            entries.forEach(entry => {
                tbody.appendChild(entry);
            });
        }



        function updateActiveGiveaway(userName, points, country) {
            document.getElementById('user-name').textContent = userName;
            document.getElementById('points').textContent = points;
            document.getElementById('country').textContent = country;

            updatePoints(country, points);
        }

        function updatePoints(entryId, newPoints) {
            var entry = document.getElementById(entryId);
            console.log(entry);
            if (entry) {
                let numStr = entry.textContent.split(' ')[0]; // "2412"
                let currentPoints = parseInt(numStr); // 2412
                newPoints = parseInt(newPoints); // 2412

                // Add CSS classes for animation
                entry.classList.add('animated');
                entry.classList.add('highlight');

                // Update points after a delay to allow time for CSS animation
                setTimeout(() => {
                    entry.innerHTML = (currentPoints + newPoints) + ' Punkte <span class="new-points">  (+ ' + newPoints + ')</span>';
                    // Remove CSS classes to reset animation
                    entry.classList.remove('animated');
                    entry.classList.remove('highlight');
                    entry.parentElement.classList.add('earned');
                }, 1000); // Delay for 1 second
            }
        }

        function resetCurrentGivenPoints() {
            console.log('clean');
            // Select all country entries by their class or tag (adjust selector as needed)
            const countryEntries = document.querySelectorAll('#participants-list .participant-list-entry');

            // Iterate over each entry
            countryEntries.forEach(entry => {
                entry.parentElement.classList.remove('earned');
                entry.classList.remove('earned');

                // Remove the span with class "new-points"
                const newPointsSpan = entry.querySelector('.new-points');
                if (newPointsSpan) {
                    newPointsSpan.remove(); // Remove the span element from DOM
                }
            });
        }
    }


    // vote page
    let choices = document.querySelectorAll('.choice');
    if (choices.length > 0) {
        let targets = document.querySelectorAll('.target');

        let choiceToFields = {};

        // error modal
        let errorModal = document.getElementById('errorModal');
        let errorMessage = document.getElementById('errorMessage');
        // let modalClose = document.querySelector('.modal-close');
        let submit = document.getElementById('approval');

        // Get the confirmation modal and buttons
        let confirmationModal = document.getElementById('confirmationModal');
        let confirmYesButton = document.getElementById('confirmYes');
        let confirmNoButton = document.getElementById('confirmNo');
        // let confirmClose = document.querySelector('#confirm-close');


// Function to show the confirmation modal
        function showConfirmationModal() {
            confirmationModal.style.display = "block";
        }

// Function to hide the confirmation modal
        function hideConfirmationModal() {
            confirmationModal.style.display = "none";
        }

        function isEmptyString(str) {
            console.log(str);
            console.log(str.trim().length);
            return str.trim().length === 2;
        }

        submit.addEventListener('click', function () {

            if (Reflect.ownKeys(choiceToFields).length < targets.length) {
                errorMessage.textContent = "Es müssen alle " + targets.length + " ausgefüllt werden!";
                errorModal.style.display = "block";
                return;
            }
            if (getCookie('name') === null || isEmptyString(getCookie('name'))) {
                errorMessage.textContent = "Es muss ein Name gesetzt sein!";
                errorModal.style.display = "block";
                return;
            }
            showConfirmationModal();
        });

        // confirmClose.addEventListener('click', function () {
        //     errorModal.style.display = "none";
        // });

        // Close the modal when clicking outside of it
        window.addEventListener('click', function (event) {
            if (event.target === errorModal) {
                errorModal.style.display = "none";
            }
        });

        // Event listener for confirmation modal close button
        // modalClose.addEventListener('click', hideConfirmationModal);

        // Event listener for No button in confirmation modal
        confirmNoButton.addEventListener('click', hideConfirmationModal);

// Event listener for Yes button in confirmation modal
        confirmYesButton.addEventListener('click', function () {
            // Hide confirmation modal and proceed with form submission
            hideConfirmationModal();
            sendDataToServer();
        });


        let input = document.getElementById('name');
        fetchName();
        // Add event listener for input event
        input.addEventListener('input', function () {
            let enteredValue = input.value;
            setCookieWithObject('name', enteredValue, 365);
        });

        // swipe functionallity
        let container = document.getElementById('container');
        let pool = document.getElementById('pool');
        let targetContainer = document.getElementById('targets');
        let startX;

        function hidePool() {
            pool.classList.add('hidden');
            pool.classList.remove('visible');
            targetContainer.classList.add('visible');
            targetContainer.classList.remove('hidden');
        }

        function hideTargets() {
            pool.classList.add('visible');
            pool.classList.remove('hidden');
            targetContainer.classList.add('hidden');
            targetContainer.classList.remove('visible');
        }

        container.addEventListener('touchstart', function (e) {
            var touchobj = e.changedTouches[0];
            startX = touchobj.pageX;
        }, false);

        let tolerance = 250;
        container.addEventListener('touchend', function (e) {
            let touchobj = e.changedTouches[0];
            let distX = touchobj.pageX - startX;
            if (distX > tolerance) { // Minimum swipe distance
                hidePool();
            }
            if (distX < -1 * tolerance) { // Minimum swipe distance
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

                target.innerHTML = selectedChoice.innerHTML;
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
                    if (currentlyCheckedTarget !== null) {

                        currentlyCheckedTarget.innerHTML = choice.innerHTML;
                        currentlyCheckedTarget.classList.add('choosen');

                        choice.classList.remove('selected');
                        choice.classList.add('hidden');
                        choiceToFields[currentlyCheckedTarget.id] = choice.id;


                        setCookieWithObject('choices', choiceToFields, 365);

                        currentlyCheckedTarget = null;
                        hidePool();
                    } else {
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
                    target.innerHTML = selectedChoice.innerHTML;
                    target.classList.add('choosen');

                    selectedChoice.classList.remove('selected');
                    selectedChoice.classList.add('hidden');
                    choiceToFields[target.id] = selectedChoice.id;
                } else {
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

        function removeCookie(name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
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
            let data = {};
            data['choices'] = choiceToFields;
            data['name'] = getCookie('name');
            let jsonData = JSON.stringify(data);

            // Send data to the server using AJAX
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/esc/save', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 201) {
                        let votes = getCookie('votes');
                        if (votes === null) {
                            votes = [getCookie('name')];
                        } else {
                            votes = JSON.parse(votes);
                            votes.push(getCookie('name'));
                        }

                        setCookieWithObject('votes', votes, 365);

                        removeCookie('name');
                        removeCookie('choices');
                        document.getElementById('name').value = null;
                        location.reload();
                    }
                }
            };
            xhr.send(jsonData);
        }
    }
});
