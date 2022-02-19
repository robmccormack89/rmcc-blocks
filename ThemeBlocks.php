<?php
namespace Rmcc;
use Timber\Timber;
use Timber\Post;
use Timber\PostQuery;

array_unshift(
  Theme::$dirname, 
  'inc/acf/blocks/templates',
  'inc/acf/blocks/templates/no-acf',
  'inc/acf/blocks/templates/simple',
  'inc/acf/blocks/templates/muted',
  'inc/acf/blocks/macros'
);

class ThemeBlocks {
  
  public function __construct() {

    add_action('acf/init', array($this, 'register_blocks'));
    add_action('enqueue_block_assets', array($this, 'acf_blocks_editor_scripts')); // use 'enqueue_block_editor_assets' for backend-only
    
  }
  
  public function register_blocks() {
    
    if(!function_exists('acf_register_block')) return;
    
    $example_block_data = array(
      
      // *required
      'name' => 'cover_section',
      'title' => 'Cover section',
      
      // the callback function
      'render_callback' => array($this, 'cover_section_render_callback'), // the callback function
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true,
        'align_text' => true, // allow text align: left, center & right
        'align_content' => true, // allow content align: top, center(middle) & bottom
        'full_height' => true, // allow full height toggle
        'mode' => false, // allow toggle for edit/preview mode
        'jsx' => false // enable for when using <InnerBlocks /> component
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_text' => 'center',
      'align_content' => 'center',
      'full_height' => true,
      'mode' => 'preview',
      
      // *optional
      'description' => 'All fields are optional.', // *optional
      
      // category & icon
      'category' => 'text',
      'icon' => 'cover-image',
      
      // keywords by which to search for the block
      'keywords' => array('cover', 'section'),
      
      // example data for block selection previews 
      // 'example' => array(
      //   'attributes' => array(
      //     'mode' => 'preview',
      //     'data' => array(
      //       'cover_heading' => "Lorem ipsum dolor sit amet",
      //       'cover_desc' => "Lorem ipsum dolor sit amet consectetur adipisicing",
      //       'cover_btn_txt' => "Lorem ipsum",
      //       'cover_btn_url' => "#",
      //       'cover_bottom' => "<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor | </span><span>Tel: <a href=\"tel:01234567\">01234567</a> </span><span>Email: <a href=\"mailto:info@example.com\">info@example.com</a></span>",
      //     )
      //   )
      // )
      
    );
    
    /*
    No acf fields used
    */
    
    acf_register_block(array( // blog posts section 
      
      // *required
      'name' => 'blog_posts',
      'title' => 'Blog posts section',
      
      // the callback function
      'render_callback' => array($this, 'blog_posts_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true, 
        'align_text' => false, 
        'align_content' => false, 
        'full_height' => false, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align' => '',
      
      // *optional
      'description' => 'Requires some published posts.',
      
      // category & icon
      '__category' => 'text',
      'icon' => 'list-view',
      
      // keywords by which to search for the block
      'keywords' => array('blog', 'posts'),
    ));
    
    /*
    Simple blocks
    */
    
    acf_register_block(array( // contact section 
      
      // *required
      'name' => 'contact_section',
      'title' => 'Contact section',
      
      // the callback function
      'render_callback' => array($this, 'contact_section_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true, 
        'align_text' => true, 
        'align_content' => true, 
        'full_height' => false, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_text' => 'center',
      'align_content' => 'center',
      
      // *optional
      'description' => 'All fields are optional',
      
      // category & icon
      '__category' => 'text',
      'icon' => 'align-pull-right',
      
      // keywords by which to search for the block
      'keywords' => array('contact', 'section'),
      
    ));
    
    acf_register_block(array( // cover section 
      
      // *required
      'name' => 'cover_section',
      'title' => 'Cover section',
      
      // the callback function
      'render_callback' => array($this, 'cover_section_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true,
        'align_text' => true,
        'align_content' => true,
        'full_height' => true,
        'mode' => false,
        'jsx' => false
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_text' => 'center',
      'align_content' => 'center',
      'full_height' => true,
      'mode' => 'preview',
      
      // *optional
      'description' => 'All fields are optional',
      
      // category & icon
      '__category' => 'text',
      'icon' => 'cover-image',
      
      // keywords by which to search for the block
      'keywords' => array('cover', 'section'),
      
    ));
    
    acf_register_block(array( // cta section 
      
      // *required
      'name' => 'cta_section',
      'title' => 'CTA section',
      
      // the callback function
      'render_callback' => array($this, 'cta_section_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true,
        'align_text' => true, 
        'align_content' => false, 
        'full_height' => false, 
        'mode' => false,
        'jsx' => false // enable for when using <InnerBlocks /> component
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_text' => 'center',
      
      // *optional
      'description' => 'All fields are optional',
      
      // category & icon
      '__category' => 'text', // what category the lock will be in 
      'icon' => 'editor-aligncenter', // icon used for the block (dashicons)
      
      // keywords by which to search for the block
      'keywords' => array('cta', 'section'),
      
    ));
    
    acf_register_block(array( // video section 
      
      // *required
      'name' => 'video_popup_section',
      'title' => 'Video popup section',
      
      // the callback function
      'render_callback' => array($this, 'video_popup_section_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true, 
        'align_text' => false, 
        'align_content' => 'matrix', 
        'full_height' => true, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_content' => 'center center',
      
      // *optional
      'description' => 'All fields are optional',
      
      // category & icon
      '__category' => 'text',
      'icon' => 'youtube',
      
      // keywords by which to search for the block
      'keywords' => array('video', 'popup'),
      
    ));
    
    /*
    layout: featured content on muted background
    */
    
    acf_register_block(array( // Featured content section: post object field 
      
      // *required
      'name' => 'featured_content',
      'title' => 'Featured content section',
      
      // the callback function
      'render_callback' => array($this, 'featured_content_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true, 
        'align_text' => true, 
        'align_content' => true, 
        'full_height' => false, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_text' => 'center',
      'align_content' => 'center',
      
      // *optional
      'description' => 'All fields are optional. Use the custom fields to override the selected featured content, or instead of it.',
      
      // category & icon
      '__category' => 'text',
      'icon' => 'align-center',
      
      // keywords by which to search for the block
      'keywords' => array('featured', 'content'),
      
    ));
    
    acf_register_block(array( // Featured gallery section: gallery field. uses lightgallery 
      
      // *required
      'name' => 'featured_gallery',
      'title' => 'Featured gallery section',
      
      // the callback function
      'render_callback' => array($this, 'featured_gallery_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true, 
        'align_text' => true, 
        'align_content' => true, 
        'full_height' => false, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_text' => 'center',
      'align_content' => 'center',
      
      // *optional
      'description' => 'All fields are optional.',
      
      // category & icon
      '__category' => 'text',
      'icon' => 'format-gallery',
      
      // keywords by which to search for the block
      'keywords' => array('featured', 'content'),
      
    ));
      
  }
  
  public function _register_blocks() {
    
    if (! function_exists('acf_register_block')) {
      return;
    }
    
    /*
    repeater fields
    */
    
    acf_register_block(array(
      'name' => 'featured_items',
      'title' => 'Featured items section',
      'description' => 'Add some pages/posts & display them as columns in a row.',
      'render_callback' => array($this, 'featured_items_render_callback'),
      'category' => 'text',
      'icon' => 'sticky',
      'keywords' => array('featured', 'items'),
    ));
    acf_register_block(array( // uses swiper 
      'name' => 'slider_section',
      'title' => 'Slider section',
      'description' => 'A slideshow carousel with optional overlay & content',
      'render_callback' => array($this, 'slider_section_render_callback'),
      'category' => 'text',
      'icon' => 'slides',
      'keywords' => array('slider', 'section'),
    ));
    acf_register_block(array( // uses swiper 
      'name' => 'testimonials',
      'title' => 'Testimonials section',
      'description' => 'A testimonials & rating carousel',
      'render_callback' => array($this, 'testimonials_render_callback'),
      'category' => 'text',
      'icon' => 'editor-quote',
      'keywords' => array('testimonials', 'rating'),
    ));
      
  }
  
  // no ACF fields used. 2 posts arrays, first_posts & second_posts. uses stickies
  public function blog_posts_render_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
  
    // get sticky posts before get_posts 
    $sticky = get_option('sticky_posts');
  
    // the first post (sticky enabled)
    $args1 = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => '1',
      'post__in'   => $sticky,
      'ignore_sticky_posts' => 1,
      'orderby' => 'date',
      'order' => 'DESC',
    );
    $context['first_posts'] = Timber::get_posts($args1);
  
    // the 2nd and/or 3rd post/s (with stickies enabled)
    $args2 = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => '2',
      'orderby' => 'date',
      'order' => 'DESC',
    );
    if($sticky) {
      $args2['post__not_in'] = $sticky;
    } 
    else {
      $args2['offset'] = '1';
    }
    $context['second_posts'] = Timber::get_posts($args2);
  
    Timber::render('blog-posts-section.twig', $context);
  }
  
  // simple blocks
  public function contact_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Theme::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Theme::render('contact-section.twig', $context);
  }
  public function cover_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Theme::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Theme::render('cover-section.twig', $context);
  }
  public function cta_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Theme::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Theme::render('cta-section.twig', $context);
  }
  public function video_popup_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Theme::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Theme::render('video-section.twig', $context);
  }
  
  // layout: featured content on muted background
  public function featured_content_render_callback($block, $content = '', $is_preview = false) { // Gets 'select_featured_item' -> 'post' 
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
  
    // set the 'post' using the 'select_fcontent_item' if it exists
    if($context['fields']['select_featured_content']){
      $context['post'] = new Post($context['fields']['select_featured_content']);
    }
  
    Timber::render('featured-content-section.twig', $context);
  }
  public function featured_gallery_render_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Timber::render('featured-gallery-section.twig', $context);
  }
  
  // the rest
  // public function slider_section_render_callback($block, $content = '', $is_preview = false) {
  //   $context = Timber::context();
  //   $context['block'] = $block;
  //   $context['fields'] = get_fields();
  //   $context['is_preview'] = $is_preview;
  //   Timber::render('slider-section.twig', $context);
  // }
  // public function testimonials_render_callback($block, $content = '', $is_preview = false) {
  //   $context = Timber::context();
  //   $context['block'] = $block;
  //   $context['fields'] = get_fields();
  //   $context['is_preview'] = $is_preview;
  //   Timber::render('testimonials-section.twig', $context);
  // }
  // public function featured_items_render_callback($block, $content = '', $is_preview = false) { // Gets 'featured_pages' -> 'posts' 
  //   $context = Timber::context();
  //   $context['block'] = $block;
  //   $context['fields'] = get_fields();
  //   $context['is_preview'] = $is_preview;
  // 
  //   // repeater: join post object from select_featured_item to featured_item if it exists
  //   if($context['fields']['featured_items']){
  //     $items = null;
  //     foreach($context['fields']['featured_items'] as $item){
  //       if($item['select_featured_item']){
  //         $item['post'] = new Post($item['select_featured_item']);
  //       }
  //       $items[] = $item;
  //     }
  //     $context['items'] = $items;
  //   }
  // 
  //   Timber::render('featured-items-section.twig', $context);
  // }

  public function acf_blocks_editor_scripts() {
    
    // swiper
    wp_enqueue_style(
      'swiper',
      get_template_directory_uri() . '/inc/acf/blocks/assets/css/swiper-bundle.min.css'
    );
    wp_enqueue_script(
      'swiper-js',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/swiper-bundle.min.js',
      '',
      '1.0.0',
      false
    );
    
    // lightgallery
    wp_enqueue_style(
      'lightgallery',
      get_template_directory_uri() . '/inc/acf/blocks/assets/css/lightgallery.min.css'
    );
    wp_enqueue_script(
      'lightgallery',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/lightgallery.min.js',
      '',
      '1.0.0',
      false
    );
    // lg thumbnail
    wp_enqueue_script(
      'lg-thumbnail',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/lg-thumbnail.min.js',
      '',
      '1.0.0',
      false
    );
    // lg zoom
    wp_enqueue_script(
      'lg-zoom',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/lg-zoom.min.js',
      '',
      '1.0.0',
      false
    );
    // lg fullscreen
    wp_enqueue_script(
      'lg-fullscreen',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/lg-fullscreen.min.js',
      '',
      '1.0.0',
      false
    );
    // lg share
    wp_enqueue_script(
      'lg-share',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/lg-share.min.js',
      '',
      '1.0.0',
      false
    );
    // lg hash
    wp_enqueue_script(
      'lg-hash',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/lg-hash.min.js',
      '',
      '1.0.0',
      false
    );
  
  }

}