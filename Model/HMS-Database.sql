CREATE TABLE Doctors (
    DoctorID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    Name VARCHAR(255) NOT NULL,
    Specialty VARCHAR(255) NOT NULL,
    ContactEmail VARCHAR(255),
    ContactPhone VARCHAR(25),
    Availability VARCHAR(255),
    Qualifications TEXT,
    IsActive BOOLEAN DEFAULT 1,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE Admins (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    FullName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    ContactNumber VARCHAR(25),
    IsActive BOOLEAN DEFAULT 1,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE Patients (
    PatientID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL, --
    FullName VARCHAR(255) NOT NULL, --
    DateOfBirth DATE NOT NULL, --
    Gender ENUM('Male', 'Female') NOT NULL, --
    ContactEmail VARCHAR(255) UNIQUE NOT NULL, --
    ContactPhone VARCHAR(25), --
    Address TEXT, --
    MedicalHistory TEXT,
    Allergies TEXT,
    CurrentMedications TEXT,
    IsActive BOOLEAN DEFAULT 1,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE LabTechnicians (
    TechnicianID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    FullName VARCHAR(255) NOT NULL,
    ContactEmail VARCHAR(255) UNIQUE NOT NULL,
    ContactPhone VARCHAR(25),
    IsActive BOOLEAN DEFAULT 1,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE LabReports (
    ReportID INT PRIMARY KEY AUTO_INCREMENT,
    PatientID INT NOT NULL,
    TechnicianID INT NOT NULL,
    ReportDetails TEXT,
    ReportDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (PatientID) REFERENCES Patients(PatientID),
    FOREIGN KEY (TechnicianID) REFERENCES LabTechnicians(TechnicianID)
);
CREATE TABLE Appointments (
    AppointmentID INT PRIMARY KEY AUTO_INCREMENT,
    PatientID INT NOT NULL,
    DoctorID INT NOT NULL,
    AppointmentDate DATETIME NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('Scheduled', 'Completed', 'Cancelled', 'NoShow') DEFAULT 'Scheduled',
    Notes TEXT,
    FOREIGN KEY (PatientID) REFERENCES Patients(PatientID),
    FOREIGN KEY (DoctorID) REFERENCES Doctors(DoctorID)
);


INSERT INTO Doctors (Username, PasswordHash, Name, Specialty, ContactEmail, ContactPhone, Availability, Qualifications) VALUES 
('jane.smith', 'hashed_password_here', 'Dr. Jane Smith', 'Cardiology', 'jane.smith@hospital.com', '555-1234', 'Mon-Fri 9am-5pm', 'Qualification details here'),
('john.doe', 'hashed_password_here', 'Dr. John Doe', 'Neurology', 'john.doe@hospital.com', '555-5678', 'Mon-Fri 8am-4pm', 'Qualification details here'),
('susan.storm', 'hashed_password_here', 'Dr. Susan Storm', 'General Medicine', 'susan.storm@hospital.com', '555-3333', 'Mon-Fri 10am-6pm', 'MBBS, General Medicine'),
('bruce.banner', 'hashed_password_here', 'Dr. Bruce Banner', 'Radiology', 'bruce.banner@hospital.com', '555-4444', 'Tue-Sat 9am-5pm', 'MD Radiology');

INSERT INTO Patients (Username, PasswordHash, FullName, DateOfBirth, Gender, ContactEmail, ContactPhone, Address, MedicalHistory) VALUES 
('alice.brown', 'hashed_password_here', 'Alice Brown', '1980-05-15', 'Female', 'alice.brown@example.com', '555-1234', '123 Maple Street', 'Medical history details'),
('bob.white', 'hashed_password_here', 'Bob White', '1985-07-20', 'Male', 'bob.white@example.com', '555-5678', '456 Oak Avenue', 'Medical history details'),
('charlie.day', 'hashed_password_here', 'Charlie Day', '1990-08-14', 'Male', 'charlie.day@example.com', '555-5555', '789 Pine Road', 'No significant medical history'),
('dee.reynolds', 'hashed_password_here', 'Dee Reynolds', '1987-01-09', 'Female', 'dee.reynolds@example.com', '555-6666', '321 Birch Street', 'Asthma');

INSERT INTO LabTechnicians (Username, PasswordHash, FullName, ContactEmail, ContactPhone) VALUES 
('dave.green', 'hashed_password_here', 'Dave Green', 'dave.green@lab.com', '555-9012'),
('eve.blue', 'hashed_password_here', 'Eve Blue', 'eve.blue@lab.com', '555-3456'),
('matt.murdock', 'hashed_password_here', 'Matt Murdock', 'matt.murdock@lab.com', '555-7777'),
('foggy.nelson', 'hashed_password_here', 'Foggy Nelson', 'foggy.nelson@lab.com', '555-8888');

INSERT INTO Appointments (PatientID, DoctorID, AppointmentDate, Notes) VALUES 
(1, 1, '2024-04-18 10:00:00', 'Initial consultation'),
(2, 1, '2024-04-19 11:00:00', 'Follow-up on test results'),
(1, 2, '2024-04-25 09:30:00', 'Regular check-up'),
(2, 2, '2024-04-25 10:30:00', 'Consultation for headache');

INSERT INTO LabReports (PatientID, TechnicianID, ReportDetails) VALUES 
(1, 1, 'Complete blood count normal'),
(2, 2, 'MRI scan shows no issues');
