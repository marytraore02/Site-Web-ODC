<?php
/**
 * Template part for displaying posts
 * @package WordPress
 * @subpackage multicolor-business
 * @since 1.0
 * @version 1.4
 */

?>
<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="article_content">   
    <div class="article-text">
      <h1><?php esc_html(the_title()); ?></h1>       
      <?php the_post_thumbnail(); ?>
      <div class="metabox"> 
        <span class="entry-date"><i class="fas fa-calendar"></i><?php the_time( get_option( 'date_format' ) ); ?></span><span>|</span>
        <a href="<?php echo esc_url( get_permalink() );?>"><i class="fas fa-user"></i><span class="entry-author"><?php esc_html(the_author()); ?></span></a><span>|</span>
        <a href="<?php echo esc_url( get_permalink() );?>"><i class="fas fa-comments"></i><span class="entry-comments"><?php comments_number( __('0 Comments','multicolor-business'), __('0 Comments','multicolor-business'), __('% Comments','multicolor-business') ); ?></span></a>
      </div>
      <p><?php the_content(); ?></p>      
    </div>
    <div class="clearfix"></div> 
  </div>
</div>