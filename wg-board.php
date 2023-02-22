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
if(in_array($chatGPT->getlang(),$languages)) {
    include plugin_dir_path(__FILE__)."language/".$chatGPT->getlang().".php";
} else {
    include plugin_dir_path(__FILE__)."language/en.php";
}

if (isset($_POST['generate'])){
    $user_input = $_POST['request'];
    $chatGPT->generate_content($user_input);
}

if (isset($_POST['btn-post'])){
  $title = $_POST['title'];
  $content = $_POST['content'];
  $keys = $_POST['keys'];
  $category = $_POST['category'];
  $userID = get_current_user_id();

  $blog = new BlogPost($title, $content, $keys, 'publish', $userID, $category);
  $blog->insert_into_database();
}

function imgPath($path){
    return plugin_dir_url(__FILE__).'img/assets/'.$path;
}

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
                                      placeholder="Example: write short article about the most popular pc games "><?php echo $chatGPT->getResult() ?></textarea>
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

                    <form class="chat__form form-bg" method="POST"><label class="chat__label" >Post Title
                            <input
                                    class="chat__input input" name="title" placeholder="Example: the most popular pc games" ></label>
                        <label class="chat__label">Post Content <textarea class="chat__text text-to-copy" name="content"
                                                                                 id="" cols="30" rows="10"><?php echo $chatGPT->getResult() ?></textarea>
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
                        <div class="chat__label"><p>Key Words</p><input class="chat__key" name="keys" value="Fast Break, Sport">
                            <div class="chat__details"><span class="chat__keys"></span></div>
                        </div>
                        <div class="chat__btn-box"><input class="btn btn--save" type="submit" name="btn-post" value="Add new post"></div>
                    </form>
                </div>
                <div class="chat__dialogs"><img class="chat__brain" src="<?= imgPath('brain.png');?>" alt="">
                    <h3 class="chat__title chat__title--change">welcome to gpt chat</h3>
                    <div class="chat__dialog">
                        <div class="chat__author chat__all">
                            <div class="chat__logo-box chat__logo-box--author"><img
                                        class="chat__logo chat__logo--author" src="<?= imgPath('logo-author.svg');?>"
                                        alt="logo-author"></div>
                            <div class="chat__info chat__info--author"><p>Example: write short article about the most
                                    popular pc games PC gaming has come a long way since its inception and continues to
                                    be a thriving industry with a vast selection of games available for players of all
                                    ages and skill levels. Here are some of the most popular PC games that have captured
                                    the hearts of players worldwide:</p></div>
                        </div>
                        <div class="chat__ai chat__all">
                            <div class="chat__logo-box chat__logo-box--ai"><img class="chat__logo chat__logo--ai"
                                                                                src="<?= imgPath('logo-author.svg');?>"
                                                                                alt="logo-ai"></div>
                            <div class="chat__info chat__info--ai"><p>PC gaming has come a long way since its inception
                                    and continues to be a thriving industry with a vast selection of games available for
                                    players of all ages and skill levels. Here are some of the most popular PC games
                                    that have captured the hearts of players worldwide:</p>
                                <p>Fortnite: This battle royale game has taken the world by storm and has become one of
                                    the most popular games in the world. It is a free-to-play game that offers a unique
                                    blend of survival, exploration, and combat.</p>
                                <p>Apex Legends: Another popular battle royale game, Apex Legends has quickly gained a
                                    large player base with its fast-paced gameplay and unique characters.</p>
                                <p>League of Legends: This MOBA (multiplayer online battle arena) game has been a staple
                                    in the world of gaming for over a decade, with a huge player base and a thriving
                                    professional scene.</p></div>
                        </div>
                    </div>
                    <form class="chat__form chat__form--request"><input class="chat__input chat__input--request input"
                                                                        placeholder="Request">
                        <button class="chat__img-box" type="submit">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.4 20.4L20.85 12.92C21.0304 12.8432 21.1842 12.715 21.2923 12.5514C21.4004 12.3879 21.4581 12.1961 21.4581 12C21.4581 11.804 21.4004 11.6122 21.2923 11.4486C21.1842 11.2851 21.0304 11.1569 20.85 11.08L3.4 3.60003C3.2489 3.53412 3.08377 3.50687 2.91951 3.52073C2.75525 3.53459 2.59702 3.58912 2.4591 3.67942C2.32118 3.76971 2.20791 3.89292 2.1295 4.03793C2.0511 4.18293 2.01003 4.34518 2.01 4.51003L2 9.12003C2 9.62003 2.37 10.05 2.87 10.11L17 12L2.87 13.88C2.37 13.95 2 14.38 2 14.88L2.01 19.49C2.01 20.2 2.74 20.69 3.4 20.4Z"
                                      fill="white"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <span class="settings__version">Version 1.0</span></div>
    </div>
</section>