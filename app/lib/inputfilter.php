<?php
namespace MVC\LIB;

trait InputFilter
{
    public function FilterInt($input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }
    public function FilterFloat($input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    public function FilterString($input)
    {
        return htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
    public function FilterEmail($input)
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }
}
