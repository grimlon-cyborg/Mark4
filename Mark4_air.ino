//Mark4_air 

int sensorValueLicht = 0;  
int sensorLicht = A4;  
int ledLichtne = A0;    //rot
int ledLichttm = A1;    //grün 


int sensorValueFeuchtigkeit = 0; 
int sensorFeuchtigkeit = A5;
int ledWasserne = A2; //rot
int ledWassertm =A3; //grün 


void setup() {

  Serial.begin(9600); 
  pinMode(ledWasserne, OUTPUT);
  pinMode(ledWassertm, OUTPUT);
  pinMode(ledLichtne, OUTPUT);
  pinMode(ledLichttm, OUTPUT);

}

void loop() {
  
  Serial.print("Licht: ");

  sensorValueLicht = analogRead(sensorLicht); 
  Serial.print(sensorValueLicht); 
 
 
 Serial.print(" Feuchtigkeit: ");

  sensorValueFeuchtigkeit = analogRead(sensorFeuchtigkeit); // read the value from the sensor
  Serial.println(sensorValueFeuchtigkeit); //prints the values coming from the sensor on the screen


if(sensorValueLicht<130)
{
 Serial.println("Mehr Licht!!! ");
 digitalWrite(ledLichtne, HIGH);
}


else
{
  digitalWrite(ledLichtne, LOW);
}


if(sensorValueLicht>250)
{
 Serial.println("Weniger Licht!!! ");
 digitalWrite(ledLichttm, HIGH);
}

else
{
  digitalWrite(ledLichttm, LOW);
}


if(sensorValueFeuchtigkeit<50)
{
  Serial.println("Mehr Wasser!!! ");
  digitalWrite(ledWasserne, HIGH);
  }

if(sensorValueFeuchtigkeit<50)
{
  Serial.println("Mehr Wasser!!! ");
  digitalWrite(ledWasserne, HIGH);
}


else
{
  digitalWrite(ledWasserne, LOW);
}

if(sensorValueFeuchtigkeit>200)
  { 
  Serial.println("Zu viel  Wasser!!! ");
  digitalWrite(ledWassertm, HIGH);
    
  }
  else
  {
    digitalWrite(ledWassertm, LOW);
  }


  digitalWrite(ledWassertm, HIGH);



 delay(10);

}
