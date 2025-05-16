import './bootstrap.js';
import {startStimulusApp} from '@symfony/stimulus-bridge';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/calendar.scss'

const app = startStimulusApp(require.context(
    './controllers', true, /\.(j|t)sx?$/
));


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉')
