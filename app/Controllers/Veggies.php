<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Veggies extends Controller
{
  public function veggieLoop()
  {
      $veggie_items = get_posts([
          'post_type' => 'veggies',
          'posts_per_page'=>'50',
      ]);
  
    return array_map(function ($post) {
        return [
            'title' => get_the_title($post->ID),
            'family' => get_field('family', $post),
            'storage' => get_field('storage', $post),
            'thumbnail' => get_the_post_thumbnail($post->ID, 'large'),
        ];
    }, $veggie_items);
  }
  
}
