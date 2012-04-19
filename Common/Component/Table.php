<?php

namespace NetBricks\Common\Component;

use \NetBricks\Common\Component\Tag;
use \NetCore\Configurable\StaticConfigurator;

/**
 * Author: Szymon Wygnański
 * Date: 08.09.11
 * Time: 17:06
 */
class Table extends Tag
{


    private $columns = array();

    /**
     * @return void
     */
    public function render() {
        ?>
<table <?php echo $this->renderTagAttributes(array('id', 'class', 'padding', 'spacing')); ?>>
    <thead>
        <tr>
        <?php foreach($this->columns as $c): ?>
            <th><?php echo $c['header_name']; ?></th>
        <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->getDataProvider() as $record): ?>
        <tr>
            <?php foreach($this->columns as $c): ?>
                <td><?php echo $this->renderField($record, $c); ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>


        <?php
    }

    /**
     * @param array|object $record
     * @param $column
     * @return string
     */
    private function renderField($record, $column)
    {
        $view = $column['view'];
        $fieldName = $column['param_name'];
        if($view == null) {
            return $this->getRecordFieldValue($record, $fieldName);
        } else {
            return $this->renderVariable($view, $record);
        }
    }

    public function getRecordFieldValue($record, $fieldName)
    {
       return \NetCore\Renderer::renderObjectProperty($record, $fieldName);
    }

    /**
     * @param $param_name
     * @param $header_name
     * @param null $view
     * @return \NetBricks\Common\Component\Table
     */
    public function column($param_name, $header_name, $view = null)
    {
        $this->columns[] = array('param_name' => $param_name, 'header_name' => $header_name, 'view' => $view);
        return $this;
    }

    /**
     * @return array
     */
    public function columns()
    {
        return $this->columns;
    }

    /**
     * @param $value
     * @return \NetBricks\Common\Component\Table
     */
    public function setDataProvider($value)
    {
        $this->options['data_provider'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataProvider()
    {
        return isset($this->options['data_provider']) ? $this->options['data_provider'] : array();
    }

}
