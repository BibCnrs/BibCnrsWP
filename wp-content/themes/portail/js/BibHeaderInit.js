"use strict";

var widgetElement = document.getElementById('BibHeader');
var language = widgetElement.getAttribute('data-language');
window.ReactDOM.render(window.React.createElement(window.bibcnrsWidget.BibHeader, {language: language}), widgetElement);
