<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ESP Emulator — ESP8266 &amp; ESP32</title>
<style>
:root{--bg:#0b0f1a;--p:#121a2b;--p2:#182238;--bd:#26344f;--tx:#e6edf7;--mu:#8a99b5;
--ac:#35e0a1;--er:#ff5d6c;--bl:#4da3ff;--yl:#ffd166;--pp:#b388ff}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--tx);font:14px/1.5 system-ui,'Segoe UI',sans-serif}
header{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;
padding:10px 18px;background:var(--p);border-bottom:1px solid var(--bd);position:sticky;top:0;z-index:20}
h1{font-size:17px;white-space:nowrap}h1 b{color:var(--ac)}
.chips{display:flex;gap:6px;flex-wrap:wrap}
.chip{background:var(--p2);border:1px solid var(--bd);border-radius:99px;padding:2px 11px;font-size:11.5px;color:var(--mu)}
.chip b{color:var(--ac);font-weight:600}
main{display:grid;grid-template-columns:minmax(0,1.15fr) minmax(0,1fr);gap:14px;padding:14px 18px;max-width:1560px;margin:auto}
@media(max-width:980px){main{grid-template-columns:1fr}}
.card{background:var(--p);border:1px solid var(--bd);border-radius:12px;padding:12px;margin-bottom:14px}
.card h3{font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--mu);
margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap}
.bar{display:flex;gap:7px;flex-wrap:wrap;align-items:center}
button,select,input[type=text],input[type=number]{font:inherit;font-size:13px;color:var(--tx);
background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:6px 11px}
button{cursor:pointer;transition:.15s}button:hover{border-color:var(--ac)}
button.run{background:var(--ac);color:#04251a;border-color:var(--ac);font-weight:700}
button.stop{background:var(--er);border-color:var(--er);color:#fff;font-weight:700}
button.mini{padding:2px 9px;font-size:12px}
select{padding:6px 8px}
.ed{display:flex;border:1px solid var(--bd);border-radius:8px;background:#080c15;height:430px;overflow:hidden}
.ed pre,.ed textarea{font:13px/1.55 ui-monospace,Consolas,monospace;padding:10px 8px;border:0;white-space:pre;tab-size:2}
.ed pre{color:#4a5a78;text-align:right;user-select:none;background:#0a101c;overflow:hidden;min-width:44px}
.ed textarea{flex:1;background:transparent;color:#bdf5de;resize:none;outline:none;overflow:auto;border-radius:0}
#ser{height:230px;overflow:auto;background:#080c15;border:1px solid var(--bd);border-radius:8px;
padding:8px 10px;font:12.5px/1.55 ui-monospace,Consolas,monospace;margin-bottom:8px}
#ser div{white-space:pre-wrap;color:#bdf5de}#ser .sys{color:var(--mu)}#ser .err{color:var(--er)}
#ser .tx{color:var(--bl)}
.row{display:flex;gap:7px}.row input{flex:1}
.tabs{display:flex;gap:5px;flex-wrap:wrap;margin-bottom:12px}
.tabs button{background:var(--p);border:1px solid var(--bd);border-radius:99px;padding:5px 14px;font-size:12.5px;color:var(--mu)}
.tabs button.on{background:var(--ac);color:#04251a;border-color:var(--ac);font-weight:700}
.panel{display:none}.panel.on{display:block}
.pins{display:grid;grid-template-columns:repeat(auto-fill,minmax(74px,1fr));gap:7px}
.pin{background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:6px 3px;text-align:center;
cursor:pointer;user-select:none;transition:.12s}
.pin:hover{border-color:var(--ac)}.pin small{display:block;color:var(--mu);font-size:10px;line-height:1.3}
.pin b{font-size:16px;line-height:1.2}
.pin.hi{background:var(--ac);color:#04251a;border-color:var(--ac)}.pin.hi small{color:#06402c}
.pin.pw{border-color:var(--yl);color:var(--yl)}
.pin.io{opacity:.55}
.leds{display:flex;gap:20px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.led{text-align:center;font-size:11px;color:var(--mu)}
.led i{display:block;width:22px;height:22px;border-radius:50%;background:#2a3550;margin:0 auto 4px;transition:.1s}
canvas{display:block;max-width:100%}
.mono{font:12.5px/1.5 ui-monospace,Consolas,monospace}
input[type=range]{width:100%;margin:8px 0;accent-color:var(--ac)}
.wifi div{display:flex;justify-content:space-between;padding:6px 8px;border-bottom:1px solid var(--bd);cursor:pointer;font-size:13px}
.wifi div:hover{background:var(--p2)}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.kv{display:flex;justify-content:space-between;font-size:12.5px;padding:3px 0;border-bottom:1px dashed #1e2a40}
.kv span:last-child{color:var(--ac)}
label.sw{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--mu);cursor:pointer}
.doc{font-size:12.5px;color:var(--mu);line-height:1.7}
.doc code{background:#080c15;border:1px solid var(--bd);border-radius:4px;padding:1px 5px;color:#bdf5de}
.doc h4{color:var(--ac);font-size:12px;margin:10px 0 4px;letter-spacing:.05em}
.modal{position:fixed;inset:0;background:#000a;display:none;align-items:center;justify-content:center;z-index:60;padding:20px}
.modal.on{display:flex}
.modal .box{background:var(--p);border:1px solid var(--bd);border-radius:14px;padding:20px;max-width:620px;width:100%;max-height:80vh;overflow:auto}
.badge{font-size:10.5px;background:var(--p2);border:1px solid var(--bd);border-radius:6px;padding:1px 6px;color:var(--mu)}
</style>
</head>
<body>

<header>
  <h1>⚡ ESP<b>Emulator</b></h1>
  <div class="bar">
    <select id="board"><option value="esp8266">ESP8266</option><option value="esp32">ESP32</option></select>
    <button class="run" id="run">▶ Chạy</button>
    <button class="stop" id="stop">■ Dừng</button>
    <button class="mini" id="help">? API</button>
  </div>
  <div class="chips">
    <span class="chip">CPU <b id="c-cpu">—</b></span>
    <span class="chip">WiFi <b id="c-wifi">OFF</b></span>
    <span class="chip">IP <b id="c-ip">0.0.0.0</b></span>
    <span class="chip">Heap <b id="c-heap">—</b></span>
    <span class="chip">Uptime <b id="c-up">0s</b></span>
    <span class="chip">Loops <b id="c-lp">0</b></span>
  </div>
</header>

<main>
<!-- ============ LEFT ============ -->
<section>
  <div class="card">
    <h3>Sketch <span id="state" class="badge">● Dừng</span></h3>
    <div class="bar" style="margin-bottom:9px">
      <select id="ex" style="flex:1;min-width:170px"></select>
      <select id="slot" title="Khe lưu"><option value="a">Khe A</option><option value="b">Khe B</option><option value="c">Khe C</option></select>
      <button id="save" class="mini">💾 Lưu</button>
      <button id="loadb" class="mini">📂 Mở</button>
      <button id="dl" class="mini">⬇ .ino</button>
      <button id="up" class="mini">⬆ Tệp</button>
      <input type="file" id="file" accept=".ino,.cpp,.txt" hidden>
      <span class="badge" id="spd">delay ×1</span>
      <input type="range" id="speed" min="0" max="4" step="1" value="1" style="width:90px;margin:0">
    </div>
    <div class="ed"><pre id="gut">1</pre><textarea id="src" spellcheck="false"></textarea></div>
  </div>

  <div class="card">
    <h3>
      <span>Serial</span>
      <span class="bar">
        <button class="mini" id="tabMon">Monitor</button>
        <button class="mini" id="tabPlot">Plotter</button>
        <button class="mini" onclick="document.getElementById('ser').innerHTML='';plotData=[]">Xoá</button>
      </span>
    </h3>
    <div id="ser"></div>
    <canvas id="plot" width="600" height="180" style="display:none;width:100%;height:180px;background:#080c15;border:1px solid var(--bd);border-radius:8px;margin-bottom:8px"></canvas>
    <div class="row">
      <input type="text" id="rx" placeholder="Gửi dữ liệu tới Serial rồi Enter…">
      <button id="send">Gửi</button>
    </div>
  </div>
</section>

<!-- ============ RIGHT ============ -->
<section>
  <div class="tabs" id="rtabs">
    <button data-t="gpio" class="on">GPIO</button>
    <button data-t="adc">Analog</button>
    <button data-t="sens">Cảm biến</button>
    <button data-t="disp">Hiển thị</button>
    <button data-t="net">Mạng &amp; Bus</button>
    <button data-t="doc">Trợ giúp</button>
  </div>

  <!-- GPIO -->
  <div class="panel on" id="p-gpio">
    <div class="card"><h3>GPIO — bấm để đảo mức chân INPUT</h3>
      <div class="pins" id="pins"></div>
      <div class="leds" id="leds"></div>
    </div>
  </div>

  <!-- ADC -->
  <div class="panel" id="p-adc">
    <div class="card"><h3>ADC <span id="adcv"></span></h3>
      <canvas id="cv" width="400" height="120"></canvas>
      <input type="range" id="adc">
      <div class="bar">
        <button id="rnd">🎲 Ngẫu nhiên</button>
        <button id="tch">👆 Giữ Touch</button>
        <button id="noise">〰 Nhiễu</button>
        <label class="sw"><input type="checkbox" id="ntc"> Bật nhiễu ADC</label>
      </div>
    </div>
  </div>

  <!-- Sensors -->
  <div class="panel" id="p-sens">
    <div class="card"><h3>Cảm biến mô phỏng</h3>
      <div class="kv"><span>🌡 DHT — Nhiệt độ</span><span id="v-t">28.4 °C</span></div>
      <input type="range" id="s-t" min="-10" max="60" step="0.1" value="28.4">
      <div class="kv"><span>💧 DHT — Độ ẩm</span><span id="v-h">64 %</span></div>
      <input type="range" id="s-h" min="0" max="100" step="1" value="64">
      <div class="kv"><span>📏 HC-SR04 — Khoảng cách</span><span id="v-d">25 cm</span></div>
      <input type="range" id="s-d" min="2" max="400" step="1" value="25">
      <div class="kv"><span>☀ LDR — Ánh sáng</span><span id="v-l">50 %</span></div>
      <input type="range" id="s-l" min="0" max="100" step="1" value="50">
      <div class="bar" style="margin-top:10px">
        <button id="btn0">🔘 Nút GPIO0</button>
        <label class="sw"><input type="checkbox" id="pir"> PIR chuyển động</label>
      </div>
    </div>
  </div>

  <!-- Display -->
  <div class="panel" id="p-disp">
    <div class="card"><h3>NeoPixel <span class="badge" id="npinfo">chưa dùng</span></h3>
      <canvas id="npcv" width="400" height="60"></canvas>
    </div>
    <div class="card"><h3>Servo</h3>
      <canvas id="svcv" width="400" height="110"></canvas>
    </div>
    <div class="card"><h3>OLED SSD1306 128×64</h3>
      <canvas id="oledcv" width="384" height="192" style="image-rendering:pixelated;background:#000;border:1px solid var(--bd);border-radius:8px"></canvas>
    </div>
    <div class="card"><h3>LCD I2C 16×2</h3>
      <canvas id="lcdcv" style="background:#0d1f14;border:1px solid var(--bd);border-radius:8px"></canvas>
    </div>
  </div>

  <!-- Network -->
  <div class="panel" id="p-net">
    <div class="card"><h3>WiFi xung quanh</h3>
      <div class="wifi" id="wl"></div>
      <div class="bar" style="margin-top:10px">
        <button id="wdis">Ngắt WiFi</button>
        <label class="sw"><input type="checkbox" id="mute" checked> 🔊 Âm thanh</label>
      </div>
    </div>
    <div class="card"><h3>Bus I2C — thiết bị gắn sẵn</h3>
      <div id="i2clist" class="bar"></div>
    </div>
    <div class="card"><h3>Nhật ký HTTP / Socket</h3>
      <div id="netlog" class="mono" style="max-height:160px;overflow:auto;color:var(--mu)"></div>
    </div>
  </div>

  <!-- Docs -->
  <div class="panel" id="p-doc">
    <div class="card"><h3>API được hỗ trợ</h3>
      <div class="doc" id="docbody"></div>
    </div>
  </div>
</section>
</main>

<div class="modal" id="modal"><div class="box">
  <h3 style="margin-bottom:10px">⚡ ESP Emulator — Hướng dẫn nhanh</h3>
  <div class="doc">
    <p>Viết mã kiểu Arduino (C++) rồi bấm <b>▶ Chạy</b>. Trình biên dịch sẽ chuyển mã sang JavaScript và chạy trong trình duyệt.</p>
    <h4>Phím tắt</h4>
    <p><code>Ctrl/⌘ + Enter</code> Chạy · <code>Tab</code> thụt lề · <code>Ctrl + S</code> Lưu vào khe</p>
    <h4>Mô phỏng</h4>
    <p>GPIO, PWM, ADC, Touch, Ngắt, WiFi, I2C, NeoPixel, Servo, DHT, OLED SSD1306, LCD I2C, HC-SR04, EEPROM, LittleFS, HTTP, Buzzer.</p>
    <h4>Giới hạn</h4>
    <p>Đây là mô phỏng logic — không mô phỏng điện áp, thời gian thực tuyệt đối hay đa luồng thật. <code>delay()</code> là bất đồng bộ nên các hàm trong lớp (class) được tự động đánh dấu <code>async</code>.</p>
  </div>
  <div class="bar" style="margin-top:16px"><button class="run" onclick="document.getElementById('modal').classList.remove('on')">Đã hiểu</button></div>
</div></div>

<script>
/* ==========================================================================
   0. TIỆN ÍCH
   ========================================================================== */
const $ = id => document.getElementById(id);
const STOP = {stop:true};
const esc = s => String(s).replace(/[&<>]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[c]));

/* ⚠ FIX: AsyncFunction constructor cho trình biên dịch động */
const AsyncFunction = Object.getPrototypeOf(async function(){}).constructor;

/* ==========================================================================
   1. CẤU HÌNH BOARD
   ========================================================================== */
const BOARDS = {
  esp8266:{name:'ESP8266', mhz:160, heap:81920, adcMax:1023, pwmMax:1023, touch:false,
    pins:[0,1,2,3,4,5,12,13,14,15,16],
    alias:{D0:16,D1:5,D2:4,D3:0,D4:2,D5:14,D6:12,D7:13,D8:15,A0:17,SDA:4,SCL:5,
           LED_BUILTIN:2,LED_BLUE:2,BUILTIN_LED:2}},
  esp32:{name:'ESP32', mhz:240, heap:327680, adcMax:4095, pwmMax:255, touch:true,
    pins:[0,2,4,5,12,13,14,15,16,17,18,19,21,22,23,25,26,27,32,33,34,35,36,39],
    alias:{LED_BUILTIN:2,SDA:21,SCL:22,A0:36,A3:39,A4:32,A5:33,A6:34,A7:35,
           T0:4,T1:0,T2:2,T3:15,T4:13,T5:12,T6:14,T7:27,DAC1:25,DAC2:26,
           TRIG:5,ECHO:18,BUZZER:5}}
};

const NETS = [['ELECTRONICSTREE',-45,6,'WPA2'],['Viettel 5G',-58,1,'WPA2'],
              ['FPT Telecom',-55,1,'WPA2'],['iPhone 15',-48,6,'WPA3'],
              ['Free WiFi',-72,3,'mở']];

const I2C_DEVICES = [0x3C,0x27,0x68,0x76,0x23,0x48,0x1E,0x40];

/* ==========================================================================
   2. VÍ DỤ
   ========================================================================== */
const EX = [
['blink','💡 Blink',`#define LED 2

void setup() {
  Serial.begin(115200);
  pinMode(LED, OUTPUT);
  Serial.println("=== Blink bat dau ===");
}

void loop() {
  digitalWrite(LED, HIGH);
  Serial.println("LED ON");
  delay(500);
  digitalWrite(LED, LOW);
  Serial.println("LED OFF");
  delay(500);
}`],

['fade','🎚 PWM Fade',`#define LED 2
int doSang = 0;
int buoc = 5;

void setup() {
  Serial.begin(115200);
  pinMode(LED, OUTPUT);
}

void loop() {
  analogWrite(LED, doSang);
  doSang += buoc;
  if (doSang <= 0 || doSang >= 255) buoc = -buoc;
  Serial.println(doSang);
  delay(30);
}`],

['button','🔘 Nút nhấn',`#define LED 2
#define BTN 0

void setup() {
  Serial.begin(115200);
  pinMode(LED, OUTPUT);
  pinMode(BTN, INPUT_PULLUP);
}

void loop() {
  if (digitalRead(BTN) == LOW) {
    digitalWrite(LED, HIGH);
    Serial.println(">>> Nhan nut! <<<");
    while (digitalRead(BTN) == LOW) delay(10);
  } else {
    digitalWrite(LED, LOW);
  }
  delay(50);
}`],

['irq','⚡ Ngắt (Interrupt)',`volatile int dem = 0;
#define BTN 0
#define LED 2

void IRAM_ATTR onPress() {
  dem++;
}

void setup() {
  Serial.begin(115200);
  pinMode(BTN, INPUT_PULLUP);
  pinMode(LED, OUTPUT);
  attachInterrupt(digitalPinToInterrupt(BTN), onPress, FALLING);
  Serial.println("San sang - bam chan GPIO0");
}

void loop() {
  if (dem > 0) {
    Serial.print("So lan ngat: ");
    Serial.println(dem);
    digitalWrite(LED, !digitalRead(LED));
    dem = 0;
  }
  delay(50);
}`],

['wifi','📶 Quét WiFi',`void setup() {
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  Serial.println("Bat dau quet WiFi...");
}

void loop() {
  int n = WiFi.scanNetworks();
  Serial.print("Tim thay ");
  Serial.print(n);
  Serial.println(" mang:");
  for (int i = 0; i < n; i++) {
    Serial.print("  ");
    Serial.print(WiFi.SSID(i));
    Serial.print("  ");
    Serial.print(WiFi.RSSI(i));
    Serial.print(" dBm  ch");
    Serial.println(WiFi.channel(i));
  }
  Serial.println("-------------------");
  delay(5000);
}`],

['wificonn','🔗 Kết nối WiFi',`void setup() {
  Serial.begin(115200);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  Serial.print("Dang ket noi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(400);
    Serial.print(".");
  }
  Serial.println();
  Serial.print("Da ket noi! IP = ");
  Serial.println(WiFi.localIP());
  Serial.print("MAC = ");
  Serial.println(WiFi.macAddress());
}

void loop() {
  delay(1000);
}`],

['i2c','🔌 Quét I2C',`#include <Wire.h>

void setup() {
  Wire.begin();
  Serial.begin(115200);
  Serial.println("Quet bus I2C...");
}

void loop() {
  int found = 0;
  for (int addr = 1; addr < 127; addr++) {
    Wire.beginTransmission(addr);
    if (Wire.endTransmission() == 0) {
      Serial.print("Thiet bi tai 0x");
      Serial.println(addr, HEX);
      found++;
    }
  }
  Serial.print("Tong cong: ");
  Serial.println(found);
  delay(5000);
}`],

['touch','👆 Touch (ESP32)',`// Chỉ ESP32 — giữ nút "Giữ Touch" ở tab Analog
#define LED 2

void setup() {
  Serial.begin(115200);
  pinMode(LED, OUTPUT);
}

void loop() {
  int v = touchRead(T0);
  Serial.print("Touch T0 = ");
  Serial.println(v);
  digitalWrite(LED, v < 40);
  delay(200);
}`],

['neopixel','🌈 NeoPixel',`#include <Adafruit_NeoPixel.h>
#define PIN 4
#define NUM 12

Adafruit_NeoPixel strip(NUM, PIN, NEO_GRB + NEO_KHZ800);

void setup() {
  Serial.begin(115200);
  strip.begin();
  strip.setBrightness(120);
  strip.show();
  Serial.println("NeoPixel san sang");
}

void loop() {
  for (int i = 0; i < NUM; i++) {
    strip.clear();
    strip.setPixelColor(i, strip.Color(255, 0, 0));
    strip.setPixelColor((i + 4) % NUM, strip.Color(0, 255, 0));
    strip.setPixelColor((i + 8) % NUM, strip.Color(0, 0, 255));
    strip.show();
    delay(120);
  }
}`],

['servo','⚙ Servo quét góc',`#include <Servo.h>
Servo myServo;

void setup() {
  Serial.begin(115200);
  myServo.attach(13);
  Serial.println("Servo tren GPIO13");
}

void loop() {
  for (int a = 0; a <= 180; a += 10) {
    myServo.write(a);
    Serial.println(a);
    delay(80);
  }
  for (int a = 180; a >= 0; a -= 10) {
    myServo.write(a);
    delay(80);
  }
}`],

['dht','🌡 DHT22',`#include <DHT.h>
#define DHTPIN 4
#define DHTTYPE DHT22

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(115200);
  dht.begin();
  Serial.println("Cam bien DHT22 san sang");
}

void loop() {
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  Serial.print("Nhiet do: ");
  Serial.print(t);
  Serial.print(" C   Do am: ");
  Serial.print(h);
  Serial.println(" %");
  delay(2000);
}`],

['oled','🖥 OLED SSD1306',`#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>

Adafruit_SSD1306 display(128, 64, &Wire, -1);

void setup() {
  Serial.begin(115200);
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);
  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);
  display.setCursor(0, 0);
  display.println("ESP EMULATOR");
  display.drawLine(0, 12, 127, 12, SSD1306_WHITE);
  display.setCursor(0, 20);
  display.println("Hello ban!");
  display.display();
}

void loop() {
  display.fillRect(0, 46, random(0, 128), 8, SSD1306_WHITE);
  display.setCursor(0, 34);
  display.setTextSize(1);
  display.print("ms=");
  display.print(millis());
  display.display();
  delay(400);
}`],

['lcd','📟 LCD I2C',`#include <Wire.h>
#include <LiquidCrystal_I2C.h>

LiquidCrystal_I2C lcd(0x27, 16, 2);

void setup() {
  Serial.begin(115200);
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("ESP Emulator");
  lcd.setCursor(0, 1);
  lcd.print("Xin chao!");
}

void loop() {
  lcd.setCursor(11, 1);
  lcd.print("    ");
  lcd.setCursor(11, 1);
  lcd.print(millis() / 1000);
  delay(500);
}`],

['buzzer','🔊 Buzzer',`#define BUZZER 5
int notes[] = {262, 294, 330, 349, 392, 440, 494, 523};

void setup() {
  Serial.begin(115200);
  pinMode(BUZZER, OUTPUT);
}

void loop() {
  for (int i = 0; i < 8; i++) {
    tone(BUZZER, notes[i], 180);
    Serial.println(notes[i]);
    delay(250);
  }
  noTone(BUZZER);
  delay(1000);
}`],

['ultra','📏 HC-SR04',`#define TRIG 5
#define ECHO 18

void setup() {
  Serial.begin(115200);
  pinMode(TRIG, OUTPUT);
  pinMode(ECHO, INPUT);
}

void loop() {
  digitalWrite(TRIG, LOW);
  delayMicroseconds(2);
  digitalWrite(TRIG, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIG, LOW);

  long dur = pulseIn(ECHO, HIGH);
  float cm = dur * 0.0343 / 2.0;

  Serial.print("Khoang cach: ");
  Serial.print(cm);
  Serial.println(" cm");
  delay(400);
}`],

['adc','📈 ADC + Plotter',`void setup() {
  Serial.begin(115200);
}

void loop() {
  int v = analogRead(A0);
  Serial.println(v);
  delay(50);
}`],

['plot','📊 Plotter hình sin',`void setup() {
  Serial.begin(115200);
}

void loop() {
  float t = millis() / 1000.0;
  Serial.print(sin(t) * 100);
  Serial.print(" ");
  Serial.print(cos(t) * 100);
  Serial.print(" ");
  Serial.println(sin(t * 2) * 50);
  delay(40);
}`],

['deep','😴 Deep Sleep',`void setup() {
  Serial.begin(115200);
  Serial.println("Thuc day!");
  pinMode(2, OUTPUT);
  digitalWrite(2, HIGH);
  delay(800);
  digitalWrite(2, LOW);
  Serial.println("Di ngu 5 giay...");
  delay(300);
  ESP.deepSleep(5000000);
}

void loop() {
}`],

['http','🌐 HTTP GET',`#include <WiFi.h>
#include <HTTPClient.h>

void setup() {
  Serial.begin(115200);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  while (WiFi.status() != WL_CONNECTED) {
    delay(300);
    Serial.print(".");
  }
  Serial.println();
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  HTTPClient http;
  http.begin("http://api.example.com/sensors");
  int code = http.GET();
  Serial.print("HTTP ");
  Serial.println(code);
  Serial.println(http.getString());
  http.end();
  delay(4000);
}`],

['eeprom','💾 EEPROM',`#include <EEPROM.h>
int dem = 0;

void setup() {
  Serial.begin(115200);
  EEPROM.begin(32);
  dem = EEPROM.read(0);
  Serial.print("Lan chay truoc dem = ");
  Serial.println(dem);
}

void loop() {
  dem++;
  EEPROM.write(0, dem);
  EEPROM.commit();
  Serial.print("Dem = ");
  Serial.println(dem);
  delay(1000);
}`],

['oop','🧱 Lập trình hướng đối tượng',`class Den {
  int chan;
  int trangThai;
public:
  Den(int c) {
    chan = c;
    trangThai = 0;
  }
  void bat() {
    trangThai = 1;
    digitalWrite(chan, HIGH);
  }
  void tat() {
    trangThai = 0;
    digitalWrite(chan, LOW);
  }
  void dao() {
    if (trangThai) tat();
    else bat();
  }
  int doc() {
    return trangThai;
  }
};

Den led(2);

void setup() {
  Serial.begin(115200);
  pinMode(2, OUTPUT);
}

void loop() {
  led.dao();
  Serial.print("Trang thai LED = ");
  Serial.println(led.doc());
  delay(600);
}`],

['string','🔤 Xử lý chuỗi',`void setup() {
  Serial.begin(115200);

  String ten = "ESP Emulator";
  Serial.print("Chuoi: ");
  Serial.println(ten);
  Serial.print("Do dai: ");
  Serial.println(ten.length());

  String s = "";
  for (int i = 0; i < 5; i++) {
    s += "X";
    Serial.println(s);
    delay(200);
  }

  int so = 1234;
  Serial.print("So: ");
  Serial.println(so);
  Serial.print("Hex: ");
  Serial.println(so, HEX);
}`],

['web','🕸 Web Server (giả lập)',`#include <WiFi.h>
#include <WebServer.h>

WebServer server(80);
int dem = 0;

void handleRoot() {
  dem++;
  Serial.print("Co request! Tong = ");
  Serial.println(dem);
}

void setup() {
  Serial.begin(115200);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  delay(1500);
  Serial.print("IP server: ");
  Serial.println(WiFi.localIP());
  server.on("/", handleRoot);
  server.begin();
  Serial.println("HTTP server dang chay o cong 80");
}

void loop() {
  server.handleClient();
  delay(500);
}`]
];

/* ==========================================================================
   3. THIẾT BỊ MÔ PHỎNG
   ========================================================================== */
const dev = {
  np:{n:0,buf:[],bright:1},
  servos:{},
  oled:null,
  lcd:null,
  dht:{t:28.4,h:64},
  dist:25,
  ldr:50,
  adc:512,
  touch:[38,42,46,50,54,36,40,44,48,52],
  touchHold:false,
  i2c:new Set([0x3C,0x27,0x68]),
  fs:{},
  prefs:{},
  eeprom:new Uint8Array(512),
  httpLog:[],
  toneOsc:null,
  tone:null,
  mute:true,
  noise:false
};

/* ---------- Formatter ---------- */
function cformat(f, a){
  let i = 0;
  return String(f).replace(/%(-?\d*\.?\d*)(?:l{1,2}|h)?([diufsxXc%])/g, (m, pad, t)=>{
    if(t === '%') return '%';
    let v = a[i++];
    switch(t){
      case 'd': case 'i': case 'u': return String(Math.trunc(+v));
      case 'f': return (+v).toFixed(pad && pad.includes('.') ? +pad.split('.')[1] : 6);
      case 's': return String(v);
      case 'x': return (Math.trunc(+v) >>> 0).toString(16);
      case 'X': return (Math.trunc(+v) >>> 0).toString(16).toUpperCase();
      case 'c': return String.fromCharCode(v);
    }
    return m;
  });
}

/* ---------- Thư viện mô phỏng ---------- */
class NeoPixelSim{
  constructor(n, pin, type){
    this.n = n|0; this.pin = pin; this.buf = new Array(this.n).fill(0); this.br = 255;
    dev.np = {n:this.n, buf:this.buf, bright:1};
    $('npinfo').textContent = this.n + ' LED / GPIO' + pin;
  }
  begin(){ renderPixels(); return true; }
  setPin(p){ this.pin = p; }
  setBrightness(b){ this.br = b; dev.np.bright = Math.max(0,Math.min(1,b/255)); renderPixels(); }
  getBrightness(){ return this.br; }
  setPixelColor(i, ...a){
    i = i|0; if(i < 0 || i >= this.n) return;
    let c;
    if(a.length === 1){ c = (typeof a[0] === 'number') ? (a[0]>>>0) : 0; }
    else { c = ((a[0]&255)<<16)|((a[1]&255)<<8)|(a[2]&255); }
    this.buf[i] = c;
  }
  getPixelColor(i){ return this.buf[i]|0; }
  fill(c, first, count){
    first = first||0; count = count===undefined ? this.n : count;
    for(let i=first;i<Math.min(this.n, first+count);i++) this.buf[i] = c>>>0;
    renderPixels();
  }
  clear(){ this.buf.fill(0); }
  numPixels(){ return this.n; }
  show(){ renderPixels(); }
  canShow(){ return true; }
  Color(r,g,b){ return ((r&255)<<16)|((g&255)<<8)|(b&255); }
  ColorHSV(h,s,v){
    h = ((h%360)+360)%360/360; s = s/255; v = v/255;
    const i = Math.floor(h*6), f = h*6-i, p = v*(1-s), q = v*(1-f*s), t = v*(1-(1-f)*s);
    let r,g,b;
    switch(i%6){
      case 0: r=v;g=t;b=p; break; case 1: r=q;g=v;b=p; break;
      case 2: r=p;g=v;b=t; break; case 3: r=p;g=q;b=v; break;
      case 4: r=t;g=p;b=v; break; default: r=v;g=p;b=q;
    }
    return ((Math.round(r*255)&255)<<16)|((Math.round(g*255)&255)<<8)|(Math.round(b*255)&255);
  }
}

class ServoSim{
  constructor(){ this.pin = -1; this.deg = 90; }
  attach(pin){ this.pin = pin; dev.servos[pin] = {deg:this.deg}; renderServos(); return 1; }
  detach(){ if(dev.servos[this.pin]) delete dev.servos[this.pin]; this.pin = -1; renderServos(); }
  write(d){ this.deg = Math.max(0, Math.min(180, +d)); if(this.pin>=0) dev.servos[this.pin] = {deg:this.deg}; renderServos(); }
  writeMicroseconds(us){ this.write((us-544)*180/(2400-544)); }
  read(){ return this.deg; }
  readMicroseconds(){ return 544 + this.deg*(2400-544)/180; }
  attached(){ return this.pin >= 0; }
}

class DHTSim{
  constructor(pin, type){ this.pin = pin; this.type = type; }
  begin(){ return true; }
  readTemperature(f){
    const t = dev.dht.t + (Math.random()-0.5)*0.3;
    return f ? t*9/5+32 : t;
  }
  readHumidity(){ return dev.dht.h + (Math.random()-0.5)*0.8; }
  computeHeatIndex(t, f){
    const T = f ? (t-32)*5/9 : t;
    return f ? (T*9/5+32+3) : (T+2);
  }
}

class OLEDSim{
  constructor(w, h, wire, rst){
    this.w = w||128; this.h = h||64;
    this.cv = document.createElement('canvas');
    this.cv.width = this.w; this.cv.height = this.h;
    this.ctx = this.cv.getContext('2d');
    this.ctx.fillStyle = '#000'; this.ctx.fillRect(0,0,this.w,this.h);
    this.color = '#fff'; this.size = 1; this.cx = 0; this.cy = 0;
    dev.oled = this;
  }
  begin(a,b,c){ return true; }
  clearDisplay(){ this.ctx.fillStyle='#000'; this.ctx.fillRect(0,0,this.w,this.h); }
  display(){ renderOLED(); }
  _c(c){ return (c === 0 || c === 'SSD1306_BLACK') ? '#000' : '#fff'; }
  drawPixel(x,y,c){ this.ctx.fillStyle=this._c(c===undefined?1:c); this.ctx.fillRect(x|0, y|0, 1, 1); }
  drawLine(x0,y0,x1,y1,c){ this.ctx.strokeStyle=this._c(c===undefined?1:c); this.ctx.lineWidth=1;
    this.ctx.beginPath(); this.ctx.moveTo(x0+.5,y0+.5); this.ctx.lineTo(x1+.5,y1+.5); this.ctx.stroke(); }
  drawRect(x,y,w,h,c){ this.ctx.strokeStyle=this._c(c===undefined?1:c); this.ctx.lineWidth=1;
    this.ctx.strokeRect(x+.5,y+.5,w,h); }
  fillRect(x,y,w,h,c){ this.ctx.fillStyle=this._c(c===undefined?1:c); this.ctx.fillRect(x,y,w,h); }
  drawRoundRect(x,y,w,h,r,c){ this.drawRect(x,y,w,h,c); }
  fillRoundRect(x,y,w,h,r,c){ this.fillRect(x,y,w,h,c); }
  drawCircle(x,y,r,c){ this.ctx.strokeStyle=this._c(c===undefined?1:c); this.ctx.lineWidth=1;
    this.ctx.beginPath(); this.ctx.arc(x,y,r,0,Math.PI*2); this.ctx.stroke(); }
  fillCircle(x,y,r,c){ this.ctx.fillStyle=this._c(c===undefined?1:c);
    this.ctx.beginPath(); this.ctx.arc(x,y,r,0,Math.PI*2); this.ctx.fill(); }
  drawTriangle(x0,y0,x1,y1,x2,y2,c){ this.ctx.strokeStyle=this._c(c===undefined?1:c); this.ctx.lineWidth=1;
    this.ctx.beginPath(); this.ctx.moveTo(x0,y0); this.ctx.lineTo(x1,y1); this.ctx.lineTo(x2,y2);
    this.ctx.closePath(); this.ctx.stroke(); }
  fillTriangle(x0,y0,x1,y1,x2,y2,c){ this.ctx.fillStyle=this._c(c===undefined?1:c);
    this.ctx.beginPath(); this.ctx.moveTo(x0,y0); this.ctx.lineTo(x1,y1); this.ctx.lineTo(x2,y2);
    this.ctx.closePath(); this.ctx.fill(); }
  setTextSize(s){ this.size = s||1; }
  setTextColor(c){ this.color = this._c(c===undefined?1:c); }
  setTextWrap(){}
  setCursor(x,y){ this.cx = x; this.cy = y; }
  print(v){
    const s = String(v);
    this.ctx.fillStyle = this.color;
    this.ctx.font = (8*this.size) + 'px monospace';
    this.ctx.textBaseline = 'top';
    for(const ch of s){
      if(ch === '\n'){ this.cx = 0; this.cy += 8*this.size; continue; }
      this.ctx.fillText(ch, this.cx, this.cy);
      this.cx += 6*this.size;
    }
  }
  println(v){ this.print(v===undefined?'':v); this.cx = 0; this.cy += 8*this.size; }
  write(c){ this.print(String.fromCharCode(c)); }
  drawBitmap(x,y,bmp,w,h,c){
    this.ctx.fillStyle = this._c(c===undefined?1:c);
    for(let j=0;j<h;j++) for(let i=0;i<w;i++){
      const byte = bmp[(j*w+i)>>3] || 0;
      if(byte & (128 >> ((j*w+i)&7))) this.ctx.fillRect(x+i, y+j, 1, 1);
    }
  }
  startscrollright(){} startscrollleft(){} stopscroll(){}
  dim(){} invertDisplay(){} ssd1306_command(){}
  width(){ return this.w; } height(){ return this.h; }
}

class LCDSim{
  constructor(addr, cols, rows){
    this.addr = addr; this.cols = cols||16; this.rows = rows||2;
    this.buf = Array.from({length:this.rows}, ()=>new Array(this.cols).fill(' '));
    this.cx = 0; this.cy = 0; this.on = true;
    dev.lcd = this;
  }
  init(){ this.clear(); return this; }
  begin(c,r){ return this.init(); }
  backlight(){ this.on = true; renderLCD(); }
  noBacklight(){ this.on = false; renderLCD(); }
  display(){ this.on = true; renderLCD(); }
  noDisplay(){ this.on = false; renderLCD(); }
  clear(){ this.buf.forEach(r=>r.fill(' ')); this.cx = 0; this.cy = 0; renderLCD(); }
  home(){ this.cx = 0; this.cy = 0; }
  setCursor(c,r){ this.cx = Math.max(0,Math.min(this.cols-1, c|0)); this.cy = Math.max(0,Math.min(this.rows-1, r|0)); }
  print(v){ for(const ch of String(v)) this.write(ch.charCodeAt(0)); renderLCD(); }
  println(v){ this.print(v===undefined?'':v); this.cx = 0; this.cy = Math.min(this.rows-1, this.cy+1); renderLCD(); }
  write(c){
    if(c === 10){ this.cx = 0; this.cy = Math.min(this.rows-1, this.cy+1); return; }
    if(c === 13) return;
    if(this.cy < this.rows && this.cx < this.cols) this.buf[this.cy][this.cx] = String.fromCharCode(c);
    this.cx++;
    if(this.cx >= this.cols){ this.cx = 0; this.cy = Math.min(this.rows-1, this.cy+1); }
  }
  createChar(){} blink(){} noBlink(){} cursor(){} noCursor(){}
  scrollDisplayLeft(){} scrollDisplayRight(){} autoscroll(){}
}

class PreferencesSim{
  constructor(ns){ this.ns = ns || 'default'; this.ro = false; }
  begin(ns, ro){ this.ns = ns || this.ns; this.ro = !!ro; return true; }
  _k(k){ return this.ns + ':' + k; }
  putInt(k,v){ dev.prefs[this._k(k)] = Math.trunc(v); return 1; }
  getInt(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? (d||0) : v|0; }
  putFloat(k,v){ dev.prefs[this._k(k)] = +v; return 1; }
  getFloat(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? (d||0) : v; }
  putBool(k,v){ dev.prefs[this._k(k)] = !!v; return 1; }
  getBool(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? !!d : v; }
  putString(k,v){ dev.prefs[this._k(k)] = String(v); return 1; }
  getString(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? (d||'') : v; }
  isKey(k){ return dev.prefs[this._k(k)] !== undefined; }
  remove(k){ delete dev.prefs[this._k(k)]; }
  clear(){ Object.keys(dev.prefs).forEach(k=>{ if(k.startsWith(this.ns+':')) delete dev.prefs[k]; }); }
  end(){ return true; }
}

class FileSim{
  constructor(path){ this.path = path; this.pos = 0; }
  print(s){ dev.fs[this.path] = (dev.fs[this.path]||'') + String(s); return 1; }
  println(s){ return this.print((s===undefined?'':s) + '\n'); }
  write(s){ return this.print(s); }
  readString(){ const s = dev.fs[this.path]||''; this.pos = s.length; return s; }
  read(){ const s = dev.fs[this.path]||''; return this.pos < s.length ? s.charCodeAt(this.pos++) : -1; }
  available(){ return (dev.fs[this.path]||'').length - this.pos; }
  close(){ return true; }
  size(){ return (dev.fs[this.path]||'').length; }
  name(){ return this.path; }
  flush(){ return true; }
}

class HTTPClientSim{
  constructor(){ this.url = ''; }
  begin(url){ this.url = url; return true; }
  GET(){
    const code = 200;
    netLog('GET ' + this.url + ' → ' + code);
    this.body = '{"temp":' + dev.dht.t.toFixed(1) + ',"humi":' + dev.dht.h.toFixed(0) + ',"ok":true}';
    return code;
  }
  POST(p){ this.body = '{"status":"ok"}'; netLog('POST ' + this.url + ' → 200'); return 200; }
  getString(){ return this.body || ''; }
  end(){ }
  setConnectTimeout(){} setReuse(){}
}

class WiFiClientSim{
  connect(h,p){ netLog('Socket → ' + h + ':' + p); return 1; }
  print(s){ this._buf = (this._buf||'') + s; }
  println(s){ this.print((s===undefined?'':s)+'\n'); }
  available(){ return this._resp ? this._resp.length : 0; }
  readString(){ const r = this._resp || ''; this._resp = ''; return r; }
  stop(){ this._resp = 'HTTP/1.1 200 OK\n\nHello from ' + (this._host||'server'); }
  setTimeout(){} connected(){ return true; }
}

class WebServerSim{
  constructor(port){ this.port = port; }
  on(path, fn){ this.handler = fn; return true; }
  begin(){ netLog('WebServer lắng nghe cổng ' + this.port); return true; }
  handleClient(){ if(Math.random() < 0.06 && this.handler) this.handler(); }
  send(){ }
  stop(){ }
}

class PubSubClientSim{
  constructor(client){ }
  setServer(h,p){ this.host = h; netLog('MQTT → ' + h + ':' + p); }
  connect(id){ netLog('MQTT connected: ' + id); return true; }
  publish(t, m){ netLog('MQTT pub ' + t + ' = ' + m); return true; }
  subscribe(t){ netLog('MQTT sub ' + t); return true; }
  loop(){ return true; }
  connected(){ return true; }
  setCallback(){}
}

class UltrasonicSim{
  constructor(t,e){ this.t = t; this.e = e; }
  read(){ return dev.dist; }
  distanceRead(){ return dev.dist; }
  timing(){ return dev.dist * 58; }
}

/* ==========================================================================
   4. BỘ CHUYỂN MÃ C++ → JS
   ========================================================================== */
const TYPES = '(?:unsigned\\s+|signed\\s+)?(?:long\\s+long|long|short|int|char|float|double|bool|boolean|byte|word|size_t|ssize_t|uint8_t|uint16_t|uint32_t|uint64_t|int8_t|int16_t|int32_t|int64_t|String|auto)';

const LIB_CLASSES = ['Adafruit_NeoPixel','Adafruit_SSD1306','Adafruit_GFX','LiquidCrystal_I2C',
  'DHT','Servo','ESP32Servo','WiFiClient','WiFiServer','HTTPClient','WebServer','Preferences',
  'PubSubClient','Ultrasonic','OneWire','DallasTemperature','Adafruit_BMP280','SoftwareSerial',
  'HardwareSerial','Ticker','IRrecv','TFT_eSPI','ArduinoJson','File'];

function cleanArgs(a){
  return a.split(',').map(s=>s.trim()).filter(Boolean).map(s=>{
    if(s === 'void') return null;
    const m = /^[\s\S]*?([A-Za-z_]\w*)\s*(\[\s*\])?\s*(=[\s\S]*)?$/.exec(s);
    if(!m) return s;
    return m[1] + (m[3] ? ' ' + m[3].trim() : '');
  }).filter(Boolean).join(', ');
}

function convFields(s, names){
  s = s.replace(/\b(?:public|private|protected)\s*:\s*/g, '');
  s = s.replace(new RegExp(`(?:virtual\\s+)?${TYPES}\\s+\\*?\\s*(\\w+)\\s*\\([^()]*\\)\\s*(?:const\\s*)?;`, 'g'), '');
  s = s.replace(new RegExp(`${TYPES}\\s+\\*?\\s*(\\w+)\\s*=\\s*`, 'g'), (m,n)=>{ names&&names.push(n); return n + ' = '; });
  s = s.replace(new RegExp(`(${TYPES})\\s+\\*?\\s*(\\w+)\\s*(?:\\[[^\\]]*\\])?\\s*;`, 'g'),
    (m,ty,n)=>{ names&&names.push(n); return n + ' = ' + (/String|char/.test(ty) ? '""' : '0') + ';'; });
  return s;
}

function processClassBody(cls, body){
  const parts = []; let cur = '', depth = 0;
  for(let i=0;i<body.length;i++){
    const ch = body[i];
    if(ch === '{'){
      if(depth === 0){ parts.push({sig:cur, block:null}); cur = ''; }
      depth++; cur += ch;
    } else if(ch === '}'){
      depth--; cur += ch;
      if(depth === 0){ parts[parts.length-1].block = cur; cur = ''; }
    } else cur += ch;
  }
  if(cur.trim()) parts.push({sig:cur, block:null});

  const methods = [], fields = [];
  for(const p of parts){
    if(p.block === null) continue;
    const m = /([A-Za-z_~]\w*)\s*\(([^()]*)\)\s*$/.exec(p.sig);
    if(m) methods.push(m[1].replace('~',''));
  }

  let out = '';
  for(let i=0;i<parts.length;i++){
    const p = parts[i];
    if(p.block === null){ out += convFields(p.sig, fields); continue; }

    const m = /([A-Za-z_~]\w*)\s*\(([^()]*)\)\s*$/.exec(p.sig);
    let isCtor = false, head = p.sig;
    if(m){
      head = p.sig.slice(0, m.index);
      const fname = m[1].replace('~','');
      isCtor = (fname === cls);
      out += convFields(head, fields) + (isCtor
        ? 'constructor(' + cleanArgs(m[2]) + ') '
        : 'async ' + fname + '(' + cleanArgs(m[2]) + ') ');
    } else {
      out += convFields(head, fields);
    }

    let block = p.block;
    if(methods.length){
      const re = new RegExp(`(?<![\\w.$])(${methods.map(x=>x.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')).join('|')})\\s*\\(`, 'g');
      block = block.replace(re, 'this.$1(');
    }
    if(fields.length){
      const re = new RegExp(`(?<![\\w.$])(${fields.map(x=>x.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')).join('|')})\\b(?!\\s*\\()`, 'g');
      block = block.replace(re, 'this.$1');
    }
    if(!isCtor) block = block.replace(/\bthis\.(\w+)\s*\(/g, 'await this.$1(');
    out += block;
  }
  return out;
}

function transformClasses(code, classNames){
  const re = /\b(class|struct)\s+(\w+)\s*(?::[^{;]*)?\{/g;
  const found = []; let m;
  while((m = re.exec(code))){
    const bodyStart = m.index + m[0].length;
    let depth = 1, j = bodyStart;
    while(j < code.length && depth > 0){
      const ch = code[j];
      if(ch === '{') depth++; else if(ch === '}') depth--;
      j++;
    }
    found.push({start:m.index, end:j, name:m[2], body:code.slice(bodyStart, j-1)});
    re.lastIndex = j;
  }
  for(let k = found.length-1; k >= 0; k--){
    const f = found[k];
    classNames.push(f.name);
    code = code.slice(0, f.start) + 'class ' + f.name + ' {\n' + processClassBody(f.name, f.body) + '\n}\n'
         + code.slice(f.end).replace(/^\s*;/, '');
  }
  return code;
}

function transpile(src){
  const strs = [];
  let c = src.replace(/"(?:\\.|[^"\\])*"|'(?:\\.|[^'\\])*'/g, m => {
    strs.push(m); return '\u0000' + (strs.length-1) + '\u0000';
  });
  const unstr = s => s.replace(/\u0000(\d+)\u0000/g, (m,i)=>strs[+i]);

  c = c.replace(/\/\*[\s\S]*?\*\//g, '').replace(/\/\/[^\n]*/g, '');

  c = c.replace(/^\s*#\s*include[^\n]*$/gm, '');
  c = c.replace(/^\s*#\s*define\s+(\w+)\s*\(([^)]*)\)\s*([^\n]*)$/gm,
      (m,n,a,b)=>`const ${n} = (${cleanArgs(a)}) => (${b.trim()});`);
  c = c.replace(/^\s*#\s*define\s+(\w+)\s*([^\n]*)$/gm,
      (m,n,v)=> v.trim() ? `const ${n} = ${v.trim()};` : `const ${n} = 1;`);
  c = c.replace(/^\s*#\s*(?:if|ifdef|ifndef|else|elif|endif|pragma|undef|error|warning|line)[^\n]*$/gm, '');

  c = c.replace(/\benum\s+\w*\s*\{([^}]*)\}\s*;?/g, (m, body)=>{
    let i = 0, out = [];
    body.split(',').forEach(p=>{
      p = p.trim(); if(!p) return;
      const eq = p.indexOf('=');
      if(eq >= 0){
        const k = p.slice(0,eq).trim(), v = p.slice(eq+1).trim();
        out.push(`const ${k} = ${v};`); i = (parseInt(v,10)||0) + 1;
      } else { out.push(`const ${k=p} = ${i};`); i++; }
    });
    return out.join('\n');
  });

  const classNames = [];
  c = transformClasses(c, classNames);

  c = c.replace(/\b(?:volatile|static|extern|inline|constexpr|PROGMEM|IRAM_ATTR|ICACHE_RAM_ATTR)\b\s*/g, '');
  c = c.replace(/\bconst\s+(?=[A-Za-z_])/g, '');

  const fns = [];
  const fnRe = new RegExp(`^([ \\t]*)(?:void|${TYPES})\\s+\\*?\\s*(\\w+)\\s*\\(([^;{]*)\\)\\s*\\{`, 'gm');
  c = c.replace(fnRe, (m, ind, name, args)=>{
    if(name === 'if' || name === 'for' || name === 'while' || name === 'switch' || name === 'catch') return m;
    fns.push(name);
    return ind + 'async function ' + name + '(' + cleanArgs(args) + '){';
  });

  const allClasses = [...new Set([...LIB_CLASSES, ...classNames])];
  if(allClasses.length){
    const N = allClasses.map(x=>x.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')).join('|');
    c = c.replace(new RegExp(`\\b(${N})\\s+(\\w+)\\s*\\(([^;()]*)\\)\\s*;`, 'g'), 'let $2 = new $1($3);');
    c = c.replace(new RegExp(`\\b(${N})\\s+(\\w+)\\s*;`, 'g'), 'let $2 = new $1();');
    c = c.replace(new RegExp(`\\b(${N})\\s+(\\w+)\\s*=`, 'g'), 'let $2 =');
  }

  c = c.replace(new RegExp(`\\b${TYPES}\\b\\s*\\*?\\s*&?\\s*(?=[A-Za-z_]\\w*\\s*(?:=|;|,|\\[|\\)))`, 'g'), 'let ');
  c = c.replace(/^\s*([A-Z][A-Za-z_0-9]*)\s+([A-Za-z_]\w*)\s*=/gm, 'let $2 =');

  c = c.replace(/let (\w+)\s*\[[^\]]*\]\s*=\s*\{([^}]*)\}/g, 'let $1 = [$2]');
  c = c.replace(/let (\w+)\s*\[\s*(\d*)\s*\]\s*;/g, 'let $1 = [];');

  c = c.replace(/\bfor\s*\(\s*(?:auto|int|const\s+auto|const)\s*&?\s*(\w+)\s*:\s*([^)]+)\)/g, 'for (let $1 of $2)');

  c = c.replace(/\((?:int|long|byte|uint\d+_t|int\d+_t)\)\s*/g, '~~');
  c = c.replace(/\((?:float|double)\)\s*/g, '');

  c = c.replace(/\bnullptr\b|\bNULL\b/g, 'null');
  c = c.replace(/->/g, '.').replace(/::/g, '.');
  c = c.replace(/\bF\s*\(/g, '(');
  c = c.replace(/\.length\(\)/g, '.length');
  c = c.replace(/(\w+)\.toInt\(\)/g, 'parseInt($1)');
  c = c.replace(/(\w+)\.toFloat\(\)/g, 'parseFloat($1)');
  c = c.replace(/(\w+)\.equals\(/g, '($1 == ');
  c = c.replace(/(?<=[(,]\s*)&(?=[A-Za-z_])/g, '');

  c = c.replace(/\bfor\s*\(\s*;\s*;\s*\)/g, 'for (;;await tick())');
  c = c.replace(/\bwhile\s*\(/g, 'while (await tick(),');

  if(fns.length){
    const N = [...new Set(fns)].map(x=>x.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')).join('|');
    c = c.replace(new RegExp(`(?<!function\\s)(?<![\\w.$])(${N})\\s*\\(`, 'g'), 'await $1(');
  }
  c = c.replace(/\bWiFi\.scanNetworks\s*\(/g, 'await WiFi.scanNetworks(');
  c = c.replace(/\bdelay\s*\(/g, 'await delay(');
  c = c.replace(/\bdelayMicroseconds\s*\(/g, 'await delayMicroseconds(');
  c = c.replace(/(?<![\w.$])yield\s*\(/g, 'await yieldFn(');

  c = unstr(c);
  return new AsyncFunction('env', 'with(env){' + c + '\nreturn {setup: typeof setup==="function"?setup:null, loop: typeof loop==="function"?loop:null};}');
}

/* ==========================================================================
   5. MÔI TRƯỜNG CHẠY
   ========================================================================== */
let B, pv = {}, pm = {}, pw = {}, irq = {}, ledc = {};
let run = false, tok = 0, wifi = {on:false, ip:'0.0.0.0'}, rx = [], sb = '', t0 = Date.now(), loops = 0;
let speed = 1, btn0 = 1, hist = new Array(120).fill(0), plotData = [];

const log = (m, c='') => {
  const d = document.createElement('div');
  d.className = c; d.textContent = m;
  const s = $('ser');
  s.appendChild(d);
  if(s.children.length > 400) s.firstChild.remove();
  s.scrollTop = 1e9;
  if(!c || c === '' || c === 'tx') pushPlot(m);
};
const netLog = m => {
  const d = document.createElement('div');
  d.textContent = '› ' + m;
  const n = $('netlog');
  n.appendChild(d);
  if(n.children.length > 60) n.firstChild.remove();
  n.scrollTop = 1e9;
};

function pushPlot(line){
  const nums = (line.match(/-?\d+(?:\.\d+)?/g) || []).map(Number);
  if(!nums.length) return;
  plotData.push(nums);
  if(plotData.length > 300) plotData.shift();
}

function wait(ms){
  const t = tok;
  const real = ms / speed;
  return new Promise((res, rej) => setTimeout(() => (t === tok && run) ? res() : rej(STOP), Math.max(real, 0)));
}
const tick = () => (++loops % 200) ? Promise.resolve() : new Promise(r=>setTimeout(r));

function makeEnv(){
  const M = {};
  Object.getOwnPropertyNames(Math).forEach(k => { if(typeof Math[k] === 'function') M[k] = Math[k]; });

  const fmt = (v, f) => {
    if(typeof v === 'number'){
      if(f === undefined) return Number.isInteger(v) ? String(v) : String(+v.toFixed(2));
      if(f === 16) return (Math.trunc(v) >>> 0).toString(16).toUpperCase();
      if(f === 10) return String(Math.trunc(v));
      if(f === 2) return (Math.trunc(v) >>> 0).toString(2);
      if(f === 8) return (Math.trunc(v) >>> 0).toString(8);
      return v.toFixed(f);
    }
    return String(v);
  };
  const flush = () => { if(sb){ log(sb); sb = ''; } };

  const setPinVal = (p, v) => {
    if(pm[p] === 1){ pv[p] = v ? 1 : 0; delete pw[p]; upd(p); }
  };
  const pwmWrite = (p, d, max) => {
    pw[p] = Math.max(0, Math.min(1, d / max));
    pv[p] = d > 0 ? 1 : 0;
    upd(p);
  };

  const env = {
    ...M,
    ...B.alias,
    HIGH:1, LOW:0, OUTPUT:1, INPUT:0, INPUT_PULLUP:2, INPUT_PULLDOWN:3,
    RISING:1, FALLING:2, CHANGE:3, ONHIGH:1, ONLOW:0,
    HEX:16, DEC:10, BIN:2, OCT:8,
    PI:Math.PI, TWO_PI:Math.PI*2, HALF_PI:Math.PI/2, M_PI:Math.PI,
    DEG_TO_RAD:Math.PI/180, RAD_TO_DEG:180/Math.PI,
    WIFI_STA:1, WIFI_AP:2, WIFI_AP_STA:3, WIFI_OFF:0,
    WL_CONNECTED:3, WL_DISCONNECTED:6, WL_IDLE_STATUS:0, WL_NO_SSID_AVAIL:1,
    ESP_OK:0, ESP_FAIL:-1,
    DHT11:11, DHT21:21, DHT22:22,
    NEO_GRB:0x52, NEO_RGB:0x06, NEO_KHZ800:0x0000, NEO_KHZ400:0x0400,
    SSD1306_SWITCHCAPVCC:0x02, SSD1306_EXTERNALVCC:0x01,
    SSD1306_WHITE:1, SSD1306_BLACK:0, SSD1306_INVERSE:2,
    WHITE:1, BLACK:0,
    A0:B.alias.A0 ?? 36, A1:37, A2:38, A3:B.alias.A3 ?? 39,
    A4:B.alias.A4 ?? 32, A5:B.alias.A5 ?? 33,
    T0:B.alias.T0 ?? 4, T1:B.alias.T1 ?? 0, T2:B.alias.T2 ?? 2,
    LED_BUILTIN:B.alias.LED_BUILTIN ?? 2,
    LED_RED:B.alias.LED_BUILTIN ?? 2, LED_BLUE:B.alias.LED_BLUE ?? 2,

    pinMode:(p, m) => { pm[p] = m; if(m === 2 && pv[p] === undefined) pv[p] = 1; upd(p); },
    digitalWrite: setPinVal,
    digitalRead: p => pv[p] ?? (pm[p] === 2 ? 1 : 0),
    analogWrite:(p, v) => pwmWrite(p, v, B.pwmMax),
    dacWrite:(p, v) => pwmWrite(p, v, 255),
    analogRead: p => {
      let v = dev.adc;
      if(dev.noise) v += (Math.random()-0.5) * B.adcMax * 0.02;
      return Math.max(0, Math.min(B.adcMax, Math.round(v)));
    },
    analogReadResolution:() => {},
    analogWriteResolution:() => {},
    analogSetAttenuation:() => {},
    touchRead: p => {
      if(!B.touch) return 0;
      if(dev.touchHold) return 10 + Math.floor(Math.random()*15);
      const idx = B.pins.indexOf(p);
      return dev.touch[(idx < 0 ? 0 : idx) % dev.touch.length] + Math.floor(Math.random()*6);
    },
    touchAttachInterrupt:() => {}, touchDetachInterrupt:() => {},
    hallRead:() => Math.floor(Math.random()*20) - 10,
    temperatureRead:() => 40 + Math.random()*3,
    pulseIn:(p, state, t) => dev.dist * 58 + Math.floor(Math.random()*20),
    pulseInLong:(p, state, t) => dev.dist * 58,

    ledcSetup:(ch, f, bits) => { ledc[ch] = {bits:bits, freq:f}; return f; },
    ledcAttachPin:(p, ch) => { (ledc[ch] = ledc[ch] || {bits:8}).pin = p; pm[p] = 1; },
    ledcAttach:(p, f, bits) => { ledc[p] = {pin:p, bits:bits}; pm[p] = 1; return true; },
    ledcWrite:(ch, d) => { const l = ledc[ch] || {pin:ch, bits:8}; pwmWrite(l.pin ?? ch, d, Math.pow(2, l.bits) - 1); },
    ledcWriteTone:(ch, f) => { if(f) tone(ch, f); else noTone(ch); },
    ledcDetachPin: p => { delete ledc[p]; },
    ledcFade:() => {},

    delay: wait,
    delayMicroseconds: us => wait(us/1000),
    yieldFn: () => wait(0),
    millis: () => Date.now() - t0,
    micros: () => (Date.now() - t0) * 1000,
    tick,

    random:(a, b) => b === undefined ? Math.floor(Math.random()*a) : a + Math.floor(Math.random()*(b-a)),
    randomSeed:() => {},
    map:(x,a,b,c,d) => Math.trunc((x-a)*(d-c)/(b-a)+c),
    constrain:(x,a,b) => Math.min(b, Math.max(a, x)),
    sq: x => x*x, abs: Math.abs, min: Math.min, max: Math.max,
    bitRead:(x,n) => (x >> n) & 1,
    bitSet:(x,n) => x | (1<<n),
    bitClear:(x,n) => x & ~(1<<n),
    bitWrite:(x,n,b) => b ? (x | (1<<n)) : (x & ~(1<<n)),
    _BV:n => 1 << n,
    lowByte: x => x & 255, highByte: x => (x >> 8) & 255,
    makeWord:(h,l) => (h << 8) | l,
    isDigit: c => /\d/.test(String.fromCharCode(c)),
    isAlpha: c => /[a-zA-Z]/.test(String.fromCharCode(c)),
    isSpace: c => /\s/.test(String.fromCharCode(c)),
    strcmp:(a,b) => String(a) === String(b) ? 0 : 1,
    strlen: s => String(s).length,
    atoi: s => parseInt(s, 10) || 0,
    atof: s => parseFloat(s) || 0,
    dtostrf:(v, w, p) => Number(v).toFixed(p||2),
    sprintf:(buf, f, ...a) => cformat(f, a),
    snprintf:(buf, n, f, ...a) => cformat(f, a),
    F: x => x,

    attachInterrupt:(p, fn, m) => { irq[p] = {fn, m}; log('attachInterrupt GPIO' + p, 'sys'); },
    detachInterrupt: p => { delete irq[p]; },
    digitalPinToInterrupt: p => p,
    interrupts:() => {}, noInterrupts:() => {},

    Serial:{
      begin: b => log('Serial @ ' + b + ' baud', 'sys'),
      print:(v, f) => { sb += fmt(v, f); },
      println:(v = '', f) => { sb += fmt(v, f); flush(); },
      printf:(f, ...a) => {
        sb += cformat(f, a);
        if(sb.endsWith('\n')){ sb = sb.slice(0, -1); flush(); }
      },
      write:(...a) => { a.forEach(x => { if(typeof x === 'number') sb += String.fromCharCode(x); else sb += String(x); }); },
      available:() => rx.length,
      read:() => rx.length ? rx.shift().charCodeAt(0) : -1,
      peek:() => rx.length ? rx[0].charCodeAt(0) : -1,
      readString:() => { const s = rx.join('').trim(); rx = []; return s; },
      readStringUntil:() => { const s = rx.join(''); rx = []; return s; },
      parseInt:() => { const s = rx.join('').trim(); rx = []; return parseInt(s,10) || 0; },
      flush:() => {}, setTimeout:() => {}, end:() => {}, availableForWrite:() => 128
    },

    Wire:{
      _a:0, begin:() => {}, setClock:() => {}, setTimeOut:() => {},
      beginTransmission(a){ this._a = a; },
      endTransmission(){ return dev.i2c.has(this._a) ? 0 : 2; },
      requestFrom:(a,n) => dev.i2c.has(a) ? (n||1) : 0,
      write:() => 1, available:() => 0, read:() => 0, end:() => {}
    },

    SPI:{ begin:() => {}, end:() => {}, transfer: v => v, setFrequency:() => {}, setDataMode:() => {} },

    EEPROM:{
      begin:(n) => {},
      read: a => dev.eeprom[a] || 0,
      write:(a, v) => { dev.eeprom[a] = v & 255; },
      update:(a, v) => { dev.eeprom[a] = v & 255; },
      put:(a, s, len) => { s = String(s); for(let i=0;i<len;i++) dev.eeprom[a+i] = i < s.length ? s.charCodeAt(i) : 0; },
      get:(a, len) => { let s = ''; for(let i=0;i<len;i++){ const c = dev.eeprom[a+i]; if(c) s += String.fromCharCode(c); } return s; },
      commit:() => true, end:() => true, length:() => dev.eeprom.length
    },

    LittleFS:{
      begin:() => true, format:() => { dev.fs = {}; return true; },
      exists: p => dev.fs[p] !== undefined,
      open:(p, mode) => new FileSim(p),
      remove: p => { delete dev.fs[p]; return true; },
      mkdir:() => true, rename:() => true
    },
    SPIFFS:{
      begin:() => true, format:() => { dev.fs = {}; return true; },
      exists: p => dev.fs[p] !== undefined,
      open:(p, mode) => new FileSim(p),
      remove: p => { delete dev.fs[p]; return true; }
    },

    WiFi:{
      mode:() => {},
      disconnect:() => { wifi = {on:false, ip:'0.0.0.0'}; ui(); },
      begin:(ssid, pass) => {
        if(ssid) log('Đang kết nối "' + ssid + '"…', 'sys');
        const t = tok;
        setTimeout(() => {
          if(t === tok){ wifi = {on:true, ip:'192.168.1.' + (100 + Math.floor(Math.random()*60))}; ui(); log('WiFi OK → ' + wifi.ip, 'sys'); }
        }, 1500 / speed);
        return 3;
      },
      scanNetworks: async () => { await wait(1000); return NETS.length; },
      SSID: i => (NETS[i] || [])[0] || '',
      RSSI: i => (NETS[i] || [])[1] || 0,
      channel: i => (NETS[i] || [])[2] || 1,
      encryptionType: i => (NETS[i] || [])[3] || 'WPA2',
      status:() => wifi.on ? 3 : 6,
      localIP:() => wifi.ip,
      gatewayIP:() => '192.168.1.1',
      subnetMask:() => '255.255.255.0',
      macAddress:() => '24:6F:28:AA:BB:CC',
      RSSI_AP:() => -50,
      softAP: s => { wifi = {on:true, ip:'192.168.4.1'}; ui(); log('AP: ' + s, 'sys'); return true; },
      setAutoReconnect:() => {}, setSleep:() => {}, hostname:() => 'esp-emulator',
      client:() => new WiFiClientSim(),
      macAddress_AP:() => '24:6F:28:AA:BB:CC'
    },

    ESP:{
      getFreeHeap:() => B.heap - Math.floor(Math.random()*3000),
      getHeapSize:() => B.heap,
      getChipId:() => 0x5CCF7F,
      getFlashChipSize:() => 4194304,
      getChipModel:() => B.name,
      getChipRevision:() => 1,
      getCpuFreqMHz:() => B.mhz,
      getSdkVersion:() => 'emulator-1.0',
      restart:() => { log('↻ Khởi động lại…', 'sys'); setTimeout(() => { if(run) runSketch(); }, 400); throw STOP; },
      deepSleep: us => { log('😴 Deep sleep ' + (us/1e6).toFixed(2) + 's', 'sys'); throw STOP; },
      deepSleepEnable:() => {},
      lightSleep: us => wait(us/1000)
    },
    esp_sleep_enable_timer_wakeup: us => {},
    esp_deep_sleep_start:() => { log('😴 Deep sleep', 'sys'); throw STOP; },
    esp_restart:() => { throw STOP; },
    esp_get_free_heap_size:() => B.heap - 4096,

    xTaskCreate:(fn, name, stack, param, prio, handle) => { log('Tạo task: ' + name, 'sys'); return 1; },
    vTaskDelay: ms => wait(ms),
    xTaskGetTickCount:() => Math.floor((Date.now()-t0)/1000*1000),
    pdMS_TO_TICKS: ms => Math.round(ms),

    tone:(p, f, d) => tone(p, f, d),
    noTone: p => noTone(p),

    Adafruit_NeoPixel:NeoPixelSim,
    Servo:ServoSim,
    ESP32Servo:ServoSim,
    DHT:DHTSim,
    Adafruit_SSD1306:OLEDSim,
    Adafruit_GFX:OLEDSim,
    LiquidCrystal_I2C:LCDSim,
    Preferences:PreferencesSim,
    File:FileSim,
    HTTPClient:HTTPClientSim,
    WiFiClient:WiFiClientSim,
    WebServer:WebServerSim,
    PubSubClient:PubSubClientSim,
    Ultrasonic:UltrasonicSim,
    LittleFS_File:FileSim
  };

  env.WiFiClient = WiFiClientSim;
  env.HTTPClient = HTTPClientSim;
  env.WebServer = WebServerSim;

  return env;
}

/* ==========================================================================
   6. ÂM THANH
   ========================================================================== */
let actx = null;
function tone(pin, freq, dur){
  try{
    if(dev.mute) return;
    actx = actx || new (window.AudioContext || window.webkitAudioContext)();
    if(dev.toneOsc){ try{ dev.toneOsc.stop(); }catch(e){} }
    const o = actx.createOscillator(), g = actx.createGain();
    o.type = 'square'; o.frequency.value = freq;
    g.gain.value = 0.025;
    o.connect(g); g.connect(actx.destination); o.start();
    dev.toneOsc = o; dev.tone = {pin, freq};
    if(dur) setTimeout(() => { try{ o.stop(); }catch(e){} }, dur);
  }catch(e){}
}
function noTone(pin){
  if(dev.toneOsc){ try{ dev.toneOsc.stop(); }catch(e){} dev.toneOsc = null; }
  dev.tone = null;
}

/* ==========================================================================
   7. VẼ GIAO DIỆN THIẾT BỊ
   ========================================================================== */
function pinLabel(p){
  const a = Object.entries(B.alias).find(([k,v]) => v === p && /^D\d$/.test(k));
  return a ? a[0] : '';
}
function buildPins(){
  $('pins').innerHTML = B.pins.map(p =>
    `<div class="pin" id="p${p}" onclick="togglePin(${p})">
       <small>GPIO${p}${pinLabel(p) ? ' · ' + pinLabel(p) : ''}</small>
       <b>0</b><small>IN</small>
     </div>`).join('');
  const L = B.name === 'ESP32' ? [2,4,5,18] : [2,4,16];
  $('leds').innerHTML = L.map(p => `<div class="led"><i id="l${p}"></i>GPIO${p}</div>`).join('');
  B.leds = L;
}
function upd(p){
  const e = $('p' + p); if(!e) return;
  const v = pv[p] ?? (pm[p] === 2 ? 1 : 0);
  e.className = 'pin' + (pw[p] !== undefined ? ' pw' : v ? ' hi' : '');
  e.children[1].textContent = v;
  e.children[2].textContent = pw[p] !== undefined ? 'PWM ' + Math.round(pw[p]*100) + '%'
    : pm[p] === 1 ? 'OUT' : pm[p] === 2 ? 'IN↑' : 'IN';
  const l = $('l' + p);
  if(l){
    const b = pw[p] !== undefined ? pw[p] : v;
    l.style.background = b ? '#35e0a1' : '#2a3550';
    l.style.opacity = b ? 0.3 + 0.7*b : 1;
    l.style.boxShadow = b ? '0 0 ' + (14*b) + 'px #35e0a1' : 'none';
  }
}
window.togglePin = function(p){
  if(pm[p] === 1) return;
  const old = pv[p] ?? (pm[p] === 2 ? 1 : 0);
  const nv = old ? 0 : 1;
  pv[p] = nv; upd(p);
  const i = irq[p];
  if(i && (i.m === 3 || (i.m === 2 && old && !nv) || (i.m === 1 && !old && nv))){
    Promise.resolve().then(() => i.fn()).catch(e => log('ISR: ' + e.message, 'err'));
  }
};

function renderPixels(){
  const cv = $('npcv'); if(!cv) return;
  const n = dev.np.n;
  if(cv.width !== Math.max(320, n*30)) cv.width = Math.max(320, n*30);
  const ctx = cv.getContext('2d');
  ctx.clearRect(0, 0, cv.width, cv.height);
  if(!n){ ctx.fillStyle = '#1a2233'; ctx.font = '12px system-ui'; ctx.fillText('Chưa có NeoPixel nào', 12, 34); return; }
  const step = cv.width / n;
  for(let i=0;i<n;i++){
    const c = dev.np.buf[i] || 0;
    const b = dev.np.bright;
    const r = Math.round(((c>>16)&255) * b), g = Math.round(((c>>8)&255) * b), bl = Math.round((c&255) * b);
    const x = i*step + step/2, y = 30;
    ctx.beginPath(); ctx.arc(x, y, 11, 0, Math.PI*2);
    ctx.fillStyle = (r||g||bl) ? `rgb(${r},${g},${bl})` : '#222c40';
    if(r||g||bl){ ctx.shadowColor = `rgb(${r},${g},${bl})`; ctx.shadowBlur = 18; }
    ctx.fill(); ctx.shadowBlur = 0;
    ctx.fillStyle = '#3b4a66'; ctx.font = '9px monospace'; ctx.textAlign = 'center';
    ctx.fillText(i, x, 55);
  }
  ctx.textAlign = 'left';
}

function renderServos(){
  const cv = $('svcv'); if(!cv) return;
  const ctx = cv.getContext('2d');
  ctx.clearRect(0, 0, cv.width, cv.height);
  const pins = Object.keys(dev.servos);
  if(!pins.length){
    ctx.fillStyle = '#1a2233'; ctx.font = '12px system-ui';
    ctx.fillText('Chưa có Servo nào (dùng myServo.attach(pin))', 12, 58); return;
  }
  const w = cv.width / pins.length;
  pins.forEach((p, i) => {
    const cx = i*w + w/2, cy = 82, R = 42;
    const deg = dev.servos[p].deg;
    ctx.strokeStyle = '#2b3a55'; ctx.lineWidth = 2;
    ctx.beginPath(); ctx.arc(cx, cy, R, Math.PI, 0); ctx.stroke();
    for(let a=0;a<=180;a+=30){
      const rad = (180-a) * Math.PI/180;
      ctx.beginPath();
      ctx.moveTo(cx + Math.cos(rad)*(R-7), cy - Math.sin(rad)*(R-7));
      ctx.lineTo(cx + Math.cos(rad)*R, cy - Math.sin(rad)*R);
      ctx.strokeStyle = '#2b3a55'; ctx.stroke();
    }
    const rad = (180-deg) * Math.PI/180;
    ctx.beginPath(); ctx.moveTo(cx, cy);
    ctx.lineTo(cx + Math.cos(rad)*(R-4), cy - Math.sin(rad)*(R-4));
    ctx.strokeStyle = '#35e0a1'; ctx.lineWidth = 3; ctx.stroke();
    ctx.beginPath(); ctx.arc(cx, cy, 5, 0, Math.PI*2); ctx.fillStyle = '#35e0a1'; ctx.fill();
    ctx.fillStyle = '#8a99b5'; ctx.font = '11px monospace'; ctx.textAlign = 'center';
    ctx.fillText('GPIO' + p + ' · ' + Math.round(deg) + '°', cx, 102);
    ctx.textAlign = 'left';
  });
}

function renderOLED(){
  const o = dev.oled; if(!o) return;
  const cv = $('oledcv'); if(!cv) return;
  const ctx = cv.getContext('2d');
  ctx.imageSmoothingEnabled = false;
  ctx.clearRect(0, 0, cv.width, cv.height);
  ctx.drawImage(o.cv, 0, 0, cv.width, cv.height);
}

function renderLCD(){
  const l = dev.lcd; if(!l) return;
  const cv = $('lcdcv'); if(!cv) return;
  const ctx = cv.getContext('2d');
  const cw = 15, chh = 30;
  const W = l.cols*cw + 18, H = l.rows*chh + 14;
  if(cv.width !== W || cv.height !== H){ cv.width = W; cv.height = H; }
  ctx.fillStyle = l.on ? '#1b4d2e' : '#0d1f14';
  ctx.fillRect(0, 0, W, H);
  ctx.fillStyle = l.on ? '#9dffbe' : '#33513c';
  ctx.font = '19px ui-monospace,monospace';
  ctx.textBaseline = 'middle';
  for(let r=0;r<l.rows;r++)
    for(let c=0;c<l.cols;c++)
      ctx.fillText(l.buf[r][c] || ' ', 9 + c*cw, 7 + r*chh + chh/2);
}

function renderPlot(){
  const cv = $('plot'); if(!cv || cv.style.display === 'none') return;
  const ctx = cv.getContext('2d');
  const w = cv.width, h = cv.height;
  ctx.clearRect(0, 0, w, h);
  ctx.strokeStyle = '#16202f'; ctx.lineWidth = 1;
  for(let i=0;i<=4;i++){
    const y = h*i/4;
    ctx.beginPath(); ctx.moveTo(0,y); ctx.lineTo(w,y); ctx.stroke();
  }
  if(plotData.length < 2) return;
  const cols = Math.max(...plotData.map(r=>r.length));
  const all = plotData.flat();
  let mn = Math.min(...all), mx = Math.max(...all);
  if(mx - mn < 1e-6){ mx = mn + 1; }
  const colors = ['#35e0a1','#4da3ff','#ffd166','#ff5d6c','#b388ff'];
  for(let c=0;c<cols;c++){
    ctx.beginPath(); ctx.strokeStyle = colors[c % colors.length]; ctx.lineWidth = 2;
    let started = false;
    plotData.forEach((row, i) => {
      if(row[c] === undefined) return;
      const x = i/(plotData.length-1) * w;
      const y = h - 6 - (row[c]-mn)/(mx-mn) * (h-12);
      started ? ctx.lineTo(x,y) : (ctx.moveTo(x,y), started = true);
    });
    ctx.stroke();
  }
  ctx.fillStyle = '#8a99b5'; ctx.font = '10px monospace';
  ctx.fillText(mx.toFixed(1), 4, 12);
  ctx.fillText(mn.toFixed(1), 4, h-4);
}

function ui(){
  $('c-wifi').textContent = wifi.on ? 'ON' : 'OFF';
  $('c-wifi').style.color = wifi.on ? 'var(--ac)' : 'var(--mu)';
  $('c-ip').textContent = wifi.ip;
}

/* ==========================================================================
   8. VÒNG ĐỜI SKETCH
   ========================================================================== */
function resetState(){
  pv = {}; pm = {}; pw = {}; irq = {}; ledc = {};
  rx = []; sb = '';
  wifi = {on:false, ip:'0.0.0.0'};
  dev.np = {n:0, buf:[], bright:1};
  dev.servos = {};
  dev.oled = null; dev.lcd = null;
  dev.toneOsc = null;
  loops = 0;
  plotData = [];
  hist = new Array(120).fill(dev.adc);
  B.pins.forEach(upd);
  renderPixels(); renderServos(); renderLCD();
  const oc = $('oledcv').getContext('2d');
  oc.fillStyle = '#000'; oc.fillRect(0,0,384,192);
  $('npinfo').textContent = 'chưa dùng';
  $('netlog').innerHTML = '';
  ui();
}

async function runSketch(){
  tok++;
  const my = tok;
  run = false;
  await new Promise(r => setTimeout(r, 30));
  resetState();
  t0 = Date.now();
  run = true;
  setState();

  let api;
  try{
    api = await transpile($('src').value)(makeEnv());
  }catch(e){
    log('❌ Lỗi biên dịch: ' + e.message, 'err');
    run = false; setState(); return;
  }
  log('✔ Biên dịch OK → ' + B.name, 'sys');

  try{
    if(api.setup) await api.setup();
    while(run && my === tok){
      if(api.loop) await api.loop();
      await wait(0);
    }
  }catch(e){
    if(e !== STOP) log('❌ Lỗi runtime: ' + e.message, 'err');
  }
  if(my === tok){ run = false; setState(); }
}

function stopSketch(){
  tok++; run = false; setState();
  if(dev.toneOsc){ try{ dev.toneOsc.stop(); }catch(e){} dev.toneOsc = null; }
  log('■ Đã dừng', 'sys');
}
function setState(){
  $('state').textContent = run ? '● Đang chạy' : '● Dừng';
  $('state').style.color = run ? 'var(--ac)' : 'var(--mu)';
}

/* ==========================================================================
   9. EDITOR
   ========================================================================== */
function gutter(){
  const n = $('src').value.split('\n').length;
  $('gut').textContent = Array.from({length:n}, (_,i)=>i+1).join('\n');
}
function currentKey(){ return 'esp_src_' + B.name + '_' + $('slot').value; }
function saveSrc(){
  const k = 'esp_src_' + B.name;
  localStorage.setItem(k, $('src').value);
  localStorage.setItem(currentKey(), $('src').value);
}
function loadSrc(){
  return localStorage.getItem(currentKey())
      || localStorage.getItem('esp_src_' + B.name)
      || EX[0][2];
}

/* ==========================================================================
   10. KHỞI TẠO
   ========================================================================== */
function setBoard(k){
  if(B) saveSrc();
  tok++; run = false;
  B = BOARDS[k];
  localStorage.setItem('esp_board', k);
  $('board').value = k;
  buildPins();
  dev.adc = Math.round(B.adcMax/2);
  $('adc').max = B.adcMax;
  $('adc').value = dev.adc;
  $('c-cpu').textContent = B.mhz + ' MHz';
  $('tch').style.display = B.touch ? '' : 'none';
  hist = new Array(120).fill(dev.adc);
  $('src').value = loadSrc();
  gutter();
  resetState();
  setState();
}

/* dropdown ví dụ */
(function initEx(){
  const sel = $('ex');
  sel.innerHTML = '<option value="">— Chọn ví dụ —</option>' +
    EX.map(([k,name]) => `<option value="${k}">${name}</option>`).join('');
  sel.onchange = e => {
    const item = EX.find(x => x[0] === e.target.value);
    if(!item) return;
    $('src').value = item[2];
    gutter();
    saveSrc();
  };
})();

/* WiFi list */
$('wl').innerHTML = NETS.map(n =>
  `<div onclick="connectWifi('${n[0]}')"><span>📶 ${n[0]}</span>
   <span style="color:var(--mu)">${n[1]} dBm · ch ${n[2]} · ${n[3]}</span></div>`).join('');
window.connectWifi = s => {
  wifi = {on:true, ip:'192.168.1.100'}; ui();
  log('Kết nối thủ công: ' + s, 'sys');
};

/* I2C list */
$('i2clist').innerHTML = I2C_DEVICES.map(a =>
  `<label class="sw"><input type="checkbox" data-a="${a}" ${dev.i2c.has(a) ? 'checked' : ''}>
   0x${a.toString(16).toUpperCase()}</label>`).join('');
$('i2clist').onchange = e => {
  const a = +e.target.dataset.a;
  e.target.checked ? dev.i2c.add(a) : dev.i2c.delete(a);
};

/* Tabs phải */
$('rtabs').onclick = e => {
  const b = e.target.closest('button'); if(!b) return;
  [...$('rtabs').children].forEach(x => x.classList.toggle('on', x === b));
  document.querySelectorAll('.panel').forEach(p => p.classList.toggle('on', p.id === 'p-' + b.dataset.t));
};

/* Tabs serial */
let plotMode = false;
function setSerTab(plot){
  plotMode = plot;
  $('ser').style.display = plot ? 'none' : 'block';
  $('plot').style.display = plot ? 'block' : 'none';
  $('tabMon').classList.toggle('on', !plot);
  $('tabPlot').classList.toggle('on', plot);
  renderPlot();
}
$('tabMon').onclick = () => setSerTab(false);
$('tabPlot').onclick = () => setSerTab(true);
$('tabMon').classList.add('on');
$('tabMon').style.background = 'var(--ac)'; $('tabMon').style.color = '#04251a';
$('tabPlot').onclick = () => { setSerTab(true);
  $('tabPlot').style.background = 'var(--ac)'; $('tabPlot').style.color = '#04251a';
  $('tabMon').style.background = ''; $('tabMon').style.color = '';
};
$('tabMon').onclick = () => { setSerTab(false);
  $('tabMon').style.background = 'var(--ac)'; $('tabMon').style.color = '#04251a';
  $('tabPlot').style.background = ''; $('tabPlot').style.color = '';
};

/* Editor events */
$('src').addEventListener('input', () => { gutter(); saveSrc(); });
$('src').addEventListener('scroll', () => { $('gut').scrollTop = $('src').scrollTop; });
$('src').addEventListener('keydown', e => {
  if(e.key === 'Tab'){
    e.preventDefault();
    const t = e.target, s = t.selectionStart;
    t.setRangeText('  ', s, t.selectionEnd, 'end');
    t.dispatchEvent(new Event('input'));
  }
  if(e.key === 'Enter' && (e.ctrlKey || e.metaKey)){ e.preventDefault(); runSketch(); }
  if(e.key === 's' && (e.ctrlKey || e.metaKey)){ e.preventDefault(); saveSrc(); log('💾 Đã lưu', 'sys'); }
});

/* Controls */
$('run').onclick = runSketch;
$('stop').onclick = stopSketch;
$('board').onchange = e => setBoard(e.target.value);
$('save').onclick = () => { saveSrc(); log('💾 Đã lưu vào ' + $('slot').value.toUpperCase(), 'sys'); };
$('loadb').onclick = () => {
  const v = localStorage.getItem(currentKey());
  if(v){ $('src').value = v; gutter(); log('📂 Đã mở khe ' + $('slot').value.toUpperCase(), 'sys'); }
  else log('Khe trống', 'sys');
};
$('slot').onchange = () => { $('src').value = loadSrc(); gutter(); };
$('dl').onclick = () => {
  const blob = new Blob([$('src').value], {type:'text/plain'});
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = 'sketch_' + B.name + '.ino';
  a.click();
};
$('up').onclick = () => $('file').click();
$('file').onchange = e => {
  const f = e.target.files[0]; if(!f) return;
  const r = new FileReader();
  r.onload = () => { $('src').value = r.result; gutter(); saveSrc(); log('⬆ Đã nạp ' + f.name, 'sys'); };
  r.readAsText(f);
};
$('speed').oninput = e => {
  const v = +e.target.value;
  speed = [0.5, 1, 2, 5, 20][v];
  $('spd').textContent = 'delay ×' + speed;
};
$('help').onclick = () => $('modal').classList.add('on');
$('modal').onclick = e => { if(e.target.id === 'modal') $('modal').classList.remove('on'); };

/* ADC */
$('adc').oninput = e => { dev.adc = +e.target.value; };
$('rnd').onclick = () => { dev.adc = Math.floor(Math.random()*(B.adcMax+1)); $('adc').value = dev.adc; };
$('tch').onpointerdown = () => { dev.touchHold = true; };
$('tch').onpointerup = $('tch').onpointerleave = () => { dev.touchHold = false; };
$('noise').onclick = () => { $('ntc').checked = !$('ntc').checked; dev.noise = $('ntc').checked; };
$('ntc').onchange = e => { dev.noise = e.target.checked; };

/* Sensors */
$('s-t').oninput = e => { dev.dht.t = +e.target.value; $('v-t').textContent = dev.dht.t.toFixed(1) + ' °C'; };
$('s-h').oninput = e => { dev.dht.h = +e.target.value; $('v-h').textContent = dev.dht.h + ' %'; };
$('s-d').oninput = e => { dev.dist = +e.target.value; $('v-d').textContent = dev.dist + ' cm'; };
$('s-l').oninput = e => {
  dev.ldr = +e.target.value;
  $('v-l').textContent = dev.ldr + ' %';
  dev.adc = Math.round(dev.ldr/100 * B.adcMax);
  $('adc').value = dev.adc;
};
$('btn0').onpointerdown = () => { btn0 = 0; pv[0] = 0; upd(0); fireIrq(0, 1, 0); };
$('btn0').onpointerup = $('btn0').onpointerleave = () => { btn0 = 1; pv[0] = 1; upd(0); fireIrq(0, 0, 1); };
function fireIrq(p, old, nv){
  const i = irq[p];
  if(i && (i.m === 3 || (i.m === 2 && old && !nv) || (i.m === 1 && !old && nv))){
    Promise.resolve().then(() => i.fn()).catch(e => log('ISR: ' + e.message, 'err'));
  }
}
$('mute').onchange = e => { dev.mute = !e.target.checked; if(dev.mute) noTone(); };
$('wdis').onclick = () => { wifi = {on:false, ip:'0.0.0.0'}; ui(); log('Đã ngắt WiFi', 'sys'); };

/* Serial input */
const sendRx = () => {
  const v = $('rx').value; if(!v) return;
  rx.push(...(v + '\n'));
  log('> ' + v, 'tx');
  $('rx').value = '';
};
$('send').onclick = sendRx;
$('rx').onkeydown = e => { if(e.key === 'Enter') sendRx(); };

/* Vòng cập nhật */
setInterval(() => {
  let a = dev.adc;
  if(dev.noise) a += (Math.random()-0.5) * B.adcMax * 0.02;
  a = Math.max(0, Math.min(B.adcMax, a));
  hist.push(a); hist.shift();
  const c = $('cv'), x = c.getContext('2d'), w = c.width, h = c.height;
  x.clearRect(0, 0, w, h);
  x.strokeStyle = '#16202f';
  for(let i=0;i<=4;i++){ x.beginPath(); x.moveTo(0, h*i/4); x.lineTo(w, h*i/4); x.stroke(); }
  const grd = x.createLinearGradient(0, 0, 0, h);
  grd.addColorStop(0, 'rgba(53,224,161,.35)');
  grd.addColorStop(1, 'rgba(53,224,161,0)');
  x.beginPath();
  hist.forEach((v, i) => {
    const px = i/(hist.length-1) * w, py = h - 4 - (v/B.adcMax) * (h - 12);
    i ? x.lineTo(px, py) : x.moveTo(px, py);
  });
  x.strokeStyle = '#35e0a1'; x.lineWidth = 2; x.stroke();
  x.lineTo(w, h); x.lineTo(0, h); x.closePath(); x.fillStyle = grd; x.fill();
  $('adcv').textContent = Math.round(a) + ' / ' + B.adcMax + '  (' + (a/B.adcMax*100).toFixed(1) + '%)';

  const s = Math.floor((Date.now() - t0)/1000);
  $('c-up').textContent = run ? s + 's' : '0s';
  $('c-lp').textContent = loops > 9999 ? (loops/1000).toFixed(1) + 'k' : loops;
  $('c-heap').textContent = Math.round((B.heap - (run ? 4200 + Math.random()*2000 : 0))/1024) + ' KB';

  renderPlot();
}, 120);

/* Tài liệu */
$('docbody').innerHTML = `
<h4>GPIO</h4>
<p><code>pinMode</code> <code>digitalWrite</code> <code>digitalRead</code> <code>analogWrite</code>
<code>analogRead</code> <code>dacWrite</code> <code>tone</code> <code>noTone</code> <code>pulseIn</code>
<code>attachInterrupt</code> <code>detachInterrupt</code> <code>digitalPinToInterrupt</code>
<code>ledcSetup</code> <code>ledcAttachPin</code> <code>ledcAttach</code> <code>ledcWrite</code></p>
<h4>Thời gian</h4>
<p><code>delay</code> <code>delayMicroseconds</code> <code>millis</code> <code>micros</code> <code>yield</code></p>
<h4>Serial</h4>
<p><code>Serial.begin/print/println/printf/write/available/read/readString</code></p>
<h4>WiFi</h4>
<p><code>WiFi.begin</code> <code>WiFi.status</code> <code>WiFi.localIP</code> <code>WiFi.macAddress</code>
<code>WiFi.scanNetworks</code> <code>WiFi.SSID</code> <code>WiFi.RSSI</code> <code>WiFi.channel</code>
<code>WiFi.softAP</code> <code>WiFi.disconnect</code></p>
<h4>Thư viện mô phỏng</h4>
<p><code>Adafruit_NeoPixel</code> · <code>Servo</code> · <code>DHT</code> · <code>Adafruit_SSD1306</code> ·
<code>LiquidCrystal_I2C</code> · <code>Wire</code> · <code>SPI</code> · <code>EEPROM</code> ·
<code>Preferences</code> · <code>LittleFS</code> / <code>SPIFFS</code> · <code>HTTPClient</code> ·
<code>WiFiClient</code> · <code>WebServer</code> · <code>PubSubClient</code> · <code>Ultrasonic</code></p>
<h4>ESP</h4>
<p><code>ESP.getFreeHeap</code> <code>ESP.getChipModel</code> <code>ESP.getCpuFreqMHz</code>
<code>ESP.restart</code> <code>ESP.deepSleep</code> <code>esp_restart</code></p>
<h4>Lưu ý</h4>
<p>Mã được chuyển tự động sang JavaScript. Các hàm người dùng và phương thức lớp đều là
<code>async</code> nên <code>delay()</code> hoạt động đúng. Tránh vòng lặp vô hạn không có
<code>delay()</code> — trình mô phỏng đã tự chèn <code>tick()</code> cho <code>while</code> và
<code>for(;;)</code>.</p>
`;

/* Bắt đầu */
setBoard(localStorage.getItem('esp_board') || 'esp8266');
log('Sẵn sàng. Chọn board, chọn ví dụ rồi bấm ▶ Chạy (Ctrl+Enter).', 'sys');
renderPixels(); renderServos();
</script>
</body>
</html>
