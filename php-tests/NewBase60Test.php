<?php
class NewBase60Test extends PHPUnit_Framework_TestCase {

  /**
   * @dataProvider toSxgDataProvider
   */
  public function testNumToSxg($expected, $input) {
    $this->assertEquals($expected, num_to_sxg($input));
  }

  public function toSxgDataProvider() {
    $tests = json_decode(file_get_contents(dirname(__FILE__).'/../test-data/num_to_sxg.json'));
    return array_map(function($test){
      return [$test->expect, $test->str];
    }, $tests);
  }

  /**
   * @dataProvider toNumDataProvider
   */
  public function testSxgToNum($expected, $input) {
    $this->assertEquals($expected, sxg_to_num($input));
  }

  public function toNumDataProvider() {
    $tests = json_decode(file_get_contents(dirname(__FILE__).'/../test-data/sxg_to_num.json'));
    return array_map(function($test){
      return [$test->expect, $test->str];
    }, $tests);
  }

}
