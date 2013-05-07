<form action="login.php" method="post">
	<fieldset>
		<span class="formtitle"><?PHP echo lang()->get('login_title') ?></span>
		
		<input type="hidden" name="login_token" value="<?PHP echo $_SESSION['login_token']; ?>" />
		<p><label class="formlabel"><?PHP echo lang()->get('login_username') ?></label> 		<input class="textfield" type="text" name="login_username" id="login_username" /></p>
		<p><label class="formlabel"><?PHP echo lang()->get('login_password') ?></label> 		<input class="textfield" type="password" name="login_password" id="login_password" /></p>

		<hr/>
		<input type="submit" name="login_submit" value="<?PHP echo lang()->get('login_submit') ?>" class="button buttrans bluebut" />
	</fieldset>
</form>