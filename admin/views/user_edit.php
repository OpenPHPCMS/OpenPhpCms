<H1><?PHP echo lang()->get('user_edit_title') ?> </H1>

<form action="" method="post">
	<fieldset>		
		<input class="textfield" type="hidden" id="user_username" name="user_username" value="<?PHP echo $username ?>" />
		<h3><?PHP echo str_replace('[username]', $username, lang()->get('user_edit_editing_user')) ?></h3>
		<hr/>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_password') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_password_info') ?></label> 		
			<input class="textfield" type="password" id="user_password" name="user_password" value="<?PHP echo $password ?>" />
			<span class="formError"><?PHP echo $error_password ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_name') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_name_info') ?></label> 		
			<input class="textfield" type="text" id="user_name" name="user_name" value="<?PHP echo $name ?>" />
			<span class="formError"><?PHP echo $error_name ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_surname') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_surname_info') ?></label> 		
			<input class="textfield" type="text" id="user_surname" name="user_surname" value="<?PHP echo $surname ?>" />
			<span class="formError"><?PHP echo $error_surname ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_email') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_email_info') ?></label> 		
			<input class="textfield" type="text" id="user_email" name="user_email" value="<?PHP echo $email ?>" />
			<span class="formError"><?PHP echo $error_email ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_user_role') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_user_role_info') ?></label> 		
			<select name="user_level" id="user_level">
				<?PHP echo $user_roles; ?>
			</select>
			<span class="formError"><?PHP echo $error_level ?></span>
		</p>


		<hr/>
		<br/>
		<input type="submit" value="<?PHP echo lang()->get('user_edit_save_submit') ?>" name="user_submit" class="button buttrans bluebut" />
	</fieldset>
</form>