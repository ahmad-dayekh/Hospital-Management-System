<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
          <span class="material-icons-sharp">account_circle</span>
          <h3>Administrator</h3>
          <p>admin@edoc.com</p>
        </div>
        <a href="DashBoard.php">
          <span class="material-icons-sharp">dashboard</span>
          <h3>Dashboard</h3>
        </a>
        <a href="Doctors.php">
          <span class="material-icons-sharp">medical_services</span>
          <h3>Doctors</h3>
        </a>
        <a href="LabTechs.php">
          <span class="material-icons-sharp">science</span>
          <h3>Lab Technicians</h3>
        </a>
        <a href="Patients.php">
          <span class="material-icons-sharp">personal_injury</span>
          <h3>Patients</h3>
        </a>
        <a href="Appointments.php">
          <span class="material-icons-sharp">bookmark</span>
          <h3>Appointments</h3>
        </a>
        <a href="Messages.php" class="active">
          <span class="material-icons-sharp">mail</span>
          <h3>Messages</h3>
        </a>
        <div class="logout-button">
          <a href="#">Log out</a>
        </div>
      </div>
    </div>
    <div class="main-content">
        <div class="header1">
            <div class="date-display">
                <span class="material-icons-sharp">today</span>
                <div id="current-date" class="date"></div>
            </div>
        </div>
        <div class="header">
          <button class="add-button" id = "addbtn">
            <span class="material-icons-sharp">add</span>
            Send Message
          </button>
        </div>
        <div class="data-table-container">
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Subject</th>
                <th>Sender</th>
                <th>Date</th>
                <th>Receiver</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="messagesBody">
        </tbody>
    </table>
</div>
</div>
<div id="messageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeMessageModal()">&times;</span>
        <h2>Message Details</h2>
        <form>
            <label for="messageSubject">Subject:</label>
            <input type="text" id="messageSubject" readonly>

            <label for="messageBody">Message:</label>
            <textarea id="messageBody" readonly></textarea>

            <label for="messageSender">Sender:</label>
            <input type="text" id="messageSender" readonly>

            <label for="messageReceiver">Receiver:</label>
            <input type="text" id="messageReceiver" readonly>

            <label for="messageDate">Date:</label>
            <input type="text" id="messageDate" readonly>
        </form>
    </div>
</div>


<!-- Send Message Modal -->
<div id="sendMessageModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('sendMessageModal')">&times;</span>
    <h2>Send New Message</h2>
    <form id="sendMessageForm" action="../../../Model/sendMessage.php" method="post">

      <label for="messageType">Message Type:</label>
      <select id="messageType" name="messageType" required>
        <option value="Appointment">Appointment</option>
        <option value="Report">Report</option>
        <option value="General">General</option>
      </select>

      <label for="messageSubject">Subject:</label>
      <input type="text" id="messageSubject" name="messageSubject" required>

      <label for="messageBody">Message:</label>
      <textarea id="messageBody" name="messageBody" required></textarea>

      <label for="messageReceiver">Receiver Email:</label>
      <input type="email" id="messageReceiver" name="messageReceiver" required>

      <input type="hidden" id="messageSender" name="messageSender" value="<?php echo isset($_SESSION['ContactEmail']) ? $_SESSION['ContactEmail'] : 'admin@hospital.com'; ?>">

      <input type="submit" value="Send Message">
    </form>
  </div>
</div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
    fetchMessages();
});

function fetchMessages() {
    fetch('../../../Model/fetchMessages.php')
        .then(response => response.json())
        .then(messages => {
            const tbody = document.getElementById('messagesBody');
            tbody.innerHTML = '';
            messages.forEach(msg => {
                const row = `<tr>
                    <td>${msg.Type}</td>
                    <td>${msg.Subject}</td>
                    <td>${msg.SenderEmail}</td>
                    <td>${new Date(msg.SentDate).toLocaleDateString()}</td>
                    <td>${msg.ReceiverEmail}</td>
                    <td>
                        <button onclick="viewMessage(${msg.MessageID})">View</button>
                        <button onclick="deleteMessage(${msg.MessageID})">Delete</button>
                    </td>
                </tr>`;
                tbody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error loading messages:', error));
}



function viewMessage(messageId) {
    fetch(`../../../Model/viewMessage.php?messageId=${messageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const message = data.message;
                document.getElementById('messageSubject').textContent = message.Subject;
                document.getElementById('messageBody').textContent = message.Body;
                document.getElementById('messageSender').textContent = message.SenderEmail;
                document.getElementById('messageReceiver').textContent = message.ReceiverEmail;
                document.getElementById('messageDate').textContent = new Date(message.SentDate).toLocaleString();
                
                document.getElementById('messageModal').style.display = 'block';
            } else {
                console.error('Failed to load message:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
}


function deleteMessage(messageId) {
    if (confirm("Are you sure you want to delete this message?")) {
        fetch('../../../Model/deleteMessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `messageId=${messageId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchMessages();
            } else {
                console.error('Failed to delete message:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}


document.addEventListener('DOMContentLoaded', function () {
    const messageModal = document.getElementById('messageModal');
    const closeBtns = document.querySelectorAll('.modal .close');

    window.viewMessage = function(messageId) {
        fetch(`../../../Model/viewMessage.php?messageId=${messageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const message = data.message;
                    document.getElementById('messageSubject').value = message.Subject;
                    document.getElementById('messageBody').value = message.Body;
                    document.getElementById('messageSender').value = message.SenderEmail;
                    document.getElementById('messageReceiver').value = message.ReceiverEmail;
                    document.getElementById('messageDate').value = new Date(message.SentDate).toLocaleString();

                    messageModal.style.display = 'block';
                } else {
                    console.error('Failed to load message:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    };

    closeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            messageModal.style.display = 'none';
        });
    });

    window.onclick = function(event) {
        if (event.target === messageModal) {
            messageModal.style.display = 'none';
        }
    };
});

document.addEventListener('DOMContentLoaded', function() {
    setupMessageModal();
    var addMessageButton = document.getElementById('addbtn');
    
    if (addMessageButton) {
        addMessageButton.addEventListener('click', function() {
            var sendMessageModal = document.getElementById('sendMessageModal');
            if (sendMessageModal) {
                sendMessageModal.style.display = 'block';
            }
        });
    }
});
function setupMessageModal() {
    var userLoggedInEmail = document.getElementById('messageSender').value;

    if (userLoggedInEmail) {
        document.getElementById('messageSender').value = userLoggedInEmail;
    }

    var closeBtns = document.querySelectorAll('.modal .close');
    closeBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var modal = this.closest('.modal');
            modal.style.display = 'none';
        });
    });

    var messageForm = document.getElementById('sendMessageForm');
    messageForm.onsubmit = function(event) {
        event.preventDefault();
        sendMessage();
    };
}

document.addEventListener('DOMContentLoaded', function() {
    setupMessageModal();
});

function sendMessage() {
    var formData = new FormData(document.getElementById('sendMessageForm'));
    console.log('Form Data:', Array.from(formData.entries()));
    fetch('../../../Model/sendMessage.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Message sent successfully');
            closeModal('sendMessageModal');
        } else {
            console.error('Failed to send message:', data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      var dateElement = document.getElementById('current-date');
      var today = new Date();
      var options = { year: 'numeric', month: 'long', day: 'numeric' };
      var dateString = today.toLocaleDateString('en-US', options);
      dateElement.textContent = dateString;
    });
</script>
</body>
</html>