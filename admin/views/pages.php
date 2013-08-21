<h1><?PHP echo lang()->get('pages_title') ?></h1>

<form action="<?PHP echo base_url(__ADMIN_FOLDER.'/page_add.php')?>">
	<fieldset>
		<span class="formtitle"><?PHP echo lang()->get('pages_create_title') ?></span>
		<p>
			<label class="formlabel"><?PHP echo lang()->get('pages_type') ?></label> 		
			<label class="help"><?PHP echo lang()->get('pages_type_info') ?></label> 					
			<select name="type">
				<?PHP echo $types; ?> 
			</select>	
		</p>
	
		<input type="submit" value="<?PHP echo lang()->get('pages_create_page') ?>" class="button buttrans bluebut"/>
	</fieldset>
</form>

<table>
 <tr>
 	<th style="min-width:30px"></th>
  	<th><?PHP echo lang()->get('pages_name') ?></th>
  	<th><?PHP echo lang()->get('pages_type') ?></th>
</tr>
<?PHP foreach ($pages as $page): ?>
 <tr>
 	<td width="64px">  
 		<a class="right deleteicon" href="<?PHP echo base_url(__ADMIN_FOLDER.'/page_delete.php').'?page='.$page['ID'] ?>"> </a>
        <a class="right editicon" href="<?PHP echo base_url(__ADMIN_FOLDER.'/page_edit.php').'?page='.$page['ID'] ?>"> </a>
  </td>
  <td><?PHP echo $page['name'] ?></td>
  <td><?PHP echo $page['type'] ?></td>
 </tr>
<?PHP endforeach; ?>
</table>