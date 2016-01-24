<?php
// A few tests to make sure the post-processing actually stopped the source from outputting content
class PostProcessTest extends PHPUnit_Framework_TestCase {

  public function testEllipsize() {
    ob_start();
    $short = ellipsize_to_word('some text', 40, '...', 10);
    $result = ob_get_clean();
    $this->assertEquals('', $result);
  }

  public function testBase60() {
    ob_start();
    num_to_sxg(503194);
    $result = ob_get_clean();
    $this->assertEquals('', $result);
  }

}
