<?php

namespace classes;

class BlogPost
{
    private $title;
    private $content;
    private $keywords;
    private $status;
    private $author;
    private $category;

    function __construct($title, $content, $keywords, $status, $author, $category) {
        $this->title = $title;
        $this->content = $content;
        $this->keywords = $keywords;
        $this->status = $status;
        $this->author = $author;
        $this->category = $category;
    }

    private function categoryArray(){
        $category = $this->category;
        $categoryArr = explode(',', $category);
        return array_map('intval', $categoryArr);
    }

    function insert_into_database() {
        $my_post = array();
        $my_post['post_title']    = $this->title;
        $my_post['post_content']  = $this->content;
        $my_post['tags_input']  = $this->keywords;
        $my_post['post_status']   = $this->status;
        $my_post['post_author']   = $this->author;
        $my_post['post_category'] = $this->categoryArray();
        // Insert the post into the database
        $this->getMassge(wp_insert_post( $my_post ));
    }

    public function getMassge ($post){
        if ($post){
            $message = __( 'Post created!', 'textdomain' );
            printf( '<div id="message" class="updated"><p>%s</p></div>', $message );
        }
    }
}