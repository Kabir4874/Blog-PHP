<?php
include 'partials/header.php';
?>

<!-- !featured  -->
<section class="featured">
  <div class="container featured_container">
    <div class="post_thumbnail">
      <img src="./assets/blog1.jpg" alt="blog" />
    </div>
    <div class="post_info">
      <a href="category-posts.html" class="category_button">Wild Life</a>
      <h2 class="post_title">
        <a href="post.html">Lorem ipsum dolor sit amet consectetur adipisicing elit.
          Expedita, nostrum?</a>
      </h2>
      <p class="post_body">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda,
        natus minus. Distinctio voluptatum molestias est corporis incidunt
        mollitia ad fuga!
      </p>
      <div class="post_author">
        <div class="post_author-avatar">
          <img src="./assets/avatar2.jpg" alt="avatar" />
        </div>
        <div class="post_author-info">
          <h5>By: Jane Doe</h5>
          <small>June 10, 2025 - 07:25</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- !posts  -->
<section class="posts">
  <div class="container posts_container">
    <article class="post">
      <div class="post_thumbnail">
        <img src="./assets/blog2.jpg" alt="blog" />
      </div>
      <div class="post_info">
        <a href="category-posts.html" class="category_button">Wild Life</a>
        <h3 class="post_title">
          <a href="post.html">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cum,
            accusamus.</a>
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

<!-- !category buttons  -->
<section class="category_buttons">
  <div class="container category_buttons-container">
    <a href="" class="category_button">Art</a>
    <a href="" class="category_button">Wild Life</a>
    <a href="" class="category_button">Travel</a>
    <a href="" class="category_button">Science & Technology</a>
    <a href="" class="category_button">Food</a>
    <a href="" class="category_button">Music</a>
  </div>
</section>

<?php
include 'partials/footer.php'
?>