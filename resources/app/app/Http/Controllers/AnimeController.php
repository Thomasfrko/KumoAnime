<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Jobs\AddAnimeJob;

class AnimeController
{
  public function show()
  {
    $anime = \DB::select('select * from animes');
    $titles = [];
    $sources = [];
    $tags = [];
    
    if (count($anime) < 1 ){
      return view('default');
    }

    foreach ($anime as $element) {
      array_push($titles, $element->name);
      array_push($sources, $element->source_image);
      array_push($tags, $element->tag);
    }
    return view('catalog', [
      'title'=> json_encode($titles),
      'source' => json_encode($sources),
      'tags' => json_encode($tags)
    ]);
  }
  
  public function searchAnime() 
  {
    /**
     * Fonction qui retourne la liste des animes résultant de la recherche
     * Return un tableau des liens vers les animes pour ensuite scrape les épisodes
     */
    $animesResult = array();
    $animesName = array();
    $search = request('animeName'); // Intitulé de la recherche
    $web = new \spekulatius\phpscraper();
    $web->go('https://4anime.to/?s=' . $search);
    foreach ($web->links as $link) {
      if(strpos($link, 'https://4anime.to/anime/') !== false) {
        array_push($animesResult, $link);
      }
    }
    return view('adding', [
        'links' => json_encode($animesResult)
    ]);
  }

  public function addAnime()
  {
    $idEp = [];
    $linkarray = [];
    $anime = request('linkChosen');
    $web = new \spekulatius\phpscraper();
    $web->go($anime);
    $animeName = $web->title;

    foreach ($web->images as $image){
      if (strpos($image, 'https://4anime.to/image/') !== false) {
        $source =  $image;
      }
    }

    $content = file_get_contents($source);
    $fileName = $animeName.'.jpg';
    $fileName = str_replace(":", "", $animeName);
    file_put_contents('./images/' . $fileName, $content);

    foreach ($web->links as $link) {
      if(strpos($link, 'episode') !== false) {
        array_push($linkarray, $link);
      }
    }

    for($a = 1; $a < count($linkarray)+1; $a++){
      array_push($idEp, $a);
    }

    dispatch(new AddAnimeJob($linkarray,$idEp , $animeName, 'add'));
    \DB::insert('insert into animes (id, name, source_image, original_link, tag) values (DEFAULT,"'. $animeName . '","./images/' . $fileName . '","' . $anime .'", "toWatch")');
    return redirect('/');
  }

  public function deleteAnime()
  {
    $animeDeleted = request('delete');
    \DB::delete('delete from animes where name = "' . $animeDeleted .'"');
    \DB::delete('delete from episodes where name = "' . $animeDeleted .'"');
    return redirect('/');
  }

  public function changeTag($tag)
  {
    $animeChange = request('changeTag');
    \DB::update('update animes SET tag ="' . $tag .'" where name="' . $animeChange . '"');
    return redirect('/');
  }

  public function watch($animeWatching) {
    return view('watch', [
      'numbers' => json_encode(\DB::select('select number from episodes where name ="' . $animeWatching . '"')),
      'links' => json_encode(\DB::select('select links from episodes where name ="' . $animeWatching . '"')),
      'name' => $animeWatching
    ]);
  }

  public function update(){
    $idEp = [];
    $linkarray = [];
    $animeName = request('animeToUpdate');
    $anime = \DB::select('select original_link from animes where name="' . $animeName . '"')[0]->original_link; //Je récupère le lien avec les épisodes
    $web = new \spekulatius\phpscraper(); // Lance le scraper
    $web->go($anime);
    
    foreach ($web->links as $link) { 
      if(strpos($link, 'episode') !== false) { //Check si le lien contient le mot episode
        array_push($linkarray, $link);
      }
    }

    for($a = 1; $a < count($linkarray)+1; $a++){
      array_push($idEp, $a);
    }

    dispatch(new AddAnimeJob($linkarray, $idEp , $animeName, 'update'));
    return redirect('/');
  }
}
?>