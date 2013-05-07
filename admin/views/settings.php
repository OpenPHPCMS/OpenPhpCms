<h1><?PHP echo lang()->get('settings_title') ?></h1>

<!-- Form -->
<form method="post" id="settingsForm" action="">
	<fieldset>
		<span class="formtitle"><?PHP echo lang()->get('settings_general_title') ?></span>
		<hr/>
		<p><label class="formlabel"><?PHP echo lang()->get('settings_title_label') ?></label> 		
				<label class="help"><?PHP echo lang()->get('settings_title_info') ?></label> 					
					<input class="textfield" type="text" name="title" value="<?php echo $title ?>"/>
					<span class="formError"><?PHP echo $error_title ?></span>			
		</p>
		<p><label class="formlabel"><?PHP echo lang()->get('settings_slogan_label') ?></label> 		
				<label class="help"><?PHP echo lang()->get('settings_slogan_info') ?></label>					
					<input class="textfield" type="text" name="slogan" value="<?php echo $slogan ?>"/>
					<span class="formError"><?PHP echo $error_slogan ?></span>
		</p>
		<p><label class="formlabel"><?PHP echo lang()->get('settings_description_label') ?></label> 
				<label class="help"><?PHP echo lang()->get('settings_description_info') ?></label>				
					<input class="textfield" type="text" name="description" value="<?php echo $description ?>"/>
					<span class="formError"><?PHP echo $error_description ?></span>
		</p>
		<p><label class="formlabel"><?PHP echo lang()->get('settings_titleformat_label') ?></label> 
				<label class="help"><?PHP echo lang()->get('settings_titleformat_info') ?></label>					
					<input class="textfield" type="text" name="titleformat" value="<?php echo $titleformat ?>"/>
					<span class="formError"><?PHP echo $error_titleformat ?></span>
		</p>
		<p><label class="formlabel"><?PHP echo lang()->get('settings_email_label') ?></label> 		
				<label class="help"><?PHP echo lang()->get('settings_email_info') ?></label>						
					<input class="textfield" type="text" name="email" value="<?php echo $email ?>"/>
					<span class="formError"><?PHP echo $error_email ?></span>
		</p>
		<p><label class="formlabel"><?PHP echo lang()->get('settings_baseurl_label') ?></label> 	
				<label class="help"><?PHP echo lang()->get('settings_baseurl_info') ?></label>			
					<input class="textfield" type="text" name="baseurl" value="<?php echo $baseurl ?>"/>
					<span class="formError"><?PHP echo $error_baseurl ?></span>
		</p>
		<p><label class="formlabel"><?PHP echo lang()->get('settings_language_label') ?></label> 	
				<label class="help"><?PHP echo lang()->get('settings_language_info') ?></label>
					<select name="language">
						<?php echo $languageOptions ?>
					</select>
		</p>
		
		<hr/>
		<br/>
		<input type="submit" name="settings_save" value="<?PHP echo lang()->get('settings_save_button') ?>" class="button buttrans bluebut" />
	</fieldset>
</form>