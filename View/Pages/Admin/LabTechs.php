
<?php include "../../Common PHP Functions/ConnectSql.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Lab Techs</title>
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
        <a href="LabTechs.php" class="active">
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
            <h1>Lab Technicians</h1>
            <button class="add-button" id="addBtn">
                <span class="material-icons-sharp">add</span>
                Add Technician
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
                    $query = "SELECT * FROM LabTechnicians";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>TECH-" . htmlspecialchars($row["TechnicianID"]) . "</td>
                            <td>" . htmlspecialchars($row["FullName"]) . "</td>
                            <td>" . htmlspecialchars($row["ContactEmail"]) . "</td>
                            <td class='actions'>
                                <button class='action-button view-button'
                                    data-email='" . htmlspecialchars($row["ContactEmail"]) . "' 
                                    data-name='" . htmlspecialchars($row["FullName"]) . "' 
                                    data-phone='" . htmlspecialchars($row["ContactPhone"]) . "'
                                    data-id='" . $row["TechnicianID"] . "'>View</button>
                                <button class='action-button edit-button'
                                    data-email='" . htmlspecialchars($row["ContactEmail"]) . "' 
                                    data-name='" . htmlspecialchars($row["FullName"]) . "' 
                                    data-phone='" . htmlspecialchars($row["ContactPhone"]) . "'
                                    data-id='" . $row["TechnicianID"] . "'>Edit</button>
                                <button onclick='openDeleteModal(" . htmlspecialchars($row["TechnicianID"]) . ")'
                                    class='action-button delete-button'>Delete</button>
                            </td>
                        </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No lab technicians found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<!-- Add Lab Technician Modal -->
<div id="addTechnicianModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Add Lab Technician</h2>
    <form action="../../../Model/addTechnicians.php" method="post">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="phone">Telephone:</label>
      <input type="text" id="phone" name="phone">

      <input type="submit" value="Add Technician">
    </form>
  </div>
</div>
<!-- View Lab Technician Modal -->
<div id="viewTechnicianModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>View Lab Technician Details</h2>
    <form action="" method="post">
      <label for="email-view">Email:</label>
      <input type="email" id="email-view" name="email" required readonly>

      <label for="name-view">Name:</label>
      <input type="text" id="name-view" name="name" required readonly>

      <label for="phone-view">Telephone:</label>
      <input type="text" id="phone-view" name="phone" readonly>
    </form>
  </div>
</div>

<!-- Edit Lab Technician Modal -->
<div id="editTechnicianModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Edit Lab Technician Details</h2>
    <form action="../../../Model/editTechnician.php" method="post">
      <input type="hidden" id="technician-id-edit" name="technicianID">
      <label for="email-edit">Email:</label>
      <input type="email" id="email-edit" name="email" required>

      <label for="name-edit">Name:</label>
      <input type="text" id="name-edit" name="name" required>

      <label for="phone-edit">Telephone:</label>
      <input type="text" id="phone-edit" name="phone">

      <input type="submit" value="Update Technician">
    </form>
  </div>
</div>

<!-- Delete Lab Technician Modal -->
<div id="deleteTechnicianModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('deleteTechnicianModal')">&times;</span>
    <h2>Delete Lab Technician</h2>
    <p>Are you sure you want to delete this lab technician?</p>
    <form action="../../../Model/deleteTechnician.php" method="post">
      <input type="hidden" id="delete-technician-id" name="technicianID">
      <button type="button" onclick="closeModal('deleteTechnicianModal')" class="cancel-confirm">Cancel</button>
      <button type="submit" class="delete-confirm">Delete</button>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle Add Technician Modal
    var addModal = document.getElementById("addTechnicianModal");
    var addBtn = document.getElementById("addBtn");
    var closeAddSpans = document.querySelectorAll('#addTechnicianModal .close');

    addBtn.onclick = function() {
        addModal.style.display = "block";
    };

    closeAddSpans.forEach(function(span) {
        span.onclick = function() {
            addModal.style.display = "none";
        };
    });

    // Handle View Technician Modal
    var viewModal = document.getElementById('viewTechnicianModal');
    var viewBtns = document.querySelectorAll('.view-button');

    viewBtns.forEach(function (btn) {
        btn.onclick = function () {
            var data = btn.dataset;
            document.getElementById('email-view').value = data.email;
            document.getElementById('name-view').value = data.name;
            document.getElementById('phone-view').value = data.phone;
            viewModal.style.display = 'block';
        };
    });

    // Handle Edit Technician Modal
    var editModal = document.getElementById('editTechnicianModal');
    var editBtns = document.querySelectorAll('.edit-button');

    editBtns.forEach(function (btn) {
        btn.onclick = function () {
            var data = btn.dataset;
            document.getElementById('technician-id-edit').value = btn.getAttribute('data-id');
            document.getElementById('email-edit').value = data.email;
            document.getElementById('name-edit').value = data.name;
            document.getElementById('phone-edit').value = data.phone;
            editModal.style.display = 'block';
        };
    });

    // Handle Delete Technician Modal
    var deleteModal = document.getElementById('deleteTechnicianModal');
    var deleteBtns = document.querySelectorAll('.delete-button');

    deleteBtns.forEach(function(btn) {
        btn.onclick = function() {
            document.getElementById('delete-technician-id').value = btn.getAttribute('data-id');
            deleteModal.style.display = 'block';
        };
    });

    window.onclick = function(event) {
        if (event.target == addModal || event.target == viewModal || event.target == editModal || event.target == deleteModal) {
            event.target.style.display = 'none';
        }
    };
});

</script>
</body>
</html>