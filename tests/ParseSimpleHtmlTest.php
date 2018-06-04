<?php

namespace Ruth\HtmlBuilder\Tests;

use PHPUnit\Framework\TestCase;
use Ruth\HtmlBuilder\Html;
use Ruth\HtmlBuilder\HtmlElement;

class ParseSimpleHtmlTest extends TestCase
{
    public function test_it_build_a_simple_element()
    {
        $this->assertSame('<div></div>', Html::tag('div')->toHtml());
        $this->assertSame('<div>Foo</div>', Html::tag('div')->text('Foo')->toHtml());
        $this->assertSame('<div class="bar">Foo</div>', Html::tag('div')->text('Foo')->class('bar')->toHtml());
    }

    public function test_it_can_nest_elements()
    {
        $this->assertSame(
            '<div><div></div></div>',
            Html::tag('div')
                ->addChild(Html::tag('div'))
                ->toHtml()
        );

        $this->assertSame(
            '<div><div></div><div></div></div>',
            Html::tag('div')
                ->addChild(Html::tag('div'))
                ->addChild(Html::tag('div'))
                ->toHtml()
        );
    }

    public function test_it_can_add_multiple_child_elements()
    {
        // <nav>
        //     <ul>
        //         <li><a href="#">Link 1</a></li>
        //         <li><a href="#">Link 2</a></li>
        //         <li><a href="#">Link 3</a></li>
        //     </ul>
        // </nav>
        $this->assertSame(
            '<nav><ul><li><a href="#">Link 1</a></li><li><a href="#">Link 2</a></li><li><a href="#">Link 3</a></li></ul></nav>',
            Html::tag('nav')->addChild(
                Html::tag('ul')->setChildren([
                    Html::tag('li')->addChild(Html::tag('a')->href('#')->text('Link 1')),
                    Html::tag('li')->addChild(Html::tag('a')->href('#')->text('Link 2')),
                    Html::tag('li')->addChild(Html::tag('a')->href('#')->text('Link 3')),
                ])
            )->toHtml()
        );
    }

    public function test_it_can_set_custom_attributes()
    {
        $this->assertSame(
            '<div foo="bar"></div>',
            Html::tag('div')->setAttribute('foo', 'bar')->toHtml()
        );
    }

    public function test_it_can_set_multiple_attributes()
    {
        $this->assertSame(
            '<div class="foo" id="app" foo="bar"></div>',
            Html::tag('div')->class('foo')->id('app')->setAttribute('foo', 'bar')->toHtml()
        );
    }

    public function test_it_can_be_cast_as_html_string()
    {
        $this->assertSame('<div></div>', (string) Html::tag('div'));
    }

    public function test_it_can_build_singleton_html()
    {
        $this->assertSame('<img src="/path/to/image.jpg" alt="description" />', Html::tag('img')->src('/path/to/image.jpg')->alt('description')->toHtml());
    }

    public function test_is_can_build_data_attributes()
    {
        $this->assertSame('<div data-lang="en"></div>', Html::tag('div')->setAttribute('data-lang', 'en')->toHtml());
    }

    public function test_default_tagname_is_a_div()
    {
        $obj = new HtmlElement;
        $this->assertSame('div', $obj->tagname);
        $this->assertSame('<div></div>', $obj->toHtml());
    }

    /**
     *
     */
    public function test_it_can_build_a_login_form()
    {
        // <form src="/login" method="post">
        //     <div>
        //         <label for="login">Email</label>
        //         <input type="email" id="login" required="required" placeholder="Email" />
        //     </div>
        //     <div>
        //         <label for="password">Password</label>
        //         <input type="password" id="password" required="required" placeholder="********" />
        //     </div>
        //     <div>
        //         <button>Login</button>
        //     </div>
        // </form>
        $this->assertSame(
            '<form src="/login" method="post"><div><label for="login">Email</label><input type="email" id="login" required="required" placeholder="Email" /></div><div><label for="password">Password</label><input type="password" id="password" required="required" placeholder="********" /></div><div><button>Login</button></div></form>',
            Html::tag('form')->src('/login')->method('post')->setChildren([
                Html::tag('div')->setChildren([
                    Html::tag('label')->for('login')->text('Email'),
                    Html::tag('input')->type('email')->id('login')->required()->placeholder('Email'),
                ]),
                Html::tag('div')->setChildren([
                    Html::tag('label')->for('password')->text('Password'),
                    Html::tag('input')->type('password')->id('password')->required()->placeholder('********'),
                ]),
                Html::tag('div')->addChild(
                    Html::tag('button')->text('Login')
                ),
            ])->toHtml()
        );
    }

    public function test_any_method_can_initialise_the_html_element()
    {
        $this->assertSame('<img />', Html::tag('img')->toHtml());
        $this->assertSame('<div title="foobar"></div>', Html::title('foobar')->toHtml());
        $this->assertSame('<div class="foobar"></div>', Html::class('foobar')->toHtml());
        $this->assertSame('<img src="/path/to/image.png" />', Html::src('/path/to/image.png')->tag('img')->toHtml());
    }
}
