<h1><?PHP echo lang()->get('page_add_title') ?></h1>
 <form method="post" id="settingsForm" action="">
	<fieldset>
		<input type="hidden" name="type" value="<?php echo $type ?>"/>
	<p>
		<label class="formlabel"><?PHP echo lang()->get('page_add_name_label') ?></label> 		
		<label class="help"><?PHP echo lang()->get('page_add_name_info') ?></label> 					
		<input class="textfield" type="text" name="name" value="<?php echo $name ?>"/>
		<span class="formError"><?PHP echo $error_name ?></span>			
	</p>

	<p>
		<label class="formlabel"><?PHP echo lang()->get('page_add_title_label') ?></label> 		
		<label class="help"><?PHP echo lang()->get('page_add_title_info') ?></label> 					
		<input class="textfield" type="text" name="title" value="<?php echo $title ?>"/>
		<span class="formError"><?PHP echo $error_title ?></span>			
	</p>
	
	<?PHP require($page_form_file) ?>
	
	<hr/>
	<br/>
	<input type="submit" name="page_submit" value="<?PHP echo lang()->get('page_add_save') ?>" class="button buttrans bluebut" />
</fieldset>
</form>

<?PHP require($page_content_file) ?>