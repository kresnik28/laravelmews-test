<?php

namespace App\Helpers\DataBridge;

/**
 * Class DataBridge
 * @package App\Helpers\DataBridge
 *
 * @property array $inputData
 * @property array $morphMap
 */
class DataBridge
{
    protected array $inputData;
    protected static $morphMap = [];

    /**
     * DataBridge constructor.
     * @param array $inputData
     */
    public function __construct(array $inputData = [])
    {
        $this->inputData = $inputData;
    }

    /**
     * @return array
     */
    public function morph()
    {
        $outputData = [];

        foreach ($this->inputData as $field => $value) {
            if (array_key_exists($field, $map = static::$morphMap)) {
                $outputData[$map[$field]] = $value;
            }
        }

        return $outputData;
    }

    /**
     * @param array $data
     * @return array
     */
    public static function factory(array $data)
    {
        $morphed = [];

        foreach ($data as $item) {
            $morphed[] = (new static($item))->morph();
        }

        return $morphed;
    }
}
