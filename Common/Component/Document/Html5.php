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

namespace NetBricks\Common\Component\Document;

use \NetBricks\Common\Component\Container;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 01.03.12
 * @time: 11:37
 *
 * @property \NetBricks\Common\Component\Header $head
 * @property \NetBricks\Common\Component\Tag $body
 */
class Html5 extends Container
{

    public function __construct($options = array())
    {
        //In case someone will overrdie __construct and add custom components
        $this->head = $this->head ? $this->head : new \NetBricks\Common\Component\Head();
        $this->body = $this->body ? $this->body : \NetBricks\Common\Component\Tag::factory('body');
        parent::__construct($options);
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Document\Html5
     */
    public function setLang($value)
    {
        $this->options['lang'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return empty($this->options['lang']) ? 'en' : $this->options['lang'];
    }

    public function getView()
    {
        $render = $this->renderVariable(array($this, 'render'));
        ?>
    <!DOCTYPE html>
    <html lang="<?php echo $this->getLang(); ?>">
        <?php echo $this->head; ?>

        <?php if(isset($this->content)): ?>
            <?php echo $this->content; ?>
        <?php elseif($render): ?>
            <body>
                <?php echo $render; ?>
        <?php else: ?>
            <?php echo $this->body; ?>
        <?php endif; ?>
    </html>
    <?php
    }

}
