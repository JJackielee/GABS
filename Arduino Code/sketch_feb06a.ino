/*The portion of code dealing with WiFi connectivity is from Shawn Hymel from his site: http://shawnhymel.com/695/quick-tip-http-get-with-the-esp8266-thing/ 
 * ------Changelog--------
 *  - Different pin input
 *  - Change in baud rate
 *  - Does not use remoste site info but is inclusive in code
 *The portion of code dealing with sending a HTTP GET request is from the user Wiwo on Stack overflow: http://stackoverflow.com/questions/34078497/esp8266-wificlient-simple-http-get
 * ------Changelog--------
 *  - Removed unneccessary code for this setup
 *  - Renamed a few variables
 *  
 *  The rest of the code was done manually Tony Nguyen & Jackie Lee
*/
#include <ESP8266WiFi.h>

//For Wifi
const char* ssid = "HOME-7992";//type your ssid //University of Washington//HOME-7992
const char* password = "TG862G0F7992";//type your password //Newport1000//TG862G0F7992
WiFiServer server(80);
//For Data
String data;
int sensorValue = 0;

//Sound variables
int soundDetectedPin = 2; // Use Pin 10 as our Input
int soundDetectedVal = HIGH; // This is where we record our Sound Measurement
boolean bAlarm = false;
unsigned long lastSoundDetectTime; // Record the time that we measured a sound
int soundAlarmTime = 30000; // Number of milli seconds to keep the sound alarm high

WiFiClient client;
//First connects to wifi
void setup() {
  Serial.begin(115200); //Baudrate
  delay(10); //Set 10 milisecond delay

  WiFi.begin(ssid, password);// Initiates wifi SSID and PASSWORD parameters
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("System Ready");
  Serial.println("");
  pinMode (soundDetectedPin, INPUT) ; // input from the Sound Detection Module
}
//Loop through methods
void loop() {
sensorValue= analogRead(soundDetectedPin);
soundDetectedVal = analogRead (soundDetectedPin);
if (soundDetectedVal == LOW) {
    lastSoundDetectTime = millis(); // record the time of the sound alarm
    // The following is so you don't scroll on the output screen
    if (!bAlarm) {
      Serial.println("Yes");
      dataTransfer();
      bAlarm = true;
    }
    
  } else {;
    if ( (millis() - lastSoundDetectTime) > soundAlarmTime  &&  bAlarm) {
      Serial.println("Ready!");
      bAlarm = false;
    }
  }
}
//Method to send data from arduino to database
void dataTransfer() {
int lat = 1010.1;
int lng = 1079.1;
String location = "tonyhouse";
int description =sensorValue;
if (client.connect("www.students.washington.edu", 80)) { // REPLACE WITH YOUR SERVER ADDRESS
        Serial.println("connected");
        //Write data to database table shots_data
        client.print(String("GET ") + "/nguy923/ios/ardiuno.php?lat=" + lat + "&lng="+ lng + "&location="+location+"&description="+ description + " HTTP/1.1\r\n" +
                     "Host: " + "students.washington.edu" + "\r\n" +
                     "Connection: close\r\n\r\n");
        //Print data on serial monitor for confirmation             
        Serial.print(String("GET ") + "/nguy923/ios/ardiuno.php?lat=" + lat + "&lng="+ lng + "&location="+location+"&description="+ description + " HTTP/1.1\r\n" +
                     "Host: " + "students.washington.edu" + "\r\n" +
                     "Connection: close\r\n\r\n");
        //Confirm that data was sent             
        Serial.println("GET http request Successful");
        Serial.println("");
        Serial.println(sensorValue);
      }
      //Disconnect from client once data is sent
      if (client.connected()) {
        client.stop();    // DISCONNECT FROM THE SERVER
      }

}
