document.addEventListener("DOMContentLoaded", function() {
    // Dummy playlist data (replace with PHP-generated data)
    const playlists = ['Playlist 1', 'Playlist 2', 'Playlist 3'];

    // Get the playlist element
    const playlistElement = document.getElementById('playlist');

    // Populate the playlist sidebar with PHP-generated data
    playlists.forEach(playlist => {
        const listItem = document.createElement('li');
        listItem.textContent = playlist;
        listItem.addEventListener('click', () => displayPlaylistContent(playlist));
        playlistElement.appendChild(listItem);
    });

    // Function to display playlist content
    function displayPlaylistContent(playlist) {
        // Dummy content (replace with PHP-generated content)
        const content = `<p>This is the content of ${playlist}.</p>`;
        
        // Display content in the content area
        document.getElementById('playlist-content').innerHTML = content;
    }
});
