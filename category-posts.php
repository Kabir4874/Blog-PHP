<?php
include 'partials/header.php';
?>

    <!-- !header  -->
    <header class="category_title">
      <h2>Category Title</h2>
    </header>

    <!-- !posts  -->
    <section class="posts">
      <div class="container posts_container">
        <article class="post">
          <div class="post_thumbnail">
            <img src="./assets/blog2.jpg" alt="blog" />
          </div>
          <div class="post_info">
            <a href="category-posts.php" class="category_button">Wild Life</a>
            <h3 class="post_title">
              <a href="post.php"
                >Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cum,
                accusamus.</a
              >
            </h3>
            <p class="post_body">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Inventore ab, fugiat repudiandae doloremque atque nemo vitae quod
              molestiae totam ut.
            </p>
            <div class="post_author">
              <div class="post_author-avatar">
                <img src="./assets/avatar3.jpg" alt="avatar" />
              </div>
              <div class="post_author-info">
                <h5>By: John Mills</h5>
                <small>June 13, 2025 - 10:34</small>
              </div>
            </div>
          </div>
        </article>
      </div>
    </section>
<?php
include 'partials/footer.php'
?>