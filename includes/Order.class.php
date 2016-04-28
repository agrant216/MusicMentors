<?php
	class Order
	{
		private $id;
		private $studentID;
		private $dateTime;
		private $total;


		public function __construct($id, $s_id, $dateTime, $total)
		{
			$this->id = $id;
			$this->studentID = $s_id;
			$this->dateTime = $dateTime;
			$this->total = $total;
		}

		public function setOrderID($x) { $this->id = $x; }
		public function setStudentID($x) { $this->studentID = $x; }
		public function setDateTime($x) { $this->dateTime = $x; }
		public function setTotal($x) { $this->total = $x; }

		public function getOrderID() { return $this->id; }
		public function getStudentID() { return $this->studentID; }
		public function getDateTime() { return $this->dateTime; }
		public function getTotal() { return $this->total; }
	}
?>