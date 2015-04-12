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
    str: 'this string definately has a link.com in it',
    expect: 'this string definately has a ' +
    '<a class="auto-link" href="http://link.com">link.com</a> in it',
    msg: 'auto_link simple .com links'
  },
  {
    str: 'This has an academic.edu link',
    expect: 'This has an ' +
    '<a class="auto-link" href="http://academic.edu">academic.edu</a> link',
    msg: 'auto_link simple .edu links'
  },
  {
    str: 'This has an nerd.io link',
    expect: 'This has an ' +
    '<a class="auto-link" href="http://nerd.io">nerd.io</a> link',
    msg: 'auto_link simple .io links'
  }
];

test('singleline transforms', function (t) {
  t.plan(links.length)
  links.forEach(function (obj) {
    t.equal(auto_link(obj.str), obj.expect, obj.msg)
  });
});
