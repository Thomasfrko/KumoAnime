<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddAnimeJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $link;
  protected $idEp;
	protected $animeName;
	protected $action;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($link, $idEp, $animeName, $action)
	{
		$this->link =$link;
    $this->idEp = $idEp;
		$this->animeName = $animeName;
		$this->web = "";
		$this->action = $action;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$n = 0;
		$this->web = new \spekulatius\phpscraper();
		foreach($this->link as $l){
			$this->web->go($l);
			$sourceVideo = $this->web->filter('//source');
    	foreach($sourceVideo as $element){
     		$video = $element->getAttribute('src');
			}
			if($this->action == 'add'){
				if(count(\DB::select('select number from episodes where name="' . $this->animeName . '" and number=' . $this->idEp[$n])) < 1){
					\DB::insert('insert into episodes (id, name, number, links, watched) values (DEFAULT,"'. $this->animeName . '",' . $this->idEp[$n] . ',"' . $video . '", false)');
				}
				$n++;
			}

			if($this->action == 'update') {
				\DB::update("update episodes set `links` = '" . $video . "' where `name`= '" . $this->animeName . "' and `number` =" . $this->idEp[$n]);
				$n++;
			}
		}
  }
}


/*
if($this->action == 'add'){
				\DB::insert('insert into episodes (id, name, number, links, watched) values (DEFAULT,"'. $this->animeName . '",' . $this->idEp[$n] . ',"' . $video . '", false)');
				$n++;
			}

			if($this->action == 'update') {
				\DB::update("update episodes set `links` = '" . $video . "' where `name`= '" . $this->animeName . "' and `number` =" . $this->idEp[$n]);
				$n++;
			}
*/