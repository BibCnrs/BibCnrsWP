"use strict";

console.log('im loaded');
// document.onreadystatechange = function () {
console.log('onreadystatechange');
    // if (document.readyState === 'complete') {
        var widgetElement = document.getElementById('BibHeader');
        window.ReactDOM.render(window.React.createElement(window.bibcnrsWidget.BibHeader), widgetElement);
    // }
// };
