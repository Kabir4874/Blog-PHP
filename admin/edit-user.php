<?php
include 'partials/header.php';
?>

<!-- ! edit user  -->
<section class="form_section">
  <div class="container form_section-container">
    <h2>Edit User</h2>
    <div class="alert_message error">
      <p>This is an error message</p>
    </div>
    <form action="" enctype="multipart/form-data">
      <input type="text" placeholder="First Name" />
      <input type="text" placeholder="Last Name" />
      <select name="" id="">
        <option value="0">Author</option>
        <option value="1">Admin</option>
      </select>
      <button type="submit" class="btn">Update User</button>
    </form>
  </div>
</section>
<?php
include '../partials/footer.php'
?>