<?php
namespace Quiz\Models;
abstract class BaseModel implements \JsonSerializable
{
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
//      $this->validator = new Validator();
    }

    /** @var int */
    public $id;
    /**  @var bool */
    public $isNew = true;
    /** @var array */
    public $attributes;

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;
        foreach ($attributes as $key => $value) {
            $key = static::snakeCaseToCamelCase($key);
            if (property_exists(static::class, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Transform a snake_case string to camelCase.
     *
     * @param string $snakeCased snake_cased string
     * @return string camel cased string
     */
    public static function snakeCaseToCamelCase(string $snakeCased): string
    {
        $parts = explode('_', $snakeCased);
        $out = array_shift($parts);
        $out .= implode('', array_map(function ($part) {
            return ucfirst($part);
        }, $parts));
        return $out;
    }

    /**
     * Transform a camelCase string to snake_case.
     *
     * @param string $camelCased camel cased string
     * @return string snake cased string
     */
    public static function camelCaseToSnakeCase(string $camelCased): string
    {
        if (strlen($camelCased) < 1) {
            return '';
        }
        $parts = [];
        $len = strlen($camelCased);
        $part = $camelCased[0];
        for ($i = 1; $i < $len; $i += 1) {
            if (ctype_upper($camelCased[$i])) {
                $parts[] = $part;
                $part = strtolower($camelCased[$i]);
            } else {
                $part .= $camelCased[$i];
            }
        }
        $parts[] = $part;
        return implode('_', $parts);
    }
}