<?php
	class Playlist {

		private $con;
		private $pid;
		private $name;
		private $image; 
		private $uid;
        private $date;

		public function __construct($con, $pid) {
			$this->con = $con;

			$query = mysqli_query($con, "SELECT * FROM playlist WHERE playlist.PlaylistID = $pid");
			$data = mysqli_fetch_array($query);

			$this->pid = $data['PlaylistID'];
			$this->name = $data['PlaylistTitle'];
			$this->image = $data['image'];
			$this->uid = $data['UserID'];
            $this->date = $data['CreatedDate'];
		}

		public function getName() {
			return $this->name;
		}
		public function getImage() {
			return $this->image;
		}

		public function getUID() {
			return $this->uid;
		}

		public function getPID() {
			return $this->pid;
		}

        public function getCreationDate() {
            return $this->date;
        }

		public function getNumberOfSongs() {
			$query = mysqli_query($this->con, "SELECT SongID from playlistsongs WHERE PlaylistID='$this->pid'");
			return mysqli_num_rows($query);
		}

		public function getSongIds() {
			$query = mysqli_query($this->con, "SELECT SongID from playlistsongs WHERE PlaylistID='$this->pid'");

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['SongID']);
			}

			return $array;
		}

		public function isEmpty() {
			return count($this->getSongIds()) == 0;
		}
	}
?>
