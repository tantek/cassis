<?php
class AutoLinkTest extends PHPUnit_Framework_TestCase {

  /**
   * @dataProvider linkProvider
   */
  public function testAutoLink($expected, $input) {
    $this->assertEquals($expected, auto_link($input));
  }

  public function linkProvider() {
    $tests = json_decode(file_get_contents(dirname(__FILE__).'/../test-data/auto_link.json'));
    return array_map(function($test){
      return [$test->expect, $test->str];
    }, $tests);
  }

}
