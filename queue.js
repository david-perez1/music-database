var audio = new Audio();
var songQueue = [];
var index;

function loadPlaylist(playlistID, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);

                if (Array.isArray(response)) {
                    songQueue = response;
                    console.log(songQueue);
                    callback(); // Call the callback function after loading the playlist
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
        // Optional: You can handle what happens when trying to go beyond the last song.
        console.log('End of playlist');
    }
}

function prev() {
    if (index > 0) {
        index--;
        playCurrentSong();
    } else {
        // Optional: You can handle what happens when trying to go before the first song.
        console.log('Start of playlist');
    }
}

function playCurrentSong() {
    audio.pause();
    audio.onended = function() {
        
        next();
    };
    audio.onplay = function() {
        // Use fetch API to send a POST request to increment_play_count.php
        fetch('increment_play_count.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'songId=' + songQueue[index] // Make sure the key matches the one expected by the PHP script
        })
        .then(response => response.text())
        .then(data => {
            console.log('Play count increment response:', data);
        })
        .catch((error) => {
            console.error('Error incrementing play count:', error);
        });
    };
    audio.src = 'getSong.php?id=' + songQueue[index];
    audio.play();
}

function playOrPauseSong() {
    if (audio.paused) {
        audio.play();
    } else {
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
