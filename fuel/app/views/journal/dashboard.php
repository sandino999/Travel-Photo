<?php echo Fuel\Core\Html::doctype('html5') ?>
<html>
    <head>
        <title><?php print $title ?></title>
        <?php 
            echo \Fuel\Core\Asset::css('main.css');
            echo \Fuel\Core\Asset::css('bootstrap.min.css');
            echo \Fuel\Core\Asset::js('jquery-1.8.2.js');
            echo \Fuel\Core\Asset::js('bootstrap.min.js');
        ?>
    </head>
    <body>
        <header class="base-element" id="front-side-header-element">
            <nav id="front-site-header" class="base-table-content">
                <section class="child-table default-padding">
                    <input type="text"/>
                </section>
                <section class="child-table default-padding">
                    <h1>Dashboard</h1>
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
        <article class="base-element">
            
            <article class="base-table-content" id="journal-content">
                <section class="child-table">
                    <article class="base-table-full">
                        <header><h2>Listed Journals</h2></header>
                        <section class="child-table-full">
                            <article class="journal-item">
                                <p>testing</p>
                            </article>
                            <?php 
                                print_r($journal_items);
                            ?>
                        </section>
                    </article>
                </section>
                <section class="child-table">
                    <p>testing</p>
                </section>
            </article>
            
        </article>
        <footer>
        </footer>
    </body>
</html>
