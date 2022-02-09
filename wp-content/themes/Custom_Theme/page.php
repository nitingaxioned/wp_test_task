<?php 
  get_header();  
  $title = get_the_title();
  $content = get_the_content();
?>
<!--main section start-->
    <main>
      <!--section start-->
      <section>
        <div class="wrapper">
          <h2><?php echo $title;  ?></h2>
          <?php echo $content;  ?>
        </div>
      </section>
      <!--section end-->
    </main>
    <!--main section end-->
    <?php
get_footer();