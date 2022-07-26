<?php
/**
 * Template part for displaying posts
 * @package WordPress
 * @subpackage multicolor-business
 * @since 1.0
 * @version 1.4
 */

?>
<div class="col-lg-4 col-md-4">
	<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
    <div class="article_content">   
      <div class="article-text">
        <h3><?php esc_html(the_title()); ?></h3>      
        <?php the_post_thumbnail(); ?>
        <div class="metabox"> 
          <span class="entry-date"><i class="fas fa-calendar"></i><?php the_time( get_option( 'date_format' ) ); ?></span><span>|</span>
          <a href="<?php echo esc_url( get_permalink() );?>"><i class="fas fa-user"></i><span class="entry-author"><?php esc_html(the_author()); ?></span></a><span>|</span>
          <a href="<?php echo esc_url( get_permalink() );?>"><i class="fas fa-comments"></i><span class="entry-comments"><?php comments_number( __('0 Comments','multicolor-business'), __('0 Comments','multicolor-business'), __('% Comments','multicolor-business') ); ?></span></a>
        </div>
        <p><?php $excerpt = get_the_excerpt();echo esc_html( multicolor_business_string_limit_words( $excerpt,30 ) ); ?></p>      
        <div class="know-btn">
          <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small" title="<?php esc_attr_e( 'Know More', 'multicolor-business' ); ?>"><?php esc_html_e('Know More','multicolor-business'); ?>
          </a>
        </div>
      </div>
      <div class="clearfix"></div> 
    </div>
  </div>
</div>