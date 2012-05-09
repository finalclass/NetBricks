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
namespace NetBricks\Page\Component\Paragraph;
use \NetBricks\Common\Component\Container;
use \NetBricks\Page\Service\Paragraph;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Link;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.05.12
 * @time: 13:19
 *
 * @property Link $editButton
 */
class EditableParagraph extends Container
{

    /**
     * @var \NetBricks\Page\Document\Paragraph
     */
    private $document;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->editButton = Link::factory()
                ->addParam('stage', 'admin')
                ->addParam('action', 'edit')
                ->addParam('content', 'npcpml');
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Component\Paragraph\EditableParagraph
     */
    public function setId($value)
    {
        $this->options['id'] = (string)$value;
        $this->editButton->addParam('id', $value);

        $this->document = $this->getService()->get(array('id' => $this->getId()));
        if (!$this->document) {
            $paragraph = new \NetBricks\Page\Document\Paragraph();
            $paragraph->setId($this->getId());
            $this->document = $this->getService()->put($paragraph);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string)@$this->options['id'];
    }

    /**
     * @param boolean $value
     * @return \NetBricks\Page\Component\Paragraph\EditableParagraph
     */
    public function setShowEditButton($value)
    {
        $this->options['show_edit_button'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShowEditButton()
    {
        return (boolean)@$this->options['show_edit_button'];
    }

    /**
     * @return \NetBricks\Page\Service\ParagraphReader
     */
    public function getService()
    {
        return _::services()->paragraphReader();
    }

    public function render()
    {
        ?>
    <div class="nb_page_paragraph_editable">
        <?php echo $this->document->getText(); ?>
        <?php if ($this->getShowEditButton()): ?>
        <?php echo $this->editButton
                ->setLabel('nb_page_paragrpah_editable_edit_button')
                ->addClass('nb_page_paragraph_editable_edit_button'); ?>
        <?php endif ?>
    </div>
    <?php
    }

}
