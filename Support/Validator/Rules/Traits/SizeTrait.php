<?php
namespace Support\Validator\Rules\Traits;

use Exception\ValidationException;

trait SizeTrait
{
    protected function getValueSize($value)
    {
        if (is_int($value) || is_float($value)) {
            return (float) $value;
        } elseif (is_string($value)) {
            return (float) mb_strlen($value, 'UTF-8');
        } elseif ($this->isUploadedFileValue($value)) {
            return (float) $value['size'];
        } elseif (is_array($value)) {
            return (float) count($value);
        } else {
            return false;
        }
    }

    protected function getBytesSize($size)
    {
        if (is_numeric($size)) {
            return (float) $size;
        }
        if (!is_string($size)) {
            throw new ValidationException("Size must be string or numeric Bytes");
        }
        if (!preg_match("/^(?<number>((\d+)?\.)?\d+)(?<format>(B|K|M|G|T|P)B?)?$/i", $size, $match)) {
            throw new ValidationException("Size is not valid format");
        }
        $number = (float) $match['number'];
        $format = isset($match['format']) ? $match['format'] : '';
        switch (strtoupper($format)) {
            case "KB":
            case "K":
                return $number * 1024;
            case "MB":
            case "M":
                return $number * pow(1024, 2);
            case "GB":
            case "G":
                return $number * pow(1024, 3);
            case "TB":
            case "T":
                return $number * pow(1024, 4);
            case "PB":
            case "P":
                return $number * pow(1024, 5);
            default:
                return $number;
        }
    }
}
