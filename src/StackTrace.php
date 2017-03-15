<?php

namespace Gohanman\StackTrace;

class StackTrace
{
    /**
      Format string used to stringify stack frames.
      Allow placeholders:
      %frame => frame number
      %filename => file name including path 
      %basename => file name excluding path
      %line => line number
      %function => name of function, including class if applicable
    */
    private $format = "Frame #%frame, File %basename, Line %line, %function\n";

    /**
      Number of frames to include in output
      The call to StackTrace->output itself is automatically excluded
    */
    private $limit = 0;

    /**
      Set a format (see above)
      @param [string] $format
      @return self
    */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
      Set a frame limit (see above)
      @param [integer] $limit
      @return self
    */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
      Output current stack as string
      @return [string] formatted, depth-limited stack trace
    */
    public function output()
    {
        $stack = debug_backtrace();
        array_shift($stack);
        $ret = '';
        for ($i=0; $i<count($stack); $i++) {
            if ($i+1 > $this->limit) {
                break;
            }
            $frame = $stack[$i];
            $filename = isset($frame['file']) ? $frame['file'] : 'unknown file?';
            $line = isset($frame['line']) ? $frame['line'] : 'unknown line?';
            $ret .= $this->formatLine($i+1, $filename, $line, $this->funcName($frame));
        }

        return $ret;
    }

    /**
      Replace placeholders in stack frame format
      @param [integer] $frameID current stack depth
      @param [string] $filename
      @param [integer] $lineNumber
      @param [string] $function
    */
    private function formatLine($frameID, $filename, $lineNumber, $function)
    {
        $line = $this->format;
        $line = preg_replace('/%frame/', $frameID, $line);
        $line = preg_replace('/%filename/', $filename, $line);
        $line = preg_replace('/%basename/', basename($filename), $line);
        $line = preg_replace('/%line/', $lineNumber, $line);
        $line = preg_replace('/%function/', $function, $line);

        return $line;
    }

    /**
      Format function name from stack frame
      adding on class name and static/non indicator
      @param [array] $frame
      @return [string] formatted name
    */
    private function funcName(array $frame)
    {
        $func = isset($frame['function']) ? $frame['function'] : 'unknown function?';
        $divider = isset($frame['type']) ? $frame['type'] : '::';
        if (isset($frame['class'])) {
            $func = $frame['class'] . $divider . $func;
        }

        return $func;
    }
}

