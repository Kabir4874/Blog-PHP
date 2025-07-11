<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM categories WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $category = mysqli_fetch_assoc($result);
} else {
  header('location: ' . ROOT_URL . 'admin/manage-categories.php');
  die();
}
?>

<!-- ! edit category  -->
<section class="form_section">
  <div class="container form_section-container">
    <h2>Edit Category</h2>
    <div class="alert_message error">
      <p>This is an error message</p>
    </div>
    <form action="<?= ROOT_URL ?>admin/logic/edit-category-logic.php" method="POST">
      <input type="hidden" name="id" value="<?= $category['id'] ?>">
      <input type="text" name="title" placeholder="Title" value="<?= $category['title'] ?>" />
      <textarea rows="4" name="description" placeholder="Description"><?= htmlspecialchars($category['description']) ?></textarea>
      <button type="submit" name="submit" class="btn">Update Category</button>
    </form>
  </div>
</section>
<?php
include '../partials/footer.php'
?>