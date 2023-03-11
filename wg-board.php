<?php
use classes\ChatGpt;
use classes\BlogPost;

require plugin_dir_path(__FILE__) . 'classes/ChatGpt.php';
require plugin_dir_path(__FILE__) . 'classes/BlogPost.php';


// Check if the required class exists
if (!class_exists('classes\ChatGpt')) {
    exit('The Settings class is missing.');
}

global $wpdb;
$chatGPT = new ChatGpt($wpdb);

$languages = ["ua","en"];

if(in_array($chatGPT->language,$languages)) {
    include plugin_dir_path(__FILE__)."language/".$chatGPT->language.".php";
} else {
    include plugin_dir_path(__FILE__)."language/en.php";
}

if (isset($_POST['generate'])){
    $user_input = $_POST['request'];
    $chatGPT->generate_content($user_input);
}



function imgPath($path){
    return plugin_dir_url(__FILE__).'img/assets/'.$path;
}



$result = wp_get_recent_posts( [
    'numberposts'      => 5,
    'offset'           => 0,
    'category'         => 0,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'post',
    'post_status'      => 'draft, publish, future, pending, private',
    'suppress_filters' => true,
], OBJECT );

?>

<section class="chat">
    <div class="container">
        <div class="settings__logo-box"><a class="settings__logo" href="/"><img class="settings__logo-img" src="<?= imgPath('logo.png');?>" alt="logo GPT WriteGenie"></a></div>
        <div class="bg" style="background-image: url('<?= imgPath('bg.jpg')?>')">
            <div class="chat__wrap">
                <div class="chat__left-form-box">
                    <form class="chat__form form-bg" method="POST">
                        <label class="chat__label" for="">Request to Chat GPT
                            <textarea class="chat__text text-to-copy" name="request" id="" cols="30" rows="10"
                                      placeholder="Example: write short article about the most popular pc games "><?php echo $chatGPT->getResult()['content'] ?? ''; ?></textarea>
                            <div class="copy-message"></div>
                            <button class="chat__coppy">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7916 21.875H8.33325V7.29166H19.7916M19.7916 5.20832H8.33325C7.78072 5.20832 7.25081 5.42782 6.86011 5.81852C6.46941 6.20922 6.24992 6.73912 6.24992 7.29166V21.875C6.24992 22.4275 6.46941 22.9574 6.86011 23.3481C7.25081 23.7388 7.78072 23.9583 8.33325 23.9583H19.7916C20.3441 23.9583 20.874 23.7388 21.2647 23.3481C21.6554 22.9574 21.8749 22.4275 21.8749 21.875V7.29166C21.8749 6.73912 21.6554 6.20922 21.2647 5.81852C20.874 5.42782 20.3441 5.20832 19.7916 5.20832ZM16.6666 1.04166H4.16659C3.61405 1.04166 3.08415 1.26115 2.69345 1.65185C2.30275 2.04255 2.08325 2.57246 2.08325 3.12499V17.7083H4.16659V3.12499H16.6666V1.04166Z"
                                          fill="#8B8B8B"/>
                                </svg>
                            </button>
                            <div class="chat__btn-box">
                                <input class="btn btn--save" type="submit" name="generate" value="Generate">
                            </div>
                        </label>
                    </form>

                    <form class="chat__form form-bg" method="POST"><label class="chat__label" ><?php echo $lang["blogTitle"]?>
                            <input
                                    class="chat__input input" name="title" placeholder="Example: the most popular pc games" value="<?php echo $chatGPT->getResult()['title'] ?? '';?>"></label>
                        <label class="chat__label">Post Content <textarea class="chat__text text-to-copy" name="content"
                                                                                 id="" cols="30" rows="10"><?php echo $chatGPT->getResult()['content'] ?? ''; ?></textarea>
                            <button class="chat__coppy chat__coppy--post-content">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7916 21.875H8.33325V7.29166H19.7916M19.7916 5.20832H8.33325C7.78072 5.20832 7.25081 5.42782 6.86011 5.81852C6.46941 6.20922 6.24992 6.73912 6.24992 7.29166V21.875C6.24992 22.4275 6.46941 22.9574 6.86011 23.3481C7.25081 23.7388 7.78072 23.9583 8.33325 23.9583H19.7916C20.3441 23.9583 20.874 23.7388 21.2647 23.3481C21.6554 22.9574 21.8749 22.4275 21.8749 21.875V7.29166C21.8749 6.73912 21.6554 6.20922 21.2647 5.81852C20.874 5.42782 20.3441 5.20832 19.7916 5.20832ZM16.6666 1.04166H4.16659C3.61405 1.04166 3.08415 1.26115 2.69345 1.65185C2.30275 2.04255 2.08325 2.57246 2.08325 3.12499V17.7083H4.16659V3.12499H16.6666V1.04166Z"
                                          fill="#8B8B8B"/>
                                </svg>
                            </button>
                            <div class="copy-message"></div>
                        </label>
                        <h3 class="chat__category">Category</h3>
                        <div class="chat__checkbox-inner">
                            <?php
                            $categories = get_categories([ 'hide_empty' => 0 ]);
                            foreach ($categories as $category):?>
                            <label class="chat__lab-check" ><input  type="checkbox"  value="<?= $category->term_id ?>" class="chat__real-checkbox">
                                <span class="chat__castom-chekbox"></span><?= $category->name?></label>
                            <?php endforeach ?>
                            <input type="text" class="chat__real-checkbox--hidden" name="category" value="1" hidden="">
                            </div>
                        <div class="chat__label"><p>Key Words</p><input class="chat__key" name="keys" value="<?php echo $chatGPT->getResult()['keywords'] ?? 'sport,football'; ?>">
                            <div class="chat__details"><span class="chat__keys"></span></div>
                        </div>
                        <div id="group">
                            <fieldset class="switch">
                                <legend>Publish post: </legend>

                                <input id="yes" name="view" type="radio" value="yes">
                                <label for="yes">Yes</label>

                                <input id="no" name="view" type="radio" value="no" checked>
                                <label for="no">No</label>

                                <span class="switch-button"></span>
                            </fieldset>
                        </div>
                        <div class="chat__btn-box"><input class="btn btn--save" type="submit" name="btn-post" value="Add new post"></div>
                        <?php
                        if (isset($_POST['btn-post'])){
                            $title = $_POST['title'];
                            $content = $_POST['content'];
                            $keys = $_POST['keys'];
                            $category = $_POST['category'];
                            $userID = get_current_user_id();
                            $publish = $_POST["view"] == "yes" ? 'publish' : 'draft';
                            $blog = new BlogPost($title, $content, $keys, $publish, $userID, $category);
                            $blog->insert_into_database();
                            echo $blog->getMassagehtml();
                        }
?>
                    </form>
                </div>
                <div class="chat__box-right">
                    <div class="test"></div>

                    <!-- chat -->
                    <div class="chat__aricle-list chat--bg">
                        <div class="chat__caption">
                            <h3 class="chat__caption-title">Recent posts</h3>
                            <button class="chat__res-article">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="0.5">
                                        <path
                                                d="M13.8124 3.12497C8.51031 2.97914 4.16656 7.23956 4.16656 12.5H2.30197C1.83322 12.5 1.60406 13.0625 1.93739 13.3854L4.84364 16.3021C5.05197 16.5104 5.37489 16.5104 5.58322 16.3021L8.48947 13.3854C8.56145 13.312 8.61009 13.2189 8.62925 13.1178C8.64841 13.0168 8.63723 12.9124 8.59712 12.8177C8.55702 12.723 8.48979 12.6423 8.4039 12.5858C8.31801 12.5292 8.2173 12.4994 8.11447 12.5H6.24989C6.24989 8.43747 9.56239 5.15622 13.6457 5.20831C17.5207 5.26039 20.7811 8.52081 20.8332 12.3958C20.8853 16.4687 17.6041 19.7916 13.5416 19.7916C11.8645 19.7916 10.3124 19.2187 9.08322 18.25C8.88371 18.0928 8.63338 18.0144 8.37985 18.0298C8.12633 18.0452 7.8873 18.1532 7.70822 18.3333C7.27072 18.7708 7.30197 19.5104 7.79156 19.8854C9.42815 21.1796 11.4551 21.881 13.5416 21.875C18.802 21.875 23.0624 17.5312 22.9166 12.2291C22.7811 7.34372 18.6978 3.26039 13.8124 3.12497ZM13.2811 8.33331C12.8541 8.33331 12.4999 8.68747 12.4999 9.11456V12.9479C12.4999 13.3125 12.6978 13.6562 13.0103 13.8437L16.2603 15.7708C16.6353 15.9896 17.1145 15.8646 17.3332 15.5C17.552 15.125 17.427 14.6458 17.0624 14.4271L14.0624 12.6458V9.10414C14.0624 8.68747 13.7082 8.33331 13.2811 8.33331Z"
                                                fill="white" />
                                    </g>
                                </svg>
                            </button>
                        </div>

                        <?php
                        foreach ($result as $post):
                        setup_postdata($post);
                        ?>
                        <div class="chat__paper">
                            <div class="chat__article">
                                <div class="chat__paper-info">
                                    <?php echo $post->post_title?>
                                    <span class="chat__style-title">
                      <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M12.5 0L15.8761 9.12387L25 12.5L15.8761 15.8761L12.5 25L9.12387 15.8761L0 12.5L9.12387 9.12387L12.5 0Z"
                                fill="white" />
                      </svg>
                    </span>
                                </div>
                                <time class="chat__time" datetime="<?php echo $post->post_date?>"><?php echo $post->post_date?></time>
                            </div>
                            <a class="chat__link-article" target="_blank" href="<?php echo get_edit_post_link($post->ID, '') ?>">Edit post</a>
                        </div>
                        <?php endforeach;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
            <span class="settings__version">Version 1.0</span></div>
    </div>
</section>



