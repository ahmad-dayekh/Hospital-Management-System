<?php
session_start();
include "../../Common PHP Functions/ConnectSql.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Patients</title>
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
        <a href="Patients.php" class="active">
          <span class="material-icons-sharp">personal_injury</span>
          <h3>Patients</h3>
        </a>
        <a href="Appointments.php">
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
            <h1>Patients</h1>
            <button class="add-button" id="addBtn">
                <span class="material-icons-sharp">add</span>
                Add Patient
            </button>
        </div>
        <div class="data-table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM Patients";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>PAT-" . htmlspecialchars($row["PatientID"]) . "</td>
                            <td>" . htmlspecialchars($row["FullName"]) . "</td>
                            <td>" . htmlspecialchars($row["ContactEmail"]) . "</td>
                            <td class='actions'>
                                <button class='action-button view-button'
                                    data-email='" . htmlspecialchars($row["ContactEmail"]) . "' 
                                    data-name='" . htmlspecialchars($row["FullName"]) . "' 
                                    data-phone='" . htmlspecialchars($row["ContactPhone"]) . "'
                                    data-date-of-birth='" . htmlspecialchars($row["DateOfBirth"]) . "'
                                    data-gender='" . htmlspecialchars($row["Gender"]) . "'
                                    data-address='" . htmlspecialchars($row["Address"]) . "'
                                    data-medical='" . htmlspecialchars($row["MedicalHistory"]) . "'
                                    data-allergies='" . htmlspecialchars($row["Allergies"]) . "'
                                    data-medications='" . htmlspecialchars($row["CurrentMedications"]) . "'
                                    data-id='" . $row["PatientID"] . "'>
                                    <span class='material-icons-sharp'>visibility</span>
                                    <span>View</span></button>   
                                <button class='action-button edit-button'
                                    data-email='" . htmlspecialchars($row["ContactEmail"]) . "' 
                                    data-name='" . htmlspecialchars($row["FullName"]) . "' 
                                    data-phone='" . htmlspecialchars($row["ContactPhone"]) . "'
                                    data-date-of-birth='" . htmlspecialchars($row["DateOfBirth"]) . "'
                                    data-gender='" . htmlspecialchars($row["Gender"]) . "'
                                    data-address='" . htmlspecialchars($row["Address"]) . "'
                                    data-medical='" . htmlspecialchars($row["MedicalHistory"]) . "'
                                    data-allergies='" . htmlspecialchars($row["Allergies"]) . "'
                                    data-medications='" . htmlspecialchars($row["CurrentMedications"]) . "'
                                    data-id='" . $row["PatientID"] . "'>
                                    <span class='material-icons-sharp'>edit</span>
                                    <span>Edit</span></button>
                                    <button onclick='openDeleteModal(".$row["PatientID"].")' class='action-button delete-button'>
                                    <span class='material-icons-sharp'>delete</span>
                                    <span>Delete</span>
                                </button>
                            </td>
                        </tr>";                        
                        }
                    } else {
                        echo "<tr><td colspan='4'>No patients found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<!-- Add Patient Modal -->
<div id="addPatientModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Add Patient</h2>
    <form action="../../../Model/addPatients.php" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="fullName">Full Name:</label>
      <input type="text" id="fullName" name="fullName" required>

      <label for="dateOfBirth">Date of Birth:</label>
      <input type="date" id="dateOfBirth" name="DateOfBirth" required>

      <label for="gender">Gender:</label>
      <select id="gender" name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone:</label>
      <input type="text" id="phone" name="phone">

      <label for="address">Address:</label>
      <input type="text" id="address" name="address">

      <label for="medicalHistory">Medical History:</label>
      <textarea id="medicalHistory" name="medicalHistory"></textarea>

      <label for="allergies">Allergies:</label>
      <input type="text" id="allergies" name="allergies">

      <label for="currentMedications">Current Medications:</label>
      <input type="text" id="currentMedications" name="currentMedications">

      <input type="submit" value="Add Patient">
    </form>
  </div>
</div>
<!-- View Patient Modal -->
<div id="viewPatientModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>View Patient Details</h2>
    <form>
      <label for="fullName-view">Full Name:</label>
      <input type="text" id="fullName-view" readonly>

      <label for="email-view">Email:</label>
      <input type="email" id="email-view" readonly>

      <label for="phone-view">Phone:</label>
      <input type="text" id="phone-view" readonly>

      <label for="dateOfBirth-view">Date of Birth:</label>
      <input type="date" id="dateOfBirth-view" readonly>

      <label for="gender-view">Gender:</label>
      <input type="text" id="gender-view" readonly>

      <label for="address-view">Address:</label>
      <input type="text" id="address-view" readonly>

      <label for="medicalHistory-view">Medical History:</label>
      <textarea id="medicalHistory-view" readonly></textarea>

      <label for="allergies-view">Allergies:</label>
      <input type="text" id="allergies-view" readonly>

      <label for="currentMedications-view">Current Medications:</label>
      <input type="text" id="currentMedications-view" readonly>
    </form>
  </div>
</div>

<!-- Edit Patient Modal -->
<div id="editPatientModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Edit Patient Details</h2>
    <form action="../../../Model/editPatients.php" method="post">
      <input type="hidden" id="patient-id-edit" name="patientID">

      <label for="fullName-edit">Full Name:</label>
      <input type="text" id="fullName-edit" name="fullName" required>

      <label for="email-edit">Email:</label>
      <input type="email" id="email-edit" name="email" required>

      <label for="phone-edit">Phone:</label>
      <input type="text" id="phone-edit" name="phone">

      <label for="dateOfBirth-edit">Date of Birth:</label>
      <input type="date" id="dateOfBirth-edit" name="DateOfBirth" required>

      <label for="gender-edit">Gender:</label>
      <select id="gender-edit" name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>

      <label for="address-edit">Address:</label>
      <input type="text" id="address-edit" name="address">

      <label for="medicalHistory-edit">Medical History:</label>
      <textarea id="medicalHistory-edit" name="medicalHistory"></textarea>

      <label for="allergies-edit">Allergies:</label>
      <input type="text" id="allergies-edit" name="allergies">

      <label for="currentMedications-edit">Current Medications:</label>
      <input type="text" id="currentMedications-edit" name="currentMedications">

      <input type="submit" value="Update Patient">
    </form>
  </div>
</div>


<!-- Delete Patient Modal -->
<div id="deletePatientModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('deletePatientModal')">&times;</span>
    <h2>Delete Patient</h2>
    <p>Are you sure you want to delete this patient?</p>
    <form action="../../../Model/deletePatients.php" method="post">
      <input type="hidden" id="delete-patient-id" name="patientID">
      <button type="button" onclick="closeModal('deletePatientModal')" class="cancel-confirm">Cancel</button>
      <button type="submit" class="delete-confirm">Delete</button>
    </form>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var addModal = document.getElementById("addPatientModal");
    var viewModal = document.getElementById('viewPatientModal');
    var editModal = document.getElementById('editPatientModal');
    var deleteModal = document.getElementById('deletePatientModal');
    var addBtn = document.getElementById("addBtn");
    var viewBtns = document.querySelectorAll('.view-button');
    var editBtns = document.querySelectorAll('.edit-button');
    var deleteBtns = document.querySelectorAll('.delete-button');
    var closeBtns = document.querySelectorAll('.modal .close, .cancel-confirm');

    // Open Add Patient Modal
    addBtn.onclick = function() {
        addModal.style.display = "block";
    };

    // Open View Patient Modal
    viewBtns.forEach(function(btn) {
        btn.onclick = function() {
            var data = btn.dataset;
            document.getElementById('email-view').value = data.email;
            document.getElementById('fullName-view').value = data.name;
            document.getElementById('phone-view').value = data.phone;
            document.getElementById('dateOfBirth-view').value = data.dateOfBirth;
            document.getElementById('gender-view').value = data.gender;
            document.getElementById('address-view').value = data.address;
            document.getElementById('medicalHistory-view').value = data.medical;
            document.getElementById('allergies-view').value = data.allergies;
            document.getElementById('currentMedications-view').value = data.medications;
            viewModal.style.display = 'block';
        };
    });

    // Open Edit Patient Modal
    editBtns.forEach(function(btn) {
        btn.onclick = function() {
            var data = btn.dataset;
            document.getElementById('patient-id-edit').value = data.id;
            document.getElementById('email-edit').value = data.email;
            document.getElementById('fullName-edit').value = data.name;
            document.getElementById('phone-edit').value = data.phone;
            document.getElementById('dateOfBirth-edit').value = data.dateOfBirth;
            document.getElementById('gender-edit').value = data.gender;
            document.getElementById('address-edit').value = data.address;
            document.getElementById('medicalHistory-edit').value = data.medical;
            document.getElementById('allergies-edit').value = data.allergies;
            document.getElementById('currentMedications-edit').value = data.medications;
            editModal.style.display = 'block';
        };
    });

    // Close Modals with Close Button and Outside Click
    closeBtns.forEach(function(btn) {
        btn.onclick = function() {
            this.closest('.modal').style.display = 'none';
        };
    });

    // Close modals when clicking outside of any modal content
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    };

});
function openDeleteModal(patientId) {
      document.getElementById('delete-patient-id').value = patientId;
      document.getElementById('deletePatientModal').style.display = 'block';
}
</script>

</body>
</html>