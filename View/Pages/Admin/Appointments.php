<?php
include "../../Common PHP Functions/ConnectSql.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Appointments</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <style>
    /* Container holding the filter */
.doctor-filter {
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: start;
}

/* Label styling */
.doctor-filter label {
    font-size: 16px;
    margin-right: 10px;
    color: #333; /* Adjust based on your color scheme */
}

/* Select dropdown styling */
#doctorSelect {
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #ccc; /* Light grey border */
    font-size: 16px;
    color: #333;
    background-color: white;
    cursor: pointer;
    outline: none;
}

/* Hover and focus styles for the select dropdown */
#doctorSelect:hover, #doctorSelect:focus {
    border-color: #888; /* Darker border on hover/focus */
}

/* Option styling */
#doctorSelect option {
    padding: 8px 12px;
}

/* Media query for responsive adjustments */
@media (max-width: 600px) {
    .doctor-filter {
        flex-direction: column;
        align-items: flex-start;
    }

    #doctorSelect {
        width: 100%; /* Full width on smaller screens */
        margin-top: 5px; /* Spacing after the label on smaller screens */
    }
}

    </style>
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
        <a href="Appointments.php" class="active">
          <span class="material-icons-sharp">bookmark</span>
          <h3>Appointments</h3>
        </a>
        <a href="Messages.php">
          <span class="material-icons-sharp">mail</span>
          <h3>Messages</h3>
        </a>
        <div class="logout-button">
          <a href="#">Log out</a>
        </div>
      </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Appointments</h1>
            <div class="doctor-filter">
                <label for="doctorSelect">Choose a Doctor:</label>
                <select id="doctorSelect" onchange="filterAppointments(this.value)">
                    <option value="">All Doctors</option>
                    <?php
                    $doctors = $conn->query("SELECT DoctorID, Name FROM Doctors ORDER BY Name");
                    while ($doc = $doctors->fetch_assoc()) {
                        echo "<option value='" . $doc['DoctorID'] . "'>" . htmlspecialchars($doc['Name']) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="data-table-container">
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Doctor Assigned</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id = "appointmentsBody">
            <?php
            $query = "SELECT a.AppointmentID, p.FullName AS PatientName, d.Name AS DoctorName, 
                      a.AppointmentDate, a.Status
                      FROM Appointments a
                      JOIN Patients p ON a.PatientID = p.PatientID
                      JOIN Doctors d ON a.DoctorID = d.DoctorID
                      ORDER BY a.AppointmentDate ASC";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>APPT-" . htmlspecialchars($row["AppointmentID"]) . "</td>
                        <td>" . htmlspecialchars($row["PatientName"]) . "</td>
                        <td>" . date("Y-m-d", strtotime($row["AppointmentDate"])) . "</td>
                        <td>" . date("H:i", strtotime($row["AppointmentDate"])) . "</td>
                        <td>" . htmlspecialchars($row["DoctorName"]) . "</td>
                        <td class='actions'>";
                    if ($row["Status"] === 'Scheduled') {
                        echo "<button onclick='cancelAppointment(" . $row["AppointmentID"] . ")' class='action-button cancel-button'>
                        <span class='material-icons-sharp'>cancel</span>
                        Cancel
                    </button>";
                    
                    }
                    echo "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No appointments found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

    </div>
    <script>
function filterAppointments(doctorId) {
    fetch(`../../../Model/fetchAppointments.php?doctorId=${doctorId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const tbody = document.getElementById('appointmentsBody');
            tbody.innerHTML = '';
            if (data.length > 0) {
                data.forEach(app => {
                    const dateTime = new Date(app.AppointmentDate);
                    const date = dateTime.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                    const time = dateTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                    let row = `<tr>
                        <td>APT-${app.AppointmentID}</td>
                        <td>${app.PatientName}</td>
                        <td>${date}</td>
                        <td>${time}</td>
                        <td>${app.DoctorName}</td>
                        <td class='actions'>`;
                    if (app.Status === 'Scheduled') {
                        row += `<button onclick="cancelAppointment(${app.AppointmentID})" class='action-button cancel-button'>
                            <span class='material-icons-sharp'>cancel</span>
                            Cancel
                            </button>`;
                    }
                    row += `</td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="6">No appointments found for this doctor.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching data: ', error);
        });
}

function cancelAppointment(appointmentId) {
    if (!confirm("Are you sure you want to cancel this appointment?")) {
        return;
    }

    fetch('../../../Model/cancelAppointment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `appointmentId=${appointmentId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Appointment deleted successfully');
            alert('Appointment canceled successfully.');
            window.location.reload();
        } else {
            console.error('Failed to delete appointment:', data.error);
            alert('Failed to cancel appointment. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}


</script>

</body>
</html>