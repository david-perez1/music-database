var audio = new Audio();
var songQueue = [];
var index;
var progressBar = document.getElementById('progressBar');


function loadPlaylist(playlistID, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);

                if (Array.isArray(response)) {
                    songQueue = response;
                    console.log(songQueue);
                    callback();
                } else {
                    console.error('Invalid JSON response');
                }
            } else {
                console.error('Error loading playlist');
            }
        }
    };

    xhr.open('GET', 'getSongsJSON.php?playlistID=' + playlistID, true);
    xhr.send();
}

function next() {
    if (index < songQueue.length - 1) {
        index++;
        playCurrentSong();
    } else {
        var playPauseImage = document.getElementById("playPauseImage");
        playPauseImage.src = "images/play.svg";
        console.log('End of playlist');
    }
}

function prev() {
    if (index > 0) {
        index--;
        playCurrentSong();
    } else {
        console.log('Start of playlist');
    }
}

function playCurrentSong() {
    audio.pause();
    audio.onended = function() {
        next();
    };
    audio.onplay = function() {
        fetch('getSongInfo.php?id=' + songQueue[index])
            .then(response => response.json())
            .then(data => {
                var currentlyPlayingElement = document.getElementById('currentlyPlayingElement');
                currentlyPlayingElement.innerText = data.title + "\n" + data.artistName;
            })
            .catch((error) => {
                console.error('Error fetching song information:', error);
            });

        // Use fetch API to send a POST request to increment_play_count.php
        fetch('increment_play_count.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'songId=' + songQueue[index]
        })
            .then(response => response.text())
            .then(data => {
                console.log('Play count increment response:', data);
            })
            .catch((error) => {
                console.error('Error incrementing play count:', error);
            });

        var playPauseImage = document.getElementById("playPauseImage");
        playPauseImage.src = "images/pause.svg";
    };
    var currentlyPlayingElement = document.getElementById('currentlyPlayingElement');
    currentlyPlayingElement.innerText = "";

    audio.ontimeupdate = function () {
        var progress = (audio.currentTime / audio.duration) * 100;
        progressBar.value = progress;
    };
    audio.src = 'getSong.php?id=' + songQueue[index];
    audio.play();
}


function playOrPauseSong() {
    var playPauseImage = document.getElementById("playPauseImage");
    if (audio.paused) {
        playPauseImage.src = "images/pause.svg";
        audio.play();
    } else {
        playPauseImage.src = "images/play.svg";
        audio.pause();
    }
}


function updateSession(songID) {
    var playlistID = parseInt(window.location.href.match(/#playlistID=(\d+)/)[1], 10);
    loadPlaylist(playlistID, function() {
        index = songQueue.indexOf(songID);
        playCurrentSong();
    });
}

progressBar.addEventListener('click', function (e) {
    var rect = this.getBoundingClientRect();
    var offsetX = e.clientX - rect.left;
    var percent = offsetX / rect.width;
    audio.currentTime = percent * audio.duration;
    console.log(audio.currentTime);
});
