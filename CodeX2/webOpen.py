import serial
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

# Connect to Arduino via serial port (adjust the COM port if needed)
serial_port = 'COM3'  # Replace with your correct serial port (check your device manager)
baud_rate = 9600
ser = serial.Serial(serial_port, baud_rate)

# Set up Selenium WebDriver
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))

# Open the index.php page (the page that will have the UID field)
driver.get("http://localhost/CodeX2/index.php")  # Replace with your actual URL

while True:
    if ser.in_waiting > 0:
        uid = ser.readline().decode().strip()  # Read the UID from Arduino and clean it
        print(f"Scanned UID: {uid}")

        # Fill the UID field on the form in the index.php page
        try:
            # Locate the UID field on the form and fill it in
            uid_field = driver.find_element(By.NAME, 'uid')  # Assuming the input field has name="uid"
            uid_field.clear()  # Clear any existing value
            uid_field.send_keys(uid)  # Fill in the UID field

            print(f"UID filled: {uid}")
        except Exception as e:
            print(f"Error filling UID field: {e}")
        
        # Optional: Wait a bit before the next reading
        time.sleep(1)
