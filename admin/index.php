<?php
include 'partials/header.php';

// fetch current user's posts 
$current_user_id = $_SESSION['user-id'];

$query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_user_id ORDER BY id DESC ";

$posts = mysqli_query($connection, $query);

?>
<section class="dashboard">
  <?php if (isset($_SESSION['add-post-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['add-post-success'];
        unset($_SESSION['add-post-success']) ?>
      </p>
    </div>
  <?php endif ?>
  <?php if (isset($_SESSION['edit-post-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['edit-post-success'];
        unset($_SESSION['edit-post-success']) ?>
      </p>
    </div>
  <?php endif ?>
  <?php if (isset($_SESSION['delete-post-success'])): ?>
    <div class="alert_message success container">
      <p>
        <?= $_SESSION['delete-post-success'];
        unset($_SESSION['delete-post-success']) ?>
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
          <a href="index.php" class="active"><i class="uil uil-postcard"></i>
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
            <th>Title</th>
            <th>Category</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($posts) > 0) {
            while ($post = mysqli_fetch_assoc($posts)): ?>
              <?php
              $category_id = $post['category_id'];
              $category_query = "SELECT title FROM categories WHERE id=$category_id";
              $category_result = mysqli_query($connection, $category_query);
              $category = mysqli_fetch_assoc($category_result);
              ?>
              <tr>
                <td><?= $post['title'] ?></td>
                <td><?= $category['title'] ?></td>
                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                <td>
                  <a href="<?= ROOT_URL ?>admin/logic/delete-post-logic.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a>
                </td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="5" style="text-align: center;">No posts found</td>
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