<?php
	class Review
	{
		private $id;
		private $s_name;
		private $date;
		private $text;
		private $rating;

		public function __construct($i, $s, $d, $t, $r)
		{
			$this->id = $i;
			$this->s_name = $s;
			$this->date = $d;
			$this->text = $t;
			$this->rating = $r;
		}


		public function setID($x) { $this->id = $x; }
		public function setStudentUsername($x) { $this->s_name = $x; }
		public function setReviewDate($x) { $this->date = $x; }
		public function setReviewText($x) { $this->text = $x; }
		public function setRating($x) { $this->rating = $x; }

		public function getID() { return $this->id; }
		public function getStudentUsername() { return $this->s_name; }
		public function getReviewDate() { return $this->date; }
		public function getReviewText() { return $this->text; }
		public function getRating() { return $this->rating; }

	}
?>