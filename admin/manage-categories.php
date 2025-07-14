<?php
include 'partials/header.php';
$query = "SELECT * FROM categories ORDER BY title ASC";
$categories = mysqli_query($connection, $query);

?>
<section class="dashboard">
  <?php if (isset($_SESSION['add-category-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['add-category-success'];
        unset($_SESSION['add-category-success']) ?>
      </p>
    </div>
  <?php endif ?>
  <?php if (isset($_SESSION['edit-category-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['edit-category-success'];
        unset($_SESSION['edit-category-success']) ?>
      </p>
    </div>
  <?php endif ?>
  <div class="container dashboard_container">
    <button id="show_sidebar-btn" class="sidebar_toggle">
      <i class="uil uil-angle-right-b"></i>
    </button>
    <button id="hide_sidebar-btn" class="sidebar_toggle">
      <i class="uil uil-angle-left-b"></i>
    </button>
    <aside>
      <ul>
        <li>
          <a href="add-post.php"><i class="uil uil-pen"></i>
            <h5>Add Post</h5>
          </a>
        </li>
        <li>
          <a href="<?= ROOT_URL ?>admin/index.php"><i class="uil uil-postcard"></i>
            <h5>Manage Posts</h5>
          </a>
        </li>
        <?php if (isset($_SESSION['user_is_admin'])): ?>
          <li>
            <a href="add-user.php"><i class="uil uil-user-plus"></i>
              <h5>Add User</h5>
            </a>
          </li>
          <li>
            <a href="manage-users.php"><i class="uil uil-users-alt"></i>
              <h5>Manage Users</h5>
            </a>
          </li>
          <li>
            <a href="add-category.php"><i class="uil uil-edit"></i>
              <h5>Add Category</h5>
            </a>
          </li>
          <li>
            <a href="manage-categories.php" class="active"><i class="uil uil-list-ul"></i>
              <h5>Manage Categories</h5>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </aside>
    <main>
      <h2>Manage Categories</h2>
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($category = mysqli_fetch_assoc($categories)): ?>
              <tr>
                <td><?= $category['title'] ?></td>
                <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                <td>
                  <a href="<?= ROOT_URL ?>admin/logic/delete-category-logic.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a>
                </td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="5" style="text-align: center;">No categories found</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </main>
  </div>
</section>
<?php
include '../partials/footer.php'
?>