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

namespace NetBricks\Common\Nbml;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 11.03.12
 * @time: 14:07
 */
class Element
{

    public function __construct($domElement)
    {

    }

    public function toString()
    {
        echo '<?php' . PHP_EOL;
?>

namespace <?php echo $this->namespace; ?>;

class <?php echo $this->className; ?> extends <?php echo $this->superClass; ?>
{

<?php foreach($this->publicProperties as $propertyName); ?>
    public <?php echo $propertyName; ?>;
<?php endforeach; ?>


    public function __construct($options = array())
    {

        <?php foreach($this->children as $child): ?>
            <?php
                $element = new \NetBricks\Common\Nbml\Element($child);
                echo $element->getCreateStatemant();
            ?>
            <?php // echo \NetCore\Renderer::renderVariable(array($this, 'renderCreatechild')); ?>
        <?php endforeach ;?>

        parent::__construct($options);

    }

}

<?php
    }

    public function getCreateStatement()
    {
        ?>
            $item = new <?php echo $this->className; ?>();
        <?php foreach($this->publicProperties as $property => $value): ?>
            $item-><?php echo $property; ?> = <?php echo $this->renderParameter($value); ?>;
        <?php endforeach; ?>

        <?php foreach($this->children as $child); ?>
<?php //@TODO dokończyć ?>
        <?php endforeach; ?>
        <?php
    }

    private function isExpresion($string)
    {
        $len = strlen($string);
        if($len < 2) {
            return false;
        }
        return $string[0] == '{' && $string[$len] = '}';
    }

    public function renderParameter($param)
    {
        $param = trim($param);
        if($this->isExpresion($param)) {
            return
            'function() {
                    return ' . substr($param, 1, strlen($param) - 2) . ';
            }';
        }
        return $param;
    }

}
