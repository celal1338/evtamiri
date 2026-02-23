# evtamiri

ESP32-S3 starter notes for quickly bringing up a board with the ESP-IDF toolchain.

## Target
- MCU: **ESP32-S3**
- Framework: **ESP-IDF** (recommended for first bring-up)

## Quick start
1. Install Espressif tools via the official installer (`idf_tools.py` or VS Code ESP-IDF extension).
2. Set the target to ESP32-S3:
   ```bash
   idf.py set-target esp32s3
   ```
3. Configure your serial port and flash:
   ```bash
   idf.py -p /dev/ttyUSB0 flash monitor
   ```

## Common bring-up checklist
- Confirm USB cable supports data (not power-only).
- Verify board enters download mode when flashing.
- Use a stable 5V source if USB power is unreliable.
- If serial monitor is garbled, check baud rate (typically 115200).

## Next steps
- Add board-specific pin mapping and peripheral notes.
- Add known-good project template for ESP32-S3 (Wi-Fi/BLE/USB as needed).
