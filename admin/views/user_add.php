<script type="text/javascript">
$(document).ready(function() {
	$(".formchange").blur(function() {
		$('#error_'+$(this).attr("name")).html("");
		$("#"+$(this).attr("name")+"_icon").attr("src", "images/icons/loading.gif")

		$.ajax({                                      
			url: 'user_validate.php',       
			data: "input=" + $(this).attr("name")+"&value="+$(this).val(), 							   		 							   		
			dataType: 'json',               		    
			success: function(data) {
				var output = "";
				var inputName = data['input'];
				delete data['input'];

				for(var error in data) {
					output = output+data[error]+"<br />";
				}
				$('#error_'+inputName).html(output);

				if(output != "")
					$("#"+inputName+"_icon").attr("src", "images/icons/error_red.png")
				else
					$("#"+inputName+"_icon").attr("src", "images/icons/accept.png")
			} 
		});	
	});
});
</script>
<H1><?PHP echo lang()->get('user_add_title') ?></H1>

<form action="" method="post">
	<fieldset>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_username') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_username_info') ?></label> 		
			<input class="textfield formchange" type="text" id="user_username" name="user_username" value="<?PHP echo $username ?>" />
			<img class="form_validate_icon" id="user_username_icon" src="">
			<span id="error_user_username" class="formError"><?PHP echo $error_username ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_password') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_password_info') ?></label> 		
			<input class="textfield formchange" type="password" id="user_password" name="user_password" value="<?PHP echo $password ?>" />
			<img class="form_validate_icon" id="user_password_icon" src="">
			<span id="error_user_password" class="formError"><?PHP echo $error_password ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_name') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_name_info') ?></label> 		
			<input class="textfield formchange" type="text" id="user_name" name="user_name" value="<?PHP echo $name ?>" />
			<img class="form_validate_icon" id="user_name_icon" src="">
			<span id="error_user_name" class="formError"><?PHP echo $error_name ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_surname') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_surname_info') ?></label> 		
			<input class="textfield formchange" type="text" id="user_surname" name="user_surname" value="<?PHP echo $surname ?>" />
			<img class="form_validate_icon" id="user_surname_icon" src="">
			<span id="error_user_surname" class="formError"><?PHP echo $error_surname ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_email') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_email_info') ?></label> 		
			<input class="textfield formchange" type="text" id="user_email" name="user_email" value="<?PHP echo $email ?>" />
			<img class="form_validate_icon" id="user_email_icon" src="">
			<span id="error_user_email" class="formError"><?PHP echo $error_email ?></span>
		</p>

		<p>
			<label class="formlabel"><?PHP echo lang()->get('user_add_user_role') ?></label>	
			<label class="help"><?PHP echo lang()->get('user_add_user_role_info') ?></label> 		
			<select name="user_level" id="user_level">
				<?PHP echo $user_roles; ?>
			</select>
			<span id="error_user_level" class="formError"><?PHP echo $error_level ?></span>
		</p>


		<hr/>
		<br/>
		<input type="submit" value="<?PHP echo lang()->get('user_add_save_submit') ?>" name="user_submit" class="button buttrans bluebut" />
	</fieldset>
</form>