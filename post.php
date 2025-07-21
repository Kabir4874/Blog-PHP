<?php
include 'partials/header.php';

// fetch post from database if id is set 
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($result);
} else {
  header('location: ' . ROOT_URL . 'blog.php');
  die();
}
?>

<!-- !single post  -->
<section class="single-post">
  <div class="container single-post_container">
    <h2>
      <?= $post['title'] ?>
    </h2>
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
    <div class="single-post_thumbnail">
      <img src="./assets/<?= $post['thumbnail'] ?>" alt="blog" />
    </div>
    <p>
      <?= $post['body'] ?>
    </p>
  </div>
</section>
<?php
include 'partials/footer.php'
?>