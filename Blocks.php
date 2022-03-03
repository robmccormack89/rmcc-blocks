<?php
namespace Rmcc;
use Timber\Timber;
use Timber\Post;
use Timber\PostQuery;

/*

  Blocks: Adds some ACF Blocks to the gutenberg editor & renders them with Twig/Timber...//
  
  How to use Blocks: 

    1. Add directory to main project's psr-4 autoload in composer.json

    2. Copy json data files to theme's local json data directory (replace when updated via the backend prior to git push)

    3. Init Blocks class (when ACF & Timber are available)
    
  Blocks assumes the use of:
  
    1. Timber library (loaded via theme's composer.json)
  
    2. ACF plugin (PRO version installed as a plugin)
    
    3. UiKit frontend framework (scripts & styles loaded via theme)
    
    4. Fontawesome icons (scripts & styles loaded via theme)

*/

array_unshift(
  Timber::$dirname, 
  'inc/acf/blocks/macros',
  
  // views
  'inc/acf/blocks/views',
  
  // featured-muted style (featured content card on muted bg)
  'inc/acf/blocks/views/featured-muted',
  'inc/acf/blocks/views/featured-muted/featured-content-section',
  'inc/acf/blocks/views/featured-muted/featured-gallery-section',
    
  // blocks not using any ACF fields*****
  // 'inc/acf/blocks/views/no-acf',
  // 'inc/acf/blocks/views/no-acf/blog-posts-section',
    
  // blocks using repeater fields*****
  'inc/acf/blocks/views/repeater',
  'inc/acf/blocks/views/repeater/featured-items-section',
  
  // blocks with repeater fields using swiper*****
  'inc/acf/blocks/views/repeater/swiper',
  'inc/acf/blocks/views/repeater/swiper/slider-section',
  'inc/acf/blocks/views/repeater/swiper/testimonials-section',
    
  // simple blocks (simple fields like: image, heading, message, button text & url etc...)
  'inc/acf/blocks/views/simple',
);

class Blocks {
  
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
      '__description' => 'All fields are optional.', // *optional
      
      // category & icon
      'category' => 'design',
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
      '__description' => 'All fields are optional',
      
      // category & icon
      'category' => 'design',
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
      '__description' => 'All fields are optional',
      
      // category & icon
      'category' => 'design',
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
      '__description' => 'All fields are optional',
      
      // category & icon
      'category' => 'design', // what category the lock will be in 
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
      '__description' => 'All fields are optional',
      
      // category & icon
      'category' => 'design',
      'icon' => 'youtube',
      
      // keywords by which to search for the block
      'keywords' => array('video', 'popup'),
      
    ));
    
    /*
    layout: featured content card on muted background
    */
    
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
      '__description' => 'All fields are optional.',
      
      // category & icon
      'category' => 'design',
      'icon' => 'format-gallery',
      
      // keywords by which to search for the block
      'keywords' => array('featured', 'content'),
      
    ));
    
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
      '__description' => 'All fields are optional. Use the custom fields to override the selected featured content, or instead of it.',
      
      // category & icon
      'category' => 'design',
      'icon' => 'align-center',
      
      // keywords by which to search for the block
      'keywords' => array('featured', 'content'),
      
    ));
    
    /*
    repeater fields
    */
    
    acf_register_block(array( // Featured items section 
      
      // *required
      'name' => 'featured_items',
      'title' => 'Featured items section',
      
      // the callback function
      'render_callback' => array($this, 'featured_items_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true, 
        'align_text' => false, 
        'align_content' => 'matrix', 
        'full_height' => false, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_content' => 'center center',
      
      // *optional
      '__description' => '',
      
      // category & icon
      'category' => 'design',
      'icon' => 'sticky',
      
      // keywords by which to search for the block
      'keywords' => array('featured', 'items'),
      
    ));
    
    /*
    repeater fields with swiper
    */
    
    acf_register_block(array(
      
      // *required
      'name' => 'slider_section',
      'title' => 'Slider section',
      
      // the callback function
      'render_callback' => array($this, 'slider_section_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => true, 
        'align_text' => true, 
        'align_content' => true, 
        'full_height' => true, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align' => 'full',
      'align_text' => 'center', 
      'align_content' => 'center', 
      
      // *optional
      '__description' => '',
      
      // category & icon
      'category' => 'design',
      'icon' => 'slides',
      
      // keywords by which to search for the block
      'keywords' => array('slider', 'section'),
      
    ));
    
    acf_register_block(array(
      
      // *required
      'name' => 'testimonials',
      'title' => 'Testimonials section',
      
      // the callback function
      'render_callback' => array($this, 'testimonials_render_callback'),
      
      // what block settings does this block allow
      'supports' => array(
        'align' => false, 
        'align_text' => true, 
        'align_content' => false, 
        'full_height' => false, 
        'mode' => false
      ),
      
      // the defaults for various block settings
      'align_text' => 'center', 
      
      // *optional
      '__description' => 'A testimonials & rating carousel',
      
      // category & icon
      'category' => 'design',
      'icon' => 'editor-quote',
      
      // keywords by which to search for the block
      'keywords' => array('testimonials', 'rating'),
      
    ));
    
    /*
    No acf fields used
    */
    
    // acf_register_block(array( // blog posts section 
    // 
    //   // *required
    //   'name' => 'blog_posts',
    //   'title' => 'Blog posts section',
    // 
    //   // the callback function
    //   'render_callback' => array($this, 'blog_posts_render_callback'),
    // 
    //   // what block settings does this block allow
    //   'supports' => array(
    //     'align' => true, 
    //     'align_text' => false, 
    //     'align_content' => false, 
    //     'full_height' => false, 
    //     'mode' => false
    //   ),
    // 
    //   // the defaults for various block settings
    //   'align' => '',
    // 
    //   // *optional
    //   '__description' => 'Requires some published posts.',
    // 
    //   // category & icon
    //   'category' => 'design',
    //   'icon' => 'list-view',
    // 
    //   // keywords by which to search for the block
    //   'keywords' => array('blog', 'posts'),
    // ));
      
  }

  public function acf_blocks_editor_scripts() {
    
    // swiper
    wp_enqueue_style(
      'swiper',
      get_template_directory_uri() . '/inc/acf/blocks/assets/css/lib/swiper-bundle.min.css'
    );
    wp_enqueue_script(
      'swiper-js',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/lib/swiper-bundle.min.js',
      '',
      '1.0.0',
      false
    );
    
    // blocks (lightgallery)
    wp_enqueue_style(
      'rmcc-blocks',
      get_template_directory_uri() . '/inc/acf/blocks/assets/css/blocks.css'
    );
    wp_enqueue_script(
      'rmcc-blocks',
      get_template_directory_uri() . '/inc/acf/blocks/assets/js/blocks.js',
      '',
      '1.0.0',
      false
    );
  
  }
  
  // simple blocks
  public function contact_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Timber::render('contact-section.twig', $context);
  }
  public function cover_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Timber::render('cover-section.twig', $context);
  }
  public function cta_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Timber::render('cta-section.twig', $context);
  }
  public function video_popup_section_render_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Timber::render('video-section.twig', $context);
  }
  
  // layout: featured content on muted background
  public function featured_gallery_render_callback($block, $content = '', $is_preview = false) {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Timber::render('featured-gallery-section.twig', $context);
  }
  public function featured_content_render_callback($block, $content = '', $is_preview = false) { // 'select_post_object' -> $context['post'] 
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
  
    // set the 'post' using the 'select_post_object', if it exists
    if($context['fields'] && $context['fields']['select_post_object']){
      $context['post'] = new Post($context['fields']['select_post_object']);
    }
  
    Timber::render('featured-content-section.twig', $context);
  }
  
  // repeater
  public function featured_items_render_callback($block, $content = '', $is_preview = false) { // 'featured_items' -> $context['items'] 
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
  
    // join to the selected post to the repeater field item, if it exists. can be found at .post of featured_items item
    if($context['fields'] && $context['fields']['featured_items']){
      $items = null;
      foreach($context['fields']['featured_items'] as $item){
        if($item['select_post_object']){
          $item['post'] = new Post($item['select_post_object']);
        }
        $items[] = $item;
      }
      $context['items'] = $items;
    }
  
    Timber::render('featured-items-section.twig', $context);
  }
  
  // repeater with swiper
  public function slider_section_render_callback($block, $content = '', $is_preview = false) { 
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;

    Timber::render('slider-section.twig', $context);
  }
  public function testimonials_render_callback($block, $content = '', $is_preview = false) { 
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    
    Timber::render('testimonials-section.twig', $context);
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
    $context['first_posts'] = new PostQuery($args1);
  
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
    $context['second_posts'] = new PostQuery($args2);
  
    Timber::render('blog-posts-section.twig', $context);
  }

}