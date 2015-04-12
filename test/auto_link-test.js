var test = require('tape');

var auto_link = require('../cassis').auto_link;

var noops = [
  { 
    str: 'This string definately does not have any urls in it',
    msg: 'noop on strings without links'
  }
];

test('auto_link noops', function (t) {
  t.plan(noops.length)
  noops.forEach(function (obj) {
    t.equal(auto_link(obj.str), obj.str, obj.msg)
  });
});

var links = [
  {
    str: 'this string definitely has a link to tantek.com in it',
    expect: 'this string definitely has a link to ' +
    '<a class="auto-link" href="http://tantek.com">tantek.com</a> in it',
    msg: 'auto_link simple .com links'
  },
  {
    str: 'This has a stanford.edu link',
    expect: 'This has a ' +
    '<a class="auto-link" href="http://stanford.edu">stanford.edu</a> link',
    msg: 'auto_link simple .edu links'
  },
  {
    str: 'This has a bret.io link',
    expect: 'This has a ' +
    '<a class="auto-link" href="http://bret.io">bret.io</a> link',
    msg: 'auto_link simple .io links'
  }
];

test('singleline transforms', function (t) {
  t.plan(links.length)
  links.forEach(function (obj) {
    t.equal(auto_link(obj.str), obj.expect, obj.msg)
  });
});
