(function () {
    'use strict';

    document.onreadystatechange = function () {
        if (document.readyState === 'complete') {
            var rootElement = document.getElementById('ebsco-widget');
            var url = document.getElementById('ebsco_widget-index').getAttribute('data-url');
            if (!rootElement) {
                rootElement = document.createElement('div');
                rootElement.id = 'ebsco-widget';
                document.body.appendChild(rootElement);
            }
            var term = window.location.search.replace('?', '').split('&')
            .filter(function (p) { return p.indexOf('term=') !== -1 })
            .reduce(function(_, p) { return p.replace('term=', '') }, '');

            React.render(React.createElement(EbscoWidget, { url: url, term: term }), rootElement);
        }
    };
})(React, EbscoWidget);
