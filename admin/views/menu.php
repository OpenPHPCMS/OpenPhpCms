<h1><?PHP echo lang()->get('menu_title') ?></h1>

<form method="post">
	<fieldset>
		<span class="formtitle"><?PHP echo lang()->get('menu_add_item') ?></span>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('menu_item_name') ?></label> 		
			<label class="help"><?PHP echo lang()->get('menu_item_name_info') ?></label> 					
			<input class="textfield" type="text" name="name" value="<?php echo $name ?>"/>	
			<span class="formError"><?PHP echo $error_name ?></span>		
		</p>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('menu_item_link') ?></label> 		
			<label class="help"><?PHP echo lang()->get('menu_item_link_info') ?></label> 					
			<input class="textfield" type="text" name="link" value="<?php echo $link ?>"/>	<a href="#">Select page</a>	
			<span class="formError"><?PHP echo $error_link ?></span>	
		</p>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('menu_item_parent') ?></label> 		
			<label class="help"><?PHP echo lang()->get('menu_item_parent_info') ?></label> 					
			<select name="parrent">
				<?php echo $parents ?>
			</select>
			<span class="formError"><?PHP echo $error_parent ?></span>		
		</p>
		<input type="submit" name="menu_submit" value="<?PHP echo lang()->get('menu_item_save') ?>" class="button buttrans bluebut" />
	</fieldset>
</form>

<form method="post">

<table>
	<tr>
	<th><?PHP echo lang()->get('menu_list_name') ?></th>
	<th><?PHP echo lang()->get('menu_list_link') ?></th>
	<th><?PHP echo lang()->get('menu_list_order') ?></th>
</tr>
<?PHP echo $menu ?>
</table>

<input type="submit" name="menu_save" value="<?PHP echo lang()->get('menu_save_order') ?>" class="button buttrans bluebut" />
</form>