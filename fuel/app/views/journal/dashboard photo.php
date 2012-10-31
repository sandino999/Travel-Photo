<?php echo Fuel\Core\Html::doctype('html5') ?>
<html>
    <head>
        <title><?php print $data->name ?></title>
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
                    <h1><?php print \Fuel\Core\Html::anchor('db', 'Dashboard') ?></h1>
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
                        <header>
                            <h2><?php print $data->name;?></h2>
                        </header>
                        <section>
                            <?php if(isset($photos)):  foreach ($photos as $photo): ?>
                            <article class="journal-item">
                                <section>
                                    <img src="<?php print myupload::upload_dir().$photo->date.'/'.myupload::$small.$photo->file; ?>" />
                                </section>
                                <header><h3><?php print $photo->file ?></h3></header>
                                <footer>
                                    <ul>
                                        <li><?php print \Fuel\Core\Html::anchor('journal/main/deletephoto/'.$photo->id.'/'.$data->id, 'Remove') ?></li>
                                    </ul>
                                </footer>
                            </article>
                            <?php endforeach; endif; ?>
                        </section>
                    </article>
                </section>
                <section class="child-table">
                    <?php 
                        print \Fuel\Core\Form::open(array(
                            'action'=>'/journal/main/addphoto/',
                            'method'=>'post',
                            'enctype'=>'multipart/form-data'));
                        print \Fuel\Core\Form::file('photos[]',array('class'=>'btn btn-primary','multiple' =>''));
                        print \Fuel\Core\Form::hidden('journal-id', $data->id);
                        print \Fuel\Core\Form::submit('Submit');
                        print \Fuel\Core\Form::close();
                    ?>
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
