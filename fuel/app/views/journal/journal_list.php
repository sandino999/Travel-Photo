<?php if(isset($journal_items)): foreach ($journal_items as $item): ?>
    <article class="journal-item">
        <header><h3 class="default-padding">
                <?php print \Fuel\Core\Html::anchor('/photo/'.$item->id,$item->name); ?>
                </h3></header>
        <footer>
            <ul>
			<?php if($item->user == Session::get('username')): ?>
                <li><?php print Fuel\Core\Html::anchor('#edit-journal', 'Edit',
                                                    array(
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $item->id,
                                                        'class' => 'journal-detail'
                                                    
                                                    )); ?>
                </li>             
                
                <li>
                    <?php print Fuel\Core\Html::anchor('/journal/main/delete/'.$item->id, 'Delete');?>
                </li>
              
			<?php endif; ?> 
				<br/><li>Comment</li>
                <li>Like</li>
			</ul>	
        </footer>
    </article>
<?php endforeach; 
        endif; ?>

