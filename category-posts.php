<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
  $result = mysqli_query($connection, $query);
} else {
  header('location: ' . ROOT_URL . 'blog.php');
  die();
}
?>

<!-- !header  -->
<header class="category_title">
  <?php
  $category_query = "SELECT title FROM categories WHERE id=$id";
  $category_result = mysqli_query($connection, $category_query);
  $category = mysqli_fetch_assoc($category_result);
  ?>
  <h2><?= $category['title'] ?></h2>
</header>

<!-- !posts  -->
<section class="posts">
  <div class="container posts_container">
    <?php while ($post = mysqli_fetch_assoc($result)): ?>
      <article class="post">
        <div class="post_thumbnail">
          <img src="./assets/<?= $post['thumbnail'] ?>" alt="blog" style="height:250px" />
        </div>
        <div class="post_info">
          <?php
          $category_id = $post['category_id'];
          $category_query = "SELECT title FROM categories WHERE id=$category_id";
          $category_result = mysqli_query($connection, $category_query);
          $category = mysqli_fetch_assoc($category_result);
          ?>
          <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
          <h3 class="post_title">
            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
          </h3>
          <p class="post_body">
            <?= substr($post['body'], 0, 150) ?>...
          </p>
          <div class="post_author">
            <?php
            $author_id = $post['author_id'];
            $author_query = "SELECT firstname,lastname,avatar FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post_author-avatar">
              <img src="./assets/<?= $author['avatar'] ?>" alt="avatar" />
            </div>
            <div class="post_author-info">
              <h5>By: <?= $author['firstname'] . " " . $author['lastname'] ?></h5>
              <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
          </div>
        </div>
      </article>
    <?php endwhile ?>
  </div>
</section>

<section class="category_buttons">
  <div class="container category_buttons-container">
    <?php
    $all_categories_query = "SELECT id,title FROM categories";
    $all_categories = mysqli_query($connection, $all_categories_query);
    ?>
    <?php while ($category = mysqli_fetch_assoc($all_categories)): ?>
      <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
    <?php endwhile ?>
  </div>
</section>
<?php
include 'partials/footer.php'
?>