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

function playSongNow(songID){
    audio.pause();
    audio.src = "getSong.php?id=" + songID;
    audio.play();
}

function queueSong(songID){
    songQueue.push(songID);
}
