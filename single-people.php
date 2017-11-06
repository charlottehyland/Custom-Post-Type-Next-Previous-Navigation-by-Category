
<?php
  // On the main Practice Area page, and below, you can see that the link to the next/prev person stores the practice area in the URL to help filter which people are part of which practice area later.
   $urlSlug = $_GET["practice"];
?>
<?php
   if($urlSlug != NULL) {
      $post_id = $post->ID;
      $cat = $urlSlug;
      $args = array(
           'post_type' => 'people',
           'posts_per_page' => 100,
           'tax_query' => array(
             array(
               // Match the person's associated practice area with the practice area stored in the URL
               'taxonomy' => 'associated_practice_area',
               'field' => 'slug',
               'terms' => $urlSlug
             )
           ),
           'orderby' => 'meta_value',
           'order' => 'ASC',
           'meta_key' => 'last_name'
       );
       $posts = get_posts( $args );
       // get IDs of posts retrieved from get_posts
       $ids = array();
       foreach ( $posts as $thepost ) {
           $ids[] = $thepost->ID;
       }
       // get and echo previous and next post in the same category
       $thisindex = array_search( $post_id, $ids );
       $previd = isset($ids[ $thisindex - 1 ]) ? $ids[ $thisindex - 1 ] : end($ids);
       $nextid = isset($ids[ $thisindex + 1 ]) ? $ids[ $thisindex + 1 ] : $ids[0];

       if ( ! empty( $previd ) ) {
           ?><a rel="prev" class="prev-person" href="<?php echo get_permalink($previd) ?>?practice=<?php echo $urlSlug;?>"><i class="fa fa-angle-left"></i></a><?php
       }
       if ( ! empty( $nextid ) ) {
           ?><a rel="next" class="next-person" href="<?php echo get_permalink($nextid) ?>?practice=<?php echo $urlSlug;?>"><i class="fa fa-angle-right"></i></a><?php
       }?>

   <?php } else if($urlSlug == NULL) { ?>

      <!-- General People Next/Previous, sorted alphabetically by last name, not filtered into their practice area. -->

         <?php next_post_link_plus( array(
            'meta_key' => 'last_name',
            'order_by' => 'custom',
            'loop' => true,
            'link' => '<i class="next-person fa fa-angle-right"></i>') );
          ?>
         <?php previous_post_link_plus( array(
           'meta_key' => 'last_name',
           'order_by' => 'custom',
           'loop' => true,
           'link' => '<i class="prev-person fa fa-angle-left"></i>') );
         ?>

 <?php } ?>

