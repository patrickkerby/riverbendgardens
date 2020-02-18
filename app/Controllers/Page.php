<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Page extends Controller
{
  protected $acf = true;

  public function acf()
  {
      add_filter('sober/controller/acf/array', function () {
          return true;
      });
  }
}
