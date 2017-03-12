/*Gun A Be Safe: A project that uses the arduino to gather 
sound and location data that is sent to a data base for mobile/web use. 
*By: Tony Nguyen and Jackie Lee
*/
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
 *The portion of code dealing with GPS data is originally from a Github contributor by the name of LessonStudio: https://github.com/LessonStudio/Arduino_GPS
 *  ------Changelog--------
 *  - Only made use of the short code statement that determines for signal and encodes the data for GPS module
 *  - Used those statements directly in our data transfer loop
 *  - Redirected the pin layout which is different from LessonStudio's
 *  
 *  
 *  The rest of the code was done manually Tony Nguyen & Jackie Lee
*/
#include <ESP8266WiFi.h>
#include <TinyGPS++.h>
#include <SoftwareSerial.h>

//For Wifi variables
const char* ssid = "University of Washington";//type your ssid //University of Washington//HOME-7992
const char* password = "Newport1000";//type your password //Newport1000//TG862G0F7992
WiFiServer server(80);


//For GPS variables
static const uint32_t GPSBaud = 9600;
TinyGPSPlus gps;
SoftwareSerial ss(12, 13); //RX=pin 12, TX=pin 14

//For Data variables
String data;
double hihi;
double bye;


//Sound variables
#define PIN_ANALOG_IN A0

WiFiClient client;
//First connects to wifi
void setup() {
  Serial.println("===============================================================================");
  Serial.begin(115200); //Baudrate
  ss.begin(GPSBaud);
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
  pinMode (A0, INPUT) ; // input from the Sound Detection Module via ADC Pin on ESP 12e
  
   Serial.println("===============================================================================");
}
//Loop through methods
void loop() {
  gpsData();
 if(analogRead(PIN_ANALOG_IN) > 700) { //Determined if their was voltage reading higher than 700 and printed the following statements
  Serial.println("Bang");
  Serial.println(analogRead(PIN_ANALOG_IN));
  delay(40); //Sets a delay
  dataTransfer(); //Runs the transfer data method
  bAlarm = true;
   }else {
  if(analogRead(PIN_ANALOG_IN) < 700) { //Otherwise the readings of the sound device are environment noises.
    bAlarm = false;
  }
 }
}
  

//Method to send data from arduino to database
void dataTransfer() {
Serial.println("===============================================================================");
Serial.println("=================================Sound Detected================================");

    long lat = (gps.location.lat(), 6);
    long lng = (gps.location.lng(), 6);
    Serial.println((gps.location.lat(), 6));
    Serial.println((gps.location.lng(), 6));
    String location = "Default";
    long description = analogRead(PIN_ANALOG_IN);
    if (client.connect("www.students.washington.edu", 80)) { // REPLACE WITH YOUR SERVER ADDRESS
            Serial.println("Connected to Client");
            //Write data to database table shots_data
            client.print(String("GET ") + "/nguy923/ios/ardiuno.php?lat=");
            client.print(hihi, 6);
            client.print("&lng=");
            client.print(bye, 6);
            client.print("&location="+location+"&description="+ description + " HTTP/1.1\r\n" +
                         "Host: " + "students.washington.edu" + "\r\n" +
                         "Connection: close\r\n\r\n");
            //Print data on serial monitor for confirmation             
            Serial.print(String("GET ") + "/nguy923/ios/ardiuno.php?lat=" + hihi + "&lng="+ bye + "&location="+location+"&description="+ description + " HTTP/1.1\r\n" +
                         "Host: " + "students.washington.edu" + "\r\n" +
                         "Connection: close\r\n\r\n");
            //Confirm that data was sent             
            Serial.println("GET http request Successful");
            Serial.println("");
          }
          //Disconnect from client once data is sent
          if (client.connected()) {
            client.stop();    // DISCONNECT FROM THE SERVER
          }
    Serial.println("===============================================================================");
    
}
void gpsData() {
  while(ss.available())//While there are characters to come from the GPS
  {
    gps.encode(ss.read());//This feeds the serial NMEA data into the library one char at a time
  }
  if(gps.location.isUpdated())//This will pretty much be fired all the time anyway but will at least reduce it to only after a package of NMEA data comes in
  {
    //Get the latest info from the gps object which it derived from the data sent by the GPS unit
    hihi = gps.location.lat();
    Serial.println(gps.location.lat(), 6);
    Serial.println(hihi, 6);
    bye=gps.location.lng();
    Serial.println(bye, 6);
    Serial.println(gps.location.lng(), 6);
  }
}



