"use strict";

var widgetElement = document.getElementById('bib_header');
var scriptElement = document.getElementById('bib_header-init');
var language = scriptElement.getAttribute('data-language');
window.ReactDOM.render(window.React.createElement(window.bibcnrsWidget.BibHeader, { language: language }), widgetElement);
