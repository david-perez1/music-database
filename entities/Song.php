<?php
	class Song {

		private $con;
		private $sid;
		private $title;
		private $date;
        private $artistName;
        private $duration;
        private $artistID;
        private $genre;
        private $fileData;


		public function __construct($con, $sid) {
			$query = mysqli_query($con, "SELECT * FROM song WHERE SongID = '$sid'");
			$data = mysqli_fetch_array($query);

			$this->con = $con;
			$this->sid = $data['SongID'];
			$this->title = $data['SongTitle'];         
            $this->date = $data['ReleaseDate'];
            $this->artistName = $data['artistName'];
            $this->duration = $data['Duration'];
            $this->artistID = $data['ArtistID'];
            $this->genre = $data['Genre'];
            $this->fileData = $data['FileData'];
		}

        public function getSongID() {
            return $this->sid;
        }

        public function getTitle() {
            return $this->title;
        }

        public function getDate() {
            return $this->date;
        }

        public function getArtistName() {
            return $this->artistName;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getArtistID() {
            return $this->artistID;
        }

        public function getGenre() {
            return $this->genre;
        }

        public function getFileData() { 
            return $this->fileData;
        }

    }

?>