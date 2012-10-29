<?php
    $form = new MyHtml('form-item');
    echo \Fuel\Core\Form::open('journal/main/edit');
    $form->input('date-from', 'text', 'Date From',true,$data->datein);
    $form->input('date-to', 'text', 'Date To',true,$data->dateout);
    $form->input('journal-name', 'text', 'Name',true,$data->name);
    $form->textarea('description', 'text', 'Description',true,$data->description);
    $form->hidden('journal_id',$data->id);
    $form->submit('Submit', true, 'Submit');
    echo \Fuel\Core\Form::close();
?>
