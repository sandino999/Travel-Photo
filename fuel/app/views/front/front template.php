<?php echo Fuel\Core\Html::doctype('html5')?>
<html>
    <head>
        <title><?php echo $title ?></title>
        <?php 
			
            echo \Fuel\Core\Asset::css('main.css');
            echo \Fuel\Core\Asset::css('bootstrap.min.css');
            echo \Fuel\Core\Asset::js('jquery-1.8.2.js');
            echo \Fuel\Core\Asset::js('bootstrap.min.js');
            echo \Fuel\Core\Asset::js('login.js');
            echo \Fuel\Core\Asset::js('register.js');
            echo \Fuel\Core\Asset::js('forgot-password.js');		
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
                <?php $arg = array('data-toggle'=>'modal'); ?>
        
		<?php if(Session::get('user_id') == '' ): ?>
                    <div class="nav-items" id='login'>
                        <?php print Fuel\Core\Html::anchor('#login-module', 'Sign-In',$arg); ?>
                    </div>
                    <div class="nav-items" id='sign-up'>
                        <?php print Fuel\Core\Html::anchor('#register-module', 'Sign-Up',$arg) ?>
                    </div>
		<?php else:?>
                    <div class="dropdown nav-items">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo Fuel\Core\Html::img('assets/img/profile_picture/'.Session::get('user_photo'),array('width'=>25,'height'=>25)) . Session::get('username'); ?></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                            <li><a tabindex="-1" href="#">Action</a></li>
                            <li><?php print \Fuel\Core\Html::anchor('#add-journal','Add Journal',$arg)?></li>
                            <li><?php print Fuel\Core\Html::anchor('accounts/edit', 'Edit Profile')  ?></li>
                            <li class="divider"></li>
                            <li> <?php print Fuel\Core\Html::anchor('accounts/logout', 'Logout')  ?></li>
                        </ul>
                    </div>   
                </section>
                <?php endif;?>
            </nav>
        </header>
            
        <footer>
            <!-- Modules -->
            
            <article class="modal hide fade" id="add-journal">
                <section class="modal-header"><h1>Add Journal</h1></section>
                <section class="modal-body">
                    <?php 
                        $form_add_journal = new myform('form-item');
                        $form_add_journal->open_form('journal/main/add');
                        $form_add_journal->input('journal_name', 'text', 'Name');
                        $form_add_journal->textarea('journal_description', 'text', 'Description');
                        $form_add_journal->submit('Submit');
                        $form_add_journal->close_form();
                    ?>
                </section>
                <section class="modal-footer"></section>
            </article>
            
		
            <article class="modal hide fade" id="login-module">
                <header class="modal-header"><h2>Sign-In</h2></header>
                <section class="modal-body">
                    <?php
                        $form_login = new myform('form-item');
                        $form_login->open_form('/accounts/login');
                        $form_login->input('username', 'text', 'Username');
                        $form_login->input('password', 'password', 'Password');
                        $form_login->submit('Login',Fuel\Core\Html::anchor('#forgot-module','Forgot Password',$arg));
                        $form_login->close_form();
						
						?>
                </section>
                <footer class="modal-footer">
			<span id='error_message'></span>
		</footer>
            </article>
            
            <article class="modal hide fade" id="register-module">
                <header class="modal-header"><h2>Sign Up</h2></header>
                <section class="modal-body">
                    <?php 
                        $form_reg = new myform('form-item');
                        $form_reg->open_form('/accounts/register');
                        $form_reg->input('reg_username', 'text', 'Username');
                        $form_reg->input('reg_password', 'password', 'Password');
                        $form_reg->input('password2','password', 'Re-type Password');
			$form_reg->input('name','text','Name');
                        $form_reg->input('email','text','Email');
                        $form_reg->submit('submit');
                        $form_reg->close_form();
                    ?>
                </section>
                <footer class="modal-footer">
                    <span id='reg_error_message' class="label label-important"></span>
		</footer>
            </article>
            
            <article class="modal hide fade" id="forgot-module">
                <header class="modal-header"><h2>Forgot Password</h2></header>
                <section class="modal-body">
                    <?php
                        $form_login = new myform('form-item');
                        $form_login->open_form('/travel-photo/accounts/login');
                        $form_login->input('forgot_username', 'text', 'Username');
                        $form_login->input('forgot_email', 'email', 'Email');
                        $form_login->submit('Send');
                        $form_login->close_form();
                    ?>
                </section>
                <footer class="modal-footer">
			<span id='forgot_error_message' class="label label-important"></span>
		</footer>
            </article>     
        </footer>		
    </body>
</html>
