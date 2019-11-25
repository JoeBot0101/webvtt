<?php

namespace JoeBot0101\WebVtt\Converters;

use JoeBot0101\WebVtt\WebVttFile;
use JoeBot0101\WebVtt\WebVttCue;

/**
 * Class WebVttConverterBase
 *
 * @package JoeBot0101\WebVtt
 */
class WebVttConverterBase implements WebVttConverterInterface
{

  /**
   * {@inheritdoc}
   */
    public function createWebVttFile(): WebVttFile
    {
        return new WebVttFile();
    }

  /**
   * {@inheritdoc}
   */
    public function createWebVttCue(string $begin_time, string $end_time, string $text): WebVttCue
    {
        try {
            return new WebVttCue($begin_time, $end_time, $text);
        } catch (\Exception $e) {
            throw $e;
        }
    }

  /**
   * {@inheritdoc}
   */
    public function convertToVtt(): WebVttFile
    {
        $vtt_file = null;

        try {
            $vtt_file = $this->createWebVttFile();
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        // Load your source and set the WebVttFile properties and WebVttCues
        // as desired.
        return $vtt_file;
    }
}
