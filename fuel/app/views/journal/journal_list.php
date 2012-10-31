<?php if(isset($journal_items)): foreach ($journal_items as $item): ?>
    <article class="journal-item">
        <header><h3 class="default-padding">
                <?php print \Fuel\Core\Html::anchor('/photo/'.$item->id,$item->name); ?>
                </h3></header>
        <footer>
            <ul>
                <li><?php print Fuel\Core\Html::anchor('#edit-journal', 'Edit',
                                                    array(
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $item->id,
                                                        'class' => 'journal-detail'
                                                    
                                                    )); ?>
                </li>             
                <li>Comment</li>
                <li>Like</li>
                <li>
                    <?php print Fuel\Core\Html::anchor('/journal/main/delete/'.$item->id, 'Delete');?>
                </li>
              </ul>
        </footer>
    </article>
<?php endforeach; 
        endif; ?>

