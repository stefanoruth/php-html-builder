<?php

namespace Ruth\HtmlBuilder;

use Closure;

class HtmlElement
{
    /**
     * Html element tagname.
     *
     * @var string
     */
    public $tagname = 'div';

    /**
     * Raw text content for the html tag.
     *
     * @var string
     */
    public $text;

    /**
     * Contains all child elements an element would have.
     *
     * @var array
     */
    public $content = [];

    /**
     * Defines which attributes the element should have.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Sets the tagname of the html element.
     *
     * @param string $name
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function tag($name)
    {
        $this->tagname = $name;

        return $this;
    }

    /**
     * Sets the text string content for an html element.
     *
     * @param string $value
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function text($value)
    {
        $this->text = $value;

        return $this;
    }

    /**
     * Sets the specified html attribute and value for the tag.
     *
     * @param string $key
     * @param mixed $value
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = is_array($value) ? $value : [$value];

        return $this;
    }

    /**
     * Easy assessor for setting the html class.
     *
     * @param string
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function class($value)
    {
        return $this->setAttribute('class', $value);
    }

    /**
     * Easy assessor for making an input required.
     *
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function required()
    {
        return $this->setAttribute('required', 'required');
    }

    /**
     * Allows the object to dynamically set attributes on the html tag
     *
     * @param string $method
     * @param array $args
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function __call($method, $args)
    {
        $this->setAttribute($method, $args);

        return $this;
    }

    /**
     * Adds a child html tag to the object.
     *
     * @param \Ruth\HtmlBuilder\HtmlElement $element
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function addChild(HtmlElement $element)
    {
        $this->content[] = $element;

        return $this;
    }

    /**
     * Adds an array of html elements as the tags value.
     *
     * @param array $elements
     * @return \Ruth\HtmlBuilder\HtmlElement
     */
    public function setChildren(array $elements)
    {
        $this->content = $elements;

        return $this;
    }

    /**
     * Converts the object it self to html.
     *
     * @return string
     */
    public function toHtml()
    {
        return (new HtmlBuilder($this))->toHtml();
    }

    /**
     * Implements the option to cast the object as a string.½
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
