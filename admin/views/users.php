<h1><?PHP echo lang()->get('users_title') ?></h1>
<hr>
<p>
	<a href="<?PHP echo base_url('admin/user_add.php') ?>" class="button buttrans greenbut">
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
  <td width="64px">  <a class="right deleteicon" href="<?PHP echo base_url('admin/user_delete.php').'?username='.$user['username'] ?>"> </a>
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