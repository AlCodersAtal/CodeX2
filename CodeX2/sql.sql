CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid VARCHAR(255) NOT NULL UNIQUE,    -- Unique RFID UID
    name VARCHAR(100) NOT NULL,          -- Patient's name
    age INT NOT NULL,                    -- Patient's age
    gender ENUM('Male', 'Female', 'Other') NOT NULL,  -- Gender
    uhid VARCHAR(50) NOT NULL,           -- UHID (Unique Health ID)
    blood_group VARCHAR(5) NOT NULL,     -- Blood group
    prescription_link TEXT NOT NULL,     -- Link to prescription (e.g., Google Drive URL)
    medication_link TEXT NOT NULL        -- Link to medications (e.g., Google Drive URL)
);
