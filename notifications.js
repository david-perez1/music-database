// notifications.js
function getAndDisplayNotifications(userId) {
    fetch(`notifications.php?userId=${userId}`)
        .then(response => response.json())
        .then(notifications => {
            const notificationsContainer = document.getElementById('notifications');
            notifications.forEach(notification => {
                const notificationDiv = document.createElement('div');
                notificationDiv.className = 'notification';
                
                const closeButton = document.createElement('button');
                closeButton.textContent = '×'; // "×" is a Unicode multiplication sign
                closeButton.className = 'close-button';
                closeButton.onclick = function() {
                    notificationDiv.remove(); // Remove notification from DOM
                    // Optionally, send a request to the server to mark the notification as dismissed
                    // dismissNotification(notification.notification_id);
                };

                const textDiv = document.createElement('div');
                textDiv.textContent = notification.message;

                notificationDiv.appendChild(closeButton);
                notificationDiv.appendChild(textDiv);
                notificationsContainer.insertBefore(notificationDiv, notificationsContainer.firstChild);
            });
        })
        .catch(error => console.error('Error fetching notifications:', error));
}

// Function to send a dismiss request to the server
function dismissNotification(notificationId) {
    fetch(`dismissNotification.php?notificationId=${notificationId}`, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            console.log('Notification dismissed:', data);
        })
        .catch(error => console.error('Error dismissing notification:', error));
}


// Inside notifications.js
document.addEventListener('DOMContentLoaded', () => {
    // Assuming you have the userIdFromPHP variable set
    if (window.userIdFromPHP) {
        getAndDisplayNotifications(window.userIdFromPHP);
    }
});
