var test = require('tape');

var cassis = require('../cassis');

var num_to_sxg_tests = require('../test-data/num_to_sxg.json');
var sxg_to_num_tests = require('../test-data/sxg_to_num.json');

console.log(cassis);

test('num_to_sxg', function (t) {
  t.plan(num_to_sxg_tests.length)
  num_to_sxg_tests.forEach(function (obj) {
    t.equal(""+cassis.num_to_sxg(obj.str), obj.expect, obj.msg)
  });
});

test('sxg_to_num', function (t) {
  t.plan(sxg_to_num_tests.length)
  sxg_to_num_tests.forEach(function (obj) {
    t.equal(""+cassis.sxg_to_num(obj.str), obj.expect, obj.msg)
  });
});
