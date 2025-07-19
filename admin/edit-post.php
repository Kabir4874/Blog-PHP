<?php
include 'partials/header.php';

// fetch categories 
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// fetch post data from database if id is set 
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id=$id";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) == 1) {
    $post = mysqli_fetch_assoc($result);
  } else {
    $_SESSION['edit-post'] = "Post not found";
    header('location: ' . ROOT_URL . 'admin/index.php');
    die();
  }
} else {
  header('location: ' . ROOT_URL . 'admin/index.php');
  die();
}

// get back form data if form was invalid
$title = $_SESSION['edit-post-data']['title'] ?? $post['title'];
$body = $_SESSION['edit-post-data']['body'] ?? $post['body'];
$category_id = $_SESSION['edit-post-data']['category'] ?? $post['category_id'];
$is_featured = $_SESSION['edit-post-data']['is_featured'] ?? $post['is_featured'];

// delete form data session
unset($_SESSION['edit-post-data']);
?>

<!-- ! edit post   -->
<section class="form_section">
  <div class="container form_section-container">
    <h2>Edit Post</h2>

    <?php if (isset($_SESSION['edit-post'])): ?>
      <div class="alert_message error">
        <p>
          <?= $_SESSION['edit-post'];
          unset($_SESSION['edit-post']) ?>
        </p>
      </div>
    <?php endif ?>

    <form action="<?= ROOT_URL ?>admin/logic/edit-post-logic.php" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="id" value="<?= $post['id'] ?>">
      <input type="text" name="title" value="<?= $title ?>" placeholder="Title">

      <select name="category">
        <?php while ($category = mysqli_fetch_assoc($categories)): ?>
          <option value="<?= $category['id'] ?>" <?= $category['id'] == $category_id ? 'selected' : '' ?>>
            <?= $category['title'] ?>
          </option>
        <?php endwhile ?>
      </select>

      <textarea rows="10" name="body" placeholder="Body"><?= htmlspecialchars($body) ?></textarea>

      <?php if (isset($_SESSION['user_is_admin'])): ?>
        <div class="form_control inline">
          <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= $is_featured ? 'checked' : '' ?>>
          <label for="is_featured">Featured</label>
        </div>
      <?php endif ?>

      <div class="form_control">
        <label for="thumbnail">Change Thumbnail</label>
        <input type="file" name="thumbnail" id="thumbnail">
      </div>

      <input type="hidden" name="old_thumbnail" value="<?= $post['thumbnail'] ?>">
      <button type="submit" name="submit" class="btn">Update Post</button>
    </form>
  </div>
</section>

<?php
include '../partials/footer.php';
?>