import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/admin.scss'
import {Modal} from "./scripts/components/Modal";

document.querySelectorAll('.delivery-date')
    .forEach(element => {
            let html = element.innerHTML;

// use a regex to match all 'link=' followed by one or more non-whitespace characters (\S+)
// and then a comma and space, followed by the rest of the line (.*)
            let regex = /link=(\S+)\,\s+(.*)/g;

            html = html.replace(regex, function (match, url, text) { // url and text are the capturing groups
                return `<a href="${url}">${text}</a>`;
            });

            element.innerHTML = html;
        }
    );

// Function to increment date by one day
function getNextDay(dateString) {
    let date = new Date(dateString);
    date.setDate(date.getDate() + 1);
    let options = { month: "short", day: "numeric", year: "numeric" };
    return date.toLocaleDateString("en-US", options);  // Returns date in the format Mon DD YYYY
}

// Select all the elements
let elements = Array.from(document.querySelectorAll('.delivery-date'));

// Iterate the elements
for (let i = 0; i < elements.length - 1; i++) {
    let currentDate = new Date(elements[i].innerText.trim());
    let nextElementDate = new Date(elements[i + 1].innerText.trim());

    // If the next expected date is not the date of the next element,
    // highlight the current date's element
    if (getNextDay(currentDate.toString()) !== nextElementDate.toLocaleDateString("en-US", {month:"short", day:"numeric", year:"numeric"})) {
        elements[i].style.backgroundColor = '#970000';
    }
}