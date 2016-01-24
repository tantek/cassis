<?php
class EllipsizeTest extends PHPUnit_Framework_TestCase {

  private function ellipsize($text, $max) {
    ob_start(); // ellipsize_to_word seems to output some JS when called directly
    $short = ellipsize_to_word($text, $max, '...', 10);
    ob_end_clean();
    return $short;
  }

  public function testTextIsAlreadyShort() {
    $this->assertEquals('short', $this->ellipsize('short', 100));
  }

  public function testEllipsizeLongSentence() {
    $this->assertEquals('this sentence is too long and should be ...',
      $this->ellipsize('this sentence is too long and should be truncated at "be"', 43));
  }

  public function testRemoveUrlIfWouldBeTrimmed() {
    $this->assertEquals('this sentence contains a URL ...',
      $this->ellipsize('this sentence contains a URL http://example.com', 40));
  }

  /*
  // This is supposed to test the part marked "if char before ellipsis would be sentence terminator, trim 2 more"
  // but can't seem to figure out how to hit that case.
  public function testTrimSentenceTerminator() {
    $this->assertEquals('This sentence ends with a period where the ellipses would go.',
      $this->ellipsize('This sentence ends with a period where the ellipses would go. There is another sentence after.', 61));
  }
  */

}
