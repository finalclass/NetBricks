<?php
/**
 * HorizontalForm
 *
 * Author: MMP
 */

namespace NetBricks\Ini\Component;

use \NetBricks\Common\ComponentAbstract;

class HorizontalForm extends ComponentAbstract {

    private $value;
    private $key;

    public function __construct() {

        parent::__construct();
    }

    public function setKey($k) {

        $this->key = $k;
        return $this;
    }

    public function getKey() {

        return ($this->key);
    }

    public function getValue() {

        return ($this->value);
    }

    public function setValue($val) {

        $this->value = $val;
        return $this;
    }

    public function render() {
        ?>

        <form action="" method="POST">
            <div style="float:left">
                <input name="config[key]" type="text" value="<?php echo $this->key; ?>" />
                <input name="config[value]" type="text" value="<?php echo $this->value; ?>" />
                <input name="config[oldKey]" type="hidden" value="<?php echo $this->key; ?>" />
            </div>

            <ul class="operations" style="float:left">
                <li>
                    <button>
                        <span class="ui-icon ui-icon-plusthick"></span>
                        O.K.</button>
                </li>
                <li>
                    <span class="ui-icon ui-icon-trash"></span>
                    <a href="/admin/config/list?remove_by_key=<?php echo $this->key; ?>">Usuń</a>
                </li>
            </ul>

        </form>

        <?php
    }

}