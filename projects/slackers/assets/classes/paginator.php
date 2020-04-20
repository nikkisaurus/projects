<?php  
  
class Paginator{  
	public $chunks;
	public $total;
	public $last_page;
	public $page;
	public $previous_page;
	public $next_page;

	public function __construct($page = 1) {
		$query = db()->query("SELECT * FROM `shoutbox` WHERE `approved` = '1' ORDER BY `created_at` DESC");
		
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		$total = $query->rowCount();
		$posts_per_page = 10;
		$last_page = ceil($total/$posts_per_page);

		if (isset($page)) {
			$page = preg_replace('#[^0-9]#', '', $page);
		}

		if ($page < 1) {
			$page = 1;
		} elseif ($page > $last_page) {
			$page = $last_page;
		}

		if ($page >= 2) {
			$previous_page = $page - 1;
		} else {
			$previous_page = 1;
		}

		if ($page <= ($last_page - 1)) {
			$next_page = $page + 1;
		} else {
			$next_page = $last_page;
		}

		$chunks = array_chunk($results, $posts_per_page);

		$chunk_ref = $page - 1;

		$this->total = $total;
		$this->last_page = $last_page;
		$this->page = $page;
		$this->previous_page = $previous_page;
		$this->next_page = $next_page;
		$this->chunks = $chunks[$chunk_ref];
		
	}
}
