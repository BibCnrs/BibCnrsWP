'use strict';

describe('accueil', function () {

    it('should display accueil page', coCb(function* () {
        browser.ignoreSynchronization = true;
        yield browser.get('/');
        console.log('------console----');
        console.log(yield browser.getCurrentUrl());
        console.log(yield element(by.css('body')).getText());
        console.log('------console----');
        browser.pause();
        assert.equal(yield browser.getTitle(), 'basard');
    }));
});
