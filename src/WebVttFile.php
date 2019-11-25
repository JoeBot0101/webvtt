<?php

namespace JoeBot0101\WebVtt;

/**
 * Class WebVttFile
 *
 * Creates a WebVTT file for subtitles or captions.
 * Does not currently support chapters or regions.
 *
 * @package JoeBot0101\WebVtt
 */
class WebVttFile
{

  /**
   * The WebVTT file header
   *
   * @see https://w3c.github.io/webvtt/#file-structure
   */
    const VTT_FILE_HEADER = "WEBVTT";

  /**
   * The WebVTT comment block prefix.
   *
   * @see https://w3c.github.io/webvtt/#webvtt-comment-block
   */
    const VTT_COMMENT_PREFIX = "NOTE";

  /**
   * A WebVTT block termination.
   *
   * @see https://w3c.github.io/webvtt/#webvtt-line-terminator
   */
    const VTT_TERMINATION = PHP_EOL . PHP_EOL;

  /**
   * Optional file header text.
   *
   * @var string
   */
    private $headerText = "";

  /**
   * Optional file comment text.
   *
   * @var string
   */
    private $comment = "";

  /**
   * An array of WebVttCue objects.
   *
   * @var array
   */
    private $cues = [];

  /**
   * WebVttFile constructor.
   *
   * @param string $file
   *   Optional path to create a WebVttFile object from an existing WebVTT file.
   *
   * @throws \Exception
   */
    public function __construct(string $file = "")
    {
        if (!empty($file)) {
            $path_info = pathinfo($file);
            if ($path_info['extension'] !== 'vtt') {
                throw new \Exception('WebVttFile: file must be a vtt file');
            }

            if (!is_readable($file)) {
                throw new \Exception('WebVttFile: file is not readable');
            }

            $this->loadFromFile($file);
        }
    }

  /**
   * Getter method for optional header text.
   *
   * @return string
   *   Returns the optional header text.
   */
    public function getHeaderText(): string
    {
        return $this->headerText;
    }

  /**
   * Setter method for optional header text.
   *
   * @param string $headerText
   *   The header text.
   */
    public function setHeaderText(string $headerText): void
    {
        $this->headerText = $headerText;
    }

  /**
   * Getter method for the file comment text.
   *
   * @return string
   *   Returns the comment text.
   */
    public function getComment(): string
    {
        return $this->comment;
    }

  /**
   * Setter method for the file comment text.
   *
   * @param string $comment
   *   The comment text.
   */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

  /**
   * Getter method for the cues array.
   *
   * @return array
   *   Returns an array of WebVttCue objects.
   */
    public function getCues(): array
    {
        return $this->cues;
    }

  /**
   * Setter method for the cues array.
   *
   * @param array $cues
   *   Must be an array of WebVttCue objects
   */
    public function setCues(array $cues): void
    {
        foreach ($cues as $cue) {
            if (get_class($cue) === 'JoeBot0101\WebVtt\WebVttCue') {
                $this->cues[] = $cue;
            }
        }
    }

  /**
   * Outputs a valid WebVTT file.
   *
   * @param string $file
   *   The path to where the file should be written.
   *
   * @throws \Exception
   */
    public function toFile(string $file)
    {
        $path_info = pathinfo($file);
        if (!is_dir($path_info['dirname'])) {
            mkdir($path_info['dirname']);
        }

        if (!is_writable($path_info['dirname'])) {
            throw new \Exception('WebVttFile: path is not writable.');
        }

        file_put_contents($file, $this->toString());
    }

  /**
   * Outputs the WebVTT content as a string.
   *
   * @return string
   *   Returns a string in valid WebVTT format.
   */
    public function toString():string
    {
        $buffer = $this->formatHeader();
        $buffer .= $this->formatComment();

      /* @var WebVttCue $cue */
        foreach ($this->cues as $cue) {
            $buffer .= $cue->toString();
        }
        return $buffer;
    }

  /**
   * Formats the file header string.
   *
   * @return string
   *   Returns the formatted file header string.
   */
    private function formatHeader()
    {
        $buffer = self::VTT_FILE_HEADER;

        if (!empty($this->getHeaderText())) {
            $buffer .= ' - ' . $this->getHeaderText();
        }

        return $buffer . self::VTT_TERMINATION;
    }

  /**
   * Formats the file comment string.
   *
   * @return string
   *   Returns the formatted file comment string.
   */
    private function formatComment()
    {
        $buffer = '';
        if (!empty($this->getComment())) {
            $buffer = self::VTT_COMMENT_PREFIX;
            $buffer .= ' ' . $this->comment;
            $buffer .= self::VTT_TERMINATION;
        }
        return $buffer;
    }

  /**
   * Loads the WebVttFile object from an existing WebVTT file.
   *
   * @param string $file
   *   The path to a valid WebVTT file.
   */
    private function loadFromFile(string $file)
    {
      // TODO
    }
}
