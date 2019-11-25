# webvtt
Provides classes to create valid WebVTT files.

See [WebVTT - MDN](https://developer.mozilla.org/en-US/docs/Web/API/WebVTT_API) 
for more information about WebVTT files.

## WebVttFile
Represents a simple WebVTT file object. *Does not currently support regions or chapters*.

## WebVttCue
Represents a WebVTT cue object.

Supports cue setting directives (vertical, line, position, size, align).
You should be able to include internal cue tags, such as:
* `<b></b>` - bold tag
* `<c></c>` - class tag
* `<i></i>` - italic tag
* `<u></u>` - underline tag
* `<ruby></ruby>` - ruby tag
* `<rt></rt>` - ruby text tag
* `<v></v>` - voice tag
* `<hh:mm:ss.ttt>` - timestamp tag

No validation is provided for for cue tags.

## Conversions - WebVttConverterBase
A simple converter interface and base class is included to help you build custom converter classes.

An example converter class is provided, `TtafVttConverter`, 
which converts a Timed Text Authoring Format 1.0 xml file into a valid WebVTT file.

An example cli script is also provided that will convert both single TTAF format xml files, 
as well as a directory of TTAF format xml files.