<?php

namespace Ruth\HtmlBuilder;

class Html
{
    /**
     * Dynamically initiates an html tag with any information about the tag itself.
     *
     * @param string $method
     * @param array $arguments
     * @return void
     */
    public static function __callStatic($method, $arguments)
    {
        return (new HtmlElement)->{$method}(...$arguments);
    }
}
