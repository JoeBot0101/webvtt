<?php

namespace JoeBot0101\WebVtt;

/**
 * Class WebVttCue
 *
 * Creates an individual cue for a WebVTT file.
 *
 * @package JoeBot0101\WebVtt
 */
class WebVttCue
{

  /**
   *  Regex for testing the correct format for a cue time.
   */
    const VTT_TIME_REGEX = '/^\d{2,4}\:\d{2}\:\d{2}\.\d{3}$/';

  /**
   * A WebVTT block termination.
   *
   * @see https://w3c.github.io/webvtt/#webvtt-line-terminator
   */
    const VTT_TERMINATION = PHP_EOL . PHP_EOL;

  /**
   * The cue identifier.
   *
   * @var string
   */
    private $id = "";

  /**
   * The cue start time, formatted as `hh:mm:ss.ttt`.
   *
   * @var string
   */
    private $startTime = "";

  /**
   * The cue end time, formatted as `hh:mm:ss.ttt`.
   *
   * @var string
   */
    private $endTime = "";

  /**
   * The cue text.
   *
   * @var string
   */
    private $text = "";

  /**
   * The vertical cue setting value.
   *
   * @var string
   */
    private $vertical = "";

  /**
   * The line cue setting value.
   *
   * @var string
   */
    private $line = "";

  /**
   * The position cue setting value.
   *
   * @var string
   */
    private $position = "";

  /**
   * The size cue setting value.
   *
   * @var string
   */
    private $size = "";

  /**
   * The align cue setting value.
   *
   * @var string
   */
    private $align = "";

  /**
   * WebVttCue constructor.
   *
   * @param string $start_time
   *   The start time of the cue. Must be formatted as `hh:mm:ss.ttt`.
   * @param string $end_time
   *   The end time of the cue. Must be formatted as `hh:mm:ss.ttt`.
   * @param string $text
   *   The text of the cue.
   *
   * @throws \Exception
   */
    public function __construct(string $start_time, string $end_time, string $text)
    {
        try {
            $this->setStartTime($start_time);
            $this->setEndTime($end_time);
            $this->setText($text);
        } catch (\Exception $e) {
            throw $e;
        }
    }

  /**
   * Getter method for the cue id.
   *
   * @return string
   *   Returns the cue id string.
   */
    public function getId(): string
    {
        return $this->id;
    }

  /**
   * Setter method for the cue id.
   *
   * @param string $id
   *   The cue id string.
   */
    public function setId(string $id): void
    {
        $this->id = trim($id);
    }

  /**
   * Getter method for the cue start time.
   *
   * @return string
   *   Returns the cue start time string formatted as `hh:mm:ss.ttt`.
   */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

  /**
   * Setter method for the cue start time.
   *
   * @param string $startTime
   *   The cue start time formatted as `hh:mm:ss.ttt`.
   *
   * @throws \Exception
   */
    public function setStartTime(string $startTime): void
    {
        $startTime = trim($startTime);
        if (preg_match(self::VTT_TIME_REGEX, $startTime) === 1) {
            $this->startTime = $startTime;
        } else {
            throw new \Exception('WebVttCue: time must be given in the `hh:mm:ss.ttt` format');
        }
    }

  /**
   * Getter method for the cue end time.
   *
   * @return string
   *   Returns the cue end time string formatted as `hh:mm:ss.ttt`.
   */
    public function getEndTime(): string
    {
        return $this->endTime;
    }

  /**
   * Setter method for the cue end time.
   *
   * @param string $endTime
   *   The cue end time formatted as `hh:mm:ss.ttt`.
   *
   * @throws \Exception
   */
    public function setEndTime(string $endTime): void
    {
        $endTime = trim($endTime);
        if (preg_match(self::VTT_TIME_REGEX, $endTime) === 1) {
            $this->endTime = $endTime;
        } else {
            throw new \Exception('WebVttCue: time must be given in the `hh:mm:ss.ttt` format');
        }
    }

  /**
   * Getter method for the cue text.
   *
   * @return string
   *   Returns the cue text string.
   */
    public function getText(): string
    {
        return $this->text;
    }

  /**
   * Setter method for the cue text.
   *
   * @param string $text
   *   The cue text string. Must not contain blank lines.
   *   You can include the following cue text tags (unvalidated):
   *     <b></b> - bold tag
   *     <c></c> - class tag
   *     <i></i> - italic tag
   *     <u></u> - underline tag
   *     <ruby></ruby> - ruby tag
   *     <rt></rt> - ruby text tag
   *     <v></v> - voice tag
   *     <hh:mm:ss.ttt> - timestamp tag
   *
   * @throws \Exception
   */
    public function setText(string $text): void
    {
        // Remove tags, carriage returns, line feeds.
        $text = trim($text);
        $text = str_replace(["\t","\r","\n"], '', $text);
        $this->text = $text;
    }

  /**
   * Getter method for the vertical cue setting.
   *
   * @return string
   *   Returns the vertical cue setting.
   *
   */
    public function getVertical(): string
    {
        return $this->vertical;
    }

  /**
   * Setter method for the vertical cue setting.
   *
   * Indicates that the text will be displayed
   * vertically rather than horizontally.
   *
   * Valid values:
   *   rl - writing direction is right to left
   *   lr - writing direction is left to right
   *
   * @param string $vertical
   *   The vertical cue setting.
   *
   * @throws \Exception
   */
    public function setVertical(string $vertical): void
    {
        $vertical = trim($vertical);
        if (!empty($vertical)) {
            switch ($vertical) {
                case 'rl':
                case 'lr':
                    $this->vertical = $vertical;
                    break;
                default:
                    throw new \Exception('WebVttCue: vertical setting must be `rl` or `lr`');
            }
        }
    }

  /**
   * Getter method for the line cue setting.
   *
   * @return string
   *   Returns the line cue setting.
   *
   */
    public function getLine(): string
    {
        return $this->line;
    }

  /**
   * Setter method for the line cue setting.
   *
   * Specifies where text appears vertically. If vertical is set,
   * line specifies where text appears horizontally.
   *
   * Value can be a line number:
   *   Positive indicates top down.
   *   Negative indicates bottom up.
   *   line:0 == top | line:-1 == bottom
   *
   *   If vertical:rl
   *   line:0 == right | line:-1 == left
   *
   *   If vertical:lr
   *   line:0 == left | line:-1 == right
   *
   * Value can be a percentage:
   *   Must be an integer between 0 and 100 inclusive, followed by `%`.
   *   line:0% == top | line:100% == bottom
   *
   *   If vertical:rl
   *   line:0% == right | line:100% == left
   *
   *   If vertical:lr
   *   line:0% == left | line:100% == right
   *
   * You can also add an optional alignment value:
   *   Can be `start`, `center`, or `end.
   *
   * Full example line setting:
   * line:0,center
   * line:100%,start
   *
   * @param string $line
   *   The line cue setting.
   * @param string $alignment
   *   The line alignment keyword.
   *
   * @throws \Exception
   */
    public function setLine(string $line, string $alignment = ""): void
    {
        if (!is_numeric($line) && strpos($line, '%') === false) {
            throw new \Exception(
                'WebVttCue: line setting must be a positive or negative 
              integer, or a string percentage value between 0 and 100 followed 
              by a `%`'
            );
        }
        $setting = $line;

        $alignment = trim($alignment);
        if (!empty($alignment)) {
            switch ($alignment) {
                case 'start':
                case 'center':
                case 'end':
                    $setting .= ',' . $alignment;
                    break;
                default:
                    throw new \Exception(
                        'WebVttCue: line alignment setting must be 
                      `start`, `center`, or `end`'
                    );
            }
        }

        $this->line = $setting;
    }

  /**
   * Getter method for the position cue setting.
   *
   * @return string
   *   Returns the position cue setting.
   *
   */
    public function getPosition(): string
    {
        return $this->position;
    }

  /**
   * Setter method for the position cue setting.
   *
   * Specifies where the text will appear horizontally. If vertical is set,
   * specifies where the text will appear vertically.
   *
   * Value is a percentage:
   *   Must be an integer between 0 and 100 inclusive, followed by a `%`.
   *   position:0% == left | position:100% == right
   *
   *   If vertical:rl
   *   position:0% == top | position:100% == bottom
   *
   *   If vertical:lr
   *   position:0% == bottom | position:100% == top
   *
   * You can also add an optional alignment value:
   *   Can be `line-left`, `center`, `line-right`
   *
   * Full example position setting:
   * position:0%,line-left
   *
   * @param string $position
   *   The position cue setting.
   * @param string $alignment
   *   The position alignment keyword.
   *
   * @throws \Exception
   */
    public function setPosition(string $position, string $alignment = ""): void
    {
        $position = trim($position);
        $alignment = trim($alignment);

        if (strpos($position, '%') === false) {
            throw new \Exception('WebVttCue: position setting must be a value between 0 and 100 followed by a `%`');
        }
        $setting = $position;

        if (!empty($alignment)) {
            switch ($alignment) {
                case 'line-left':
                case 'center':
                case 'line-right':
                    $setting .= ',' . $alignment;
                    break;
                default:
                    throw new \Exception(
                        'WebVttCue: position alignment setting must be 
                      `line-left`, `center`, or `line-right`'
                    );
            }
        }

        $this->position = $setting;
    }

  /**
   * Getter method for the size cue setting.
   *
   * @return string
   *   Returns the size cue setting.
   *
   */
    public function getSize(): string
    {
        return $this->size;
    }

  /**
   * Setter method for the size cue setting.
   *
   * Specifies the width of the text area. If vertical is set,
   * specifies the height of the text area.
   *
   * Value is a percentage:
   *   Must be an integer between 0 and 100 inclusive, followed by a `%`.
   *   size:100% == full width | size:50% == half width
   *
   *   If vertical:rl or vertical:lr
   *   size:100% == full height | size: 50% == half height
   *
   * @param string $size
   *   The size cue setting.
   *
   * @throws \Exception
   */
    public function setSize(string $size): void
    {
        $size = trim($size);
        if (strpos($size, '%') === false) {
            throw new \Exception('WebVttCue: size setting must be a value between 0 and 100 followed by a `%`');
        }
        $this->size = $size;
    }

  /**
   * Getter method for the align cue setting.
   *
   * @return string
   *   Returns the align cue setting.
   *
   */
    public function getAlign(): string
    {
        return $this->align;
    }

  /**
   * Setter method for the align cue setting.
   *
   * Specifies the alignment of the text. Text is aligned within the space
   * given by the size setting if it is set.
   *
   * align:start == left
   * align:center == centered horizontally
   * align:end == right
   * align:left == left
   * align:right == right
   *
   * If vertical:rl or vertical:lr
   * align:start == top
   * align:center == centered vertically
   * align:end == bottom
   * @param string $align
   *   The align cue setting.
   *
   * @throws \Exception
   */
    public function setAlign(string $align): void
    {
        $align = trim($align);
        switch ($align) {
            case 'start':
            case 'center':
            case 'end':
            case 'left':
            case 'right':
                $this->align = $align;
                break;
            default:
                throw new \Exception('WebVttCue: align setting must be `start`, `center`, `end`, `left`, or `right`');
        }
    }

  /**
   * Outputs the cue as a string.
   *
   * @return string
   *   Returns a string in valid WebVTT format.
   */
    public function toString()
    {
        $buffer = $this->formatCueId();
        $buffer .= $this->formatCueTiming();
        $buffer .= $this->formatCuePayload();
        return $buffer;
    }

  /**
   * Formats the cue id string.
   *
   * @return string
   *   Returns the formatted cue id string.
   */
    private function formatCueId(): string
    {
        return $this->getId() . PHP_EOL;
    }

  /**
   * Formats the cue timing string.
   *
   * @return string
   *   Returns the formatted cue timing string.
   */
    private function formatCueTiming():string
    {
        $buffer = $this->getStartTime();
        $buffer .= ' --> ';
        $buffer .= $this->getEndTime();

        $buffer .= $this->formatCueSetting();
        $buffer .= PHP_EOL;
        return $buffer;
    }

  /**
   * Formats the cue setting string.
   *
   * @return string
   *   Returns the formatted cue setting string.
   */
    private function formatCueSetting():string
    {
        $buffer = '';

        if (!empty($this->getVertical())) {
            $buffer .= ' vertical:' . $this->getVertical();
        }

        if (!empty($this->getLine())) {
            $buffer .= ' line:' . $this->getLine();
        }

        if (!empty($this->getPosition())) {
            $buffer .= ' position:' . $this->getPosition();
        }

        if (!empty($this->getSize())) {
            $buffer .= ' size:' . $this->getSize();
        }

        if (!empty($this->getAlign())) {
            $buffer .= ' align:' . $this->getAlign();
        }

        return $buffer;
    }

  /**
   * Formats the cue payload string.
   *
   * @return string
   *   Returns the formatted cue payload string.
   */
    private function formatCuePayload():string
    {
        return $this->getText() . self::VTT_TERMINATION;
    }
}
