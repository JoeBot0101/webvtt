<?php

namespace JoeBot0101\WebVtt\Converters;

use JoeBot0101\WebVtt\WebVttFile;
use JoeBot0101\WebVtt\WebVttCue;

/**
 * Interface WebVttConverterInterface
 *
 * @package JoeBot0101\WebVtt
 */
interface WebVttConverterInterface
{

  /**
   * Creates a WebVttFile object.
   *
   * @return \JoeBot0101\WebVtt\WebVttFile
   *   The WebVttFile object.
   *
   * @throws \Exception
   */
    public function createWebVttFile():WebVttFile;

  /**
   * Creates a WebVttCue object.
   *
   * @param string $begin_time
   *   The begin time for the cue.
   * @param string $end_time
   *   The end time for the cue.
   * @param string $text
   *   The text payload for the cue.
   *
   * @return \JoeBot0101\WebVtt\WebVttCue
   *   The WebVttCue object.
   *
   * @throws \Exception
   */
    public function createWebVttCue(string $begin_time, string $end_time, string $text):WebVttCue;

  /**
   * Converts source data into a WebVttFile object.
   *
   * @return \JoeBot0101\WebVtt\WebVttFile
   *   The WebVttFile object.
   */
    public function convertToVtt():WebVttFile;
}
