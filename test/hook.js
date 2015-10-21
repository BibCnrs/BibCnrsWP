'use strict';

import co from 'co';
import { assert } from 'chai';


// convert a generator to a function who take a callback
const coCb = function (gen) {
    return function (done) {
        co(gen).then(done, done);
    };
};

export const beforeLaunch = coCb(function* () {
    // initialize global to be available in all protractor test.
    global.assert = assert;
    global.coCb = coCb;
});

export const afterLaunch = coCb(function* () {
});
