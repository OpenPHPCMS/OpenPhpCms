<script type="text/javascript">
	function link(){
		var select =document.getElementById("link_select");
		if(select.options[select.selectedIndex].value == "exturl") {
			document.getElementById("link_url").style.display = 'inline';
		} else {
			document.getElementById("link_url").style.display = 'none';
		}
	}
</script>
<h1><?PHP echo lang()->get('menu_title') ?></h1>

<form method="post">
	<input type="hidden" name="id" value="<?php echo $id ?>">
	<fieldset>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('menu_edit_item_name') ?></label> 		
			<label class="help"><?PHP echo lang()->get('menu_edit_item_name_info') ?></label> 					
			<input class="textfield" type="text" name="name" value="<?php echo $name ?>"/>	
			<span class="formError"><?PHP echo $error_name ?></span>		
		</p>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('menu_edit_item_link') ?></label> 		
			<label class="help"><?PHP echo lang()->get('menu_edit_item_link_info') ?></label> 					
			
			<select name="link_select" id="link_select" onchange="link()">
				<option value="exturl">- <?PHP echo lang()->get('menu_edit_item_link_external') ?> -</option>
				<?PHP echo $link_options ?>
			</select>
			
			<span id="link_url" style="display:<?PHP echo $link_select == "exturl" ? 'inline' : 'none'  ?>"> 
				<?PHP echo lang()->get('menu_edit_item_link_url') ?>:
				<input class="textfield" type="text" name="link_url" value="<?php echo $link_url ?>"/>
			</span>
			<span class="formError"><?PHP echo $error_link ?></span>	
		</p>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('menu_edit_item_parent') ?></label> 		
			<label class="help"><?PHP echo lang()->get('menu_edit_item_parent_info') ?></label> 					
			<select name="parrent">
				<?php echo $parents ?>
			</select>
			<span class="formError"><?PHP echo $error_parent ?></span>		
		</p>
		<input type="submit" name="menu_submit" value="<?PHP echo lang()->get('menu_edit_item_save') ?>" class="button buttrans bluebut" />
	</fieldset>
</form>