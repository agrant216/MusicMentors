<?php
	class Appointment
	{
		private $id;
		private $mentorID;
		private $studentUsername;
		private $date;
		private $startTime;
		private $endTime;
		private $price;
		private $instrument;
		private $location;
		private $open;

		public function __construct($id, $m_id, $s_name, $d, $sT, $eT, $p, $i, $l, $o)
		{
			$this->id = $id;
			$this->mentorID = $m_id;
			$this->studentUsername = $s_name;
			$this->date = $d;
			$this->startTime = $sT;
			$this->endTime = $eT;
			$this->price = $p;
			$this->instrument = $i;
			$this->location = $l;
			$this->open = $o;
		}

		public function setAppointmentID($x) { $this->id = $x; }
		public function setMentorID($x) { $this->mentorID = $x; }
		public function setStudentUsername($x) { $this->studentUsername = $x; }
		public function setDate($x) { $this->date = $x; }
		public function setStartTime($x) { $this->startTime = $x; }
		public function setEndTime($x) { $this->endTime = $x; }
		public function setPrice($x) { $this->price = $x; }
		public function setInstrument($x) { $this->instrument = $x; }
		public function setLocation($x) { $this->location = $x; }
		public function setOpen($x) { $this->open = $x; }

		public function getAppointmentID() { return $this->id; }
		public function getMentorID() { return $this->mentorID; }
		public function getStudentUsername() { return $this->studentUsername; }
		public function getDate() { return $this->date; }
		public function getStartTime() { return $this->startTime; }
		public function getEndTime() { return $this->endTime; }
		public function getPrice() { return $this->price; }
		public function getInstrument() { return $this->instrument; }
		public function getLocation() { return $this->location; }
		public function getOpen() { return $this->open; }
	}

?>