<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="vi"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>ESP Emulator Pro — ESP8266 &amp; ESP32</title>
<style>
:root{--bg:#0b0f1a;--p:#121a2b;--p2:#182238;--bd:#26344f;--tx:#e6edf7;--mu:#8a99b5;--ac:#35e0a1;--er:#ff5d6c;--bl:#4da3ff;--yl:#ffcb47}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--tx);font:14px/1.5 system-ui,'Segoe UI',sans-serif;min-height:100vh}
header{display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;padding:12px 20px;background:var(--p);border-bottom:1px solid var(--bd);position:sticky;top:0;z-index:5}
h1{font-size:18px}h1 b{color:var(--ac)}
.chips{display:flex;gap:8px;flex-wrap:wrap}
.chip{background:var(--p2);border:1px solid var(--bd);border-radius:99px;padding:2px 12px;font-size:12px;color:var(--mu)}.chip b{color:var(--ac)}
.chip.on{border-color:var(--ac)}.chip.warn b{color:var(--er)}
main{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,1fr);gap:16px;padding:16px 20px;max-width:1600px;margin:auto}
@media(max-width:960px){main{grid-template-columns:1fr}}
.card{background:var(--p);border:1px solid var(--bd);border-radius:12px;padding:14px;margin-bottom:16px}
.card h3{font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--mu);margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap}
.bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:10px;align-items:center}
button,select,input[type=text],input[type=number]{font:inherit;color:var(--tx);background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:7px 12px}
button{cursor:pointer;transition:.15s}button:hover{border-color:var(--ac)}
button.run{background:var(--ac);color:#04251a;border-color:var(--ac);font-weight:700}
button.stop{background:var(--er);border-color:var(--er);color:#fff;font-weight:700}
button.ghost{background:transparent}
button:disabled{opacity:.4;cursor:not-allowed}
.ed{display:flex;border:1px solid var(--bd);border-radius:8px;background:#080c15;height:440px;overflow:hidden}
.ed pre,.ed textarea{font:13px/1.55 ui-monospace,Consolas,monospace;padding:10px 8px;border:0;white-space:pre;tab-size:2}
.ed pre{color:#4a5a78;text-align:right;user-select:none;background:#0a101c;overflow:hidden;min-width:42px}
.ed textarea{flex:1;background:transparent;color:#bdf5de;resize:none;outline:none;overflow:auto;border-radius:0}
.tabs{display:flex;gap:4px;margin-bottom:8px;border-bottom:1px solid var(--bd);overflow-x:auto}
.tabs button{background:transparent;border:0;border-bottom:2px solid transparent;border-radius:0;padding:6px 12px;color:var(--mu);white-space:nowrap}
.tabs button.on{color:var(--ac);border-bottom-color:var(--ac)}
#ser{height:240px;overflow:auto;background:#080c15;border:1px solid var(--bd);border-radius:8px;padding:8px 10px;font:13px/1.5 ui-monospace,Consolas,monospace;margin-bottom:8px}
#ser div{white-space:pre-wrap;color:#bdf5de}#ser .sys{color:var(--mu)}#ser .err{color:var(--er)}#ser .tx{color:var(--bl)}
.plotwrap{height:240px;background:#080c15;border:1px solid var(--bd);border-radius:8px;padding:8px;display:none}
.plotwrap.on{display:block}
canvas{width:100%;height:100%;display:block}
.row{display:flex;gap:8px}.row input{flex:1}
.pins{display:grid;grid-template-columns:repeat(auto-fill,minmax(70px,1fr));gap:8px;max-height:320px;overflow:auto}
.pin{background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:6px 4px;text-align:center;cursor:pointer;user-select:none;transition:.15s;position:relative;overflow:hidden}
.pin:hover{border-color:var(--ac)}.pin small{display:block;color:var(--mu);font-size:10px;position:relative;z-index:1}
.pin b{font-size:17px;position:relative;z-index:1}.pin.hi{background:var(--ac);color:#04251a;border-color:var(--ac)}.pin.hi small{color:#06402c}
.pin.pw::before{content:'';position:absolute;inset:0;background:linear-gradient(0deg,var(--ac) var(--d,0%),transparent var(--d,0%));opacity:.55}
.leds{display:flex;gap:22px;justify-content:center;margin-top:14px;flex-wrap:wrap}
.led{text-align:center;font-size:11px;color:var(--mu)}.led i{display:block;width:22px;height:22px;border-radius:50%;background:#2a3550;margin:0 auto 4px;transition:.1s}
input[type=range]{width:100%;margin:6px 0;accent-color:var(--ac)}
.wifi div{display:flex;justify-content:space-between;padding:6px 8px;border-bottom:1px solid var(--bd);cursor:pointer}.wifi div:hover{background:var(--p2)}
.comp{border:1px solid var(--bd);border-radius:8px;padding:10px;background:#080c15;margin-bottom:8px}
.comp .lbl{font-size:11px;color:var(--mu);margin-bottom:6px;letter-spacing:.05em;text-transform:uppercase}
.lcd{font:13px/1.4 ui-monospace,Consolas,monospace;background:#1a2a1a;color:#a9e8a0;border:2px solid #2a4a2a;border-radius:4px;padding:6px 8px;letter-spacing:1px;white-space:pre;overflow:hidden}
.oledwrap{background:#000;border:1px solid #333;border-radius:4px;padding:4px;display:flex;justify-content:center}
.oledwrap canvas{background:#000;border-radius:2px;width:128px;height:64px}
.servo{text-align:center}
.servo svg{width:100px;height:100px}
.neopix{display:flex;gap:3px;justify-content:center;flex-wrap:wrap;padding:6px 0}
.neopix i{width:14px;height:14px;border-radius:50%;background:#111;display:inline-block;transition:.15s}
.dht{display:grid;grid-template-columns:1fr 1fr;gap:8px;text-align:center;padding:6px 0}
.dht b{font-size:22px;color:var(--ac);display:block}.dht span{font-size:11px;color:var(--mu)}
.dist{text-align:center;padding:6px 0}.dist b{font-size:22px;color:var(--bl)}
.buzz{width:100%;height:8px;background:var(--p2);border-radius:4px;overflow:hidden;margin-top:6px}
.buzz i{display:block;height:100%;width:0;background:var(--yl);transition:.1s}
.fs{font:12px/1.5 ui-monospace,Consolas,monospace;color:var(--mu);max-height:180px;overflow:auto}
.fs div{padding:3px 0;border-bottom:1px dashed var(--bd);cursor:pointer;display:flex;justify-content:space-between;gap:8px}
.fs div:hover{color:var(--tx)}
.fs b{color:var(--ac)}
.mqtt{font:12px ui-monospace,monospace;max-height:200px;overflow:auto}
.mqtt div{padding:3px 0;border-bottom:1px solid var(--bd);display:flex;gap:6px}
.mqtt .t{color:var(--bl);min-width:120px}.mqtt .p{color:var(--ac);word-break:break-all}
.badge{display:inline-block;padding:1px 6px;border-radius:6px;background:var(--p2);font-size:10px;color:var(--mu);margin-left:4px}
.tabpane{display:none}.tabpane.on{display:block}
.kv{display:flex;justify-content:space-between;padding:3px 0;font-size:12px;border-bottom:1px dashed var(--bd);gap:8px}
.kv b{color:var(--ac);text-align:right}
.speed{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--mu)}
.slot{min-width:100px}
.hint{color:var(--mu);font-size:12px}
</style></head>
<body>
<header>
  <h1>⚡ ESP<b>Emulator Pro</b></h1>
  <div class="bar" style="margin:0">
    <select id="board"><option value="esp8266">ESP8266</option><option value="esp32">ESP32</option></select>
    <select id="ex" title="Ví dụ mẫu"></select>
  </div>
  <div class="chips">
    <span class="chip">CPU <b id="c-cpu"></b></span>
    <span class="chip" id="wchip">WiFi <b id="c-wifi">OFF</b></span>
    <span class="chip">IP <b id="c-ip">0.0.0.0</b></span>
    <span class="chip">Heap <b id="c-heap"></b></span>
    <span class="chip">Uptime <b id="c-up">0s</b></span>
    <span class="chip">Loops <b id="c-loop">0</b></span>
  </div>
</header>
<main>
<section>
  <div class="card">
    <h3>Sketch <span id="state">● Dừng</span></h3>
    <div class="bar">
      <button class="run" id="run">▶ Chạy (Ctrl+Enter)</button>
      <button class="stop" id="stop">■ Dừng</button>
      <button id="pause" class="ghost">⏸ Tạm dừng</button>
      <div class="speed">Tốc độ <input type="range" id="speed" min="0.1" max="5" step="0.1" value="1" style="width:80px"><span id="speedv">1.0x</span></div>
    </div>
    <div class="bar">
      <select class="slot" id="slots" title="Khe lưu"></select>
      <button id="saveSlot">💾 Lưu</button>
      <button id="loadSlot">📂 Mở</button>
      <button id="exportBtn">⬇ Xuất</button>
      <button id="importBtn">⬆ Nhập</button>
      <input type="file" id="importFile" accept=".txt,.ino,.cpp" hidden>
    </div>
    <div class="ed"><pre id="gut">1</pre><textarea id="src" spellcheck="false"></textarea></div>
  </div>
  <div class="card">
    <h3>Serial <span id="serStat" class="badge">0 dòng</span>
      <button onclick="clearSer()" style="padding:2px 10px">Xoá</button>
    </h3>
    <div class="tabs"><button class="on" data-pane="mono">Monitor</button><button data-pane="plot">Plotter</button></div>
    <div id="ser"></div>
    <div class="plotwrap"><canvas id="plot" width="600" height="240"></canvas></div>
    <div class="row"><input type="text" id="rx" placeholder="Gửi dữ liệu tới Serial rồi Enter…"><button id="send">Gửi</button></div>
  </div>
</section>
<section>
  <div class="card"><h3>Components <span class="badge" id="compCount">0</span></h3><div id="comps"><div class="hint">Chạy sketch có dùng Servo / LCD / OLED / NeoPixel / DHT / NewPing / tone() để thấy mô phỏng.</div></div></div>
  <div class="card"><h3>GPIO <span class="badge">Bấm để đảo mức INPUT</span></h3><div class="pins" id="pins"></div><div class="leds" id="leds"></div></div>
  <div class="card">
    <h3>ADC / Touch <span class="badge" id="adcv"></span></h3>
    <canvas id="cv" width="400" height="80"></canvas>
    <input type="range" id="adc">
    <div class="bar"><button id="rnd">🎲 Ngẫu nhiên</button><button id="tch">👆 Giữ Touch</button></div>
  </div>
  <div class="card">
    <h3>Tabs</h3>
    <div class="tabs">
      <button class="on" data-rpane="wifi">📶 WiFi</button>
      <button data-rpane="mqtt">📨 MQTT</button>
      <button data-rpane="http">🌐 HTTP</button>
      <button data-rpane="fs">📁 FS</button>
      <button data-rpane="eeprom">💾 NVM</button>
      <button data-rpane="info">ℹ Info</button>
    </div>
    <div class="tabpane on" id="rp-wifi"><div class="wifi" id="wl"></div></div>
    <div class="tabpane" id="rp-mqtt"><div class="mqtt" id="mqttLog"><div class="hint">MQTT broker mô phỏng. client.publish() sẽ hiện ở đây; có thể publish vào từ bảng này.</div></div></div>
    <div class="tabpane" id="rp-http"><div class="fs" id="httpLog"><div class="hint">Log HTTPClient & WebServer.</div></div></div>
    <div class="tabpane" id="rp-fs"><div class="fs" id="fsList"><div class="hint">Chưa có file.</div></div></div>
    <div class="tabpane" id="rp-eeprom"><div class="fs" id="nvmList"><div class="hint">Chưa ghi EEPROM / Preferences.</div></div></div>
    <div class="tabpane" id="rp-info"><div id="info"></div></div>
  </div>
</section>
</main>
<script>
/* ================= BOARD ================= */
const BOARDS={
esp8266:{name:'ESP8266',mhz:160,heap:81920,flash:4194304,adcMax:1023,pwmMax:1023,
 pins:[0,1,2,3,4,5,12,13,14,15,16],adcPins:[17],
 alias:{D0:16,D1:5,D2:4,D3:0,D4:2,D5:14,D6:12,D7:13,D8:15,A0:17,SDA:4,SCL:5,LED_BUILTIN:2,SS:15,MOSI:13,MISO:12,SCK:14}},
esp32:{name:'ESP32',mhz:240,heap:327680,flash:4194304,adcMax:4095,pwmMax:255,
 pins:[0,2,4,5,12,13,14,15,16,17,18,19,21,22,23,25,26,27,32,33,34,35,36,39],adcPins:[32,33,34,35,36,39],
 alias:{LED_BUILTIN:2,SDA:21,SCL:22,A0:36,A3:39,A4:32,A5:33,A6:34,A7:35,T0:4,T1:0,T2:2,T3:15,T4:13,T5:12,T6:14,T7:27,DAC1:25,DAC2:26,SS:5,MOSI:23,MISO:19,SCK:18,RX2:16,TX2:17}}};
const NETS=[['ELECTRONICSTREE',-45,6],['Viettel 5G',-58,1],['FPT Telecom',-55,1],['iPhone 15',-48,6],['Free WiFi',-72,3],['TP-Link_A1B2',-63,11]];
const I2C_DEV={0x3C:'SSD1306 OLED',0x27:'LCD I2C',0x3F:'LCD I2C alt',0x68:'DS1307 RTC',0x76:'BME280',0x48:'ADS1115'};

/* ================= EXAMPLES ================= */
const EX={
blink:{n:'💡 Blink',c:`void setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  digitalWrite(LED_BUILTIN, HIGH);\n  Serial.println("LED ON");\n  delay(1000);\n  digitalWrite(LED_BUILTIN, LOW);\n  Serial.println("LED OFF");\n  delay(1000);\n}`},
fade:{n:'🎚️ PWM Fade',c:`int brightness = 0;\nint amount = 5;\n\nvoid setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  analogWrite(LED_BUILTIN, brightness);\n  brightness += amount;\n  if (brightness <= 0 || brightness >= 255) amount = -amount;\n  Serial.println(brightness);\n  delay(30);\n}`},
button:{n:'🔘 Nút nhấn',c:`#define BTN 0\n\nvoid setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n  pinMode(BTN, INPUT_PULLUP);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  if (digitalRead(BTN) == LOW) {\n    digitalWrite(LED_BUILTIN, HIGH);\n    Serial.println("Nhấn!");\n  } else {\n    digitalWrite(LED_BUILTIN, LOW);\n  }\n  delay(100);\n}`},
irq:{n:'⚡ Interrupt',c:`volatile int count = 0;\n\nvoid IRAM_ATTR onPress() {\n  count++;\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(0, INPUT_PULLUP);\n  attachInterrupt(digitalPinToInterrupt(0), onPress, FALLING);\n}\n\nvoid loop() {\n  if (count > 0) {\n    Serial.print("So lan ngat: ");\n    Serial.println(count);\n    count = 0;\n  }\n  delay(50);\n}`},
wifi:{n:'📶 WiFi Scan',c:`void setup() {\n  Serial.begin(115200);\n  WiFi.mode(WIFI_STA);\n}\n\nvoid loop() {\n  int n = WiFi.scanNetworks();\n  Serial.printf("Tim thay %d mang\\n", n);\n  for (int i = 0; i < n; i++) {\n    Serial.print(WiFi.SSID(i));\n    Serial.print("  ");\n    Serial.print(WiFi.RSSI(i));\n    Serial.println(" dBm");\n  }\n  delay(5000);\n}`},
i2c:{n:'🔌 I2C Scan',c:`void setup() {\n  Wire.begin();\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  int found = 0;\n  for (int addr = 1; addr < 127; addr++) {\n    Wire.beginTransmission(addr);\n    if (Wire.endTransmission() == 0) {\n      Serial.print("Thiet bi tai 0x");\n      Serial.println(addr, HEX);\n      found++;\n    }\n  }\n  Serial.printf("Tong: %d\\n", found);\n  delay(5000);\n}`},
touch:{n:'👆 Touch (ESP32)',c:`// Chỉ ESP32 — giữ nút "Giữ Touch" ở panel ADC\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(LED_BUILTIN, OUTPUT);\n}\n\nvoid loop() {\n  int v = touchRead(T0);\n  Serial.print("Touch: ");\n  Serial.println(v);\n  digitalWrite(LED_BUILTIN, v < 40);\n  delay(300);\n}`},
dht:{n:'🌡️ DHT22',c:`#include <DHT.h>\n#define DHTPIN 4\n#define DHTTYPE DHT22\n\nDHT dht(DHTPIN, DHTTYPE);\n\nvoid setup() {\n  Serial.begin(115200);\n  dht.begin();\n}\n\nvoid loop() {\n  float t = dht.readTemperature();\n  float h = dht.readHumidity();\n  Serial.printf("Nhiet do: %.1f C | Do am: %.1f %%\\n", t, h);\n  delay(2000);\n}`},
lcd:{n:'📺 LCD I2C 16x2',c:`#include <LiquidCrystal_I2C.h>\nLiquidCrystal_I2C lcd(0x27, 16, 2);\n\nvoid setup() {\n  lcd.init();\n  lcd.backlight();\n  lcd.print("Hello ESP!");\n  Serial.begin(115200);\n}\n\nint t = 0;\nvoid loop() {\n  lcd.setCursor(0, 1);\n  lcd.print("Uptime: ");\n  lcd.print(t);\n  lcd.print("s   ");\n  t++;\n  delay(1000);\n}`},
oled:{n:'🖥️ OLED SSD1306',c:`#include <Wire.h>\n#include <Adafruit_GFX.h>\n#include <Adafruit_SSD1306.h>\n\nAdafruit_SSD1306 display(128, 64, &Wire, -1);\n\nvoid setup() {\n  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);\n  display.clearDisplay();\n  display.setTextSize(1);\n  display.setTextColor(SSD1306_WHITE);\n}\n\nint c = 0;\nvoid loop() {\n  display.clearDisplay();\n  display.setCursor(0, 0);\n  display.println("ESP Emulator Pro");\n  display.print("Counter: ");\n  display.println(c);\n  display.display();\n  c++;\n  delay(500);\n}`},
neopix:{n:'🌈 NeoPixel 8 LED',c:`#include <Adafruit_NeoPixel.h>\n#define PIN 5\n#define N 8\n\nAdafruit_NeoPixel strip(N, PIN, NEO_GRB + NEO_KHZ800);\n\nvoid setup() {\n  strip.begin();\n  strip.setBrightness(80);\n  strip.show();\n}\n\nint hue = 0;\nvoid loop() {\n  for (int i = 0; i < N; i++) {\n    int h = (hue + i * 30) % 360;\n    strip.setPixelColor(i, strip.ColorHSV(h * 182, 255, 255));\n  }\n  strip.show();\n  hue += 10;\n  delay(80);\n}`},
servo:{n:'🔄 Servo Sweep',c:`#include <Servo.h>\nServo myservo;\n\nvoid setup() {\n  myservo.attach(5);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  for (int a = 0; a <= 180; a += 10) {\n    myservo.write(a);\n    Serial.print("Goc: ");\n    Serial.println(a);\n    delay(100);\n  }\n  for (int a = 180; a >= 0; a -= 10) {\n    myservo.write(a);\n    delay(100);\n  }\n}`},
sonar:{n:'📏 HC-SR04',c:`#define TRIG 5\n#define ECHO 18\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(TRIG, OUTPUT);\n  pinMode(ECHO, INPUT);\n}\n\nvoid loop() {\n  digitalWrite(TRIG, LOW);\n  delayMicroseconds(2);\n  digitalWrite(TRIG, HIGH);\n  delayMicroseconds(10);\n  digitalWrite(TRIG, LOW);\n  long d = pulseIn(ECHO, HIGH);\n  float cm = d * 0.034 / 2;\n  Serial.printf("Khoang cach: %.2f cm\\n", cm);\n  delay(500);\n}`},
buzzer:{n:'🎵 Buzzer Melody',c:`int melody[] = {262, 294, 330, 349, 392, 440, 494, 523};\nint N = 8;\n\nvoid setup() {\n  pinMode(5, OUTPUT);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  for (int i = 0; i < N; i++) {\n    tone(5, melody[i], 200);\n    Serial.print("Note: ");\n    Serial.println(melody[i]);\n    delay(300);\n  }\n  noTone(5);\n  delay(1000);\n}`},
eeprom:{n:'💾 EEPROM Counter',c:`#include <EEPROM.h>\n\nint addr = 0;\n\nvoid setup() {\n  Serial.begin(115200);\n  EEPROM.begin(16);\n  int count = EEPROM.read(addr);\n  Serial.print("Gia tri cu: ");\n  Serial.println(count);\n  count++;\n  EEPROM.write(addr, count);\n  EEPROM.commit();\n}\n\nvoid loop() {\n  delay(1000);\n}`},
spiffs:{n:'📁 SPIFFS',c:`#include <SPIFFS.h>\n\nvoid setup() {\n  Serial.begin(115200);\n  if (!SPIFFS.begin(true)) {\n    Serial.println("SPIFFS loi!");\n    return;\n  }\n  File f = SPIFFS.open("/data.txt", FILE_WRITE);\n  if (f) {\n    f.println("Hello ESP32");\n    f.close();\n  }\n  f = SPIFFS.open("/data.txt", FILE_READ);\n  while (f.available()) {\n    Serial.write(f.read());\n  }\n  f.close();\n}\n\nvoid loop() { delay(1000); }`},
http:{n:'🌐 HTTP GET',c:`#include <WiFi.h>\n#include <HTTPClient.h>\n\nconst char* ssid = "ELECTRONICSTREE";\nconst char* pass = "";\n\nvoid setup() {\n  Serial.begin(115200);\n  WiFi.begin(ssid, pass);\n  while (WiFi.status() != WL_CONNECTED) delay(500);\n  Serial.println("WiFi OK");\n}\n\nvoid loop() {\n  HTTPClient http;\n  http.begin("http://api.thingspeak.com/update?field1=42");\n  int code = http.GET();\n  Serial.printf("HTTP %d\\n", code);\n  http.end();\n  delay(5000);\n}`},
mqtt:{n:'📨 MQTT Pub/Sub',c:`#include <WiFi.h>\n#include <PubSubClient.h>\n\nconst char* ssid = "ELECTRONICSTREE";\nWiFiClient wc;\nPubSubClient client(wc);\n\nvoid callback(char* topic, byte* payload, unsigned int len) {\n  Serial.print("Nhan: ");\n  Serial.println(topic);\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  WiFi.begin(ssid, "");\n  while (WiFi.status() != WL_CONNECTED) delay(500);\n  client.setServer("broker.hivemq.com", 1883);\n  client.setCallback(callback);\n  client.connect("ESP32Client");\n  client.subscribe("home/led");\n}\n\nint n = 0;\nvoid loop() {\n  client.loop();\n  char buf[16];\n  sprintf(buf, "count-%d", n++);\n  client.publish("home/status", buf);\n  delay(2000);\n}`},
webserver:{n:'🕸️ Web Server LED',c:`#include <WiFi.h>\n#include <WebServer.h>\n\nconst char* ssid = "ELECTRONICSTREE";\nWebServer server(80);\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(LED_BUILTIN, OUTPUT);\n  WiFi.begin(ssid, "");\n  while (WiFi.status() != WL_CONNECTED) delay(500);\n  Serial.print("IP: ");\n  Serial.println(WiFi.localIP());\n  server.on("/", []() {\n    server.send(200, "text/html", "<h1>ESP32 LED</h1><a href=/on>BAT</a> <a href=/off>TAT</a>");\n  });\n  server.on("/on", []() { digitalWrite(LED_BUILTIN, HIGH); server.send(200, "text/plain", "ON"); });\n  server.on("/off", []() { digitalWrite(LED_BUILTIN, LOW); server.send(200, "text/plain", "OFF"); });\n  server.begin();\n}\n\nvoid loop() {\n  server.handleClient();\n}`},
json:{n:'📦 ArduinoJson',c:`#include <ArduinoJson.h>\n\nvoid setup() {\n  Serial.begin(115200);\n  StaticJsonDocument<200> doc;\n  doc["device"] = "esp32";\n  doc["temp"] = 25.4;\n  doc["hum"] = 60;\n  serializeJsonPretty(doc, Serial);\n  Serial.println();\n}\n\nvoid loop() { delay(3000); }`},
deep:{n:'😴 Deep Sleep',c:`#define uS_TO_S_FACTOR 1000000ULL\n#define TIME_TO_SLEEP 5\n\nvoid setup() {\n  Serial.begin(115200);\n  Serial.println("Thuc day!");\n  esp_sleep_enable_timer_wakeup(TIME_TO_SLEEP * uS_TO_S_FACTOR);\n  Serial.println("Di ngu...");\n  delay(200);\n  esp_deep_sleep_start();\n}\n\nvoid loop() {}`},
task:{n:'🧵 FreeRTOS Task',c:`void TaskBlink(void *pv) {\n  pinMode(2, OUTPUT);\n  while (1) {\n    digitalWrite(2, !digitalRead(2));\n    delay(500);\n  }\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  xTaskCreatePinnedToCore(TaskBlink, "blink", 2048, NULL, 1, NULL, 1);\n}\n\nvoid loop() {\n  Serial.println("Main loop");\n  delay(2000);\n}`}
};

/* ================= HELPERS ================= */
const $=id=>document.getElementById(id),STOP={};
const AsyncFunction=Object.getPrototypeOf(async function(){}).constructor;
const save=(k,v)=>{try{localStorage.setItem(k,v)}catch(e){}},load=k=>{try{return localStorage.getItem(k)}catch(e){return null}};
const sleep=ms=>new Promise(r=>setTimeout(r,ms));

/* ================= STATE ================= */
let B,pv,pm,pw,run=false,paused=false,tok=0,adc=0,wifi,irq,rx,sb,t0,ticks=0,touch=false,ledc,loops=0;
let speed=1,stepOnce=false,plotMode=false,plotData=[];
let mqttLog=[],httpLog=[],fsFiles={},nvmData={};
let comps={}; // component state, keyed by id

/* ================= SERIAL ================= */
const serEl=()=>$('ser');
const log=(m,c='')=>{const d=document.createElement('div');d.className=c;d.textContent=m;serEl().appendChild(d);
 while(serEl().children.length>400)serEl().firstChild.remove();serEl().scrollTop=1e9;updSerStat()};
const updSerStat=()=>{$('serStat').textContent=serEl().children.length+' dòng'};
const clearSer=()=>{serEl().innerHTML='';updSerStat()};
const wait=ms=>{const t=tok;const s=speed;return new Promise((r,j)=>setTimeout(()=>t===tok&&run?r():j(STOP),Math.max(ms/s,0)))};
const tick=async()=>{if(!run)throw STOP;if(paused&&!stepOnce)await new Promise(r=>{const c=setInterval(()=>{if(!paused||!run){clearInterval(c);r()}},40)});if(stepOnce)stepOnce=false;return 0};

/* ================= LIB LAYER ================= */
function makeEnv(){
 const M={};Object.getOwnPropertyNames(Math).forEach(k=>{if(typeof Math[k]=='function')M[k]=Math[k]});
 const flush=()=>{if(sb){log(sb);if(plotMode)plotData.push(...parseNums(sb));sb=''}};
 const fmt=(v,f)=>typeof v=='number'?(f>1&&f!=10?v.toString(f).toUpperCase():(Number.isInteger(v)?String(v):v.toFixed(f&&f<10?f:2))):String(v);
 const num=p=>typeof p==='number'?p:+p;
 const w=(p,v)=>{if(pm[p]===1){pv[p]=v?1:0;delete pw[p];upd(p)}};
 const pwmW=(p,d,max)=>{pw[p]=Math.min(1,Math.max(0,d/max));pv[p]=d>0?1:0;upd(p)};
 const regComp=(k,v)=>{comps[k]=v;renderComps()};

 // ---- Serial wrapper ----
 const mkSerial=()=>({
  begin:b=>log('Serial @ '+b+' baud','sys'),
  print:(v,f)=>{sb+=fmt(v,f)},
  println:(v='',f)=>{sb+=fmt(v,f);flush()},
  printf:(f,...a)=>{sb+=String(f).replace(/%(\d*\.?\d*)([dilufsxXc%])/g,(m,p,t)=>{
   if(t=='%')return'%';const v=a.shift();
   if(t=='x'||t=='X')return(+v).toString(16);
   if(t=='f')return(+v).toFixed(p&&p.includes('.')?+p.split('.')[1]:6);
   if(t=='c')return String.fromCharCode(v);
   if(t=='s')return String(v);
   return String(v)});if(sb.endsWith('\n')){sb=sb.slice(0,-1);flush()}},
  available:()=>rx.length,read:()=>rx.length?rx.shift().charCodeAt(0):-1,
  readStringUntil:(c)=>{let s='';while(rx.length){const ch=rx.shift();if(ch===c)break;s+=ch}return s},
  readString:()=>{const s=rx.join('').trim();rx=[];return s},
  flush:()=>{},
  write:(...a)=>{if(typeof a[0]==='number'){sb+=String.fromCharCode(a[0]);flush()}else{sb+=a[0];if(sb.includes('\n'))flush()}}
 });

 // ---- NTP / time ----
 let ntpOk=false;
 const timeLib={
  configTime:(tz,dst,srv)=>{ntpOk=true;log('NTP: '+srv,'sys')},
  getLocalTime:(tm)=>{const d=new Date();if(tm){tm.tm_year=d.getFullYear()-1900;tm.tm_mon=d.getMonth();tm.tm_mday=d.getDate();tm.tm_hour=d.getHours();tm.tm_min=d.getMinutes();tm.tm_sec=d.getSeconds()}return true},
  time:()=>Math.floor(Date.now()/1000),
  now:()=>Math.floor(Date.now()/1000)
 };

 // ---- EEPROM ----
 let eeprom=new Uint8Array(512);
 const EEPROM={
  begin:s=>{const old=eeprom.slice();eeprom=new Uint8Array(s);eeprom.set(old.subarray(0,Math.min(old.length,s)));log('EEPROM begin('+s+')','sys')},
  read:a=>eeprom[a]||0,
  write:(a,v)=>{eeprom[a]=v&0xff;nvmData['EEPROM['+a+']']=v&0xff;renderNVM()},
  update:(a,v)=>{if(eeprom[a]!==(v&0xff))EEPROM.write(a,v)},
  commit:()=>true,end:()=>{}
 };

 // ---- Preferences ----
 const prefsStore={};
 const Preferences=function(space='nvs'){this.space=space;};
 Preferences.prototype.begin=(ns,ro)=>{this.ns=ns||'nvs';return true};
 const put=(t,k,v)=>{prefsStore[this.space+'/'+(this.ns||'nvs')+'/'+k]=v;nvmData['NVS:'+(this.ns||'nvs')+'/'+k]=v;renderNVM();return true};
 const gett=(k,d)=>{const v=prefsStore[this.space+'/'+(this.ns||'nvs')+'/'+k];return v===undefined?d:v};
 Object.assign(Preferences.prototype,{
  putInt:put,putUInt:put,putLong:put,putFloat:put,putBool:put,putString:put,putBytes:put,
  getInt:gett,getUInt:gett,getLong:gett,getFloat:gett,getBool:gett,getString:gett,
  isKey:(k)=>k in prefsStore,remove:(k)=>{delete prefsStore[this.space+'/'+(this.ns||'nvs')+'/'+k];delete nvmData['NVS:'+(this.ns||'nvs')+'/'+k];renderNVM()},
  clear:()=>{Object.keys(prefsStore).forEach(k=>{if(k.startsWith(this.space+'/'))delete prefsStore[k]})},end:()=>{}
 });

 // ---- SPIFFS / FS ----
 const mkFile=(path,content,mode)=> {
   const isWrite=mode.includes('w')||mode.includes('a');
   if(isWrite){fsFiles[path]=content!==undefined?String(content):(fsFiles[path]||'')}
   let pos=isWrite?fsFiles[path].length:0;
   const buf=isWrite?fsFiles[path]:(fsFiles[path]||'');
   const f={
    _path:path,_buf:buf,_mode:mode,_pos:pos,
    print:(s)=>{f._buf+=String(s);f._pos=f._buf.length;fsFiles[path]=f._buf;renderFS()},
    println:(s)=>{f._buf+=String(s)+'\n';f._pos=f._buf.length;fsFiles[path]=f._buf;renderFS()},
    write:(...a)=>{if(typeof a[0]==='number')f._buf+=String.fromCharCode(a[0]);else f._buf+=a[0];f._pos=f._buf.length;fsFiles[path]=f._buf;renderFS()},
    read:()=>f._pos<f._buf.length?f._buf.charCodeAt(f._pos++):-1,
    readString:()=>{const s=f._buf.slice(f._pos);f._pos=f._buf.length;return s},
    readStringUntil:(c)=>{let s='';while(f._pos<f._buf.length){const ch=f._buf[f._pos++];if(ch===c)break;s+=ch}return s},
    available:()=>f._buf.length-f._pos,size:()=>f._buf.length,
    name:()=>path,seek:p=>f._pos=p,position:()=>f._pos,
    close:()=>{},flush:()=>{}
   };
   return f;
 };
 const mkFS=(name)=>({
  begin:(fmt)=>{log(name+'.begin'+(fmt?'(format)':''),'sys');return true},
  open:(path,mode='r')=>mkFile(path,'',mode),
  exists:p=>p in fsFiles,
  remove:p=>{delete fsFiles[p];renderFS();return true},
  rename:(a,b)=>{fsFiles[b]=fsFiles[a];delete fsFiles[a];renderFS();return true},
  mkdir:()=>true,rmdir:()=>true,
  listDir:(p='/',cb)=>{Object.keys(fsFiles).forEach(f=>cb&&cb(p,f,fsFiles[f].length))},
  format:()=>{fsFiles={};renderFS();return true},
  totalBytes:()=>1048576,usedBytes:()=>Object.values(fsFiles).reduce((a,s)=>a+s.length,0)
 });

 // ---- Wire / SPI ----
 const Wire={_a:0,begin:()=>{},setClock:()=>{},
  beginTransmission(a){this._a=a},
  endTransmission(){return I2C_DEV[this._a]?0:2},
  write:()=>1,requestFrom:(a,n)=>{return I2C_DEV[a]?n:0},available:()=>0,read:()=>0,onReceive:()=>{},onRequest:()=>{}
 };
 const SPI={begin:()=>{},setFrequency:()=>{},transfer:(v)=>v,end:()=>{}};

 // ---- WiFi ----
 const wifiStates={connected:false,ip:'0.0.0.0',mode:1,ap:null};
 const WiFi={
  mode:m=>{wifiStates.mode=m},
  begin:async(ssid,pass)=>{log('Đang kết nối WiFi "'+ssid+'"…','sys');const t=tok;await sleep(1500);if(t===tok){wifiStates.connected=true;wifiStates.ip='192.168.1.'+(100+Math.floor(Math.random()*100));ui();log('WiFi connected, IP '+wifiStates.ip,'sys')}return 3},
  disconnect:()=>{wifiStates.connected=false;wifiStates.ip='0.0.0.0';ui()},
  scanNetworks:async()=>{await sleep(1200);return NETS.length},
  SSID:i=>NETS[i]?.[0]||'',RSSI:i=>NETS[i]?.[1]||0,channel:i=>NETS[i]?.[2]||0,
  encryptionType:i=>NETS[i]?.[2]===6?2:4,
  status:()=>wifiStates.connected?3:6,
  localIP:()=>wifiStates.ip,
  gatewayIP:()=>'192.168.1.1',
  subnetMask:()=>'255.255.255.0',
  macAddress:()=>'24:6F:28:AA:BB:CC',
  hostname:()=>'esp-emu',
  softAP:(s,p)=>{wifiStates.ap=s;wifiStates.connected=true;wifiStates.ip='192.168.4.1';ui();log('AP: '+s,'sys');return true},
  softAPIP:()=>'192.168.4.1',
  RSSI:()=>-45-Math.floor(Math.random()*20),
  setHostname:()=>true,setAutoReconnect:()=>{},
  getMode:()=>wifiStates.mode
 };
 const _wifiState=wifiStates;

 // ---- Web Server ----
 const mkWebServer=(port)=>({
  _routes:{},
  on:(path,fn)=>{mkWebServer._._routes[path]=fn;httpLog.push({t:'ROUTE',p:path});renderHTTP();},
  begin:()=>{log('WebServer chạy tại http://'+wifiStates.ip+':'+port,'sys');httpLog.push({t:'START',p:'http://'+wifiStates.ip+':'+port});renderHTTP()},
  handleClient:()=>{},stop:()=>{},
  send:(code,ctype,body)=>{httpLog.push({t:'RESP',p:code+' '+body.slice(0,60)});renderHTTP()},
  send_P:(code,ctype,body)=>mkWebServer._.send(code,ctype,body),
  arg:(n)=>'',hasArg:()=>false,
  uri:()=>'/'
 });
 // attach a shared routes store
 const WebServer=function(p){const s=mkWebServer(p);WebServer._=s;return s;};

 // ---- HTTP Client ----
 const HTTPClient=function(){this._url='';};
 HTTPClient.prototype.begin=(url)=>{this._url=url;httpLog.push({t:'GET',p:url});renderHTTP();return true};
 HTTPClient.prototype.addHeader=()=>{};
 HTTPClient.prototype.GET=()=>{const c=200;httpLog.push({t:'200',p:this._url});renderHTTP();return c};
 HTTPClient.prototype.POST=(b)=>{httpLog.push({t:'POST',p:this._url+' body='+(b||'').slice(0,40)});renderHTTP();return 200};
 HTTPClient.prototype.getString=()=>'{"status":"ok","value":'+Math.floor(Math.random()*100)+'}';
 HTTPClient.prototype.getSize=()=>32;
 HTTPClient.prototype.end=()=>{};

 // ---- MQTT ----
 const PubSubClient=function(c){this._cb=null;};
 PubSubClient.prototype.setServer=(h,p)=>{this._h=h;this._p=p};
 PubSubClient.prototype.setCallback=fn=>fn;
 PubSubClient.prototype.connect=async(cid)=>{await sleep(300);mqttLog.push({t:'CONNECT',p:cid});renderMQTT();return true};
 PubSubClient.prototype.connected=()=>true;
 PubSubClient.prototype.subscribe=t=>{mqttLog.push({t:'SUB',p:t});renderMQTT();return true};
 PubSubClient.prototype.publish=(t,p)=>{mqttLog.push({t:'PUB '+t,p:String(p)});renderMQTT();return true};
 PubSubClient.prototype.loop=()=>{};
 PubSubClient.prototype.disconnect=()=>{};

 // ---- DHT ----
 const dhtState={t:25.4,h:60.2};
 const DHT=function(p,t){this.pin=p;this.type=t;};
 DHT.prototype.begin=()=>{regComp('dht',{pin:DHT._pin||4});return true};
 DHT.prototype.readTemperature=()=>{const v=dhtState.t+(Math.random()-0.5)*0.4;regComp('dhtv',{t:v.toFixed(1),h:dhtState.h.toFixed(1)});return v};
 DHT.prototype.readHumidity=()=>{const v=dhtState.h+(Math.random()-0.5)*0.8;regComp('dhtv',{t:dhtState.t.toFixed(1),h:v.toFixed(1)});return v};
 DHT.prototype.computeHeatIndex=(t,h)=>t+0.5;

 // ---- Servo ----
 const Servo=function(){this.pin=null;this.angle=90;};
 Servo.prototype.attach=(p)=>{(Servo._inst=this).pin=p;this.angle=90;regComp('servo',{pin:p,angle:90})};
 Servo.prototype.detach=()=>{delete comps.servo;renderComps()};
 Servo.prototype.write=a=>{this.angle=a;regComp('servo',{pin:this.pin,angle:a})};
 Servo.prototype.writeMicroseconds=us=>{this.write(Math.round((us-500)/2000*180))};
 Servo.prototype.read=()=>this.angle;

 // ---- LiquidCrystal_I2C ----
 const LiquidCrystal_I2C=function(addr,cols,rows){this.addr=addr;this.cols=cols||16;this.rows=rows||2;
   this.buf=Array.from({length:this.rows},()=>' '.repeat(this.cols));
   this.cx=0;this.cy=0;this.bl=true;regComp('lcd',this.dump())};
 LiquidCrystal_I2C.prototype.init=function(){regComp('lcd',this.dump());};
 LiquidCrystal_I2C.prototype.begin=function(){this.init()};
 LiquidCrystal_I2C.prototype.backlight=function(v){this.bl=v!==false;regComp('lcd',this.dump())};
 LiquidCrystal_I2C.prototype.noBacklight=function(){this.backlight(false)};
 LiquidCrystal_I2C.prototype.clear=function(){this.buf=this.buf.map(()=>' '.repeat(this.cols));this.cx=0;this.cy=0;regComp('lcd',this.dump())};
 LiquidCrystal_I2C.prototype.home=function(){this.cx=0;this.cy=0};
 LiquidCrystal_I2C.prototype.setCursor=function(c,r){this.cx=c;this.cy=r||0};
 LiquidCrystal_I2C.prototype.print=function(s){s=String(s);const row=this.buf[this.cy]||'';let out=row.substring(0,this.cx)+s+row.substring(this.cx+s.length);this.buf[this.cy]=out.substring(0,this.cols);this.cx+=s.length;if(this.cx>this.cols)this.cx=this.cols;regComp('lcd',this.dump())};
 LiquidCrystal_I2C.prototype.write=function(b){if(typeof b==='number')this.print(String.fromCharCode(b));else this.print(b)};
 LiquidCrystal_I2C.prototype.dump=function(){return{cols:this.cols,rows:this.rows,text:this.buf.join('\n'),bl:this.bl}};
 const LiquidCrystal=LiquidCrystal_I2C;

 // ---- OLED SSD1306 (text-only sim) ----
 const SSD1306_SWITCHCAPVCC=2,SSD1306_WHITE=1,SSD1306_BLACK=0;
 const Adafruit_SSD1306=function(w,h,wire,reset){this.w=w;this.h=h;this.cur=[];this.cx=0;this.cy=0;};
 Adafruit_SSD1306.prototype.begin=function(vcc,addr){regComp('oled',{w:this.w,h:this.h,lines:[]});return true};
 Adafruit_SSD1306.prototype.clearDisplay=function(){this.cur=[];this.cx=0;this.cy=0;regComp('oled',{w:this.w,h:this.h,lines:this.cur})};
 Adafruit_SSD1306.prototype.setTextSize=function(s){this.ts=s||1};
 Adafruit_SSD1306.prototype.setTextColor=function(c){this.tc=c};
 Adafruit_SSD1306.prototype.setCursor=function(x,y){this.cx=x;this.cy=y};
 Adafruit_SSD1306.prototype.print=function(s){s=String(s);if(!this.cur[this.cy])this.cur[this.cy]='';this.cur[this.cy]+=s;regComp('oled',{w:this.w,h:this.h,lines:this.cur})};
 Adafruit_SSD1306.prototype.println=function(s){this.print(s===undefined?'':s);this.cy++;this.cx=0};
 Adafruit_SSD1306.prototype.display=function(){regComp('oled',{w:this.w,h:this.h,lines:this.cur})};
 Adafruit_SSD1306.prototype.drawPixel=function(){};
 Adafruit_SSD1306.prototype.drawLine=function(){};
 Adafruit_SSD1306.prototype.fillRect=function(){};
 Adafruit_SSD1306.prototype.drawRect=function(){};

 // ---- NeoPixel ----
 const NEO_GRB=1,NEO_KHZ800=1;
 const Adafruit_NeoPixel=function(n,p,t){this.n=n;this.pin=p;this.px=new Array(n).fill(0);this.bright=255;};
 Adafruit_NeoPixel.prototype.begin=function(){regComp('neo',{n:this.n,px:this.px.slice(),bright:this.bright});return true};
 Adafruit_NeoPixel.prototype.setBrightness=function(b){this.bright=b};
 Adafruit_NeoPixel.prototype.setPixelColor=function(i,c){(this.px[i]=c)};
 Adafruit_NeoPixel.prototype.setPixelColorRGB=function(i,r,g,b){this.px[i]=(r<<16)|(g<<8)|b};
 Adafruit_NeoPixel.prototype.Color=(r,g,b)=>((r&255)<<16)|((g&255)<<8)|(b&255);
 Adafruit_NeoPixel.prototype.ColorHSV=(h,s,v)=>{const c=Adafruit_NeoPixel.prototype.Color;return c((h>>0)&255,(h>>8)&255,v&255)};
 Adafruit_NeoPixel.prototype.show=function(){const b=this.bright/255;const px=this.px.map(v=>{const r=(v>>16)&255,g=(v>>8)&255,bl=v&255;return(((r*b)|0)<<16)|(((g*b)|0)<<8)|((bl*b)|0)});regComp('neo',{n:this.n,px,bright:this.bright})};
 Adafruit_NeoPixel.prototype.clear=function(){this.px.fill(0)};
 Adafruit_NeoPixel.prototype.numPixels=function(){return this.n};

 // ---- NewPing / Ultrasonic ----
 const NewPing=function(trig,echo,max){this.trig=trig;this.echo=echo;this.max=max||200;};
 NewPing.prototype.ping=function(){const v=(adc/B.adcMax)*this.max*0.95+5;return Math.round(v*58)}; // us
 NewPing.prototype.ping_cm=function(){const cm=(adc/B.adcMax)*this.max*0.95+5;regComp('dist',{cm});return Math.round(cm)};
 NewPing.prototype.ping_in=function(){return Math.round(this.ping_cm()/2.54)};
 const Ultrasonic=NewPing;

 // ---- Ticker / Timer ----
 const Ticker=function(){this._cbs=[];this._t=null;};
 Ticker.prototype.attach=(sec,fn)=>{const t=this;t._cbs.push(fn);clearInterval(t._t);t._t=setInterval(()=>{if(!run){clearInterval(t._t);return}try{fn()}catch(e){}},sec*1000/speed)};
 Ticker.prototype.attach_ms=(ms,fn)=>{const t=this;t._cbs.push(fn);clearInterval(t._t);t._t=setInterval(()=>{if(!run){clearInterval(t._t);return}try{fn()}catch(e){}},ms/speed)};
 Ticker.prototype.detach=function(){clearInterval(this._t);this._cbs=[]};
 Ticker.prototype.once=(sec,fn)=>setTimeout(fn,sec*1000);
 Ticker.prototype.once_ms=(ms,fn)=>setTimeout(fn,ms);
 const Timer=Ticker;
 // free-function timers
 const _timers=[];
 const esp_timer_create=()=>{};
 const esp_timer_start_periodic=()=>{};
 const esp_timer_stop=()=>{};

 // ---- tone / noTone (WebAudio) ----
 let ac=null,curOsc=null;
 const tone=(pin,freq,dur)=>{try{ac=ac||new (window.AudioContext||window.webkitAudioContext)();
   if(curOsc)try{curOsc.stop()}catch(e){}
   const o=ac.createOscillator(),g=ac.createGain();
   o.frequency.value=freq;g.gain.value=0.06;o.connect(g);g.connect(ac.destination);o.start();
   curOsc=o;if(dur)setTimeout(()=>{try{o.stop()}catch(e){}},dur);
   regComp('buzz',{freq,on:true});setTimeout(()=>regComp('buzz',{freq:0,on:false}),dur||200);
 }catch(e){}};
 const noTone=()=>{if(curOsc)try{curOsc.stop()}catch(e){}curOsc=null;regComp('buzz',{freq:0,on:false})};

 // ---- ArduinoJson (basic) ----
 const JsonDocument=function(cap){this._o={};};
 JsonDocument.prototype.to=function(){};
 const _jsonProxy=()=>({_o:{},
  operator:undefined,
  set:function(k,v){this._o[k]=v},
  get:function(k){return this._o[k]},
  toJson:function(){return JSON.stringify(this._o)}
 });
 const serializeJson=(doc,out)=>{const j=typeof doc==='object'&&doc._o?JSON.stringify(doc._o):JSON.stringify(doc||{});if(out&&out.print)out.print(j);else sb+=j};
 const serializeJsonPretty=(doc,out)=>{const j=typeof doc==='object'&&doc._o?JSON.stringify(doc._o,null,2):JSON.stringify(doc||{},null,2);if(out&&out.print)out.print(j);else log(j,'sys')};
 const deserializeJson=(doc,src)=>{try{doc._o=JSON.parse(src)}catch(e){}return {code:0}};
 const DynamicJsonDocument=JsonDocument,StaticJsonDocument=JsonDocument;

 // ---- ArduinoOTA / WiFiManager ----
 const ArduinoOTA={setHostname:()=>{},setPassword:()=>{},onStart:()=>{},onEnd:()=>{},onProgress:()=>{},onError:()=>{},begin:()=>log('OTA ready','sys'),handle:()=>{},setPort:()=>{}};
 const WiFiManager=function(){};
 WiFiManager.prototype.autoConnect=async (ap,pass)=>{log('WiFiManager: AP "'+ap+'" chờ cấu hình…','sys');const t=tok;await sleep(1200);if(t===tok){wifiStates.connected=true;wifiStates.ip='192.168.1.100';ui()}return true};
 WiFiManager.prototype.setConfigPortalTimeout=()=>{};WiFiManager.prototype.resetSettings=()=>{};

 // ---- Deep sleep ----
 const ESP={
  getFreeHeap:()=>B.heap-Math.floor(Math.random()*3000),
  getChipId:()=>0x5CCF7F,getChipModel:()=>B.name,getCpuFreqMHz:()=>B.mhz,
  getSketchSize:()=>327680,getFreeSketchSpace:()=>1048576,
  restart:()=>{log('Đang khởi động lại…','sys');setTimeout(()=>{if(run)runSketch()},400);throw STOP},
  deepSleep:us=>{log('Deep sleep '+(us/1e6).toFixed(1)+'s…','sys');setTimeout(()=>{if(run)runSketch()},Math.min(us/1e4/speed,3000));throw STOP}
 };
 const esp_sleep_enable_timer_wakeup=()=>{};
 const esp_sleep_enable_ext0_wakeup=()=>{};

 // ---- misc functions ----
 const pulseIn=(pin,state,timeout)=>{// trả về thời gian ước lượng từ adc
   const base=(adc/B.adcMax)*2000+200;return Math.round(base)};
 const pulseInLong=pulseIn;
 const shiftOut=()=>{},shiftIn=()=>0;
 const attachInterrupt=(p,fn,m)=>{irq[p]={fn,m};log('attachInterrupt GPIO'+p,'sys')};
 const detachInterrupt=p=>{delete irq[p]};
 const digitalPinToInterrupt=p=>p;
 const ledcSetup=(c,f,b)=>{ledc[c]={b}};
 const ledcAttachPin=(p,c)=>{(ledc[c]=ledc[c]||{b:8}).pin=p;pm[p]=1};
 const ledcAttach=(p,f,b)=>{ledc[p]={pin:p,b};pm[p]=1};
 const ledcWrite=(c,d)=>{const l=ledc[c]||{pin:c,b:8};pwmW(l.pin??c,d,2**l.b-1)};
 const ledcDetach=()=>{};
 const dacWrite=(p,v)=>pwmW(p,v,255);
 const touchRead=()=>touch?12+Math.floor(Math.random()*8):65+Math.floor(Math.random()*10);
 const hallRead=()=>Math.floor(Math.random()*20)-10;
 const temperatureRead=()=>40+Math.random()*3;
 const analogReadResolution=()=>{},analogWriteResolution=()=>{};
 const analogSetAttenuation=()=>{},analogSetPinAttenuation=()=>{};
 const ADC_11db=3,ADC_0db=0,ADC_2_5db=1,ADC_6db=2;
 const setCpuFrequencyMhz=()=>{},getCpuFrequencyMhz=()=>B.mhz;
 const xTaskCreatePinnedToCore=(fn)=>{/* đơn giản: bỏ qua */};
 const xTaskCreate=xTaskCreatePinnedToCore;
 const vTaskDelay=(ms)=>wait(ms);

 // ---- String helpers (C++ String methods) ----
 class Str extends String{constructor(s){super(s);}
  toInt(){return parseInt(this)}
  toFloat(){return parseFloat(this)}
  c_str(){return String(this)}
  substring(a,b){return String(this).substring(a,b)}
  indexOf(s){return String(this).indexOf(s)}
  lastIndexOf(s){return String(this).lastIndexOf(s)}
  charAt(i){return String(this).charAt(i)}
  equals(s){return String(this)===s}
  equalsIgnoreCase(s){return String(this).toLowerCase()===String(s).toLowerCase()}
  startsWith(s){return String(this).startsWith(s)}
  endsWith(s){return String(this).endsWith(s)}
  trim(){return String(this).trim()}
  toUpperCase(){return String(this).toUpperCase()}
  toLowerCase(){return String(this).toLowerCase()}
  replace(a,b){return String(this).split(a).join(b)}
  concat(s){return String(this)+s}
  length(){return String(this).length}
 }

 const env={...M,...B.alias,
  HIGH:1,LOW:0,OUTPUT:1,INPUT:0,INPUT_PULLUP:2,INPUT_PULLDOWN:3,
  RISING:1,FALLING:2,CHANGE:3,ONLOW:4,ONHIGH:5,
  HEX:16,DEC:10,BIN:2,OCT:8,PI:Math.PI,HALF_PI:Math.PI/2,TWO_PI:Math.PI*2,
  DEG_TO_RAD:Math.PI/180,RAD_TO_DEG:180/Math.PI,
  WIFI_STA:1,WIFI_AP:2,WIFI_AP_STA:3,WIFI_OFF:0,
  WL_CONNECTED:3,WL_DISCONNECTED:6,WL_IDLE_STATUS:0,WL_NO_SSID_AVAIL:1,WL_CONNECT_FAILED:4,
  A0:36,A1:37,A2:38,A3:39,A4:32,A5:33,A6:34,A7:35,
  DAC1:25,DAC2:26,T0:4,T1:0,T2:2,T3:15,T4:13,T5:12,T6:14,T7:27,
  NEO_GRB,NEO_KHZ800,SSD1306_SWITCHCAPVCC,SSD1306_WHITE,SSD1306_BLACK,
  ADC_11db,ADC_0db,ADC_2_5db,ADC_6db,
  FILE_READ:'r',FILE_WRITE:'w',FILE_APPEND:'a',
  String:Str,
  // Core
  pinMode:(p,m)=>{pm[p]=m;if(m===2&&pv[p]===undefined)pv[p]=1;upd(p)},
  digitalWrite:w,digitalRead:p=>pv[p]??(pm[p]===2?1:0),
  analogWrite:(p,v)=>pwmW(p,v,B.pwmMax),
  analogRead:()=>Math.round(adc),
  ledcSetup,ledcAttachPin,ledcWrite,ledcAttach,ledcDetach,dacWrite,touchRead,
  analogReadResolution,analogWriteResolution,analogSetAttenuation,analogSetPinAttenuation,
  hallRead,temperatureRead,setCpuFrequencyMhz,getCpuFrequencyMhz,
  delay:ms=>wait(ms),delayMicroseconds:us=>wait(us/1000),yield:()=>wait(0),
  millis:()=>Date.now()-t0,micros:()=>(Date.now()-t0)*1000,
  random:(a,b)=>b===undefined?Math.floor(Math.random()*a):a+Math.floor(Math.random()*(b-a)),randomSeed:()=>{},
  map:(x,a,b,c,d)=>Math.trunc((x-a)*(d-c)/(b-a)+c),
  constrain:(x,a,b)=>Math.min(b,Math.max(a,x)),
  min:(a,b)=>Math.min(a,b),max:(a,b)=>Math.max(a,b),
  abs:Math.abs,sq:x=>x*x,sqrt:Math.sqrt,pow:Math.pow,
  attachInterrupt,detachInterrupt,digitalPinToInterrupt,
  pulseIn,pulseInLong,shiftOut,shiftIn,
  tone,noTone,
  xTaskCreatePinnedToCore,xTaskCreate,vTaskDelay,
  // Libraries
  Serial:mkSerial(),Serial1:mkSerial(),Serial2:mkSerial(),
  Wire,SPI,WiFi,WebServer,HTTPClient,WiFiClient:function(){return{connect:()=>true,connected:()=>true,stop:()=>{},print:()=>{},println:()=>{},available:()=>0,read:()=>-1}},
  PubSubClient,ArduinoOTA,WiFiManager,
  DHT,LiquidCrystal_I2C,LiquidCrystal,
  Adafruit_SSD1306,Adafruit_NeoPixel,
  NewPing,Ultrasonic,Servo,Ticker,Timer,
  EEPROM,Preferences,
  SPIFFS:mkFS('SPIFFS'),LittleFS:mkFS('LittleFS'),
  DynamicJsonDocument,StaticJsonDocument,
  serializeJson,serializeJsonPretty,deserializeJson,
  configTime:timeLib.configTime,getLocalTime:timeLib.getLocalTime,time:timeLib.time,now:timeLib.now,
  ESP,
  esp_sleep_enable_timer_wakeup,esp_sleep_enable_ext0_wakeup,
  // Internal
  tick,_emu:{regComp,setDHT:(t,h)=>{dhtState.t=t;dhtState.h=h}}
 };
 return env;
}

/* ================= TRANSPILER ================= */
const CLASSES=['DHT','Servo','LiquidCrystal_I2C','LiquidCrystal','Adafruit_SSD1306','Adafruit_NeoPixel','Ultrasonic','NewPing','Ticker','Timer','Preferences','HTTPClient','WebServer','WiFiClient','PubSubClient','DynamicJsonDocument','StaticJsonDocument'];
const T='(?:unsigned\\s+)?(?:int|long|short|float|double|bool|boolean|byte|char|word|size_t|String|auto|void|uint\\d+_t|int\\d+_t)';
function transpile(src){
 let c=src.replace(/("(?:\\.|[^"\\])*")|('(?:\\.|[^'\\])*')|\/\*[\s\S]*?\*\/|\/\/[^\n]*/g,(m,s1,s2)=>s1||s2||'');
 // #define có tham số
 c=c.replace(/^[ \t]*#define\s+(\w+)\s*\(([^)]*)\)\s*(.+)$/gm,(m,name,args,body)=>{
  const p=args.split(',').map(s=>s.trim()).filter(Boolean);
  return `const ${name}=(${p.join(',')})=>(${body});`});
 // #define đơn
 c=c.replace(/^[ \t]*#define\s+(\w+)\s+(.+)$/gm,'let $1 = $2;');
 c=c.replace(/^[ \t]*#define\s+(\w+)\s*$/gm,'let $1;');
 // Bỏ preprocessor khác
 c=c.replace(/^[ \t]*#\s*(?:include|if|ifdef|ifndef|endif|else|elif|pragma|undef|line|error|warning).*$/gm,'');
 // Bỏ storage class
 c=c.replace(/\b(?:IRAM_ATTR|ICACHE_RAM_ATTR|volatile|static|extern|inline|PROGMEM|constexpr)\b\s*/g,'');
 // enum
 c=c.replace(/\benum\s+\w*\s*\{([^}]*)\}\s*;?/g,(m,body)=>{
  const items=body.split(',').map(s=>s.trim()).filter(Boolean);
  let v=0,out=[];
  for(const it of items){
   if(it.includes('=')){const [k,val]=it.split('=').map(s=>s.trim());v=Number(val)||0;out.push(`let ${k} = ${v};`)}
   else out.push(`let ${it} = ${v};`);
   v++;}
  return out.join(' ')});
 // function declarations
 const fns=[];
 c=c.replace(new RegExp('^[ \\t]*(?:'+T+')\\s+(\\w+)\\s*\\(([^)]*)\\)\\s*\\{','gm'),(m,name,args)=>{
  fns.push(name);
  const p=args.split(',').map(x=>x.trim().split(/[\s*&]+/).pop()).filter(x=>x&&x!=='void');
  return `async function ${name}(${p.join(',')}){`});
 // class-typed var w/ constructor
 const clRe=new RegExp('\\b('+CLASSES.join('|')+')\\s+(\\w+)\\s*\\(([^;()]*)\\)\\s*;','g');
 c=c.replace(clRe,(m,cls,name,args)=>`let ${name} = ${cls}(${args});`);
 const clRe2=new RegExp('\\b('+CLASSES.join('|')+')\\s+(\\w+)\\s*;','g');
 c=c.replace(clRe2,(m,cls,name)=>`let ${name} = ${cls}();`);
 // type replacement
 c=c.replace(new RegExp('\\b'+T+'\\b(?:\\s*\\*)?\\s+(?=[A-Za-z_]\\w*\\s*[=;,)\\[\\]]|$)','gm'),'let ');
 // array init
 c=c.replace(/let (\w+)\s*\[[^\]]*\]\s*=\s*\{([^}]*)\}/g,'let $1 = [$2]');
 c=c.replace(/let (\w+)\s*\[\s*(\d+)\s*\]\s*;/g,'let $1 = new Array($2).fill(0);');
 // casts
 c=c.replace(/\((?:int|long|byte|uint\d+_t|int\d+_t)\)\s*/g,'~~');
 c=c.replace(/\((?:float|double)\)\s*/g,'');
 c=c.replace(/\((?:char\s*\*|const\s+char\s*\*|String)\)\s*/g,'');
 // method replace
 c=c.replace(/\.length\(\)/g,'.length');
 c=c.replace(/(\w+)\.toInt\(\)/g,'parseInt($1)');
 c=c.replace(/(\w+)\.toFloat\(\)/g,'parseFloat($1)');
 c=c.replace(/(\w+)\.c_str\(\)/g,'$1');
 c=c.replace(/(\w+)\.equals\(([^)]+)\)/g,'($1===$2)');
 c=c.replace(/(\w+)\.startsWith\(([^)]+)\)/g,'$1.startsWith($2)');
 c=c.replace(/(\w+)\.endsWith\(([^)]+)\)/g,'$1.endsWith($2)');
 c=c.replace(/String\(([^)]*)\)/g,'String($1)');
 // range-for
 c=c.replace(/for\s*\(\s*(?:auto|(?:const\s+)?(?:int|long|char|float|double|byte|String|bool|uint\d+_t))\s*(?:&\s*)?(\w+)\s*:\s*([^)]+)\)/g,'for (let $1 of $2)');
 // await insertion
 const names=[...fns,'delay','delayMicroseconds','yield','tick'];
 c=c.replace(new RegExp('(?<![\\w.])(?<!async function )(?:'+names.join('|')+')\\s*\\(','g'),'await $&');
 // while an toàn
 c=c.replace(/\bwhile\s*\(/g,'while(await tick(),');
 try{
  return new AsyncFunction('env','with(env){'+c+'\nreturn{setup:typeof setup=="function"?setup:null,loop:typeof loop=="function"?loop:null}}');
 }catch(e){
  log('Lỗi biên dịch: '+e.message,'err');
  throw e;
 }
}

/* ================= SERIAL PLOT ================= */
function parseNums(s){
 const out=[];
 s.split(/[\s,;]+/).forEach(t=>{const n=parseFloat(t);if(!isNaN(n))out.push(n)});
 return out;
}

/* ================= STATE MACHINE ================= */
function resetState(){
 pv={};pm={};pw={};irq={};ledc={};rx=[];sb='';loops=0;
 _wifiState.connected=false;_wifiState.ip='0.0.0.0';_wifiState.ap=null;
 touch=false;t0=Date.now();plotData=[];comps={};fsFiles={};nvmData={};
 B.pins.forEach(upd);renderComps();renderFS();renderNVM();renderHTTP();renderMQTT();ui();
}
async function runSketch(){
 tok++;const my=tok;run=false;await sleep(30);
 resetState();run=true;paused=false;$('pause').textContent='⏸ Tạm dừng';setState();
 let api;
 try{api=await transpile($('src').value)(makeEnv())}
 catch(e){run=false;setState();return}
 log('Biên dịch OK → '+B.name,'sys');
 try{
  if(api.setup)await api.setup();
  while(run&&my===tok){
   if(api.loop)await api.loop();
   loops++;$('c-loop').textContent=loops;
   await tick();await wait(0);
  }
 }catch(e){if(e!==STOP)log('Lỗi runtime: '+e.message,'err')}
 if(my===tok){run=false;setState()}
}
function stop(){tok++;run=false;paused=false;$('pause').textContent='⏸ Tạm dừng';setState();log('Đã dừng','sys')}
function setState(){
 $('state').textContent=run?(paused?'● Tạm dừng':'● Đang chạy'):'● Dừng';
 $('state').style.color=run?(paused?'var(--yl)':'var(--ac)'):'var(--mu)';
}

/* ================= UI - PINS ================= */
function pinLabel(p){const a=Object.entries(B.alias).find(([k,v])=>v===p&&/^D\d$/.test(k));return a?a[0]:''}
function buildPins(){
 $('pins').innerHTML=B.pins.map(p=>`<div class="pin" id="p${p}" onclick="toggle(${p})"><small>GPIO${p}${pinLabel(p)?' · '+pinLabel(p):''}</small><b>0</b><small>IN</small></div>`).join('');
 const L=B.name==='ESP32'?[2,4,5]:[2,4,16];
 $('leds').innerHTML=L.map(p=>`<div class="led"><i id="l${p}"></i>GPIO${p}</div>`).join('');
 B.leds=L;
}
function upd(p){
 const e=$('p'+p);if(!e)return;const v=pv[p]??(pm[p]===2?1:0);
 e.className='pin'+(pw[p]!==undefined?' pw':v?' hi':'');
 e.style.setProperty('--d',((pw[p]||0)*100)+'%');
 e.children[1].textContent=v;
 e.children[2].textContent=pw[p]!==undefined?'PWM':pm[p]===1?'OUT':pm[p]===2?'IN↑':'IN';
 const l=$('l'+p);if(l){const b=pw[p]!==undefined?pw[p]:v;
  l.style.background=b?'#35e0a1':'#2a3550';l.style.opacity=b?.25+.75*b:1;
  l.style.boxShadow=b?'0 0 '+14*b+'px #35e0a1':'none'}
}
function toggle(p){
 if(pm[p]===1)return;
 const old=pv[p]??(pm[p]===2?1:0),nv=old?0:1;pv[p]=nv;upd(p);
 const i=irq[p];
 if(i&&(i.m===3||(i.m===2&&old&&!nv)||(i.m===1&&!old&&nv)))Promise.resolve().then(()=>i.fn()).catch(e=>log('ISR: '+e.message,'err'));
}

/* ================= UI - COMPONENTS ================= */
function renderComps(){
 const c=$('comps');const keys=Object.keys(comps);
 $('compCount').textContent=keys.length;
 if(!keys.length){c.innerHTML='<div class="hint">Chạy sketch có dùng Servo / LCD / OLED / NeoPixel / DHT / NewPing / tone() để thấy mô phỏng.</div>';return}
 let html='';
 if(comps.servo){const a=comps.servo.angle||0;const rad=(a-90)*Math.PI/180;
  html+=`<div class="comp"><div class="lbl">Servo · GPIO${comps.servo.pin}</div><div class="servo">
   <svg viewBox="-60 -60 120 120"><circle r="48" fill="#0f1727" stroke="#26344f"/>
   <text y="-52" text-anchor="middle" fill="#8a99b5" font-size="9">0°</text>
   <text x="52" y="3" text-anchor="middle" fill="#8a99b5" font-size="9">90°</text>
   <text y="58" text-anchor="middle" fill="#8a99b5" font-size="9">180°</text>
   <line x1="0" y1="0" x2="0" y2="-42" stroke="#35e0a1" stroke-width="4" stroke-linecap="round" transform="rotate(${rad*180/Math.PI})"/>
   <circle r="6" fill="#35e0a1"/></svg>
   <div style="color:var(--ac);font-weight:700">${a}°</div></div></div>`}
 if(comps.lcd){const l=comps.lcd;
  html+=`<div class="comp"><div class="lbl">LCD I2C ${l.cols}×${l.rows} · ${l.bl?'ON':'OFF'}</div><div class="lcd" style="${l.bl?'':'opacity:.4'}">${l.text.replace(/ /g,'&nbsp;')}</div></div>`}
 if(comps.oled){const o=comps.oled;
  html+=`<div class="comp"><div class="lbl">OLED SSD1306 ${o.w}×${o.h}</div><div class="oledwrap"><canvas width="${o.w}" height="${o.h}" id="oledCv"></canvas></div></div>`}
 if(comps.dhtv||comps.dht){const d=comps.dhtv||{t:'--',h:'--'};
  html+=`<div class="comp"><div class="lbl">DHT · nhiệt độ / độ ẩm</div><div class="dht"><div><b>${d.t}</b><span>°C</span></div><div><b>${d.h}</b><span>%RH</span></div></div></div>`}
 if(comps.dist){const d=comps.dist;
  html+=`<div class="comp"><div class="lbl">HC-SR04</div><div class="dist"><b>${d.cm.toFixed(1)}</b> cm</div></div>`}
 if(comps.neo){const n=comps.neo;let cells='';
  for(let i=0;i<n.n;i++){const v=n.px[i]||0;const r=(v>>16)&255,g=(v>>8)&255,b=v&255;cells+=`<i style="background:rgb(${r},${g},${b});box-shadow:0 0 8px rgba(${r},${g},${b},.6)"></i>`}
  html+=`<div class="comp"><div class="lbl">NeoPixel ×${n.n}</div><div class="neopix">${cells}</div></div>`}
 if(comps.buzz){const b=comps.buzz;
  html+=`<div class="comp"><div class="lbl">Buzzer · ${b.on?b.freq+' Hz':'im'}</div><div class="buzz"><i style="width:${b.on?100:0}%"></i></div></div>`}
 c.innerHTML=html;
 // Vẽ OLED sau khi DOM có
 if(comps.oled){const cv=$('oledCv');if(cv){const o=comps.oled;const x=cv.getContext('2d');
  x.fillStyle='#000';x.fillRect(0,0,o.w,o.h);x.fillStyle='#fff';x.font='8px monospace';
  (o.lines||[]).forEach((line,i)=>{x.fillText(line||'',2,10+i*9)});}}
}

/* ================= UI - FS/NVM/HTTP/MQTT ================= */
function renderFS(){
 const el=$('fsList');const ks=Object.keys(fsFiles);
 if(!ks.length){el.innerHTML='<div class="hint">Chưa có file.</div>';return}
 el.innerHTML=ks.map(k=>`<div onclick="alert(${JSON.stringify('Nội dung file '+k+':\n\n'+fsFiles[k]).replace(/"/g,'&quot;')})"><span>${k}</span><b>${fsFiles[k].length}B</b></div>`).join('');
}
function renderNVM(){
 const el=$('nvmList');const ks=Object.keys(nvmData);
 if(!ks.length){el.innerHTML='<div class="hint">Chưa ghi EEPROM / Preferences.</div>';return}
 el.innerHTML=ks.map(k=>`<div><span>${k}</span><b>${JSON.stringify(nvmData[k])}</b></div>`).join('');
}
function renderHTTP(){
 const el=$('httpLog');if(!httpLog.length)return;
 el.innerHTML=httpLog.slice(-40).map(h=>`<div><span>${h.t}</span><b style="color:var(--bl);font-weight:400">${h.p}</b></div>`).join('');
}
function renderMQTT(){
 const el=$('mqttLog');
 el.innerHTML='<div class="hint" style="border:0">Broker mô phỏng. Bạn có thể publish thử xuống dưới.</div>'
  +mqttLog.slice(-40).map(m=>`<div><span class="t">${m.t}</span><span class="p">${m.p}</span></div>`).join('');
}
window.mqttPub=()=>{
 const t=prompt('Topic publish vào client:');if(!t)return;
 const p=prompt('Payload:');if(p===null)return;
 mqttLog.push({t:'RX '+t,p});
 renderMQTT();
 log('MQTT RX '+t+': '+p,'sys');
};

/* ================= UI - WIFI LIST ================= */
function renderWifiList(){
 $('wl').innerHTML=NETS.map(n=>`<div onclick="WIFIC('${n[0]}')"><span>📶 ${n[0]}</span><span style="color:var(--mu)">${n[1]} dBm · ch ${n[2]}</span></div>`).join('');
}
window.WIFIC=s=>{_wifiState.connected=true;_wifiState.ip='192.168.1.100';ui();log('Kết nối thủ công: '+s,'sys')};

/* ================= INFO PANEL ================= */
function renderInfo(){
 const usedFS=Object.values(fsFiles).reduce((a,s)=>a+s.length,0);
 $('info').innerHTML=`
  <div class="kv"><span>Board</span><b>${B.name}</b></div>
  <div class="kv"><span>CPU</span><b>${B.mhz} MHz</b></div>
  <div class="kv"><span>Heap tổng</span><b>${(B.heap/1024).toFixed(0)} KB</b></div>
  <div class="kv"><span>Flash</span><b>${(B.flash/1024/1024).toFixed(1)} MB</b></div>
  <div class="kv"><span>ADC max</span><b>${B.adcMax}</b></div>
  <div class="kv"><span>PWM max</span><b>${B.pwmMax}</b></div>
  <div class="kv"><span>Pins khả dụng</span><b>${B.pins.length}</b></div>
  <div class="kv"><span>File SPIFFS</span><b>${Object.keys(fsFiles).length} (${usedFS} B)</b></div>
  <div class="kv"><span>NVS entries</span><b>${Object.keys(nvmData).length}</b></div>
  <div class="kv"><span>Tốc độ mô phỏng</span><b>${speed.toFixed(1)}x</b></div>`;
}

/* ================= UI - STATUS CHIPS ================= */
function ui(){
 $('c-wifi').textContent=_wifiState.connected?'ON':'OFF';
 $('c-ip').textContent=_wifiState.ip;
 $('wchip').className='chip'+(_wifiState.connected?' on':'');
}

/* ================= BOARD SWITCH ================= */
function setBoard(k){
 if(B)save('esp_src_'+B.name,$('src').value);
 tok++;run=false;paused=false;
 B=BOARDS[k];save('esp_board',k);$('board').value=k;
 buildPins();resetState();setState();
 $('adc').max=B.adcMax;adc=Math.round(B.adcMax/2);$('adc').value=adc;
 $('c-cpu').textContent=B.mhz+' MHz';
 $('src').value=load('esp_src_'+B.name)||EX.blink.c;gutter();
 renderWifiList();renderInfo();
}

/* ================= SKETCH SLOTS ================= */
function slotKey(i){return 'esp_slot_'+B.name+'_'+i}
function refreshSlots(){
 const s=$('slots');s.innerHTML='';
 for(let i=0;i<5;i++){
  const v=load(slotKey(i));
  const o=document.createElement('option');o.value=i;
  o.textContent='Slot '+(i+1)+(v?' ✓':' (trống)');
  s.appendChild(o);}
}

/* ================= GUTTER ================= */
function gutter(){const n=$('src').value.split('\n').length;$('gut').textContent=Array.from({length:n},(_,i)=>i+1).join('\n')}

/* ================= EVENTS ================= */
$('src').addEventListener('input',()=>{gutter();save('esp_src_'+B.name,$('src').value)});
$('src').addEventListener('scroll',()=>{$('gut').scrollTop=$('src').scrollTop});
$('src').addEventListener('keydown',e=>{
 if(e.key==='Tab'){e.preventDefault();const t=e.target,s=t.selectionStart;t.setRangeText('  ',s,t.selectionEnd,'end');t.dispatchEvent(new Event('input'))}
 if(e.key==='Enter'&&(e.ctrlKey||e.metaKey)){e.preventDefault();runSketch()}});
$('run').onclick=runSketch;$('stop').onclick=stop;
$('pause').onclick=()=>{if(!run)return;paused=!paused;$('pause').textContent=paused?'▶ Tiếp tục':'⏸ Tạm dừng';setState()};
$('board').onchange=e=>setBoard(e.target.value);
$('speed').oninput=e=>{speed=+e.target.value;$('speedv').textContent=speed.toFixed(1)+'x';renderInfo()};
$('ex').onchange=e=>{const k=e.target.value;if(EX[k]){$('src').value=EX[k].c;gutter();save('esp_src_'+B.name,$('src').value)}};
$('adc').oninput=e=>{adc=+e.target.value};
$('rnd').onclick=()=>{adc=Math.floor(Math.random()*(B.adcMax+1));$('adc').value=adc};
$('tch').onpointerdown=()=>{touch=true};$('tch').onpointerup=$('tch').onpointerleave=()=>{touch=false};
const sendRx=()=>{const v=$('rx').value;if(!v)return;rx.push(...(v+'\n'));log('> '+v,'tx');$('rx').value=''};
$('send').onclick=sendRx;$('rx').onkeydown=e=>{if(e.key==='Enter')sendRx()};

// Tabs
document.querySelectorAll('.tabs').forEach(tabs=>{
 tabs.addEventListener('click',e=>{
  const b=e.target.closest('button');if(!b)return;
  const pane=b.dataset.pane,rpane=b.dataset.rpane;
  if(pane){
   tabs.querySelectorAll('button').forEach(x=>x.classList.toggle('on',x===b));
   if(pane==='mono'){$('ser').style.display='';document.querySelector('.plotwrap').classList.remove('on');plotMode=false}
   else{$('ser').style.display='none';document.querySelector('.plotwrap').classList.add('on');plotMode=true}
  } else if(rpane){
   tabs.querySelectorAll('button').forEach(x=>x.classList.toggle('on',x===b));
   tabs.parentElement.querySelectorAll('.tabpane').forEach(p=>p.classList.toggle('on',p.id==='rp-'+rpane));
  }
 });
});

// Slots
$('saveSlot').onclick=()=>{const i=+$('slots').value;save(slotKey(i),$('src').value);refreshSlots();log('Đã lưu slot '+(i+1),'sys')};
$('loadSlot').onclick=()=>{const i=+$('slots').value;const v=load(slotKey(i));if(v){$('src').value=v;gutter();log('Đã mở slot '+(i+1),'sys')}else log('Slot trống','sys')};
$('exportBtn').onclick=()=>{const blob=new Blob([$('src').value],{type:'text/plain'});const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='sketch_'+B.name+'.ino';a.click()};
$('importBtn').onclick=()=>$('importFile').click();
$('importFile').onchange=e=>{const f=e.target.files[0];if(!f)return;const r=new FileReader();r.onload=()=>{$('src').value=r.result;gutter();log('Đã nhập '+f.name,'sys')};r.readAsText(f)};

/* ================= RENDER LOOP ================= */
setInterval(()=>{
 // ADC plot nhỏ
 const c=$('cv'),x=c.getContext('2d'),w=c.width,h=c.height;
 x.clearRect(0,0,w,h);
 x.fillStyle='#0a101c';x.fillRect(0,0,w,h);
 x.strokeStyle='#26344f';x.lineWidth=1;
 x.beginPath();x.moveTo(0,h/2);x.lineTo(w,h/2);x.stroke();
 x.strokeStyle='#35e0a1';x.lineWidth=2;
 x.beginPath();
 for(let i=0;i<w;i++){const v=(Math.sin(i/15+Date.now()/600)+1)/2;const y=h-4-v*(h-8);i?x.lineTo(i,y):x.moveTo(i,y)}
 x.stroke();
 $('adcv').textContent=Math.round(adc)+' / '+B.adcMax+' ('+(adc/B.adcMax*3.3).toFixed(2)+'V)';

 // Plotter
 if(plotMode&&plotData.length){
  const pc=$('plot'),px=pc.getContext('2d'),pw=pc.width,ph=pc.height;
  px.fillStyle='#0a101c';px.fillRect(0,0,pw,ph);
  px.strokeStyle='#26344f';px.lineWidth=1;
  for(let i=1;i<5;i++){px.beginPath();px.moveTo(0,i*ph/5);px.lineTo(pw,i*ph/5);px.stroke()}
  const mn=Math.min(...plotData),mx=Math.max(...plotData),rg=mx-mn||1;
  px.strokeStyle='#35e0a1';px.lineWidth=2;px.beginPath();
  plotData.forEach((v,i)=>{const xx=i/(plotData.length-1)*pw,yy=ph-6-((v-mn)/rg)*(ph-12);i?px.lineTo(xx,yy):px.moveTo(xx,yy)});
  px.stroke();
  px.fillStyle='#8a99b5';px.font='11px monospace';
  px.fillText('min '+mn.toFixed(2),4,12);px.fillText('max '+mx.toFixed(2),4,ph-4);
  if(plotData.length>800)plotData.splice(0,plotData.length-800);
 }

 // Uptime / heap
 const s=Math.floor((Date.now()-t0)/1000);
 $('c-up').textContent=run?s+'s':'0s';
 $('c-heap').textContent=Math.round((B.heap-(run?3000+Math.random()*1500:0))/1024)+' KB';
},200);

/* ================= INIT ================= */
// Populate example select
Object.entries(EX).forEach(([k,v])=>{
 const o=document.createElement('option');o.value=k;o.textContent=v.n;$('ex').appendChild(o);
});
setBoard(load('esp_board')||'esp8266');
refreshSlots();
renderComps();renderFS();renderNVM();renderHTTP();renderMQTT();
log('Sẵn sàng. Chọn board, chọn ví dụ, bấm Chạy (Ctrl+Enter).','sys');
log('Hỗ trợ: DHT · LCD I2C · OLED · NeoPixel · Servo · NewPing · tone · EEPROM · Preferences · SPIFFS · HTTP · WebServer · MQTT · Ticker · ArduinoJson · Deep Sleep.','sys');
</script>
</body></html>
