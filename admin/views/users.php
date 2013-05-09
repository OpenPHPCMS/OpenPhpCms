<!-- Start delete user pop up -->
<style type="text/css">
  .overlay { 
    position: fixed;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    display: none;
    }
  .popup { 
    background: white;
    position: absolute;
    width: 400px;
    margin-right: -215px;
    padding: 15px;
    padding-bottom: 25px;
    top: 30%;
    right: 50%;
    border: 2px #47A3DA solid;
  }
</style>
<script type="text/javascript">
  var deleteUsername = '';
  function deleteUserPopUp(username){
    document.getElementById('deletePopUp').style.display = 'block';
    document.getElementById('deleteUsername').innerHTML = username;
    deleteUsername = username;
  }
  function hideDeletePopUp(){
    document.getElementById('deletePopUp').style.display = 'none';
  }
  function deleteUser(){
    window.location = "<?PHP echo base_url(__ADMIN_FOLDER.'/user_delete.php?username=') ?>"+deleteUsername;
  }
</script>

<div id="deletePopUp" class="overlay">
  <div class="popup">
    <h3><?PHP echo lang()->get('users_delete_pop_title'); ?></h3>
    <p><?PHP echo str_replace('[username]', "<span id=\"deleteUsername\"></span>", lang()->get('users_delete_pop_message')) ?></p>
    <br/>
    <a class="button redbut" href="#" onclick="deleteUser()"><?PHP echo lang()->get('users_delete_pop_delete'); ?></a> 
    <a class="button bluebut" href="#" onclick="hideDeletePopUp();"><?PHP echo lang()->get('users_delete_pop_cancel'); ?></a>
  </div>
</div>
<!-- end delete user pop up -->

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