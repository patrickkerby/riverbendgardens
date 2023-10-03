<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class SinglePreservation extends Controller
{
  public function preservationLoop()
  {
      $preservation_items = get_posts([
          'post_type' => 'preservation',
          'posts_per_page'=>'50',
          // 'preservation_categories' => 'pickling-fermenting'
      ]);
  
    return array_map(function ($post) {
        return [
            'title' => get_the_title($post->ID),
            'slug' => $post->post_name,
            'link' => get_permalink($post->ID),
            'veggie' => get_field('related_veggie', $post),
            // 'thumbnail' => get_the_post_thumbnail($post->ID, 'large'),
            // 'notes' => get_field('notes', $post),
            // 'terms' => get_terms(array('taxonomy' => 'preservation_categories'), $post)
            'preservation_techniques' => get_the_terms( $post->ID, 'preservation_categories' )
          ];
    }, $preservation_items);
  }

  protected $acf = true;

    public function acf()
    {
        add_filter('sober/controller/acf/array', function () {
            return true;
        });
    }
}
