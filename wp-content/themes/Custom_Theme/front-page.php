<?php 
  get_header();  
  the_post();
  $title = get_the_title();
  $content = get_the_content();
?>
    <!--main section start-->
    <main>
      <div class="wrapper">
        <h2><?php echo $title;  ?></h2>
        <?php echo $content;  ?>
        <select name="cat" class='cat'>
          <option value="all">All</option>
          <?php
            $temp = get_field('filter_cat');
            foreach($temp as $val){
              $tab_name = get_term($val, '', 'ARRAY_A')['name'];
              ?>
              <option value="<?php echo $val; ?>"><?php echo $tab_name; ?></option>
              <?php
            }
          ?>
				</select>
        <ul class='filter-box lists'>
          <li><p>Loading...</p></li>
        </ul>
		    <button class='btn load_more'>Load More</button>
		    <button class='btn show_less'>Show Less</button>
      </div>
    </main>
    <!--main section end-->
<?php
  get_footer();  
?>