<?php

namespace NetBricks\User\Component\Login;

use \NetBricks\Common\Form\Form;

use \NetBricks\Facade as _;

/**
 * LoginPage
 *
 * Author: MMP, Sel
 */
class LoginPage extends Form {

    public function __construct($options = array()) {

        parent::__construct($options);
        $this->form = _::factory()->netBricks->user->component->login->loginForm();
    }

    public function render() {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset=utf-8 />
                <title></title>
                <!--[if IE]>
                  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
                <![endif]-->
                <script type="text/javascript" data-main="/js/nb/main.js" src="/js/require-jquery.js" ></script>
                <style type="text/css">

                    @font-face {
                    	font-family: V5Prophit;
                    	src: url('/skins/fathers/V5Prophit.ttf');
                    }

                    body {
                        text-align: center;
                    }

                    fieldset {
                        text-align: left;
                        -webkit-border-radius: 20px;
                        -moz-border-radius: 20px;
                        border-radius: 20px;
                        -webkit-box-shadow: 5px 5px 10px 2px rgba(0, 0, 0, 0.5);
                        -moz-box-shadow: 5px 5px 10px 2px rgba(0, 0, 0, 0.5);
                        box-shadow: 5px 5px 10px 2px rgba(0, 0, 0, 0.5);
                        width: 350px;
                        background-color: #182171;
                        margin: 150px auto 0 auto;
                        display:block;
                        overflow: hidden;
                    }

                    form {
                        display:block;
                        width:100%;
                        height: 100%;
                        overflow: hidden;
                        overflow: hidden;
                    }

                    legend {
                        display:block;
                        float:right;
                        width:100%;
                        text-align:right;
                        color: #fff;
                        font-family: V5Prophit, sans-serif;
                        font-size: 33px;
                    }

                    label {
                        color: #fff;
                    }

                    dl {
                        overflow: hidden;
                        display:block;
                        width: 100%;
                        height: 100%;
                        margin: 20px 50px 20px 50px;
                    }

                    dt {
                        float:left;
                        display:block;
                        width: 100px;
                        margin-top: 20px;
                    }
                    dd {
                        margin-top: 20px;
                    }

                    input[type="submit"] {
                        float:right;
                    }
                </style>
            </head>
            <body>
                <?php echo $this->form;?>
            </body>
        </html>
        <?php
    }
}