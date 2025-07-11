<?php
include 'partials/header.php';
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM users WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $user = mysqli_fetch_assoc($result);
} else {
  header('location: ' . ROOT_URL . 'admin/manage-users.php');
  die();
}
?>

<!-- ! edit user  -->
<section class="form_section">
  <div class="container form_section-container">
    <h2>Edit User</h2>
    <?php
    if (isset($_SESSION['edit-user'])): ?>
      <div class="alert_message error">
        <p>
          <?= $_SESSION['edit-user'];
          unset($_SESSION['edit-user']) ?>
        </p>
      </div>
    <?php endif ?>
    <form action="<?= ROOT_URL ?>admin/logic/edit-user-logic.php" method="POST">
      <input name="id" type="hidden" value="<?= $user['id'] ?>">
      <input type="text" name="firstname" placeholder="First Name" value="<?= $user['firstname'] ?>" />
      <input type="text" name="lastname" placeholder="Last Name" value="<?= $user['lastname'] ?>" />
      <select name="userrole">
        <option value="0" <?= $user['is_admin'] == '0' ? 'selected' : '' ?>>Author</option>
        <option value="1" <?= $user['is_admin'] == '1' ? 'selected' : '' ?>>Admin</option>
      </select>
      <button type="submit" name="submit" class="btn">Update User</button>
    </form>
  </div>
</section>
<?php
include '../partials/footer.php'
?>