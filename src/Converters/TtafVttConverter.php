<?php

namespace JoeBot0101\WebVtt\Converters;

use JoeBot0101\WebVtt\WebVttFile;

/**
 * Class TtafVttConverter
 *
 * This class presents an example of how to use WebVttFile and WebVttCue
 * objects to create a valid WebVTT file from an XML source. If your source
 * is a different file type or format, use this as a guide to create your
 * own converter class.
 */
class TtafVttConverter extends WebVttConverterBase implements WebVttConverterInterface
{

    /**
     * The path to the xml file.
     *
     * @var string
     */
    private $xmlFile;

    /**
     * XmlVttConverter constructor.
     *
     * @param string $xml_file
     *   The path to the xml file.
     *
     * @throws \Exception
     */
    public function __construct(string $xml_file)
    {
        if (!is_readable($xml_file)) {
            throw new \Exception('XML file is not readable.');
        }
        $this->xmlFile = $xml_file;
    }

    /**
     * Converts an old xml timed text captions file into a WebVttFile object.
     *
     * Format is assumed to be
     * <tt xmlns="http://www.w3c.org/2006/10/ttaf1">
     *   <body>
     *     <div>
     *       <p begin="hh:mm:ss.ttt" end="hh:mm:ss.ttt">Cue text</p>
     *       ...
     *     </div>
     *   </body>
     * </tt>
     *
     * @return WebVttFile
     *   Returns a WebVttFile object.
     *
     * @throws \Exception
     */
    public function convertToVtt(): WebVttFile
    {
        $vtt_file = $this->createWebVttFile();

        $xml = null;
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($this->xmlFile);
        if (!$xml) {
            $errors = var_export(libxml_get_errors(), true);
            throw new \Exception('Invalid XML: ' . $errors);
        }

        $vtt_cues = [];
        $i = 0;
        foreach ($xml->body->div->p as $xml_cue) {
            $begin = $this->formatCueTime((string)$xml_cue['begin']);
            $end = $this->formatCueTime((string)$xml_cue['end']);
            $text = (string)$xml_cue;

            $cue = null;
            try {
                $cue = $this->createWebVttCue($begin, $end, $text);
            } catch (\Exception $e) {
                echo 'File: ' . $this->xmlFile . ' - ' . $e->getMessage() . PHP_EOL;
                $i++;
                continue;
            }
            $cue_id = $i + 1;
            $cue->setId($cue_id);

            $vtt_cues[] = $cue;
            $i++;
        }

        $vtt_file->setCues($vtt_cues);
        return $vtt_file;
    }

  /**
   * @param string $cue_time
   *
   * @return string
   * @throws \Exception
   */
    private function formatCueTime(string $cue_time): string
    {
      // Convert commas to dots
        $cue_time = str_replace(',', '.', $cue_time);
        $parsed_time = explode(':', $cue_time);
        $parsed_time = array_reverse($parsed_time);

        if (count($parsed_time) < 2) {
            throw new \Exception('Invalid cue time format. Must at least be mm:ss');
        }

      // Seconds & milliseconds
        $seconds = explode('.', $parsed_time[0]);
        $seconds[0] = str_pad($seconds[0], 2, '0', STR_PAD_LEFT);
        if (count($seconds) < 2) {
          //no milliseconds in source, add 000
            $seconds[] = '000';
        } else {
            $seconds[1] = str_pad($seconds[1], 3, '0');
        }

      // Minutes
        $minutes = $parsed_time[1];
        $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

      // Hours
        if (isset($parsed_time[2])) {
            $hours = $parsed_time[2];
            $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
        } else {
            $hours = '00';
        }

        $cue_time = $hours . ':' . $minutes . ':' . $seconds[0] . '.' . $seconds[1];
        return $cue_time;
    }
}
