<?php

namespace Ruth\HtmlBuilder;

class HtmlBuilder
{
    /**
     * Information about the root html tag.
     *
     * @var \Ruth\HtmlBuilder\HtmlElement
     */
    protected $element;

    /**
     * List of self closing html tags.
     *
     * @var array
     */
    protected $selfClosingTags = [
        'input', 'br', 'img', 'hr', 'meta',
    ];

    /**
     * Initializes the parser.
     *
     * @param HtmlElement $element
     */
    public function __construct(HtmlElement $element)
    {
        $this->element = $element;
    }

    /**
     * Compile all attributes on the HtmlElement into an string.
     *
     * @return string|null
     */
    protected function compileAttributes()
    {
        $attributes = [];

        // Every attribute is converted to a single string
        // as a key value pair in the html format key="value".
        $arr = array_walk($this->element->attributes, function ($val, $key) use (&$attributes) {
            $attributes[] = $key . '="' . implode(' ', $val) . '"';
        });

        $attributes = implode(' ', $attributes);

        return strlen($attributes) > 1 ? ' ' . $attributes : null;
    }

    /**
     * Builds the inner content for the html tag.
     *
     * @return string
     */
    protected function compileContent()
    {
        // When no child elements is defined on the object, it displays text.
        if (count($this->element->content) === 0) {
            return $this->element->text;
        }

        // Each child must be compiled into is own html string before
        // it is placed in its owner as content.
        return implode('', array_map(function ($html) {
            return $html->toHtml();
        }, $this->element->content));
    }

    /**
     * Validates is the current tag is self closing.
     *
     * @return boolean
     */
    protected function isSelfClosingTag()
    {
        return in_array($this->element->tagname, $this->selfClosingTags);
    }

    /**
     * Renders a self closing tag.
     *
     * @return string
     */
    protected function buildSelfClosingTag()
    {
        return preg_replace([
            '/element/',
            '/ props/',
        ], [
            $this->element->tagname,
            $this->compileAttributes(),
        ], '<element props />');
    }

    /**
     * Renders the final html version of the object.
     *
     * @return string
     */
    public function toHtml()
    {
        // Decides which type of tag that should be rendered.
        if ($this->isSelfClosingTag()) {
            return $this->BuildSelfClosingTag();
        }

        return preg_replace([
            '/elementStart/',
            '/ props/',
            '/content/',
            '/elementEnd/',
        ], [
            $this->element->tagname,
            $this->compileAttributes(),
            $this->compileContent(),
            $this->element->tagname,
        ], '<elementStart props>content</elementEnd>');
    }
}
