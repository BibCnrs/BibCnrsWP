'use strict';

require('babel/register')({ blacklist: [ 'regenerator' ] });
// var config = require('config');
var hook = require('./hook');

exports.config = {
    framework: 'mocha',
    mochaOpts: {
        timeout: 20000
    },
    seleniumAddress: 'http://chrome:4444/wd/hub',
    baseUrl: 'http://wordpress:8080',
    specs: ['./spec/*.js'],
    beforeLaunch: hook.beforeLaunch,
    afterLaunch: hook.afterLaunch
};
