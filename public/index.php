<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="vi"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>ESP Emulator — ESP8266 &amp; ESP32 (Full)</title>
<style>
:root{--bg:#0b0f1a;--p:#121a2b;--p2:#182238;--bd:#26344f;--tx:#e6edf7;--mu:#8a99b5;--ac:#35e0a1;--er:#ff5d6c;--bl:#4da3ff;--or:#ffb454}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--tx);font:14px/1.5 system-ui,'Segoe UI',sans-serif}
header{display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;padding:12px 20px;background:var(--p);border-bottom:1px solid var(--bd);position:sticky;top:0;z-index:5}
h1{font-size:18px}h1 b{color:var(--ac)}
.chips{display:flex;gap:8px;flex-wrap:wrap}
.chip{background:var(--p2);border:1px solid var(--bd);border-radius:99px;padding:2px 12px;font-size:12px;color:var(--mu)}.chip b{color:var(--ac)}
main{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,1fr);gap:16px;padding:16px 20px;max-width:1600px;margin:auto}
@media(max-width:900px){main{grid-template-columns:1fr}}
.card{background:var(--p);border:1px solid var(--bd);border-radius:12px;padding:14px;margin-bottom:16px}
.card h3{font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--mu);margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;gap:8px}
.bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:10px}
button,select,input[type=text]{font:inherit;color:var(--tx);background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:7px 12px}
button{cursor:pointer;transition:.15s}button:hover{border-color:var(--ac)}
button.run{background:var(--ac);color:#04251a;border-color:var(--ac);font-weight:700}
button.stop{background:var(--er);border-color:var(--er);color:#fff;font-weight:700}
button.mini{padding:3px 8px;font-size:12px}
.ed{display:flex;border:1px solid var(--bd);border-radius:8px;background:#080c15;height:430px;overflow:hidden}
.ed pre,.ed textarea{font:13px/1.55 ui-monospace,Consolas,monospace;padding:10px 8px;border:0;white-space:pre;tab-size:2}
.ed pre{color:#4a5a78;text-align:right;user-select:none;background:#0a101c;overflow:hidden;min-width:42px}
.ed textarea{flex:1;background:transparent;color:#bdf5de;resize:none;outline:none;overflow:auto;border-radius:0}
#ser{height:190px;overflow:auto;background:#080c15;border:1px solid var(--bd);border-radius:8px;padding:8px 10px;font:13px/1.5 ui-monospace,Consolas,monospace;margin-bottom:8px}
#ser div{white-space:pre-wrap;color:#bdf5de}#ser .sys{color:var(--mu)}#ser .err{color:var(--er)}#ser .mqtt{color:var(--or)}
.row{display:flex;gap:8px}.row input{flex:1}
.pins{display:grid;grid-template-columns:repeat(auto-fill,minmax(66px,1fr));gap:8px}
.pin{background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:6px 4px;text-align:center;cursor:pointer;user-select:none;transition:.15s}
.pin:hover{border-color:var(--ac)}.pin small{display:block;color:var(--mu);font-size:10px}
.pin b{font-size:17px}.pin.hi{background:var(--ac);color:#04251a;border-color:var(--ac)}.pin.hi small{color:#06402c}
.pin.pw{background:linear-gradient(0deg,var(--ac) var(--d,0%),var(--p2) var(--d,0%))}
.leds{display:flex;gap:22px;justify-content:center;margin-top:14px;flex-wrap:wrap}
.led{text-align:center;font-size:11px;color:var(--mu)}.led i{display:block;width:22px;height:22px;border-radius:50%;background:#2a3550;margin:0 auto 4px;transition:.1s}
canvas{width:100%;background:#080c15;border-radius:8px;display:block}
#oled{image-rendering:pixelated;background:#000;height:auto}
input[type=range]{width:100%;margin:6px 0 10px;accent-color:var(--ac)}
.wifi div{display:flex;justify-content:space-between;padding:6px 8px;border-bottom:1px solid var(--bd);cursor:pointer}.wifi div:hover{background:var(--p2)}
.periph label{font-size:12px;color:var(--mu);display:flex;justify-content:space-between}
.periph label b{color:var(--ac)}
.servo-wrap{display:flex;gap:20px;align-items:center;justify-content:space-around;padding:10px 0}
.servo{width:80px;height:80px;border-radius:50%;background:#0f1729;border:2px solid var(--bd);position:relative}
.servo-arm{position:absolute;left:50%;top:50%;width:36px;height:4px;background:var(--ac);border-radius:2px;transform-origin:0 50%;transform:translate(-2px,-50%) rotate(0deg);transition:transform .15s;box-shadow:0 0 8px rgba(53,224,161,.4)}
.buzzer{font-size:38px;opacity:.15;transition:.1s}.buzzer.on{opacity:1;filter:drop-shadow(0 0 8px var(--or))}
.mqttlog{height:130px;overflow:auto;background:#080c15;border:1px solid var(--bd);border-radius:8px;padding:6px 8px;font:12px/1.4 ui-monospace,monospace}
.mqttlog div{color:var(--mu)}.mqttlog b{color:var(--or)}.mqttlog i{color:var(--bl);font-style:normal}
</style></head>
<body>
<header>
  <h1>⚡ ESP<b>Emulator</b> <span style="font-size:11px;color:var(--mu)">FULL</span></h1>
  <div class="bar" style="margin:0"><select id="board"><option value="esp8266">ESP8266</option><option value="esp32">ESP32</option></select></div>
  <div class="chips">
    <span class="chip">CPU <b id="c-cpu"></b></span>
    <span class="chip">WiFi <b id="c-wifi">OFF</b></span>
    <span class="chip">IP <b id="c-ip">0.0.0.0</b></span>
    <span class="chip">Heap <b id="c-heap"></b></span>
    <span class="chip">Uptime <b id="c-up">0s</b></span>
    <span class="chip">Free <b id="c-free">0s</b></span>
  </div>
</header>
<main>
<section>
  <div class="card">
    <h3>Sketch <span id="state">● Dừng</span></h3>
    <div class="bar">
      <button class="run" id="run">▶ Chạy (Ctrl+Enter)</button>
      <button class="stop" id="stop">■ Dừng</button>
      <select id="ex">
        <option value="blink">💡 Blink</option>
        <option value="fade">🎚️ PWM Fade</option>
        <option value="button">🔘 Nút nhấn</option>
        <option value="irq">⚡ Interrupt</option>
        <option value="wifi">📶 WiFi Scan</option>
        <option value="i2c">🔌 I2C Scan</option>
        <option value="touch">👆 Touch (ESP32)</option>
        <option value="dht">🌡️ DHT22</option>
        <option value="ultra">📏 HC-SR04</option>
        <option value="oled">🖥️ OLED SSD1306</option>
        <option value="servo">🎯 Servo Sweep</option>
        <option value="buzzer">🔊 Buzzer Tone</option>
        <option value="eeprom">💾 EEPROM Lưu/Tải</option>
        <option value="mqtt">📡 MQTT Pub/Sub</option>
        <option value="http">🌐 HTTP Client</option>
        <option value="web">🖧 Web Server</option>
        <option value="ticker">⏰ Ticker định kỳ</option>
        <option value="task">🧵 FreeRTOS Task</option>
        <option value="ntp">🕒 NTP Time</option>
        <option value="json">🧩 JSON Parse</option>
      </select>
    </div>
    <div class="ed"><pre id="gut">1</pre><textarea id="src" spellcheck="false"></textarea></div>
  </div>
  <div class="card"><h3>Serial Monitor <button class="mini" onclick="ser.innerHTML=''" style="padding:2px 10px">Xoá</button></h3>
    <div id="ser"></div>
    <div class="row"><input type="text" id="rx" placeholder="Gửi dữ liệu tới Serial rồi Enter…"><button id="send">Gửi</button></div>
  </div>
</section>
<section>
  <div class="card"><h3>GPIO — bấm để đảo mức chân INPUT</h3><div class="pins" id="pins"></div>
    <div class="leds" id="leds"></div></div>

  <div class="card"><h3>Ngoại vi ảo</h3>
    <div class="periph">
      <label>🌡️ Nhiệt độ DHT <b id="dht-t-val">25.0 °C</b></label>
      <input type="range" id="dht-t" min="-20" max="80" step="0.1" value="25">
      <label>💧 Độ ẩm DHT <b id="dht-h-val">60 %</b></label>
      <input type="range" id="dht-h" min="0" max="100" value="60">
      <label>📏 Khoảng cách HC-SR04 <b id="dist-val">30 cm</b></label>
      <input type="range" id="dist" min="2" max="400" value="30">
      <label>☀️ Ánh sáng LDR <b id="ldr-val">2048</b></label>
      <input type="range" id="ldr" min="0" max="4095" value="2048">
    </div>
  </div>

  <div class="card"><h3>OLED 128×64 <span id="oled-state" style="color:var(--mu);font-weight:400;text-transform:none;letter-spacing:0">chưa dùng</span></h3>
    <canvas id="oled" width="256" height="128"></canvas>
  </div>

  <div class="card"><h3>Servo &amp; Buzzer</h3>
    <div class="servo-wrap">
      <div class="servo"><div class="servo-arm" id="servo-arm"></div></div>
      <div class="buzzer" id="buzzer">🔊</div>
    </div>
  </div>

  <div class="card"><h3>ADC <span id="adcv"></span></h3><canvas id="cv" width="400" height="90"></canvas>
    <input type="range" id="adc"><div class="bar"><button class="mini" id="rnd">🎲 Ngẫu nhiên</button><button class="mini" id="tch">👆 Giữ Touch</button></div></div>

  <div class="card"><h3>WiFi xung quanh</h3><div class="wifi" id="wl"></div></div>

  <div class="card"><h3>MQTT Broker (giả lập)</h3>
    <div class="mqttlog" id="mqttlog"></div>
    <div class="row" style="margin-top:8px">
      <input type="text" id="mqtt-topic" placeholder="topic" value="home/led">
      <input type="text" id="mqtt-msg" placeholder="payload" value="ON">
      <button class="mini" id="mqtt-pub">Publish</button>
    </div>
  </div>

  <div class="card"><h3>Web Request (giả lập)</h3>
    <div class="row">
      <input type="text" id="req-path" placeholder="/path" value="/">
      <button class="mini" id="req-get">GET</button>
    </div>
    <div id="req-log" class="mqttlog" style="height:80px;margin-top:8px"></div>
  </div>
</section>
</main>
<script>
const $=id=>document.getElementById(id),STOP={};
const BOARDS={
 esp8266:{name:'ESP8266',mhz:160,heap:81920,adcMax:1023,pwmBits:10,pins:[0,1,2,3,4,5,12,13,14,15,16],
  alias:{D0:16,D1:5,D2:4,D3:0,D4:2,D5:14,D6:12,D7:13,D8:15,A0:17,SDA:4,SCL:5,LED_BUILTIN:2}},
 esp32:{name:'ESP32',mhz:240,heap:327680,adcMax:4095,pwmBits:8,pins:[0,2,4,5,12,13,14,15,16,17,18,19,21,22,23,25,26,27,32,33,34,35,36,39],
  alias:{LED_BUILTIN:2,SDA:21,SCL:22,A0:36,A3:39,A4:32,A5:33,A6:34,A7:35,T0:4,T1:0,T2:2,T3:15,T4:13,T5:12,T6:14,T7:27,DAC1:25,DAC2:26,VN:39,VP:36}}};
const NETS=[['ELECTRONICSTREE',-45,6],['Viettel 5G',-58,1],['FPT Telecom',-55,1],['iPhone 15',-48,6],['Free WiFi',-72,3]];

const EX={
blink:`void setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  digitalWrite(LED_BUILTIN, HIGH);\n  Serial.println("LED ON");\n  delay(1000);\n  digitalWrite(LED_BUILTIN, LOW);\n  Serial.println("LED OFF");\n  delay(1000);\n}`,
fade:`int brightness = 0;\nint amount = 5;\n\nvoid setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n}\n\nvoid loop() {\n  analogWrite(LED_BUILTIN, brightness);\n  brightness += amount;\n  if (brightness <= 0 || brightness >= 255) amount = -amount;\n  delay(20);\n}`,
button:`const int BTN = 0;\n\nvoid setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n  pinMode(BTN, INPUT_PULLUP);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  if (digitalRead(BTN) == LOW) {\n    digitalWrite(LED_BUILTIN, HIGH);\n    Serial.println("Nhấn!");\n  } else {\n    digitalWrite(LED_BUILTIN, LOW);\n  }\n  delay(100);\n}`,
irq:`volatile int count = 0;\n\nvoid IRAM_ATTR onPress() {\n  count++;\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(0, INPUT_PULLUP);\n  attachInterrupt(digitalPinToInterrupt(0), onPress, FALLING);\n}\n\nvoid loop() {\n  if (count > 0) {\n    Serial.print("Ngắt lần: ");\n    Serial.println(count);\n    count = 0;\n  }\n  delay(50);\n}`,
wifi:`void setup() {\n  Serial.begin(115200);\n  WiFi.mode(WIFI_STA);\n}\n\nvoid loop() {\n  int n = WiFi.scanNetworks();\n  Serial.printf("Tìm thấy %d mạng\\n", n);\n  for (int i = 0; i < n; i++) {\n    Serial.print(WiFi.SSID(i));\n    Serial.print("  ");\n    Serial.print(WiFi.RSSI(i));\n    Serial.println(" dBm");\n  }\n  delay(5000);\n}`,
i2c:`void setup() {\n  Wire.begin();\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  int found = 0;\n  for (int addr = 1; addr < 127; addr++) {\n    Wire.beginTransmission(addr);\n    if (Wire.endTransmission() == 0) {\n      Serial.printf("Thiết bị tại 0x%X\\n", addr);\n      found++;\n    }\n  }\n  Serial.printf("Tổng: %d thiết bị\\n", found);\n  delay(5000);\n}`,
touch:`// Chỉ ESP32 — giữ nút "Giữ Touch"\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(LED_BUILTIN, OUTPUT);\n}\n\nvoid loop() {\n  int v = touchRead(T0);\n  Serial.printf("Touch = %d\\n", v);\n  digitalWrite(LED_BUILTIN, v < 40);\n  delay(200);\n}`,
dht:`#include <DHT.h>\n#define DHTPIN 4\n#define DHTTYPE DHT22\n\nDHT dht(DHTPIN, DHTTYPE);\n\nvoid setup() {\n  Serial.begin(115200);\n  dht.begin();\n}\n\nvoid loop() {\n  float t = dht.readTemperature();\n  float h = dht.readHumidity();\n  if (isnan(t) || isnan(h)) {\n    Serial.println("Lỗi đọc DHT!");\n    return;\n  }\n  Serial.printf("Nhiệt độ: %.1f C  |  Độ ẩm: %.1f %%\\n", t, h);\n  delay(2000);\n}`,
ultra:`#define TRIG 5\n#define ECHO 18\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(TRIG, OUTPUT);\n  pinMode(ECHO, INPUT);\n}\n\nvoid loop() {\n  digitalWrite(TRIG, LOW);\n  delayMicroseconds(2);\n  digitalWrite(TRIG, HIGH);\n  delayMicroseconds(10);\n  digitalWrite(TRIG, LOW);\n  long us = pulseIn(ECHO, HIGH);\n  float cm = us * 0.034 / 2;\n  Serial.printf("Khoảng cách: %.1f cm\\n", cm);\n  delay(500);\n}`,
oled:`#include <Wire.h>\n#include <Adafruit_GFX.h>\n#include <Adafruit_SSD1306.h>\n\nAdafruit_SSD1306 display(128, 64, &Wire, -1);\n\nvoid setup() {\n  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);\n  display.clearDisplay();\n  display.setTextColor(SSD1306_WHITE);\n  display.setTextSize(1);\n  display.setCursor(0, 0);\n  display.println("Hello ESP32!");\n  display.setTextSize(2);\n  display.setCursor(0, 20);\n  display.println("FULL");\n  display.drawRect(0, 50, 128, 14, SSD1306_WHITE);\n  display.display();\n}\n\nint counter = 0;\nvoid loop() {\n  counter++;\n  display.fillRect(0, 50, 128, 14, SSD1306_BLACK);\n  display.drawRect(0, 50, 128, 14, SSD1306_WHITE);\n  display.setTextSize(1);\n  display.setCursor(4, 53);\n  display.printf("Counter: %d", counter);\n  display.display();\n  delay(500);\n}`,
servo:`#include <Servo.h>\n\nServo myservo;\n\nvoid setup() {\n  Serial.begin(115200);\n  myservo.attach(18);\n}\n\nvoid loop() {\n  for (int pos = 0; pos <= 180; pos += 30) {\n    myservo.write(pos);\n    Serial.printf("Servo: %d°\\n", pos);\n    delay(400);\n  }\n  for (int pos = 180; pos >= 0; pos -= 30) {\n    myservo.write(pos);\n    Serial.printf("Servo: %d°\\n", pos);\n    delay(400);\n  }\n}`,
buzzer:`#define BUZZER 4\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(BUZZER, OUTPUT);\n}\n\nvoid loop() {\n  int notes[5] = {262, 294, 330, 349, 392};\n  for (int i = 0; i < 5; i++) {\n    Serial.printf("Note: %d Hz\\n", notes[i]);\n    tone(BUZZER, notes[i]);\n    delay(300);\n    noTone(BUZZER);\n    delay(80);\n  }\n  delay(1500);\n}`,
eeprom:`#include <EEPROM.h>\n\nint addr = 0;\nint counter;\n\nvoid setup() {\n  Serial.begin(115200);\n  EEPROM.begin(32);\n  counter = EEPROM.read(addr);\n  Serial.printf("Giá trị đã lưu: %d\\n", counter);\n}\n\nvoid loop() {\n  counter++;\n  EEPROM.write(addr, counter);\n  EEPROM.commit();\n  Serial.printf("Đã lưu: %d\\n", counter);\n  delay(1500);\n}`,
mqtt:`#include <WiFi.h>\n#include <PubSubClient.h>\n\nWiFiClient espClient;\nPubSubClient client(espClient);\n\nvoid callback(char* topic, byte* payload, unsigned int length) {\n  Serial.printf("Nhận [%s]: ", topic);\n  for (unsigned int i = 0; i < length; i++) Serial.print((char)payload[i]);\n  Serial.println();\n  if (payload[0] == 'O' && payload[1] == 'N') digitalWrite(2, HIGH);\n  if (payload[0] == 'O' && payload[1] == 'F') digitalWrite(2, LOW);\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(2, OUTPUT);\n  WiFi.begin("demo", "12345678");\n  client.setServer("broker.hivemq.com", 1883);\n  client.setCallback(callback);\n}\n\nvoid loop() {\n  if (!client.connected()) {\n    client.connect("esp32-demo");\n    client.subscribe("home/led");\n  }\n  client.loop();\n  client.publish("home/status", "online");\n  delay(3000);\n}`,
http:`#include <WiFi.h>\n#include <HTTPClient.h>\n\nvoid setup() {\n  Serial.begin(115200);\n  WiFi.begin("demo", "12345678");\n}\n\nvoid loop() {\n  if (WiFi.status() == WL_CONNECTED) {\n    HTTPClient http;\n    http.begin("http://api.example.com/data");\n    int code = http.GET();\n    Serial.printf("HTTP %d\\n", code);\n    Serial.println(http.getString());\n    http.end();\n  }\n  delay(5000);\n}`,
web:`#include <WiFi.h>\n#include <WebServer.h>\n\nWebServer server(80);\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(2, OUTPUT);\n  WiFi.begin("demo", "12345678");\n  server.on("/", []() {\n    server.send(200, "text/plain", "ESP32 OK");\n  });\n  server.on("/on", []() {\n    digitalWrite(2, HIGH);\n    server.send(200, "text/plain", "LED ON");\n  });\n  server.on("/off", []() {\n    digitalWrite(2, LOW);\n    server.send(200, "text/plain", "LED OFF");\n  });\n  server.begin();\n  Serial.println("Server: http://192.168.1.100/");\n}\n\nvoid loop() {\n  server.handleClient();\n  delay(20);\n}`,
ticker:`#include <Ticker.h>\n\nTicker timer;\nint count = 0;\n\nvoid onTick() {\n  count++;\n  digitalWrite(2, !digitalRead(2));\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(2, OUTPUT);\n  timer.attach(1.0, onTick);\n  Serial.println("Ticker: 1 giây/lần");\n}\n\nvoid loop() {\n  Serial.printf("Loop, count = %d\\n", count);\n  delay(2000);\n}`,
task:`TaskHandle_t Task1;\n\nvoid Task1code(void *pvParameters) {\n  while (1) {\n    Serial.println("Task 1 → core 0");\n    vTaskDelay(1000 / portTICK_PERIOD_MS);\n  }\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  xTaskCreatePinnedToCore(Task1code, "Task1", 10000, NULL, 1, &Task1, 0);\n  Serial.println("Setup xong");\n}\n\nvoid loop() {\n  Serial.println("Loop → core 1");\n  delay(2000);\n}`,
ntp:`#include <time.h>\n\nvoid setup() {\n  Serial.begin(115200);\n  WiFi.begin("demo", "12345678");\n  configTime(7 * 3600, 0, "pool.ntp.org");\n  Serial.println("Đang đồng bộ giờ…");\n}\n\nvoid loop() {\n  time_t now = time(nullptr);\n  struct tm *t = localtime(&now);\n  char buf[32];\n  sprintf(buf, "%02d:%02d:%02d", t->tm_hour, t->tm_min, t->tm_sec);\n  Serial.println(buf);\n  delay(1000);\n}`,
json:`#include <ArduinoJson.h>\n\nvoid setup() {\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  String json = "{\\"temp\\": 28.5, \\"humid\\": 65, \\"ok\\": true}";\n  StaticJsonDocument<200> doc;\n  deserializeJson(doc, json);\n  float t = doc["temp"];\n  int h = doc["humid"];\n  bool ok = doc["ok"];\n  Serial.printf("Temp=%.1f Humid=%d OK=%d\\n", t, h, ok);\n  delay(3000);\n}`};

let B,pv,pm,pw,run=false,tok=0,adc=0,ldr=2048,wifi,irq,rx,sb,t0,ticks=0,touch=false,ledc,hist=new Array(100).fill(0);
let dhtT=25,dhtH=60,dist=30,servoAngle=0,toneOn=false,toneFreq=0,timers=[],tasks=[],ntpBase=Date.now();
let EEPROMdata=new Uint8Array(512);
let prefsData={};
let oledCanvas,oledCtx,oledOn=false,oledBuf,oledBufCtx;
let mqttSubs=[],mqttConnected=false,mqttServer='',mqttClientId='';
let httpHandlerMap={},httpServerOn=false;
let brokerBroker=[];
let reqLog=[];
const AsyncFunction=Object.getPrototypeOf(async function(){}).constructor;
const save=(k,v)=>{try{localStorage.setItem(k,v)}catch(e){}},load=k=>{try{return localStorage.getItem(k)}catch(e){return null}};
const log=(m,c='')=>{const d=document.createElement('div');d.className=c;d.textContent=m;$('ser').appendChild(d);if($('ser').children.length>400)$('ser').firstChild.remove();$('ser').scrollTop=1e9};

function initOLED(){
  oledCanvas=$('oled');oledCtx=oledCanvas.getContext('2d');
  oledBuf=document.createElement('canvas');oledBuf.width=128;oledBuf.height=64;
  oledBufCtx=oledBuf.getContext('2d',{willReadFrequently:true});
  oledBufCtx.fillStyle='#000';oledBufCtx.fillRect(0,0,128,64);
  refreshOLED();
}
function refreshOLED(){
  oledCtx.imageSmoothingEnabled=false;
  oledCtx.fillStyle='#000';oledCtx.fillRect(0,0,256,128);
  oledCtx.drawImage(oledBuf,0,0,128,64,0,0,256,128);
}

const wait=ms=>{const t=tok;return new Promise((r,j)=>setTimeout(()=>t===tok&&run?r():j(STOP),Math.max(ms,0)))};
const tick=()=>++ticks%300?0:new Promise(r=>setTimeout(r));
const ratio=()=>adc/B.adcMax;
function mqttLog(dir,topic,msg){
  const el=$('mqttlog');const d=document.createElement('div');
  const c=dir==='pub'?'var(--or)':dir==='sub'?'var(--bl)':'var(--mu)';
  d.innerHTML=`<b style="color:${c}">${dir.toUpperCase()}</b> <i>${topic}</i> → ${msg}`;
  el.appendChild(d);el.scrollTop=1e9;
  if(el.children.length>200)el.firstChild.remove();
  log(`[MQTT ${dir}] ${topic} = ${msg}`,'mqtt');
}
function reqLogAdd(m){const el=$('req-log');const d=document.createElement('div');d.textContent=m;el.appendChild(d);el.scrollTop=1e9;
  if(el.children.length>80)el.firstChild.remove();}

// ============ TRANSPILER ============
function transpile(src){
  let c=src
    .replace(/("(?:\\.|[^"\\])*")|('(?:\\.|[^'\\])*')|\/\*[\s\S]*?\*\/|\/\/.*$/gm,(m,dq,sq)=>dq||sq==="'"+m.slice(1,-1)+"'"||dq?dq:'');
  // preserve strings, strip comments. Single-char strings kept for later.
  c=src
    .replace(/\/\*[\s\S]*?\*\//g,'')
    .replace(/\/\/[^\n]*$/gm,'')
    .replace(/(["'])(?:\\.|(?!\1).)*\1/g, m=>'\x00S'+btoa(unescape(encodeURIComponent(m)))+'\x00');

  c=c.replace(/^\s*#include.*$/gm,'')
    .replace(/^\s*#define\s+(\w+)\s+(.+?)\s*$/gm,'let $1 = $2;')
    .replace(/^\s*#(?:if|ifdef|ifndef|endif|else|elif|pragma|undef|error|warning).*$/gm,'')
    .replace(/^\s*#\w+.*$/gm,'');

  // Remove C++ qualifiers
  c=c.replace(/\b(?:IRAM_ATTR|ICACHE_RAM_ATTR|PROGMEM|volatile|static|extern|inline|constexpr|register|const)\b\s*/g,'');

  // Strip new ClassName(...) → ClassName(...) for factory functions
  c=c.replace(/\bnew\s+([A-Z]\w*)\s*\(/g,'$1(');

  // Objects with constructor: ClassName var(args);
  c=c.replace(/\b([A-Z]\w+)\s+(\w+)\s*\(([^;()]*)\)\s*;/g,(m,cls,varName,args)=>{
    return `let ${varName} = ${cls}(${args});`;
  });
  // No-arg: ClassName var;
  c=c.replace(/\b([A-Z]\w+)\s+(\w+)\s*;/g,(m,cls,varName)=>{
    if(['HIGH','LOW','OUTPUT','INPUT','INPUT_PULLUP'].includes(cls))return m;
    return `let ${varName} = ${cls}();`;
  });

  // Function definitions
  const fns=[];
  const T='(?:unsigned\\s+)?(?:int|long|short|float|double|bool|boolean|byte|char|word|size_t|String|auto|void|uint\\d+_t|int\\d+_t)';
  c=c.replace(new RegExp('^[ \\t]*(?:void|'+T+')\\s+(\\w+)\\s*\\(([^)]*)\\)\\s*\\{','gm'),(m,n,a)=>{
    fns.push(n);
    const params=a.split(',').map(x=>x.trim()).filter(x=>x&&x!='void').map(x=>{
      const parts=x.split(/[\s*&]+/).filter(s=>s);
      const last=parts[parts.length-1];
      // strip array brackets
      return last.replace(/\[.*$/,'');
    });
    return `async function ${n}(${params.join(',')}){`;
  });

  // Type keywords at declaration
  c=c.replace(new RegExp('\\b'+T+'\\b(?:\\s*\\*)?\\s+(?=[A-Za-z_]\\w*\\s*[=;,\\[])','g'),'let ');

  // Arrays
  c=c.replace(/let (\w+)\s*\[[^\]]*\]\s*=\s*\{([^}]*)\}/g,'let $1 = [$2]');
  c=c.replace(/let (\w+)\s*\[\s*(\d+)\s*\]\s*;/g,'let $1 = new Array($2).fill(0);');
  c=c.replace(/let (\w+)\s*\[\s*\]\s*=\s*\{([^}]*)\}/g,'let $1 = [$2]');

  // Struct/enum/typedef stripped
  c=c.replace(/\b(?:struct|enum|class|typedef|namespace)\s+\w*\s*\{[\s\S]*?\}\s*;?/g,'')
    .replace(/\b(?:struct|enum|class|typedef|namespace|using)\b\s+/g,'');

  // Lambda []() {
  c=c.replace(/\[\s*\]\s*\(\s*([^)]*)\)\s*\{/g,(m,args)=>{
    const params=args.split(',').map(x=>x.trim()).filter(Boolean).map(x=>{
      const parts=x.split(/[\s*&]+/).filter(Boolean);return parts[parts.length-1];
    });
    return `async (${params.join(',')}) => {`;
  });

  // String helpers
  c=c.replace(/(\w+)\.c_str\(\)/g,'$1');
  c=c.replace(/(\w+)\.toInt\(\)/g,'parseInt($1)');
  c=c.replace(/(\w+)\.toFloat\(\)/g,'parseFloat($1)');
  c=c.replace(/(\w+)\.equals\(([^)]*)\)/g,'($1 === $2)');
  c=c.replace(/(\w+)\.equalsIgnoreCase\(([^)]*)\)/g,'($1.toLowerCase() === $2.toLowerCase())');
  c=c.replace(/(\w+)\.concat\(([^)]*)\)/g,'($1 + $2)');
  c=c.replace(/(\w+)\.length\(\)/g,'$1.length');
  c=c.replace(/(\w+)\.isEmpty\(\)/g,'($1.length === 0)');

  // sprintf(buf, ...) → buf = sprintf(...)
  c=c.replace(/\bsprintf\s*\(\s*(\w+)\s*,/g,'$1 = sprintf(');

  // Casts
  c=c.replace(/\((?:int|long|byte|uint\d+_t|int\d+_t)\)\s*/g,'~~');
  c=c.replace(/\((?:float|double)\)\s*/g,'');
  c=c.replace(/\(char\)\s*(\w+)/g,'String.fromCharCode($1)');
  c=c.replace(/\(String\)\s*/g,'String(');

  // Bit shift on sentinel for restore. Restore sentinel strings first.
  c=c.replace(/\x00S([A-Za-z0-9+/=]+)\x00/g,(m,b64)=>decodeURIComponent(escape(atob(b64))));

  // Single-char literals to double-quoted (for byte comparison)
  c=c.replace(/(?<![\w.])'(\\.|[^'\\])'/g,'"$1"');

  // Address-of: &var → var (leave && &&= untouched)
  c=c.replace(/(?<![&])&(?=[A-Za-z_])/g,'');

  // while with yield
  c=c.replace(/\bwhile\s*\(/g,'while(await tick(),');
  // for(;;) → while(true)
  c=c.replace(/\bfor\s*\(\s*;\s*;\s*\)/g,'while(true)');

  // await on async helpers
  const names=[...fns,'delay','delayMicroseconds','yield','WiFi.scanNetworks','vTaskDelay','client.loop'].map(s=>s.replace('.','\\.'));
  c=c.replace(new RegExp('(?<![\\w.])(?<!async function )(?<!await\\s)(?:'+names.join('|')+')\\s*\\(','g'),'await $&');

  return new AsyncFunction('env','with(env){'+c+'\nreturn{setup:typeof setup=="function"?setup:null,loop:typeof loop=="function"?loop:null}}');
}

// ============ ENV ============
function makeEnv(){
  const M={};Object.getOwnPropertyNames(Math).forEach(k=>{if(typeof Math[k]=='function')M[k]=Math[k]});
  M.isnan=v=>Number.isNaN(v); M.isinf=v=>!Number.isFinite(v);

  const flush=()=>{log(sb);sb=''};
  const fmt=(v,f)=>{
    if(typeof v=='number'){
      if(f===16)return v.toString(16).toUpperCase();
      if(f===10)return v.toString(10);
      if(f===2)return v.toString(2);
      if(f===8)return v.toString(8);
      if(f>1)return v.toString(f).toUpperCase();
      return Number.isInteger(v)?String(v):v.toFixed(f&&f<10?f:2);
    }
    return String(v);
  };
  const num=p=>typeof p=='number'?p:+p;
  const w=(p,v)=>{if(pm[p]===1){pv[p]=v?1:0;delete pw[p];upd(p)}};
  const pwmW=(p,d,max)=>{pw[p]=Math.max(0,Math.min(1,d/max));pv[p]=d>0?1:0;upd(p)};

  function DHT(pin,type){
    return {
      _pin:pin,_type:type,
      begin(){return true},
      readTemperature(){return dhtT},
      readHumidity(){return dhtH},
      computeHeatIndex(){return dhtT+1.5}
    };
  }
  function Servo(){
    return {
      _pin:null,
      attach(p){this._pin=p;pm[p]=1;upd(p)},
      detach(){},
      write(deg){servoAngle=Math.max(0,Math.min(180,deg));$('servo-arm').style.transform=`translate(-2px,-50%) rotate(${servoAngle-90}deg)`},
      writeMicroseconds(us){this.write((us-500)/2000*180)},
      read(){return servoAngle}
    };
  }
  function Adafruit_SSD1306(w,h,wire,reset){
    oledOn=true;$('oled-state').textContent='đã kết nối';
    let curX=0,curY=0,txtSize=1,txtColor='#fff';
    const setFill=c=>{oledBufCtx.fillStyle=c==='#fff'?'#fff':'#000'};
    return {
      begin(){return true},
      clearDisplay(){oledBufCtx.fillStyle='#000';oledBufCtx.fillRect(0,0,128,64)},
      display(){refreshOLED()},
      setTextSize(s){txtSize=s},
      setTextColor(c){txtColor=(c==='#fff'||c===1)?'#fff':'#000'},
      setCursor(x,y){curX=x;curY=y},
      print(...a){this._draw(String(a.join('')))},
      println(...a){this._draw(String(a.join('')))},
      printf(f,...a){
        const s=f.replace(/%(\d*\.?\d*)([dilufsxXc%])/g,(m,p,t)=>{
          if(t=='%')return'%';
          const v=a.shift();
          if(t=='x'||t=='X')return(+v).toString(16).toUpperCase();
          if(t=='f')return(+v).toFixed(p.includes('.')?+p.split('.')[1]:2);
          if(t=='c')return String.fromCharCode(v);
          return String(v);
        });
        this._draw(s);
      },
      _draw(s){oledBufCtx.fillStyle=txtColor;oledBufCtx.font=`${8*txtSize}px monospace`;oledBufCtx.textBaseline='top';oledBufCtx.fillText(s,curX,curY);curX+=s.length*6*txtSize},
      drawPixel(x,y,c){oledBufCtx.fillStyle=c==='#000'?'#000':'#fff';oledBufCtx.fillRect(x,y,1,1)},
      drawLine(x0,y0,x1,y1,c){oledBufCtx.strokeStyle=c==='#000'?'#000':'#fff';oledBufCtx.beginPath();oledBufCtx.moveTo(x0,y0);oledBufCtx.lineTo(x1,y1);oledBufCtx.stroke()},
      drawRect(x,y,w,h,c){oledBufCtx.strokeStyle=c==='#000'?'#000':'#fff';oledBufCtx.strokeRect(x+.5,y+.5,w-1,h-1)},
      fillRect(x,y,w,h,c){oledBufCtx.fillStyle=c==='#000'?'#000':'#fff';oledBufCtx.fillRect(x,y,w,h)},
      drawCircle(x,y,r,c){oledBufCtx.strokeStyle=c==='#000'?'#000':'#fff';oledBufCtx.beginPath();oledBufCtx.arc(x,y,r,0,7);oledBufCtx.stroke()},
      fillCircle(x,y,r,c){oledBufCtx.fillStyle=c==='#000'?'#000':'#fff';oledBufCtx.beginPath();oledBufCtx.arc(x,y,r,0,7);oledBufCtx.fill()},
      drawBitmap(){},
      width(){return 128},height(){return 64},
      setRotation(){},cp437(){},dim(){},invertDisplay(){},ssd1306_command(){},ssd1306_data(){}
    };
  }
  function PubSubClient(client){
    return {
      _subs:[],
      setServer(h,p){mqttServer=h+':'+p;mqttConnected=false;mqttLog('sys','server',h+':'+p)},
      setCallback(fn){this._cb=fn},
      connect(id){mqttClientId=id;mqttConnected=true;mqttLog('sys','connect',id);return true},
      connected(){return mqttConnected},
      disconnect(){mqttConnected=false},
      publish(t,msg){mqttLog('pub',t,String(msg))},
      subscribe(t){this._subs.push(t);mqttSubs.push({topic:t,client:this});mqttLog('sub',t,'subscribed');return true},
      unsubscribe(t){mqttSubs=mqttSubs.filter(s=>s.topic!==t);return true},
      loop(){},
      state(){return mqttConnected?0:-1}
    };
  }
  function HTTPClient(){
    return {
      _url:'',_code:0,
      begin(u){this._url=u},
      GET(){this._code=200;return 200},
      POST(d){this._code=200;return 200},
      PUT(){return 200},DELETE(){return 200},
      getString(){return '{"ok":true,"msg":"Hello from '+this._url+'","ts":'+Date.now()+'}'},
      getStream(){return ''},
      getSize(){return 40},
      addHeader(){},setTimeout(){},end(){},
      errorToString(c){return 'error '+c}
    };
  }
  function WebServer(port){
    const routes={};
    httpServerOn=true;
    return {
      on(path,handler){routes[path]=handler;httpHandlerMap[path]=handler},
      begin(){httpServerOn=true;log('WebServer: cổng '+port,'sys')},
      handleClient(){},
      send(code,type,body){
        const path=this._path||'/';reqLogAdd(`${path} → ${code} ${body}`);
      },
      _routes:routes,
      close(){httpServerOn=false}
    };
  }
  function Ticker(){
    return {
      attach(sec,fn){const id=setInterval(()=>{if(run)Promise.resolve().then(fn).catch(e=>log('Ticker: '+e.message,'err'))},sec*1000);timers.push(id);return id},
      attach_ms(ms,fn){const id=setInterval(()=>{if(run)Promise.resolve().then(fn).catch(e=>log('Ticker: '+e.message,'err'))},ms);timers.push(id);return id},
      once(sec,fn){setTimeout(()=>{if(run)Promise.resolve().then(fn).catch(e=>log('Ticker once: '+e.message,'err'))},sec*1000)},
      once_ms(ms,fn){setTimeout(()=>{if(run)Promise.resolve().then(fn).catch(e=>log('Ticker once: '+e.message,'err'))},ms)},
      detach(){}
    };
  }
  function Preferences(){
    const key='p_'+Math.random().toString(36).slice(2,8);
    return {
      begin(ns,ro){this._ns=ns;return true},
      end(){},
      putInt(k,v){prefsData[this._ns+':'+k]=v|0},
      getInt(k,d=0){return prefsData[this._ns+':'+k]??d},
      putFloat(k,v){prefsData[this._ns+':'+k]=+v},
      getFloat(k,d=0){return prefsData[this._ns+':'+k]??d},
      putBool(k,v){prefsData[this._ns+':'+k]=!!v},
      getBool(k,d=false){return prefsData[this._ns+':'+k]??d},
      putString(k,v){prefsData[this._ns+':'+k]=String(v)},
      getString(k,d=''){return prefsData[this._ns+':'+k]??d},
      putBytes(){},getBytes(){return 0},remove(k){delete prefsData[this._ns+':'+k]},clear(){},isKey(k){return this._ns+':'+k in prefsData}
    };
  }
  function StaticJsonDocument(){return JsonDoc()}
  function DynamicJsonDocument(){return JsonDoc()}
  function JsonDoc(){
    return {
      _d:{},
      get(k){return this._d[k]},
      set(k,v){this._d[k]=v},
      containsKey(k){return k in this._d}
    };
  }
  function deserializeJson(doc,str){try{doc._d=JSON.parse(str);return{}}catch(e){return{error:e}}}
  function serializeJson(doc){return JSON.stringify(doc._d)}

  const EEPROM={
    begin(n){return true},
    read(a){return EEPROMdata[a]||0},
    write(a,v){EEPROMdata[a]=v&0xff},
    update(a,v){EEPROMdata[a]=v&0xff},
    commit(){log('EEPROM: đã ghi','sys');return true},
    length(){return EEPROMdata.length}
  };
  const SPI={begin(){},end(),transfer(v){return 0},transfer16(v){return 0},setFrequency(){},setBitOrder(){},setDataMode(){}};
  const Wire={
    _a:0,
    begin(){},setClock(){},beginTransmission(a){this._a=a},
    endTransmission(){return[0x3C,0x27,0x76,0x68,0x3C].includes(this._a)?0:2},
    write(){return 1},requestFrom(){return 0},available(){return 0},read(){return 0},onReceive(){},onRequest(){}
  };
  const WiFi={
    mode(){},disconnect(){wifi={on:false,ip:'0.0.0.0'};ui()},
    begin:ssid=>{log('Đang kết nối '+ssid+'…','sys');const t=tok;setTimeout(()=>{if(t===tok){wifi={on:true,ip:'192.168.1.100'};ui();log('WiFi OK, IP '+wifi.ip,'sys')}},1500);return 3},
    scanNetworks:async()=>{await wait(900);return NETS.length},
    SSID:i=>NETS[i]?.[0]||'',RSSI:i=>NETS[i]?.[1]||0,channel:i=>NETS[i]?.[2]||0,encryptionType:()=>0,
    status:()=>wifi.on?3:6,localIP:()=>wifi.ip,macAddress:()=>'24:6F:28:AA:BB:CC',
    softAP:s=>{wifi={on:true,ip:'192.168.4.1'};ui();log('AP: '+s,'sys');return true},
    setHostname(){},hostname:()=>'esp',getMode:()=>1,setSleep(){},setAutoReconnect(){}
  };
  const ESP={
    getFreeHeap:()=>B.heap-Math.floor(Math.random()*2000),
    getChipId:()=>0x5CCF7F,getChipModel:()=>B.name,getCpuFreqMHz:()=>B.mhz,
    restart:()=>{log('Khởi động lại…','sys');setTimeout(runSketch,300);throw STOP},
    deepSleep:us=>{log('Deep sleep '+(us/1e6).toFixed(1)+'s','sys');throw STOP},
    getSketchSize:()=>32768,getFlashChipSize:()=>4*1024*1024,getSdkVersion:()=>'v5.x'
  };

  // Time
  const Time={
    configTime:(tz,dst,server)=>{ntpBase=Date.now()-(tz||0)*1000;return true},
    time:t=>{const s=Math.floor((Date.now()-(t?ntpBase-Date.now():0))/1000);return s},
    localtime:t=>{const d=new Date();return{tm_hour:d.getHours(),tm_min:d.getMinutes(),tm_sec:d.getSeconds(),tm_mday:d.getDate(),tm_mon:d.getMonth(),tm_year:d.getFullYear()-1900,tm_wday:d.getDay(),tm_yday:0,tm_isdst:0}},
    gmtime:t=>{const d=new Date();return{tm_hour:d.getUTCHours(),tm_min:d.getUTCMinutes(),tm_sec:d.getUTCSeconds(),tm_mday:d.getUTCDate(),tm_mon:d.getUTCMonth(),tm_year:d.getUTCFullYear()-1900,tm_wday:d.getUTCDay()}},
    getLocalTime:()=>true,
    millis:()=>Date.now()-t0
  };

  return{...M,...B.alias,HIGH:1,LOW:0,OUTPUT:1,INPUT:0,INPUT_PULLUP:2,RISING:1,FALLING:2,CHANGE:3,LED_BUILTIN:B.alias.LED_BUILTIN,
    HEX:16,DEC:10,BIN:2,OCT:8,
    WIFI_STA:1,WIFI_AP:2,WL_CONNECTED:3,WL_DISCONNECTED:6,WIFI_OFF:0,
    NULL:null,null:null,true:true,false:false,
    DHT11:11,DHT22:22,DHT21:21,
    SSD1306_SWITCHCAPVCC:2,SSD1306_WHITE:1,SSD1306_BLACK:0,WHITE:1,BLACK:0,
    A0:0,A1:1,A2:2,A3:3,A4:4,A5:5,
    portTICK_PERIOD_MS:1,TASK_DELAY_MS:1,
    tick,
    pinMode:(p,m)=>{pm[p]=m;if(m===2&&pv[p]===undefined)pv[p]=1;upd(p)},
    digitalWrite:w,digitalRead:p=>pv[p]??(pm[p]===2?1:0),
    analogWrite:(p,v)=>{if(toneOn&&p===toneFreq)return;pwmW(p,v,B.name==='ESP32'?255:1023)},
    analogRead:pin=>pin===0?ldr:Math.round(adc),
    touchRead:()=>touch?12+Math.floor(Math.random()*8):65+Math.floor(Math.random()*10),
    hallRead:()=>Math.floor(Math.random()*20)-10,
    temperatureRead:()=>40+Math.random()*3,
    pulseIn:(pin,state,timeout)=>{return Math.round(dist*58)},
    tone:(pin,freq,dur)=>{toneOn=true;toneFreq=pin;$('buzzer').classList.add('on');if(dur)setTimeout(()=>{toneOn=false;$('buzzer').classList.remove('on')},dur)},
    noTone:pin=>{toneOn=false;$('buzzer').classList.remove('on')},
    ledcSetup:(ch,f,b)=>{ledc[ch]={b,f}},
    ledcAttachPin:(p,ch)=>{(ledc[ch]=ledc[ch]||{b:8}).pin=p;pm[p]=1;upd(p)},
    ledcAttach:(p,f,b)=>{ledc[p]={pin:p,b,f};pm[p]=1;upd(p)},
    ledcWrite:(ch,d)=>{const l=ledc[ch]||{pin:ch,b:8};pwmW(l.pin??ch,d,2**l.b-1)},
    ledcWriteTone:(ch,f)=>{toneOn=true;$('buzzer').classList.add('on')},
    ledcDetachPin:()=>{},
    dacWrite:(p,v)=>pwmW(p,v,255),
    analogReadResolution:()=>{},analogWriteResolution:()=>{},analogSetAttenuation:()=>{},
    delay:ms=>wait(ms),delayMicroseconds:us=>wait(us/1000),yield:()=>wait(0),
    millis:()=>Date.now()-t0,micros:()=>(Date.now()-t0)*1000,
    random:(a,b)=>b===undefined?Math.floor(Math.random()*a):a+Math.floor(Math.random()*(b-a)),randomSeed:()=>{},
    map:(x,a,b,c,d)=>Math.trunc((x-a)*(d-c)/(b-a)+c),
    constrain:(x,a,b)=>Math.min(b,Math.max(a,x)),
    attachInterrupt:(p,fn,m)=>{irq[p]={fn,m};log('attachInterrupt GPIO'+p,'sys')},
    detachInterrupt:p=>{delete irq[p]},digitalPinToInterrupt:p=>p,
    micros_to_cm:us=>us*0.034/2,

    Serial:makeSerial(),
    Serial1:makeSerial('Serial1'),
    Serial2:makeSerial('Serial2'),

    DHT,Servo,Adafruit_SSD1306,PubSubClient,HTTPClient,WebServer,Ticker,Preferences,
    StaticJsonDocument,DynamicJsonDocument,deserializeJson,serializeJson,
    EEPROM,SPI,Wire,WiFi,ESP,WiFiClient:()=>({}),WiFiServer:()=>({begin(){},available:()=>false}),WiFiUDP:()=>({begin(){},parsePacket:()=>0}),
    time:Time.time,localtime:Time.localtime,gmtime:Time.gmtime,configTime:Time.configTime,getLocalTime:Time.getLocalTime,

    String:v=>v===undefined?'':String(v),
    sprintf:(f,...a)=>f.replace(/%(\d*\.?\d*)([dilufsxXc%])/g,(m,p,t)=>{
      if(t=='%')return'%';const v=a.shift();
      if(t=='x'||t=='X')return(+v).toString(16).toUpperCase();
      if(t=='f')return(+v).toFixed(p.includes('.')?+p.split('.')[1]:6);
      if(t=='c')return String.fromCharCode(v);
      if(t=='s')return String(v);
      return String(v);
    }),

    xTaskCreate:(fn,name,stack,param,prio,handle)=>{tasks.push({fn,name});Promise.resolve().then(()=>fn(param))},
    xTaskCreatePinnedToCore:(fn,name,stack,param,prio,handle,core)=>{tasks.push({fn,name,core});Promise.resolve().then(()=>fn(param))},
    vTaskDelay:ms=>wait(ms),
    vTaskDelete:()=>{},
    xTaskGetCurrentTaskHandle:()=>({}),
    vTaskGetRunTimeStats:()=>'',
    xSemaphoreCreateMutex:()=>({}),xSemaphoreTake:()=>true,xSemaphoreGive:()=>true,
    TaskHandle_t:null,
    NULL:null,INPUT_PULLDOWN:3,
    _brokerPublish:(topic,msg)=>{brokerBroker.push({topic,msg,ts:Date.now()});mqttLog('pub',topic,msg)}
  };
}

function makeSerial(name){
  let sb='';
  const flush=()=>{log(sb);sb=''};
  const fmt=(v,f)=>{
    if(typeof v=='number'){
      if(f===16)return v.toString(16).toUpperCase();
      if(f===10)return v.toString(10);
      if(f===2)return v.toString(2);
      if(f===8)return v.toString(8);
      if(f>1)return v.toString(f).toUpperCase();
      return Number.isInteger(v)?String(v):v.toFixed(f&&f<10?f:2);
    }
    return String(v);
  };
  const tag=name?`[${name}] `:'';
  return{
    begin:b=>log(tag+'Serial @ '+b+' baud','sys'),
    end:()=>{},
    print:(v,f)=>{sb+=fmt(v,f)},
    println:(v='',f)=>{sb+=fmt(v,f);sb=tag+sb;flush()},
    printf:(f,...a)=>{sb+=f.replace(/%(\d*\.?\d*)([dilufsxXc%])/g,(m,p,t)=>{
      if(t=='%')return'%';const v=a.shift();
      if(t=='x'||t=='X')return(+v).toString(16).toUpperCase();
      if(t=='f')return(+v).toFixed(p.includes('.')?+p.split('.')[1]:6);
      if(t=='c')return String.fromCharCode(v);
      return String(v);
    });if(sb.endsWith('\n')){sb=sb.slice(0,-1);sb=tag+sb;flush()}},
    available:()=>rx.length,
    read:()=>rx.length?rx.shift().charCodeAt(0):-1,
    readString:()=>{const s=rx.join('').trim();rx=[];return s},
    flush:()=>{},setTimeout:()=>{},write:()=>{}
  };
}

// ============ UI ============
function resetState(){pv={};pm={};pw={};irq={};ledc={};rx=[];sb='';wifi={on:false,ip:'0.0.0.0'};touch=false;t0=Date.now();
  timers.forEach(id=>clearInterval(id));timers=[];tasks=[];mqttSubs=[];mqttConnected=false;httpHandlerMap={};brokerBroker=[];
  servoAngle=0;$('servo-arm').style.transform='translate(-2px,-50%) rotate(-90deg)';
  toneOn=false;$('buzzer').classList.remove('on');oledOn=false;$('oled-state').textContent='chưa dùng';
  oledBufCtx.fillStyle='#000';oledBufCtx.fillRect(0,0,128,64);refreshOLED();
  B.pins.forEach(upd);ui()}
async function runSketch(){
  tok++;const my=tok;run=false;await new Promise(r=>setTimeout(r,20));resetState();run=true;setState();
  let api;try{api=await transpile($('src').value)(makeEnv())}catch(e){log('Lỗi biên dịch: '+e.message,'err');run=false;setState();return}
  log('Biên dịch OK → '+B.name,'sys');
  try{if(api.setup)await api.setup();while(run&&my===tok){if(api.loop)await api.loop();await wait(0)}}
  catch(e){if(e!==STOP)log('Lỗi runtime: '+e.message,'err')}
  if(my===tok){run=false;setState()}
}
function stop(){tok++;run=false;setState();log('Đã dừng','sys');
  timers.forEach(id=>clearInterval(id));timers=[];mqttConnected=false}
function setState(){$('state').textContent=run?'● Đang chạy':'● Dừng';$('state').style.color=run?'var(--ac)':'var(--mu)'}
function pinLabel(p){const a=Object.entries(B.alias).find(([k,v])=>v===p&&/^D\d$/.test(k));return a?a[0]:''}
function buildPins(){
  $('pins').innerHTML=B.pins.map(p=>`<div class="pin" id="p${p}" onclick="toggle(${p})"><small>GPIO${p}${pinLabel(p)?' · '+pinLabel(p):''}</small><b>0</b><small>IN</small></div>`).join('');
  const L=B.name=='ESP32'?[2,4,5]:[2,4,16];$('leds').innerHTML=L.map(p=>`<div class="led"><i id="l${p}"></i>GPIO${p}</div>`).join('');
}
function upd(p){
  const e=$('p'+p);if(!e)return;const v=pv[p]??(pm[p]===2?1:0);
  e.className='pin'+(pw[p]!==undefined?' pw':v?' hi':'');e.style.setProperty('--d',((pw[p]||0)*100)+'%');
  e.children[1].textContent=v;e.children[2].textContent=pw[p]!==undefined?'PWM':pm[p]===1?'OUT':pm[p]===2?'IN↑':'IN';
  const l=$('l'+p);if(l){const b=pw[p]!==undefined?pw[p]:v;l.style.background=b?'#35e0a1':'#2a3550';l.style.opacity=b?.25+.75*b:1;l.style.boxShadow=b?'0 0 '+14*b+'px #35e0a1':'none'}
}
function toggle(p){
  if(pm[p]===1)return;const old=pv[p]??(pm[p]===2?1:0),nv=old?0:1;pv[p]=nv;upd(p);const i=irq[p];
  if(i&&(i.m==3||(i.m==2&&old&&!nv)||(i.m==1&&!old&&nv)))Promise.resolve().then(()=>i.fn()).catch(e=>log('ISR: '+e.message,'err'));
}
function ui(){$('c-wifi').textContent=wifi.on?'ON':'OFF';$('c-ip').textContent=wifi.ip}
function setBoard(k){
  if(B)save('esp_src_'+B.name,$('src').value);
  tok++;run=false;B=BOARDS[k];save('esp_board',k);$('board').value=k;buildPins();resetState();setState();
  $('adc').max=B.adcMax;adc=Math.round(B.adcMax/2);$('adc').value=adc;
  $('ldr').max=B.adcMax;$('ldr').value=ldr=Math.round(B.adcMax/2);
  $('c-cpu').textContent=B.mhz+' MHz';
  $('tch').style.display=k=='esp32'?'':'none';$('src').value=load('esp_src_'+B.name)||EX.blink;gutter();
  $('wl').innerHTML=NETS.map(n=>`<div onclick="WIFIC('${n[0]}')"><span>📶 ${n[0]}</span><span style="color:var(--mu)">${n[1]} dBm · ch ${n[2]}</span></div>`).join('');
}
window.WIFIC=s=>{wifi={on:true,ip:'192.168.1.100'};ui();log('Kết nối thủ công: '+s,'sys')};
function gutter(){const n=$('src').value.split('\n').length;$('gut').textContent=Array.from({length:n},(_,i)=>i+1).join('\n')}

// ============ EVENTS ============
$('src').addEventListener('input',()=>{gutter();save('esp_src_'+B.name,$('src').value)});
$('src').addEventListener('scroll',()=>{$('gut').scrollTop=$('src').scrollTop});
$('src').addEventListener('keydown',e=>{
  if(e.key=='Tab'){e.preventDefault();const t=e.target,s=t.selectionStart;t.setRangeText('  ',s,t.selectionEnd,'end');t.dispatchEvent(new Event('input'))}
  if(e.key=='Enter'&&(e.ctrlKey||e.metaKey)){e.preventDefault();runSketch()}});
$('run').onclick=runSketch;$('stop').onclick=stop;$('board').onchange=e=>setBoard(e.target.value);
$('ex').onchange=e=>{$('src').value=EX[e.target.value];gutter();save('esp_src_'+B.name,$('src').value)};
$('adc').oninput=e=>{adc=+e.target.value};
$('ldr').oninput=e=>{ldr=+e.target.value;$('ldr-val').textContent=ldr};
$('dht-t').oninput=e=>{dhtT=+e.target.value;$('dht-t-val').textContent=dhtT.toFixed(1)+' °C'};
$('dht-h').oninput=e=>{dhtH=+e.target.value;$('dht-h-val').textContent=dhtH+' %'};
$('dist').oninput=e=>{dist=+e.target.value;$('dist-val').textContent=dist+' cm'};
$('rnd').onclick=()=>{adc=Math.floor(Math.random()*(B.adcMax+1));$('adc').value=adc};
$('tch').onpointerdown=()=>{touch=true};$('tch').onpointerup=$('tch').onpointerleave=()=>{touch=false};
const sendRx=()=>{const v=$('rx').value;if(!v)return;rx.push(...(v+'\n'));log('> '+v,'sys');$('rx').value=''};
$('send').onclick=sendRx;$('rx').onkeydown=e=>{if(e.key=='Enter')sendRx()};

// MQTT broker → dispatch to sketch subscribers
$('mqtt-pub').onclick=()=>{
  const t=$('mqtt-topic').value,v=$('mqtt-msg').value;
  mqttLog('pub',t,v);
  mqttSubs.filter(s=>s.topic===t).forEach(s=>{
    const cb=s.client._cb;
    if(cb){
      const payload=new TextEncoder().encode(v);
      Promise.resolve().then(()=>cb(t,Array.from(payload),payload.length)).catch(e=>log('MQTT cb: '+e.message,'err'));
    }
  });
};

// Web request simulator
$('req-get').onclick=()=>{
  const path=$('req-path').value;
  const fn=httpHandlerMap[path];
  if(!fn){reqLogAdd(`GET ${path} → 404 Not Found`);return}
  // stub "server" for send()
  const fakeServer={_path:path,send:(code,type,body)=>{reqLogAdd(`GET ${path} → ${code} ${body}`)}};
  Promise.resolve().then(()=>fn.call(fakeServer)).catch(e=>{reqLogAdd(`GET ${path} → 500 ${e.message}`)});
};

setInterval(()=>{
  hist.push(adc);hist.shift();const c=$('cv'),x=c.getContext('2d'),w=c.width,h=c.height;
  x.clearRect(0,0,w,h);x.strokeStyle='#35e0a1';x.lineWidth=2;x.beginPath();
  hist.forEach((v,i)=>{const px=i/99*w,py=h-4-(v/B.adcMax)*(h-8);i?x.lineTo(px,py):x.moveTo(px,py)});x.stroke();
  $('adcv').textContent=Math.round(adc)+' / '+B.adcMax;
  const s=Math.floor((Date.now()-t0)/1000);$('c-up').textContent=run?s+'s':'0s';
  $('c-heap').textContent=Math.round((B.heap-(run?3000+Math.random()*1500:0))/1024)+' KB';
  $('c-free').textContent=Math.round((B.heap-Math.floor(Math.random()*2000))/1024)+' KB';
},200);

initOLED();
setBoard(load('esp_board')||'esp8266');
log('Sẵn sàng. Chọn board, chọn ví dụ rồi bấm Chạy (Ctrl+Enter).','sys');
</script>
</body></html>
