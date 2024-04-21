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
    ContactEmail VARCHAR(255) UNIQUE NOT NULL,
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
CREATE TABLE Messages (
    MessageID INT PRIMARY KEY AUTO_INCREMENT,
    SenderEmail VARCHAR(255) NOT NULL,
    ReceiverEmail VARCHAR(255) NOT NULL,
    Type ENUM('Appointment', 'Report', 'General') NOT NULL,
    Subject VARCHAR(255) NOT NULL,
    Body TEXT NOT NULL,
    SenderID INT NOT NULL,
    ReceiverID INT NOT NULL,
    SentDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    IsRead BOOLEAN DEFAULT 0
);

INSERT INTO Messages 
(SenderEmail, ReceiverEmail, Type, Subject, Body, SenderID, ReceiverID, SentDate, IsRead)
VALUES
('admin@hospital.com', 'alice.brown@example.com', 'General', 'Welcome to Our Medical Center', 'We are pleased to welcome you to our facility and look forward to serving your healthcare needs.', 1, 1, NOW(), 0),
('jane.smith@hospital.com', 'alice.brown@example.com', 'Appointment', 'Appointment Confirmation', 'Your appointment with Dr. Smith is confirmed for September 30th, 2023 at 3:00 PM.', 1, 1, NOW(), 0),
('dave.green@lab.com', 'alice.brown@example.com', 'Report', 'Lab Report Available', 'Your recent lab results are now available and have been uploaded to your patient portal.', 1, 1, NOW(), 0),
('admin@hospital.com', 'jane.smith@hospital.com', 'General', 'Holiday Hours Notification', 'Please note that our offices will be closed next week for the holiday observance.', 1, 1, NOW(), 1),
('admin@hospital.com', 'bob.white@example.com', 'General', 'Updated Contact Information', 'Please update your profile with your latest contact information.', 1, 2, NOW(), 0),
('admin@hospital.com', 'john.doe@hospital.com', 'General', 'New Services Available', 'We are excited to announce new healthcare services available at our clinic starting next month.', 1, 2, NOW(), 0),
('alice.brown@example.com', 'admin@hospital.com', 'General', 'Feedback', 'I had a great experience during my last visit, but I would like to suggest extending clinic hours if possible.', 1, 1, NOW(), 0),
('dave.green@lab.com', 'admin@hospital.com', 'General', 'Stock Replenishment Needed', 'We are running low on some important lab supplies needed for standard tests. Can we restock them soon?', 1, 1, NOW(), 0),
('john.doe@hospital.com', 'admin@hospital.com', 'General', 'IT Support Needed', 'There are recurring issues with our patient management system logins. Can we have IT support look into this?', 2, 1, NOW(), 0);


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
