var audio = new Audio();
var songQueue = [];

function playNextSong(){
    if (nextSongID !== undefined) {
        var nextSongID = songQueue.shift();
        audio.pause();
        audio.src = "getSong.php?id=" + nextSongID;
        audio.play();
    }
}

function playPreviousSong(){
    //todo
}

function playOrPauseSong(){ 
    if (audio.paused){
        audio.play();
    }
    else {
        audio.pause();
    }
}

function playSongNow(songID) {
    audio.pause();

    // Set the onplay event handler before setting the source and playing
    audio.onplay = function() {
        // Use fetch API to send a POST request to increment_play_count.php
        fetch('increment_play_count.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'songId=' + songID // Make sure the key matches the one expected by the PHP script
        })
        .then(response => response.text())
        .then(data => {
            console.log('Play count increment response:', data);
        })
        .catch((error) => {
            console.error('Error incrementing play count:', error);
        });
    };

    // Set the new source for the audio element
    audio.src = "getSong.php?id=" + songID;
    
    // Attempt to play the new source
    audio.play();
}



function queueSong(songID){
    songQueue.push(songID);
}
