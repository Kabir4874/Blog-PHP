<?php
include 'partials/header.php';
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($connection, $query);
?>

<!-- !search bar  -->
<section class="search_bar">
  <form action="" class="container search_bar-container">
    <div>
      <i class="uil uil-search"></i>
      <input type="search" name="" placeholder="Search" />
    </div>
    <button type="submit" class="btn">GO</button>
  </form>
</section>

<!-- !posts  -->
<section class="posts">
  <div class="container posts_container">
    <?php while ($post = mysqli_fetch_assoc($posts)): ?>
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

<!-- !category buttons  -->
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