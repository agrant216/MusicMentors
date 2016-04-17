<?php
	class User
	{
		private $id;
		private $username;
		private $email;
		private $type;
		private $biography;
		private $imageFileName;
		private $genres;
		private $instruments;

		public function __construct($id, $name)
		{
			$this->id = $id;
			$this->username = $name;
		}

		public function setUsername($x) { $this->username = $x; }
		public function setEmail($x) { $this->email = $x; }
		public function setType($x) { $this->type = $x; }
		public function setBiography($x) { $this->biography = $x; }
		public function setImageFileName($x) { $this->imageFileName = $x; }
		public function setGenres($x) { $this->genres = $x; }
		public function setInstruments($x) { $this->instruments = $x; }

		public function getID() { return $this->id; }
		public function getUsername() { return $this->username; }
		public function getEmail() { return $this->email; }
		public function getType() { return $this->type; }
		public function getBiography() { return $this->biography; }
		public function getImageFileName() { return $this->imageFileName; }
		public function getGenres() { return $this->genres; }
		public function getInstruments() { return $this->instruments; }
	}
?>