var test = require('tape');

var auto_link = require('../cassis').auto_link;

var tests = require('../test-data/auto_link.json');

test('auto_link', function (t) {
  t.plan(tests.length)
  tests.forEach(function (obj) {
    t.equal(auto_link(obj.str), obj.expect, obj.msg)
  });
});
