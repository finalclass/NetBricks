<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

namespace NetBricks\I18n\Component;

use \NetBricks\Common\ComponentAbstract;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 17:34
 */
class LanguageBar extends ComponentAbstract
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $name = get_class($this);
        $head = _::head();
        if(!$head->scripts->hasScript($name)) {
            $head->scripts->appendScript($this->renderVariable(array($name, 'getJS')), 'text/javascript', $name);
        }
        if(!$head->styleSheets->hasCss($name)) {
            $head->styleSheets->appendCss($this->renderVariable(array($name, 'getCSS')), $name);
        }
    }

    static public function  getCSS()
    {
        ?>
    <style type="text/css">

        .language_bar {
            clear: both;
            display: block;
            overflow: hidden;
            cursor: default;
        }

        .drop_down_list {
            list-style-type: none;
            background-color: #eee;
            margin: 0;
            padding: 0;
            border: outset 1px #000;
            overflow: hidden;
            display: block;
            width: 100px;
            float: left;
        }

        .drop_down_list li {
            margin: 0;
            padding: 0;
            line-height: 20px;
        }

        .drop_down_list li img {
            float: left;
        }

        .drop_down_list li:hover {
            background: #08d3f0;
        }

        .drop_down_list li.selected {
            background-color: #55e;
            color: #fff;
        }

        .drop_down_button {
            display: block;
            background: #55e;
            width: 20px;
            height: 20px;
            float: left;
        }

        .language_bar_prev, .language_bar_next {
            display: block;
            background: red;
            float: left;
        }

        .language_bar .absolute {
            position:absolute;
        }

        .drop_down_list_container {
            display:block;
            overflow:hidden;
            width: 102px;
            height: 20px;
            float:left;
        }

    </style>
    <?php
    }

    static public function getJS()
    {
        ?>
    <script type="text/javascript">

        $(function () {

            $('.language_bar').each(function () {
                var $this = $(this);
                var $selected;
                var isOpen = false;

                function init() {
                    setSelected($this.find('.drop_down_list li:first'));
                    closeDropDownList();
                }

                function openDropDownList() {
                    $this.find('.drop_down_list').addClass('absolute');
                    $this.find('.drop_down_list li').slideDown();
                    isOpen = true;
                }

                function closeDropDownList() {
                    $this.find('.drop_down_list').removeClass('absolute');
                    $this.find('.drop_down_list li').not($selected).slideUp();
                    isOpen = false;
                }

                function setSelected($item) {
                    $selected = $item;
                    $this.find('.drop_down_list li').removeClass('selected');
                    $item.addClass('selected');
                    $this.find('.drop_down_list li').not($selected).slideUp();
                    $selected.show();
                }

                $this.find('.drop_down_button').click(function (event) {
                    if (isOpen) {
                        closeDropDownList();
                    } else {
                        openDropDownList();
                    }
                });

                $('body').not($this).click(function (event) {
                    var parents = $(event.target).parents();
                    for (var i in parents) {
                        if (parents.hasOwnProperty(i)) {
                            if (parents[i] == $this.get(0)) {
                                return; //is child of $this
                            }
                        }
                    }
                    closeDropDownList();
                });

                $this.find('.language_bar_prev').click(function () {
                    var $prev = $selected.prev('li');
                    console.log($prev);
                    if ($prev.length > 0) {
                        setSelected($prev);
                    }
                });

                $this.find('.language_bar_next').click(function () {
                    var $next = $selected.next('li');
                    console.log($next);
                    if ($next.length > 0) {
                        setSelected($next);
                    }
                });

                $this.find('.drop_down_list li').click(function () {
                    if (!isOpen) {
                        openDropDownList();
                    } else {
                        setSelected($(this));
                        closeDropDownList();
                    }
                });

                init();
            });

        });

    </script>
    <?php
    }

    public function render()
    {
        ?>
    <div class="language_bar">
        <div class="language_bar_prev">&lt;</div>
        <div class="drop_down_list_container">
            <ul class="drop_down_list">
                <?php foreach (_::languages()->getAvailable() as $l): ?>
                <li data-value="<?php echo $l->getCode(); ?>">
                    <img src="<?php echo _::loader($this)->find('../../flags/' . $l->getCode() . '.png'); ?>"
                         alt="<?php echo $l->getCode(); ?>"/>
                    <?php echo $l->getName(); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="drop_down_button">\/</div>

        <div class="language_bar_next">&gt;</div>
    </div>

    <?php
    }

}
