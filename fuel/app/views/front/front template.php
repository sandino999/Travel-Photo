<?php echo Fuel\Core\Html::doctype('html5')?>
<html>
    <head>
        <title><?php echo $title ?></title>
        <?php 
            echo \Fuel\Core\Asset::css('main.css');
            echo \Fuel\Core\Asset::css('bootstrap.min.css');
            echo \Fuel\Core\Asset::js('jquery-1.8.2.js');
            echo \Fuel\Core\Asset::js('bootstrap.min.js');
        ?>
    </head>
    <body>
        <header id="front-side-header-element" class="base-element">
            <nav id="front-site-header" class="base-table-content">
                <section class="child-table default-padding">
                    <input type="text"/>
                </section>
                <section class="child-table default-padding">
                    <h1>Travel Blog</h1>
                </section>
                <section class="child-table default-padding">
                    <?php 
                        $list = array(
                             Fuel\Core\Html::anchor('login','Login'),
                             Fuel\Core\Html::anchor('#add-journal', 'Add', 
                                     array(
                                         'data-toggle' => 'modal'   
                                         ))
                        );
                        $attr = array(
                            'id' => 'home-menu-item',
                            'class' =>'menu-item'
                        );
                        echo Fuel\Core\Html::ul($list,$attr);
                    ?>
                </section>
            </nav>
        </header>
        <footer>
            <!-- Modules -->
            <article class="modal hide fade" id="add-journal">
                <section class="modal-header"><h1>Add Journal</h1></section>
                <section class="modal-body">
                    <?php 
                        $form = new MyHtml('form-item');
                        echo \Fuel\Core\Form::open('journal/main/add');
                        $form->input('journal_name', 'text', 'Name');
                        $form->textarea('journal_description', 'text', 'Description');
                        $form->submit('Submit');
                        echo \Fuel\Core\Form::close();
                    ?>
                </section>
                <section class="modal-footer"></section>
            </article>
        </footer>
    </body>
</html>
