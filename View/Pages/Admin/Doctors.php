<?php include "../../Common PHP Functions/ConnectSql.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Doctors</title>
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
        <a href="Doctors.php" class="active">
          <span class="material-icons-sharp">medical_services</span>
          <h3>Doctors</h3>
        </a>
        <a href="LabTechs.php">
          <span class="material-icons-sharp">science</span>
          <h3>Lab Technicians</h3>
        </a>
        <a href="#">
          <span class="material-icons-sharp">personal_injury</span>
          <h3>Patients</h3>
        </a>
        <a href="#">
          <span class="material-icons-sharp">bookmark</span>
          <h3>Appointments</h3>
        </a>
        <a href="#">
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
          <h1>Doctors</h1>
          <!-- Add Doctor Button at the top of the table -->
          <button class="add-button" id = "addbtn">
            <span class="material-icons-sharp">add</span>
            Add Doctor
          </button>
        </div>
        <!-- Doctors Overview -->
        
        <div class="data-table-container">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialty</th>
                <th>Contact</th>
                <th>Availability</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                    <?php
                    $query = "SELECT * FROM Doctors";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>        
                            <td>DOC-". $row["DoctorID"]. "</td>
                            <td>". $row["Name"]. "</td>
                            <td>". $row["Specialty"]. "</td>
                            <td>". $row["ContactEmail"]. "</td>
                            <td>". $row["Availability"]. "</td>
                                    <td class='actions'>
                                    <button class='action-button view-button' id='viewBtn-".$row["DoctorID"]."' 
                                    data-email='".$row["ContactEmail"]."'
                                    data-name='".$row["Name"]."'
                                    data-specialty='".$row["Specialty"]."'
                                    data-phone='".$row["ContactPhone"]."'
                                    data-availability='".$row["Availability"]."'
                                    data-qualifications='".$row["Qualifications"]."'>
                                <span class='material-icons-sharp'>visibility</span>
                                <span>View</span>
                                </button>
                                <button class='action-button edit-button' id='editBtn-".$row["DoctorID"]."' 
                                data-email='".$row["ContactEmail"]."'
                                data-name='".$row["Name"]."'
                                data-specialty='".$row["Specialty"]."'
                                data-phone='".$row["ContactPhone"]."'
                                data-availability='".$row["Availability"]."'
                                data-qualifications='".$row["Qualifications"]."'>
                                <span class='material-icons-sharp'>edit</span>
                                <span>Edit</span>
                                </button>
                                <button onclick='openDeleteModal(".$row["DoctorID"].")' class='action-button delete-button'>
                                <span class='material-icons-sharp'>delete</span>
                                <span>Delete</span>
                            </button>
                                
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No doctors found</td></tr>";
                    }
                    ?>
              </tbody>
          </table>
        </div>


  <!-- Add Doctor Modal -->
<div id="addDoctorModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Add Doctor</h2>
    <form action="../../../Model/addDoctors.php" method="post">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

  <label for="specialty">Specialty:</label>
  <select id="specialty" name="specialty" required>
    <option value="">Select a Specialty</option>
    <option value="cardiology">Cardiology</option>
    <option value="neurology">Neurology</option>
    <option value="pediatrics">Pediatrics</option>
    <option value="orthopedics">Orthopedics</option>
    <option value="anesthesiology">Anesthesiology</option>
    <option value="dermatology">Dermatology</option>
    <option value="emergency_medicine">Emergency Medicine</option>
    <option value="general_surgery">General Surgery</option>
    <option value="internal_medicine">Internal Medicine</option>
    <option value="obstetrics_gynecology">Obstetrics & Gynecology</option>
    <option value="ophthalmology">Ophthalmology</option>
    <option value="pathology">Pathology</option>
    <option value="psychiatry">Psychiatry</option>
    <option value="radiology">Radiology</option>
  </select>

      <label for="phone">Telephone:</label>
      <input type="text" id="phone" name="phone">

      <label for="availability">Availability:</label>
      <input type="text" id="availability" name="availability">

      <label for="qualifications">Qualifications:</label>
      <textarea id="qualifications" name="qualifications"></textarea>

      <input type="submit" value="Add Doctor">
      </form>
    </div>
  </div>
<!-- View Doctor Modal -->
<div id="viewDoctorModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>View Doctor Details</h2>
    <form action="" method="post">
      <label for="email-view">Email:</label>
      <input type="email" id="email-view" name="email" required readonly>

      <label for="name-view">Name:</label>
      <input type="text" id="name-view" name="name" required readonly>

      <label for="specialty-view">Specialty:</label>
      <input type="text" id="specialty-view" name="specialty" required readonly>

      <label for="phone-view">Telephone:</label>
      <input type="text" id="phone-view" name="phone" readonly>

      <label for="availability-view">Availability:</label>
      <input type="text" id="availability-view" name="availability" readonly>

      <label for="qualifications-view">Qualifications:</label>
      <textarea id="qualifications-view" name="qualifications" readonly></textarea>
    </form>
  </div>
</div>

<div id="editDoctorModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Edit Doctor Details</h2>
    <form action="../../../Model/editDoctor.php" method="post">
      <input type="hidden" id="doctor-id-edit" name="doctorID">
      <label for="email-edit">Email:</label>
      <input type="email" id="email-edit" name="email" required>

      <label for="name-edit">Name:</label>
      <input type="text" id="name-edit" name="name" required>

      <label for="specialty-edit">Specialty:</label>
      <select id="specialty-edit" name="specialty" required>
        <option value="">Select a Specialty</option>
        <option value="cardiology">Cardiology</option>
        <option value="neurology">Neurology</option>
        <option value="pediatrics">Pediatrics</option>
        <option value="orthopedics">Orthopedics</option>
        <option value="anesthesiology">Anesthesiology</option>
        <option value="dermatology">Dermatology</option>
        <option value="emergency_medicine">Emergency Medicine</option>
        <option value="general_surgery">General Surgery</option>
        <option value="internal_medicine">Internal Medicine</option>
        <option value="obstetrics_gynecology">Obstetrics & Gynecology</option>
        <option value="ophthalmology">Ophthalmology</option>
        <option value="pathology">Pathology</option>
        <option value="psychiatry">Psychiatry</option>
        <option value="radiology">Radiology</option>
      </select>

      <label for="phone-edit">Telephone:</label>
      <input type="text" id="phone-edit" name="phone">

      <label for="availability-edit">Availability:</label>
      <input type="text" id="availability-edit" name="availability">

      <label for="qualifications-edit">Qualifications:</label>
      <textarea id="qualifications-edit" name="qualifications"></textarea>

      <input type="submit" value="Update Doctor">
    </form>
  </div>
</div>
<!-- Delete Doctor Modal -->
<div id="deleteDoctorModal" class="modal">
  <div class="modal-content">
  <span class="close" onclick="closeModal('deleteDoctorModal')">&times;</span>
    <h2>Delete Doctor</h2>
    <p>Are you sure you want to delete this doctor?</p>
    <form action="../../../Model/deleteDoctor.php" method="post">
      <input type="hidden" id="delete-doctor-id" name="doctorID">
      <button type="button" onclick="closeModal('deleteDoctorModal')" class="cancel-confirm">Cancel</button>
      <button type="submit" class="delete-confirm">Delete</button>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById("addDoctorModal");
    var btn = document.getElementById("addbtn");
    var spans = document.querySelectorAll('.close');

    btn.addEventListener('click', function() {
        modal.style.display = "block";
    });

    spans.forEach(span => {
        span.addEventListener('click', function() {
            modal.style.display = "none";
        });
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    var viewModal = document.getElementById('viewDoctorModal');
    var viewBtns = document.querySelectorAll('.view-button');
    var closeBtns = document.querySelectorAll('.modal .close');

    viewBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var email = btn.getAttribute('data-email');
            var name = btn.getAttribute('data-name');
            var specialty = btn.getAttribute('data-specialty');
            var phone = btn.getAttribute('data-phone');
            var availability = btn.getAttribute('data-availability');
            var qualifications = btn.getAttribute('data-qualifications');

            document.getElementById('email-view').value = email;
            document.getElementById('name-view').value = name;
            document.getElementById('specialty-view').value = specialty;
            document.getElementById('phone-view').value = phone;
            document.getElementById('availability-view').value = availability;
            document.getElementById('qualifications-view').value = qualifications;

            viewModal.style.display = 'block';
        });
    });

    closeBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            viewModal.style.display = 'none';
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target === viewModal) {
            viewModal.style.display = 'none';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editDoctorModal');
    var editBtns = document.querySelectorAll('.edit-button');
    var closeEditBtns = document.querySelectorAll('.modal .close');

    editBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var doctorID = btn.id.split('-')[1];
            var email = btn.getAttribute('data-email');
            var name = btn.getAttribute('data-name');
            var specialty = btn.getAttribute('data-specialty');
            var phone = btn.getAttribute('data-phone');
            var availability = btn.getAttribute('data-availability');
            var qualifications = btn.getAttribute('data-qualifications');

            document.getElementById('doctor-id-edit').value = doctorID;
            document.getElementById('email-edit').value = email;
            document.getElementById('name-edit').value = name;
            document.getElementById('specialty-edit').value = specialty;
            document.getElementById('phone-edit').value = phone;
            document.getElementById('availability-edit').value = availability;
            document.getElementById('qualifications-edit').value = qualifications;

            editModal.style.display = 'block';
        });
    });

    closeEditBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            editModal.style.display = 'none';
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });
});
function openDeleteModal(doctorId) {
    document.getElementById('delete-doctor-id').value = doctorId;
    document.getElementById('deleteDoctorModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('deleteDoctorModal');
    if (event.target == modal) {
        closeModal('deleteDoctorModal');
    }
}
</script>
</body>
</html>

<?php
$conn->close();
?>