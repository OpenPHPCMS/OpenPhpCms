<!-- Start delete user pop up -->
<script type="text/javascript">
  var deleteUsername = '';
  function deleteUserPopUp(username){
    var html = "<h3><?PHP echo lang()->get('users_delete_pop_title'); ?></h3>";
    html    += "<p><?PHP echo str_replace('[username]', '<span id=\'deleteUsername\'></span>', lang()->get('users_delete_pop_message')) ?></p>";

    popup = new PopUp(html);
    popup.width = 400;
    var url = "<?PHP echo base_url(__ADMIN_FOLDER.'/user_delete.php?username=') ?>"+username;
    popup.addButton(url, "<?PHP echo lang()->get('users_delete_pop_delete'); ?>", "redbut");
    popup.display();
    document.getElementById('deleteUsername').innerHTML = username;
  }
</script>

<h1><?PHP echo lang()->get('users_title') ?></h1>
<hr>
<p>
	<a href="<?PHP echo base_url(__ADMIN_FOLDER.'/user_add.php') ?>" class="button greenbut">
    <img class="icon" src="images/icons/add.png" alt="" /><span><?PHP echo lang()->get('users_add_user') ?></span></a>
</p>

<table>
 <tr>
  <th style="min-width:30px"></th>
  <th><?PHP echo lang()->get('users_username') ?></th>
  <th><?PHP echo lang()->get('users_user_role') ?></th>
  <th><?PHP echo lang()->get('users_name') ?></th>
  <th><?PHP echo lang()->get('users_surname') ?></th>
  <th><?PHP echo lang()->get('users_email') ?></th>
</tr>
<?PHP foreach ($users as $user): ?>
 <tr>
  <td width="64px">  <a class="right deleteicon" onclick="deleteUserPopUp('<?PHP echo $user['username'] ?>');" href="#"> </a>
        <a class="right editicon" href="<?PHP echo base_url('admin/user_edit.php').'?username='.$user['username'] ?>"> </a>
  </td>
  <td><?PHP echo $user['username'] ?></td>
  <td><?PHP echo user_role_name($user['level']) ?></td>
  <td><?PHP echo $user['name'] ?></td>
  <td><?PHP echo $user['surname'] ?></td>
  <td><?PHP echo $user['email'] ?></td>
 </tr>
<?PHP endforeach; ?>
</table>