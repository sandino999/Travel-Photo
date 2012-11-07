<?php if(isset($photo_items)):  foreach ($photo_items as $photo): ?>
<article class="journal-item">
    <section>
        <img src="<?php print myupload::upload_dir().$photo->date.'/'.myupload::$small.$photo->file; ?>" />
    </section>                            
    <header>
        <h3><?php print $photo->file ?></h3>
    </header>
    <footer>                            
         <ul>
             <li>
				<?php 
					if(myjournal::check_journal($photo->journalid) == true):
						print \Fuel\Core\Html::anchor('journal/main/deletephoto/'.$photo->id.'/'.$photo->journalid, 'Remove'); 
					endif;
				?>
			</li>
         </ul>                           
                                                                   
    </footer>                           
</article>                          
<?php endforeach; endif; ?>