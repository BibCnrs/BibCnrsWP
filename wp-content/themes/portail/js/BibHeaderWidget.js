"use strict";

document.onreadystatechange = function () {
    if (document.readyState === 'complete') {
        var widgetElement = document.getElementById('BibHeader');
        window.ReactDOM.render(window.React.createElement(window.bibcnrsWidget.BibHeader), headerElement);
    }
};
