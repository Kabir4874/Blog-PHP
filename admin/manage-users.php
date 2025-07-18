<?php
include 'partials/header.php';

// fetch users from database but not current user 
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE NOT id=$current_admin_id";
$result = mysqli_query($connection, $query);
?>
<section class="dashboard">
  <?php if (isset($_SESSION['add-user-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['add-user-success'];
        unset($_SESSION['add-user-success']) ?>
      </p>
    </div>
  <?php endif ?>
  <?php if (isset($_SESSION['edit-user-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['edit-user-success'];
        unset($_SESSION['edit-user-success']) ?>
      </p>
    </div>
  <?php endif ?>
  <?php if (isset($_SESSION['delete-user'])): ?>
    <div class="alert_message error container">
      <p>
        <?= $_SESSION['delete-user'];
        unset($_SESSION['delete-user']) ?>
      </p>
    </div>
  <?php endif ?>
  <?php if (isset($_SESSION['delete-user-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['delete-user-success'];
        unset($_SESSION['delete-user-success']) ?>
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
            <a href="manage-users.php" class="active"><i class="uil uil-users-alt"></i>
              <h5>Manage Users</h5>
            </a>
          </li>
          <li>
            <a href="add-category.php"><i class="uil uil-edit"></i>
              <h5>Add Category</h5>
            </a>
          </li>
          <li>
            <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
              <h5>Manage Categories</h5>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </aside>
    <main>
      <h2>Manage Users</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Admin</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $user['firstname'] . " " . $user['lastname'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                <td>
                  <a href="<?= ROOT_URL ?>admin/logic/delete-user-logic.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a>
                </td>
                <td><?= $user['is_admin'] == 0 ? "No" : "Yes" ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="5" style="text-align: center;">No users found</td>
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