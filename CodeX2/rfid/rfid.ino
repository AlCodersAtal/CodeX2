
// connections
// SDA -> Pin 10
// SCK -> Pin 13
// MOSI -> Pin 11
// MISO -> Pin 12
// GND -> GND
// RST -> Pin 9
// 3.3V -> 3.3V

#include <SPI.h>
#include <MFRC522.h>

// Pin Definitions
#define SS_PIN 5
#define RST_PIN 22

#include <SPI.h>
#include <MFRC522.h>

// Pin Definitions
#define SS_PIN 5
#define RST_PIN 22

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance

void setup() {
  Serial.begin(9600);  // Start serial communication
  SPI.begin();         // Initialize SPI bus
  mfrc522.PCD_Init();  // Initialize MFRC522


}

void loop() {
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    // Get UID
    String rfidUID = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
      rfidUID += String(mfrc522.uid.uidByte[i], HEX);  // Corrected line to access UID
    }

    // Send UID over serial to the Python script
    Serial.println(rfidUID);  // Print UID
    delay(1000);  // Delay for 1 second to prevent multiple readings
  }
}
