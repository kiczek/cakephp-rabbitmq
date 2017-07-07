<?php
namespace RabbitMQ\Helper;

/**
 * Helper class to convert input time into user-friendly time format
 */
class MeaningfulTime
{
    /**
     * Return time in user-friendly time format
     *
     * @param  int    $time
     * @param  string $type
     * @return string
     */
    public function __invoke(int $time, string $type)
    {
        switch ($type) {
            case 'min':
                return $this->_parseMinute($time);
            case 's':
                return $this->_parseSecond($time);
            case 'ms':
                return $this->_parseMillisecond($time);
            default:
                throw new \InvalidArgumentException('Unsupport type of input time: ' . $type);
        }
    }

    /**
     * Parse millisecond
     *
     * @param  int $ms
     * @return string
     */
    protected function _parseMillisecond(int $ms)
    {
        if ($ms < 1000) {
            return sprintf('%d ms', $ms);
        }
        
        $s = floor($ms / 1000);
        $ms = $ms % 1000;
        
        if ($ms == 0) {
            return $this->_parseSecond($s);
        } else {
            return $this->_parseSecond($s) . sprintf(', %d ms', $ms);
        }
    }

    /**
     * Parse second
     *
     * @param  int $s
     * @return string
     */
    protected function _parseSecond($s)
    {
        if ($s < 60) {
            return sprintf('%d s', $s);
        }
        
        $min = floor($s / 60);
        $s = $s % 60;
        
        if ($s == 0) {
            return $this->_parseMinute($min);
        } else {
            return $this->_parseMinute($min) . sprintf(', %d s', $s);
        }
    }

    /**
     * Parse minute
     *
     * @param  int $min
     * @return string
     */
    protected function _parseMinute($min)
    {
        if ($min < 60) {
            if ($min == 1) {
                return sprintf('%d min', $min);
            } else {
                return sprintf('%d mins', $min);
            }
        }
        
        $hr = floor($min / 60);
        $min = $min % 60;
        
        if ($min == 0) {
            return $this->_parseHour($hr);
        } else {
            if ($min == 1) {
                return $this->_parseHour($hr) . sprintf(', %d min', $min);
            } else {
                return $this->_parseHour($hr) . sprintf(', %d mins', $min);
            }
        }
    }

    /**
     * Parse hour
     *
     * @param  int $hr
     * @return string
     */
    protected function _parseHour($hr)
    {
        if ($hr == 1) {
            return sprintf('%d hr', $hr);
        } else {
            return sprintf('%d hrs', $hr);
        }
    }
}
