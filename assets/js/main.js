"use strict";

import fadeMenu from "./modules/fadeMenu.js";
import steps from "./modules/steps.js";
import progress from "./modules/progressLine.js";
import questions from "./modules/questions.js";
import hamberger from "./modules/hamberger.js";
import calculator from "./modules/calculator.js";
/* import showOffersAll from './modules/showOffers'; */
import analyticsEvents from "./modules/analyticsEvents.js";
/* import popUp from './modules/popUp.js'; */
import lang from "./modules/pageLang";
import duplicateLinks from "./modules/duplicateLinks";
import offerInfo from "./modules/offerInfo.js";
/* import createPromo from './modules/createPromo.js';
import openPromo from './modules/openPromo.js'; */
import categoryArrow from "./modules/categoryArrow.js";
import sidebarMessage from "./modules/sidebarMessage.js";

fadeMenu();
steps();
progress();
questions();
hamberger();
calculator();
/* showOffersAll(); */
analyticsEvents();
lang();
duplicateLinks();
offerInfo();
categoryArrow();
/* createPromo();
openPromo(); */
sidebarMessage();
