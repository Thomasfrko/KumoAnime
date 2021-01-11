<?php
namespace App\Http\Controllers;

class PostsController 
{
  public function show($post) 
  {
    $posts = [
      'wesh' => 'wesh',
      'ouaip' => 'ouaip'
    ];

    if(! array_key_exists($post, $posts)) {
      abort(404, 'Sorry it do not exists');

    }
    
    return view('post', [
      'post' => $posts[$post]
    ]);
  }
}
?>