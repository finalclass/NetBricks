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
 * @date: 19.03.12
 * @time: 12:57
 *
 * @property \NetBricks\Common\Component\ComponentAbstract $component
 */
class SingleComponent extends Container
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->component = _::loader(_::request()->component->toString())->create();
    }

    public function render()
    {
        /*$cfg = _::cfg()->getHeader();

        return \Zend_Json::prettyPrint(\Zend_Json::encode(array(
            'scripts' => $cfg->getScripts()->getUnique(),
            'styles' => $cfg->getStyleSheets()->getUnique(),
            'html' => (string)$this->component
        )));*/

        $cfg = _::cfg()->getHeader();
        ?>

    <?php foreach ($cfg->getScripts()->getUnique() as $file): ?>
        <script type="text/javascript" src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>

    <?php foreach ($cfg->getStyleSheets()->getUnique() as $file): ?>
        <link rel="stylesheet" href="<?php echo $file; ?>">
    <?php endforeach; ?>

    <?php echo $this->component; ?>

        <?php
    }

}
