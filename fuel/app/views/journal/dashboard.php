<?php echo Fuel\Core\Html::doctype('html5') ?>
<html>
    <head>
        <title><?php print $title ?></title>
        <?php 
            echo \Fuel\Core\Asset::css('main.css');
            echo \Fuel\Core\Asset::css('bootstrap.min.css');
            echo \Fuel\Core\Asset::js('jquery-1.8.2.js');
            echo \Fuel\Core\Asset::js('bootstrap.min.js');
            echo \Fuel\Core\Asset::js('vars.js');
            echo \Fuel\Core\Asset::js('func.js');
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
                            <?php foreach ($journal_items as $item): ?>
                                
                                <article class="journal-item">
                                    <header><h3 class="default-padding">
                                        <?php print $item->name ?>
                                        </h3></header>
                                    <footer>
                                        <ul>
                                            <li><?php print Fuel\Core\Html::anchor('#edit-journal', 'Edit',
                                                    array(
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $item->id,
                                                        'class' => 'journal-detail'
                                                    
                                                    )); ?></li>
                                            <li>Comment</li>
                                            <li>Like</li>
                                        </ul>
                                    </footer>
                                </article>
                            
                            <?php endforeach; ?>
                        </section>
                    </article>
                </section>
                <section class="child-table">
                    <p>testing</p>
                </section>
            </article>
            
        </article>
        <footer>
            <!-- Modal -->
            <article class="modal hide fade" id="edit-journal">
                <header class="modal-header"><h2>Edit Journal</h2></header>
                <section class="modal-body"></section>
                <footer class="modal-footer"></footer>
            </article>
        </footer>
    </body>
</html>
