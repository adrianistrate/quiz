/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import 'bootstrap/scss/bootstrap.scss';
import 'bootstrap-table/dist/bootstrap-table.css';

import 'bootstrap-table';

import 'bootstrap';
import SurveyStats from "./Components/SurveyStats";

let surveyStats = new SurveyStats();