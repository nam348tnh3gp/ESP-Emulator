<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ESP Emulator — Full ESP8266 &amp; ESP32</title>
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
main{display:grid;grid-template-columns:minmax(0,1.15fr) minmax(0,1fr);gap:14px;padding:14px 18px;max-width:1600px;margin:auto}
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
#ser,#ser1,#ser2{height:200px;overflow:auto;background:#080c15;border:1px solid var(--bd);border-radius:8px;
padding:8px 10px;font:12.5px/1.55 ui-monospace,Consolas,monospace;margin-bottom:8px}
#ser div,#ser1 div,#ser2 div{white-space:pre-wrap;color:#bdf5de}
#ser .sys,#ser1 .sys,#ser2 .sys{color:var(--mu)}
#ser .err,#ser1 .err,#ser2 .err{color:var(--er)}
#ser .tx,#ser1 .tx,#ser2 .tx{color:var(--bl)}
.row{display:flex;gap:7px}.row input{flex:1}
.tabs{display:flex;gap:5px;flex-wrap:wrap;margin-bottom:12px}
.tabs button{background:var(--p);border:1px solid var(--bd);border-radius:99px;padding:5px 14px;font-size:12.5px;color:var(--mu)}
.tabs button.on{background:var(--ac);color:#04251a;border-color:var(--ac);font-weight:700}
.panel{display:none}.panel.on{display:block}
.pins{display:grid;grid-template-columns:repeat(auto-fill,minmax(74px,1fr));gap:7px}
.pin{background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:6px 3px;text-align:center;
cursor:pointer;user-select:none;transition:.12s;position:relative}
.pin:hover{border-color:var(--ac)}.pin small{display:block;color:var(--mu);font-size:10px;line-height:1.3}
.pin b{font-size:16px;line-height:1.2}
.pin.hi{background:var(--ac);color:#04251a;border-color:var(--ac)}.pin.hi small{color:#06402c}
.pin.pw{border-color:var(--yl);color:var(--yl)}
.pin.ro::after{content:'RO';position:absolute;top:2px;right:3px;font-size:8px;color:var(--er)}
.pin.adc::before{content:'A';position:absolute;top:2px;left:3px;font-size:8px;color:var(--bl)}
.pin.tch::before{content:'T';position:absolute;top:2px;left:3px;font-size:8px;color:var(--pp)}
.leds{display:flex;gap:20px;justify-content:center;flex-wrap:wrap;margin-top:14px}
.led{text-align:center;font-size:11px;color:var(--mu)}
.led i{display:block;width:22px;height:22px;border-radius:50%;background:#2a3550;margin:0 auto 4px;transition:.1s}
canvas{display:block;max-width:100%}
.mono{font:12.5px/1.5 ui-monospace,Consolas,monospace}
input[type=range]{width:100%;margin:8px 0;accent-color:var(--ac)}
.wifi div{display:flex;justify-content:space-between;padding:6px 8px;border-bottom:1px solid var(--bd);cursor:pointer;font-size:13px}
.wifi div:hover{background:var(--p2)}
.kv{display:flex;justify-content:space-between;font-size:12.5px;padding:3px 0;border-bottom:1px dashed #1e2a40}
.kv span:last-child{color:var(--ac)}
label.sw{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--mu);cursor:pointer}
.doc{font-size:12.5px;color:var(--mu);line-height:1.7}
.doc code{background:#080c15;border:1px solid var(--bd);border-radius:4px;padding:1px 5px;color:#bdf5de}
.doc h4{color:var(--ac);font-size:12px;margin:10px 0 4px;letter-spacing:.05em}
.modal{position:fixed;inset:0;background:#000a;display:none;align-items:center;justify-content:center;z-index:60;padding:20px}
.modal.on{display:flex}
.modal .box{background:var(--p);border:1px solid var(--bd);border-radius:14px;padding:20px;max-width:720px;width:100%;max-height:80vh;overflow:auto}
.badge{font-size:10.5px;background:var(--p2);border:1px solid var(--bd);border-radius:6px;padding:1px 6px;color:var(--mu)}
.fslist{font:12.5px/1.7 ui-monospace,Consolas,monospace;max-height:220px;overflow:auto}
.fslist div{padding:3px 6px;border-bottom:1px solid #1a2438;cursor:pointer;display:flex;justify-content:space-between}
.fslist div:hover{background:var(--p2)}
.nvslist{font:12.5px/1.7 ui-monospace,Consolas,monospace;max-height:200px;overflow:auto}
.nvslist div{padding:3px 6px;border-bottom:1px solid #1a2438}
.mqtttopic{background:#080c15;border:1px solid var(--bd);border-radius:6px;padding:6px 8px;font:12px monospace;margin-bottom:4px}
.routes div{background:#080c15;border:1px solid var(--bd);border-radius:6px;padding:6px 8px;font:12px monospace;margin-bottom:4px;display:flex;justify-content:space-between;align-items:center}
</style>
</head>
<body>

<header>
  <h1>⚡ ESP<b>Emulator</b> <span class="badge">FULL</span></h1>
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
    <span class="chip">Tasks <b id="c-tk">0</b></span>
  </div>
</header>

<main>
<section>
  <div class="card">
    <h3>Sketch <span id="state" class="badge">● Dừng</span></h3>
    <div class="bar" style="margin-bottom:9px">
      <select id="ex" style="flex:1;min-width:180px"></select>
      <select id="slot" title="Khe lưu"><option value="a">Khe A</option><option value="b">Khe B</option><option value="c">Khe C</option></select>
      <button id="save" class="mini">💾</button>
      <button id="loadb" class="mini">📂</button>
      <button id="dl" class="mini">⬇</button>
      <button id="up" class="mini">⬆</button>
      <input type="file" id="file" accept=".ino,.cpp,.txt" hidden>
      <span class="badge" id="spd">delay ×1</span>
      <input type="range" id="speed" min="0" max="4" step="1" value="1" style="width:80px;margin:0">
    </div>
    <div class="ed"><pre id="gut">1</pre><textarea id="src" spellcheck="false"></textarea></div>
  </div>

  <div class="card">
    <h3>
      <span>Serial Monitor</span>
      <span class="bar">
        <select id="uport" style="padding:2px 8px;font-size:12px">
          <option value="ser">UART0</option>
          <option value="ser1">UART1</option>
          <option value="ser2">UART2</option>
        </select>
        <button class="mini" id="tabMon">Monitor</button>
        <button class="mini" id="tabPlot">Plotter</button>
        <button class="mini" onclick="clearSerial()">Xoá</button>
      </span>
    </h3>
    <div id="ser"></div>
    <div id="ser1" style="display:none"></div>
    <div id="ser2" style="display:none"></div>
    <canvas id="plot" width="600" height="180" style="display:none;width:100%;height:180px;background:#080c15;border:1px solid var(--bd);border-radius:8px;margin-bottom:8px"></canvas>
    <div class="row">
      <input type="text" id="rx" placeholder="Gửi dữ liệu tới UART đang chọn rồi Enter…">
      <button id="send">Gửi</button>
    </div>
  </div>
</section>

<section>
  <div class="tabs" id="rtabs">
    <button data-t="gpio" class="on">GPIO</button>
    <button data-t="adc">Analog</button>
    <button data-t="sens">Cảm biến</button>
    <button data-t="disp">Hiển thị</button>
    <button data-t="net">Mạng</button>
    <button data-t="svc">Dịch vụ</button>
    <button data-t="store">Bộ nhớ</button>
    <button data-t="doc">API</button>
  </div>

  <div class="panel on" id="p-gpio">
    <div class="card"><h3>GPIO <span class="badge">bấm để đảo mức chân INPUT</span></h3>
      <div class="pins" id="pins"></div>
      <div class="leds" id="leds"></div>
    </div>
  </div>

  <div class="panel" id="p-adc">
    <div class="card"><h3>ADC <span id="adcv"></span></h3>
      <canvas id="cv" width="400" height="110"></canvas>
      <input type="range" id="adc">
      <div class="bar">
        <label class="sw">Kênh <select id="adcpin" style="padding:2px 6px;font-size:12px"></select></label>
        <label class="sw">Atten <select id="atten" style="padding:2px 6px;font-size:12px">
          <option value="0">0 dB (1.1V)</option><option value="2" selected>6 dB (1.5V)</option>
          <option value="6">11 dB (3.3V)</option></select></label>
      </div>
      <div class="bar" style="margin-top:6px">
        <button id="rnd">🎲</button><button id="tch">👆 Touch</button><button id="noise">〰 Nhiễu</button>
        <label class="sw"><input type="checkbox" id="ntc"> Bật nhiễu</label>
      </div>
    </div>
    <div class="card"><h3>DAC <span class="badge" id="dacinfo">chưa dùng</span></h3>
      <canvas id="daccv" width="400" height="70"></canvas>
    </div>
  </div>

  <div class="panel" id="p-sens">
    <div class="card"><h3>Cảm biến</h3>
      <div class="kv"><span>🌡 DHT — Nhiệt độ</span><span id="v-t">28.4 °C</span></div>
      <input type="range" id="s-t" min="-10" max="60" step="0.1" value="28.4">
      <div class="kv"><span>💧 DHT — Độ ẩm</span><span id="v-h">64 %</span></div>
      <input type="range" id="s-h" min="0" max="100" step="1" value="64">
      <div class="kv"><span>📏 HC-SR04 — Khoảng cách</span><span id="v-d">25 cm</span></div>
      <input type="range" id="s-d" min="2" max="400" step="1" value="25">
      <div class="kv"><span>☀ LDR — Ánh sáng</span><span id="v-l">50 %</span></div>
      <input type="range" id="s-l" min="0" max="100" step="1" value="50">
      <div class="kv"><span>🔘 PIR — Chuyển động</span><span id="v-pir">0</span></div>
      <div class="kv"><span>🎤 Mic — Mức âm thanh</span><span id="v-mic">0</span></div>
      <input type="range" id="s-mic" min="0" max="100" step="1" value="0">
    </div>
    <div class="card"><h3>Nút &amp; Ngắt</h3>
      <div class="bar">
        <button id="btn0">🔘 GPIO0</button>
        <button id="btn-pir">🚶 PIR</button>
        <button id="btn-wake">⚡ Wake IRQ</button>
      </div>
      <div class="kv" style="margin-top:8px"><span>Số lần ngắt đã bắn</span><span id="v-irq">0</span></div>
    </div>
  </div>

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
    <div class="card"><h3>LCD I2C 16×2 <span class="badge" id="lcdinfo">chưa dùng</span></h3>
      <canvas id="lcdcv" style="background:#0d1f14;border:1px solid var(--bd);border-radius:8px"></canvas>
    </div>
  </div>

  <div class="panel" id="p-net">
    <div class="card"><h3>WiFi quét được</h3>
      <div class="wifi" id="wl"></div>
      <div class="bar" style="margin-top:10px">
        <button id="wdis">Ngắt WiFi</button>
        <button id="wscan">🔍 Quét</button>
        <label class="sw"><input type="checkbox" id="mute" checked> 🔊 Âm thanh</label>
      </div>
    </div>
    <div class="card"><h3>HTTP Client <span class="badge" id="httpidle">chờ</span></h3>
      <div id="netlog" class="mono" style="max-height:140px;overflow:auto;color:var(--mu)"></div>
      <div class="bar" style="margin-top:8px">
        <input type="text" id="httpurl" placeholder="http://..." style="flex:1;font-size:12px">
        <button class="mini" id="httpget">GET</button>
      </div>
    </div>
    <div class="card"><h3>WebServer</h3>
      <div class="routes" id="routes"><div style="opacity:.5">Chưa có server — gọi <code>server.on()</code> + <code>server.begin()</code></div></div>
      <div class="bar" style="margin-top:8px">
        <input type="text" id="reqpath" placeholder="/" style="flex:1;font-size:12px" value="/">
        <button class="mini" id="reqgo">Gửi request</button>
      </div>
    </div>
    <div class="card"><h3>MQTT Broker</h3>
      <div id="mqttlog" class="mono" style="max-height:120px;overflow:auto;color:var(--mu)"></div>
      <div class="bar" style="margin-top:8px">
        <input type="text" id="mqtttopic" placeholder="topic" style="width:110px;font-size:12px">
        <input type="text" id="mqttmsg" placeholder="message" style="flex:1;font-size:12px">
        <button class="mini" id="mqttpub">📤 Publish tới sketch</button>
      </div>
    </div>
  </div>

  <div class="panel" id="p-svc">
    <div class="card"><h3>BLE <span class="badge" id="bleinfo">chưa dùng</span></h3>
      <div id="blelist" class="mono" style="max-height:150px;overflow:auto"></div>
      <div class="bar" style="margin-top:8px">
        <button id="blescan">🔍 BLE Scan</button>
        <button id="bleadv">📡 Advertise</button>
      </div>
    </div>
    <div class="card"><h3>Timers / Ticker</h3>
      <div id="timers" class="mono" style="max-height:160px;overflow:auto"></div>
    </div>
    <div class="card"><h3>Tasks (FreeRTOS)</h3>
      <div id="tasks" class="mono" style="max-height:140px;overflow:auto"></div>
    </div>
    <div class="card"><h3>Bus I2C — thiết bị ảo</h3>
      <div id="i2clist" class="bar"></div>
    </div>
    <div class="card"><h3>OTA Update</h3>
      <div class="bar">
        <input type="text" id="otaurl" placeholder="http://..." style="flex:1;font-size:12px" value="http://firmware.local/esp.bin">
        <button class="mini" id="otago">⬆ OTA</button>
      </div>
      <div id="otalog" class="mono" style="margin-top:6px;color:var(--mu);font-size:12px"></div>
    </div>
  </div>

  <div class="panel" id="p-store">
    <div class="card"><h3>SPIFFS / LittleFS <span class="badge" id="fsinfo">0 tệp</span></h3>
      <div class="fslist" id="fslist"></div>
      <div class="bar" style="margin-top:8px">
        <input type="text" id="fspath" placeholder="/data.txt" style="flex:1;font-size:12px">
        <button class="mini" id="fsview">Xem</button>
        <button class="mini" id="fsdel">Xoá</button>
        <button class="mini" id="fsformat">Format</button>
      </div>
    </div>
    <div class="card"><h3>NVS / Preferences <span class="badge" id="nvsinfo">0 khóa</span></h3>
      <div class="nvslist" id="nvslist"></div>
      <div class="bar" style="margin-top:8px">
        <button class="mini" id="nvsformat">Xoá tất cả NVS</button>
      </div>
    </div>
    <div class="card"><h3>EEPROM <span class="badge">512 byte</span></h3>
      <div class="mono" id="eeplist" style="max-height:120px;overflow:auto;font-size:12px"></div>
    </div>
  </div>

  <div class="panel" id="p-doc">
    <div class="card"><h3>API đầy đủ</h3>
      <div class="doc" id="docbody"></div>
    </div>
  </div>
</section>
</main>

<div class="modal" id="modal"><div class="box">
  <h3 style="margin-bottom:10px">⚡ ESP Emulator FULL — Hướng dẫn</h3>
  <div class="doc">
    <p>Viết mã kiểu Arduino (C++) → bấm <b>▶ Chạy</b>. Trình biên dịch C++→JS chạy trong trình duyệt.</p>
    <h4>Phím tắt</h4>
    <p><code>Ctrl/⌘ + Enter</code> Chạy · <code>Tab</code> thụt lề · <code>Ctrl + S</code> Lưu</p>
    <h4>Khác biệt bản FULL</h4>
    <p>• UART0/1/2 độc lập · <code>Ticker</code>, <code>esp_timer</code><br>
    • WebServer với routing thật (gửi request được)<br>
    • MQTT broker ảo (publish từ UI → callback sketch)<br>
    • BLE scan/adv mô phỏng<br>
    • SPIFFS/LittleFS + NVS browser<br>
    • I2C slave thật (BME280, MPU6050, DS1307, SSD1306, PCF8574)<br>
    • NTP/RTC qua <code>getLocalTime()</code> · <code>configTime()</code><br>
    • Pin capability: chặn <code>pinMode</code> trên chân input-only, cảnh báo ADC/touch sai kênh<br>
    • DAC output hiển thị dạng sóng<br>
    • Compile error có <b>số dòng</b> thật</p>
    <h4>Giới hạn</h4>
    <p>Đây là mô phỏng logic. Không mô phỏng điện áp, timing tuyệt đối, hay đa luồng thật.</p>
  </div>
  <div class="bar" style="margin-top:16px"><button class="run" onclick="document.getElementById('modal').classList.remove('on')">Đã hiểu</button></div>
</div></div>

<script>
/* =========================================================================
   0. TIỆN ÍCH
   ========================================================================= */
const $ = id => document.getElementById(id);
const STOP = {stop:true};
const AsyncFunction = Object.getPrototypeOf(async function(){}).constructor;

/* =========================================================================
   1. BOARD
   ========================================================================= */
const BOARDS = {
  esp8266:{
    name:'ESP8266', mhz:160, heap:81920, adcMax:1023, pwmMax:1023, adcBits:10,
    pins:[0,1,2,3,4,5,12,13,14,15,16],
    alias:{D0:16,D1:5,D2:4,D3:0,D4:2,D5:14,D6:12,D7:13,D8:15,A0:17,SDA:4,SCL:5,
           LED_BUILTIN:2,LED_BLUE:2,BUILTIN_LED:2},
    cap:{ adc:[17], touch:[], dac:[], inputOnly:[] }
  },
  esp32:{
    name:'ESP32', mhz:240, heap:327680, adcMax:4095, pwmMax:255, adcBits:12,
    pins:[0,2,4,5,12,13,14,15,16,17,18,19,21,22,23,25,26,27,32,33,34,35,36,39],
    alias:{LED_BUILTIN:2,SDA:21,SCL:22,A0:36,A3:39,A4:32,A5:33,A6:34,A7:35,
           T0:4,T1:0,T2:2,T3:15,T4:13,T5:12,T6:14,T7:27,DAC1:25,DAC2:26,
           TRIG:5,ECHO:18,BUZZER:5},
    cap:{
      adc:[32,33,34,35,36,37,38,39],
      touch:[0,2,4,12,13,14,15,27,32,33],
      dac:[25,26],
      inputOnly:[34,35,36,37,38,39]
    }
  }
};

const NETS = [['ELECTRONICSTREE',-45,6,'WPA2'],['Viettel 5G',-58,1,'WPA2'],
              ['FPT Telecom',-55,1,'WPA2'],['iPhone 15',-48,6,'WPA3'],
              ['Free WiFi',-72,3,'mở']];

const I2C_DEVICES = [
  {a:0x3C,name:'SSD1306 OLED'},
  {a:0x27,name:'PCF8574 LCD'},
  {a:0x68,name:'MPU6050 IMU'},
  {a:0x76,name:'BME280 THP'},
  {a:0x23,name:'BH1750 LUX'},
  {a:0x48,name:'ADS1115 ADC'},
  {a:0x1E,name:'HMC5883 MAG'},
  {a:0x40,name:'INA219 PWR'}
];
const DEFAULT_I2C = new Set([0x3C,0x27,0x76]);

/* =========================================================================
   2. VÍ DỤ
   ========================================================================= */
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

['irq','⚡ Ngắt',`volatile int dem = 0;
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
  Serial.println("San sang - bam GPIO0");
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

['ticker','⏱ Ticker',`#include <Ticker.h>
Ticker timer;
int dem = 0;

void nhip() {
  dem++;
}

void setup() {
  Serial.begin(115200);
  timer.attach(1.0, nhip);
  Serial.println("Ticker chay 1Hz");
}

void loop() {
  Serial.print("Dem = ");
  Serial.println(dem);
  delay(500);
}`],

['serial2','📡 UART0/1/2',`void setup() {
  Serial.begin(115200);
  Serial1.begin(9600);
  Serial2.begin(9600);
  Serial.println("UART0 OK");
  Serial1.println("UART1 OK");
  Serial2.println("UART2 OK");
}

void loop() {
  Serial.print("[0] ");
  Serial.println(millis());
  Serial1.print("[1] ");
  Serial1.println(millis());
  Serial2.print("[2] ");
  Serial2.println(millis());
  delay(1000);
}`],

['wifi','📶 Quét WiFi',`void setup() {
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  Serial.println("Quet WiFi...");
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
  Serial.print("IP = ");
  Serial.println(WiFi.localIP());
  Serial.print("MAC = ");
  Serial.println(WiFi.macAddress());
}

void loop() { delay(1000); }`],

['webserver','🕸 WebServer',`#include <WiFi.h>
#include <WebServer.h>

WebServer server(80);
int dem = 0;

void handleRoot() {
  dem++;
  Serial.print("GET / — tong = ");
  Serial.println(dem);
}

void handleLED() {
  digitalWrite(2, !digitalRead(2));
  Serial.print("GET /led — LED = ");
  Serial.println(digitalRead(2));
}

void setup() {
  Serial.begin(115200);
  pinMode(2, OUTPUT);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  delay(1500);
  Serial.print("Server: http://");
  Serial.println(WiFi.localIP());
  server.on("/", handleRoot);
  server.on("/led", handleLED);
  server.begin();
}

void loop() {
  server.handleClient();
  delay(200);
}`],

['http','🌐 HTTP GET',`#include <WiFi.h>
#include <HTTPClient.h>

void setup() {
  Serial.begin(115200);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  while (WiFi.status() != WL_CONNECTED) { delay(300); Serial.print("."); }
  Serial.println();
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

['mqtt','📨 MQTT',`#include <WiFi.h>
#include <PubSubClient.h>

WiFiClient espClient;
PubSubClient mqtt(espClient);

void callback(char* topic, byte* payload, int len) {
  Serial.print("Nhan [");
  Serial.print(topic);
  Serial.print("]: ");
  for (int i = 0; i < len; i++) Serial.print((char)payload[i]);
  Serial.println();
}

void setup() {
  Serial.begin(115200);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  delay(1500);
  mqtt.setServer("broker.local", 1883);
  mqtt.setCallback(callback);
  mqtt.connect("esp-client-01");
  mqtt.subscribe("esp/cmd");
}

void loop() {
  mqtt.loop();
  mqtt.publish("esp/status", "online");
  delay(4000);
}`],

['ntp','🕐 NTP / RTC',`#include <WiFi.h>
#include <time.h>

void setup() {
  Serial.begin(115200);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  delay(1500);
  configTime(7*3600, 0, "pool.ntp.org");
}

void loop() {
  struct tm t;
  if (getLocalTime(&t)) {
    Serial.printf("%04d-%02d-%02d %02d:%02d:%02d\\n",
      t.tm_year+1900, t.tm_mon+1, t.tm_mday,
      t.tm_hour, t.tm_min, t.tm_sec);
  }
  delay(1000);
}`],

['i2c','🔌 Quét I2C',`#include <Wire.h>

void setup() {
  Wire.begin();
  Serial.begin(115200);
  Serial.println("Quet I2C...");
}

void loop() {
  int found = 0;
  for (int addr = 1; addr < 127; addr++) {
    Wire.beginTransmission(addr);
    if (Wire.endTransmission() == 0) {
      Serial.print("0x");
      Serial.println(addr, HEX);
      found++;
    }
  }
  Serial.print("Tong: ");
  Serial.println(found);
  delay(5000);
}`],

['bme280','🌡 BME280',`#include <Wire.h>
#include <Adafruit_BME280.h>

Adafruit_BME280 bme;

void setup() {
  Serial.begin(115200);
  Wire.begin();
  if (!bme.begin(0x76)) {
    Serial.println("Khong tim thay BME280");
  }
}

void loop() {
  Serial.print("T = ");
  Serial.print(bme.readTemperature());
  Serial.print(" C   P = ");
  Serial.print(bme.readPressure() / 100.0);
  Serial.print(" hPa   H = ");
  Serial.print(bme.readHumidity());
  Serial.println(" %");
  delay(2000);
}`],

['mpu','📐 MPU6050',`#include <Wire.h>
#include <MPU6050.h>

MPU6050 mpu;

void setup() {
  Serial.begin(115200);
  Wire.begin();
  mpu.initialize();
  Serial.println("MPU6050 OK");
}

void loop() {
  int16_t ax, ay, az, gx, gy, gz;
  mpu.getMotion6(&ax, &ay, &az, &gx, &gy, &gz);
  Serial.print("A: ");
  Serial.print(ax); Serial.print(",");
  Serial.print(ay); Serial.print(",");
  Serial.print(az);
  Serial.print("  G: ");
  Serial.print(gx); Serial.print(",");
  Serial.print(gy); Serial.print(",");
  Serial.println(gz);
  delay(200);
}`],

['ble','📡 BLE Scan',`#include <BLEDevice.h>

void setup() {
  Serial.begin(115200);
  BLEDevice::init("ESP-Emu");
  Serial.println("BLE bat dau");
}

void loop() {
  BLEScan* scan = BLEDevice::getScan();
  scan->start(2);
  int n = scan->getResultsCount();
  Serial.print("Tim thay ");
  Serial.print(n);
  Serial.println(" thiet bi BLE:");
  for (int i = 0; i < n; i++) {
    Serial.print("  ");
    Serial.print(scan->getName(i));
    Serial.print("  ");
    Serial.print(scan->getRSSI(i));
    Serial.println(" dBm");
  }
  delay(8000);
}`],

['tasks','🧵 FreeRTOS Tasks',`#include <Arduino.h>
TaskHandle_t task1;
int counter = 0;

void taskBlink(void* param) {
  while (1) {
    digitalWrite(2, !digitalRead(2));
    vTaskDelay(500 / portTICK_PERIOD_MS);
  }
}

void taskLog(void* param) {
  while (1) {
    counter++;
    vTaskDelay(1000 / portTICK_PERIOD_MS);
  }
}

void setup() {
  Serial.begin(115200);
  pinMode(2, OUTPUT);
  xTaskCreatePinnedToCore(taskBlink, "Blink", 2048, NULL, 1, &task1, 0);
  xTaskCreatePinnedToCore(taskLog, "Log", 2048, NULL, 1, NULL, 1);
  Serial.println("Tasks created");
}

void loop() {
  Serial.print("counter = ");
  Serial.println(counter);
  delay(2000);
}`],

['spiffs','💾 SPIFFS',`#include <SPIFFS.h>

void setup() {
  Serial.begin(115200);
  if (!SPIFFS.begin(true)) {
    Serial.println("SPIFFS loi");
    return;
  }
  Serial.println("SPIFFS OK");
  if (!SPIFFS.exists("/config.txt")) {
    File f = SPIFFS.open("/config.txt", "w");
    f.println("wifi=ELECTRONICSTREE");
    f.println("pass=12345678");
    f.close();
    Serial.println("Da tao /config.txt");
  }
  File f = SPIFFS.open("/config.txt", "r");
  Serial.println("Noi dung /config.txt:");
  while (f.available()) {
    Serial.print((char)f.read());
  }
  f.close();
}

void loop() { delay(5000); }`],

['nvs','🗂 NVS',`#include <Preferences.h>

Preferences prefs;
int bootCount = 0;

void setup() {
  Serial.begin(115200);
  prefs.begin("app", false);
  bootCount = prefs.getInt("boots", 0) + 1;
  prefs.putInt("boots", bootCount);
  prefs.putString("ssid", "ELECTRONICSTREE");
  Serial.print("So lan boot: ");
  Serial.println(bootCount);
  Serial.print("SSID: ");
  Serial.println(prefs.getString("ssid", ""));
  prefs.end();
}

void loop() { delay(5000); }`],

['ota','⬆ OTA Update',`#include <WiFi.h>
#include <HTTPUpdate.h>

void setup() {
  Serial.begin(115200);
  WiFi.begin("ELECTRONICSTREE", "12345678");
  delay(1500);
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());
  Serial.println("Kiem tra firmware moi...");
}

void loop() {
  t_httpUpdate_return ret = httpUpdate.update("http://firmware.local/esp.bin");
  if (ret == HTTP_UPDATE_OK) {
    Serial.println("Cap nhat thanh cong!");
  } else if (ret == HTTP_UPDATE_FAILED) {
    Serial.print("Loi OTA: ");
    Serial.println(httpUpdate.getLastErrorString());
  }
  delay(30000);
}`],

['nvsbrowse','📂 Tạo file + NVS',`#include <SPIFFS.h>
#include <Preferences.h>

Preferences prefs;

void setup() {
  Serial.begin(115200);
  SPIFFS.begin(true);
  File f = SPIFFS.open("/hello.txt", "w");
  f.println("Xin chao ESP Emulator!");
  f.println("Dong 2");
  f.close();

  prefs.begin("demo");
  prefs.putString("name", "ESP32");
  prefs.putInt("version", 3);
  prefs.putFloat("temp", 28.4);
  prefs.putBool("enabled", true);
  prefs.end();
  Serial.println("Da tao /hello.txt va NVS demo");
}

void loop() { delay(5000); }`],

['adc','📈 ADC + Plotter',`void setup() { Serial.begin(115200); }

void loop() {
  Serial.println(analogRead(A0));
  delay(50);
}`],

['plot','📊 Plotter',`void setup() { Serial.begin(115200); }

void loop() {
  float t = millis() / 1000.0;
  Serial.print(sin(t) * 100);
  Serial.print(" ");
  Serial.print(cos(t) * 100);
  Serial.print(" ");
  Serial.println(sin(t * 2) * 50);
  delay(40);
}`],

['dac','🔊 DAC Wave',`#define DAC1 25

void setup() {
  Serial.begin(115200);
  Serial.println("DAC tren GPIO25");
}

void loop() {
  for (int i = 0; i < 360; i += 3) {
    int v = 128 + (int)(sin(i * PI / 180.0) * 127);
    dacWrite(DAC1, v);
    Serial.println(v);
    delay(15);
  }
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

void loop() {}`],

['oop','🧱 OOP',`class Den {
  int chan;
  int tt;
public:
  Den(int c) { chan = c; tt = 0; }
  void bat() { tt = 1; digitalWrite(chan, HIGH); }
  void tat() { tt = 0; digitalWrite(chan, LOW); }
  void dao() { if (tt) tat(); else bat(); }
  int doc() { return tt; }
};

Den led(2);

void setup() {
  Serial.begin(115200);
  pinMode(2, OUTPUT);
}

void loop() {
  led.dao();
  Serial.print("LED = ");
  Serial.println(led.doc());
  delay(600);
}`],

['string','🔤 Chuỗi',`void setup() {
  Serial.begin(115200);
  String s = "ESP Emulator";
  Serial.println(s);
  Serial.println(s.length());
  String t = "";
  for (int i = 0; i < 5; i++) {
    t += "X";
    Serial.println(t);
    delay(200);
  }
  int so = 1234;
  Serial.print("Hex: 0x");
  Serial.println(so, HEX);
  Serial.print("Bin: 0b");
  Serial.println(so, BIN);
  Serial.println(so, DEC);
}`]
];

/* =========================================================================
   3. THIẾT BỊ MÔ PHỎNG
   ========================================================================= */
const dev = {
  np:{n:0,buf:[],bright:1},
  servos:{},
  oled:null,
  lcd:null,
  dht:{t:28.4,h:64},
  dist:25,
  ldr:50,
  mic:0,
  pir:0,
  adc:512,
  adcPin:null,
  atten:2,
  touch:[38,42,46,50,54,36,40,44,48,52],
  touchHold:false,
  i2c:new Set(DEFAULT_I2C),
  fs:{},
  prefs:{},
  eeprom:new Uint8Array(512),
  toneOsc:null,
  tone:null,
  mute:true,
  noise:false,
  irqCount:0,
  dac:{pin:null, val:128, hist:new Array(120).fill(128)},
  routes:[],
  server:null,
  mqtt:{connected:false, subs:[], cb:null},
  ble:{scanning:false, results:[]},
  timers:[],
  tasks:[],
  ota:''
};

/* ---------- Format ---------- */
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

/* =========================================================================
   4. THƯ VIỆN MÔ PHỎNG
   ========================================================================= */
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
    i = i|0; if(i<0 || i>=this.n) return;
    let c;
    if(a.length === 1) c = (typeof a[0] === 'number') ? (a[0]>>>0) : 0;
    else c = ((a[0]&255)<<16)|((a[1]&255)<<8)|(a[2]&255);
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
    h=((h%360)+360)%360/360; s=s/255; v=v/255;
    const i=Math.floor(h*6), f=h*6-i, p=v*(1-s), q=v*(1-f*s), t=v*(1-(1-f)*s);
    let r,g,b;
    switch(i%6){
      case 0:r=v;g=t;b=p;break; case 1:r=q;g=v;b=p;break;
      case 2:r=p;g=v;b=t;break; case 3:r=p;g=q;b=v;break;
      case 4:r=t;g=p;b=v;break; default:r=v;g=p;b=q;
    }
    return ((Math.round(r*255)&255)<<16)|((Math.round(g*255)&255)<<8)|(Math.round(b*255)&255);
  }
}

class ServoSim{
  constructor(){ this.pin = -1; this.deg = 90; }
  attach(pin){ this.pin = pin; dev.servos[pin] = {deg:this.deg}; renderServos(); return 1; }
  detach(){ if(dev.servos[this.pin]) delete dev.servos[this.pin]; this.pin = -1; renderServos(); }
  write(d){ this.deg = Math.max(0,Math.min(180,+d)); if(this.pin>=0) dev.servos[this.pin] = {deg:this.deg}; renderServos(); }
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
  computeHeatIndex(t,f){ const T = f?(t-32)*5/9:t; return f ? (T*9/5+32+3) : (T+2); }
}

class OLEDSim{
  constructor(w,h,wire,rst){
    this.w=w||128; this.h=h||64;
    this.cv = document.createElement('canvas');
    this.cv.width = this.w; this.cv.height = this.h;
    this.ctx = this.cv.getContext('2d');
    this.ctx.fillStyle='#000'; this.ctx.fillRect(0,0,this.w,this.h);
    this.color = '#fff'; this.size = 1; this.cx = 0; this.cy = 0;
    dev.oled = this;
  }
  begin(){ return true; }
  clearDisplay(){ this.ctx.fillStyle='#000'; this.ctx.fillRect(0,0,this.w,this.h); }
  display(){ renderOLED(); }
  _c(c){ return (c === 0 || c === 'SSD1306_BLACK') ? '#000' : '#fff'; }
  drawPixel(x,y,c){ this.ctx.fillStyle=this._c(c===undefined?1:c); this.ctx.fillRect(x|0,y|0,1,1); }
  drawLine(x0,y0,x1,y1,c){ this.ctx.strokeStyle=this._c(c===undefined?1:c); this.ctx.lineWidth=1;
    this.ctx.beginPath(); this.ctx.moveTo(x0+.5,y0+.5); this.ctx.lineTo(x1+.5,y1+.5); this.ctx.stroke(); }
  drawRect(x,y,w,h,c){ this.ctx.strokeStyle=this._c(c===undefined?1:c); this.ctx.lineWidth=1; this.ctx.strokeRect(x+.5,y+.5,w,h); }
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
    $('lcdinfo').textContent = '0x' + (addr||0x27).toString(16).toUpperCase() + ' — ' + this.cols + '×' + this.rows;
  }
  init(){ this.clear(); return this; }
  begin(){ return this.init(); }
  backlight(){ this.on = true; renderLCD(); }
  noBacklight(){ this.on = false; renderLCD(); }
  display(){ this.on = true; renderLCD(); }
  noDisplay(){ this.on = false; renderLCD(); }
  clear(){ this.buf.forEach(r=>r.fill(' ')); this.cx = 0; this.cy = 0; renderLCD(); }
  home(){ this.cx = 0; this.cy = 0; }
  setCursor(c,r){ this.cx = Math.max(0,Math.min(this.cols-1,c|0)); this.cy = Math.max(0,Math.min(this.rows-1,r|0)); }
  print(v){ for(const ch of String(v)) this.write(ch.charCodeAt(0)); renderLCD(); }
  println(v){ this.print(v===undefined?'':v); this.cx = 0; this.cy = Math.min(this.rows-1,this.cy+1); renderLCD(); }
  write(c){
    if(c === 10){ this.cx = 0; this.cy = Math.min(this.rows-1,this.cy+1); return; }
    if(c === 13) return;
    if(this.cy < this.rows && this.cx < this.cols) this.buf[this.cy][this.cx] = String.fromCharCode(c);
    this.cx++;
    if(this.cx >= this.cols){ this.cx = 0; this.cy = Math.min(this.rows-1,this.cy+1); }
  }
  createChar(){} blink(){} noBlink(){} cursor(){} noCursor(){}
  scrollDisplayLeft(){} scrollDisplayRight(){} autoscroll(){}
}

class PreferencesSim{
  constructor(ns){ this.ns = ns || 'default'; }
  begin(ns){ if(ns) this.ns = ns; return true; }
  _k(k){ return this.ns + ':' + k; }
  putInt(k,v){ dev.prefs[this._k(k)] = Math.trunc(v); renderNVS(); return 1; }
  getInt(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? (d||0) : v|0; }
  putFloat(k,v){ dev.prefs[this._k(k)] = +v; renderNVS(); return 1; }
  getFloat(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? (d||0) : v; }
  putBool(k,v){ dev.prefs[this._k(k)] = !!v; renderNVS(); return 1; }
  getBool(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? !!d : v; }
  putString(k,v){ dev.prefs[this._k(k)] = String(v); renderNVS(); return 1; }
  getString(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? (d||'') : v; }
  putUInt(k,v){ dev.prefs[this._k(k)] = v>>>0; renderNVS(); return 1; }
  getUInt(k,d){ const v = dev.prefs[this._k(k)]; return v===undefined ? (d||0) : v>>>0; }
  isKey(k){ return dev.prefs[this._k(k)] !== undefined; }
  remove(k){ delete dev.prefs[this._k(k)]; renderNVS(); }
  clear(){ Object.keys(dev.prefs).forEach(k=>{ if(k.startsWith(this.ns+':')) delete dev.prefs[k]; }); renderNVS(); }
  end(){ return true; }
  freeEntries(){ return 100 - Object.keys(dev.prefs).length; }
}

class FileSim{
  constructor(path, mode){ this.path = path; this.pos = 0; this.mode = mode||'r'; }
  print(s){ dev.fs[this.path] = (dev.fs[this.path]||'') + String(s); renderFS(); return 1; }
  println(s){ return this.print((s===undefined?'':s) + '\n'); }
  write(s){ return this.print(s); }
  readString(){ const s = dev.fs[this.path]||''; this.pos = s.length; return s; }
  readStringUntil(c){ const s = dev.fs[this.path]||''; const i = s.indexOf(c, this.pos); if(i<0) return ''; const r = s.slice(this.pos, i); this.pos = i+1; return r; }
  read(){ const s = dev.fs[this.path]||''; return this.pos < s.length ? s.charCodeAt(this.pos++) : -1; }
  available(){ return (dev.fs[this.path]||'').length - this.pos; }
  close(){ return true; }
  size(){ return (dev.fs[this.path]||'').length; }
  name(){ return this.path; }
  flush(){ return true; }
  seek(p){ this.pos = p; return true; }
  position(){ return this.pos; }
  isDirectory(){ return false; }
}

class HTTPClientSim{
  constructor(){ this.url = ''; }
  begin(url){ this.url = url; $('httpidle').textContent = url; return true; }
  GET(){
    netLog('GET ' + this.url + ' → 200 OK');
    this.body = '{"temp":' + dev.dht.t.toFixed(1) + ',"humi":' + dev.dht.h.toFixed(0) + ',"ok":true,"ts":' + Date.now() + '}';
    return 200;
  }
  POST(p){ this.body = '{"status":"ok"}'; netLog('POST ' + this.url + ' → 200'); return 200; }
  PUT(p){ return 200; }
  DELETE(){ return 200; }
  getString(){ return this.body || ''; }
  getStream(){ return null; }
  end(){ }
  setTimeout(){} setConnectTimeout(){} setReuse(){}
  addHeader(){}
  errorToString(){ return 'OK'; }
}

class WiFiClientSim{
  connect(h,p){ netLog('Socket → ' + h + ':' + p); this._host = h; return 1; }
  print(s){ this._buf = (this._buf||'') + s; }
  println(s){ this.print((s===undefined?'':s)+'\n'); }
  available(){ return this._resp ? this._resp.length : 0; }
  readString(){ const r = this._resp || ''; this._resp = ''; return r; }
  read(){ return -1; }
  stop(){ this._resp = 'HTTP/1.1 200 OK\r\n\r\nHello from ' + (this._host||'server'); }
  setTimeout(){} connected(){ return true; }
  write(){} flush(){}
}

class WebServerSim{
  constructor(port){
    this.port = port || 80;
    dev.server = this;
    dev.routes = [];
  }
  on(path, fn){
    dev.routes.push({path, fn});
    renderRoutes();
    return true;
  }
  onNotFound(fn){ this.notFound = fn; }
  begin(){
    netLog('WebServer lắng nghe cổng ' + this.port);
    renderRoutes();
    return true;
  }
  handleClient(){ }
  send(){}
  send_P(){}
  stop(){}
  arg(){ return ''; }
  hasArg(){ return false; }
}

class PubSubClientSim{
  constructor(client){ this.host=''; }
  setServer(h,p){ this.host = h; netLog('MQTT broker → ' + h + ':' + p); }
  connect(id){
    dev.mqtt.connected = true;
    netLog('MQTT connected: ' + id);
    return true;
  }
  disconnect(){ dev.mqtt.connected = false; }
  publish(t, m){
    netLog('MQTT pub ' + t + ' = ' + m);
    mqttLog('pub ' + t, m);
    return true;
  }
  subscribe(t){
    dev.mqtt.subs.push(t);
    netLog('MQTT sub ' + t);
    return true;
  }
  unsubscribe(t){ dev.mqtt.subs = dev.mqtt.subs.filter(x=>x!==t); }
  setCallback(fn){ dev.mqtt.cb = fn; }
  loop(){ return true; }
  connected(){ return dev.mqtt.connected; }
  state(){ return dev.mqtt.connected ? 0 : -1; }
}

class UltrasonicSim{
  constructor(t,e){ this.t = t; this.e = e; }
  read(){ return dev.dist; }
  distanceRead(){ return dev.dist; }
  timing(){ return dev.dist * 58; }
}

class TickerSim{
  constructor(){ this.handle = null; }
  attach(sec, cb){
    const h = {interval: sec*1000, cb, start: Date.now(), id: Math.random()};
    dev.timers.push(h); this.handle = h; renderTimers();
    h._t = setInterval(() => { if(run) try{ cb(); }catch(e){ log('Ticker: '+e.message,'err'); } }, sec*1000);
    return 1;
  }
  attach_ms(ms, cb){
    const h = {interval: ms, cb, start: Date.now(), id: Math.random()};
    dev.timers.push(h); this.handle = h; renderTimers();
    h._t = setInterval(() => { if(run) try{ cb(); }catch(e){ log('Ticker: '+e.message,'err'); } }, ms);
    return 1;
  }
  once(sec, cb){
    const h = {interval: sec*1000, once: true, cb, start: Date.now(), id: Math.random()};
    dev.timers.push(h); renderTimers();
    setTimeout(() => { if(run) try{ cb(); }catch(e){} }, sec*1000);
    return 1;
  }
  once_ms(ms, cb){ this.once(ms/1000, cb); }
  detach(){
    if(this.handle){ clearInterval(this.handle._t); dev.timers = dev.timers.filter(t=>t!==this.handle); this.handle = null; renderTimers(); }
  }
}

class BME280Sim{
  constructor(addr){ this.addr = addr||0x76; }
  begin(a){ if(a) this.addr = a; if(!dev.i2c.has(this.addr)) return false; return true; }
  readTemperature(){ return dev.dht.t + (Math.random()-0.5)*0.2; }
  readPressure(){ return (1013 + (Math.random()-0.5)*10) * 100; }
  readHumidity(){ return dev.dht.h + (Math.random()-0.5)*1.5; }
  readAltitude(sea){ return 44330 * (1 - Math.pow((this.readPressure()/100)/sea, 0.1903)); }
  seaLevelForAltitude(alt, p){ return (p/100) / Math.pow(1 - alt/44330, 5.255); }
}

class MPU6050Sim{
  constructor(addr){ this.addr = addr||0x68; }
  initialize(){ return dev.i2c.has(this.addr); }
  testConnection(){ return this.initialize(); }
  getMotion6(ax, ay, az, gx, gy, gz){
    // trả con trỏ - giả lập bằng cách ghi vào các biến bên ngoài (không khả thi trong JS)
    // dùng phương pháp readAccel/readGyro
    return [Math.random()*200-100, Math.random()*200-100, Math.random()*200-100+16000,
            Math.random()*400-200, Math.random()*400-200, Math.random()*400-200];
  }
  getAcceleration(ax, ay, az){}
  getRotation(gx, gy, gz){}
  readAccelX(){ return Math.round(Math.random()*200-100); }
  readAccelY(){ return Math.round(Math.random()*200-100); }
  readAccelZ(){ return Math.round(Math.random()*200-100+16000); }
  readGyroX(){ return Math.round(Math.random()*400-200); }
  readGyroY(){ return Math.round(Math.random()*400-200); }
  readGyroZ(){ return Math.round(Math.random()*400-200); }
  getTemp(){ return Math.round((dev.dht.t+10)*340+1000); }
  setFullScaleAccelRange(){} setFullScaleGyroRange(){}
}

class BLEScanSim{
  start(sec){ dev.ble.scanning = true; setTimeout(() => { dev.ble.scanning = false; renderBLE(); }, (sec||3)*1000); return true; }
  stop(){ dev.ble.scanning = false; renderBLE(); }
  getResultsCount(){ return dev.ble.results.length; }
  getName(i){ return dev.ble.results[i]?.name || ''; }
  getRSSI(i){ return dev.ble.results[i]?.rssi || 0; }
  getAddress(i){ return dev.ble.results[i]?.addr || ''; }
  clearResults(){ dev.ble.results = []; renderBLE(); }
}

class BLEDeviceSim{
  init(name){ log('BLE init: ' + name, 'sys'); $('bleinfo').textContent = name; return true; }
  getScan(){ return new BLEScanSim(); }
  createServer(){ return { getAdvertising(){ return { setName(n){ log('BLE advertise: '+n,'sys'); renderBLE(); } }; }, start(){}, }; }
  deinit(){}
}

/* =========================================================================
   5. BỘ CHUYỂN MÃ C++ → JS
   ========================================================================= */
const TYPES = '(?:unsigned\\s+|signed\\s+)?(?:long\\s+long|long|short|int|char|float|double|bool|boolean|byte|word|size_t|ssize_t|uint8_t|uint16_t|uint32_t|uint64_t|int8_t|int16_t|int32_t|int64_t|String|auto|TaskHandle_t|t_httpUpdate_return)';
const LIB_CLASSES = ['Adafruit_NeoPixel','Adafruit_SSD1306','Adafruit_GFX','LiquidCrystal_I2C',
  'DHT','Servo','ESP32Servo','WiFiClient','WiFiServer','HTTPClient','WebServer','Preferences',
  'PubSubClient','Ultrasonic','OneWire','DallasTemperature','Adafruit_BMP280','SoftwareSerial',
  'HardwareSerial','Ticker','IRrecv','TFT_eSPI','ArduinoJson','File','Adafruit_BME280',
  'MPU6050','BLEDevice','BLEScan','BLEServer','BLECharacteristic','DNSServer','AsyncWebServer',
  'HTTPUpdateResult','WiFiUDP','WebSocketsServer'];

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
  s = s.replace(new RegExp(`(?:virtual\\s+)?${TYPES}\\s+\\*?\\s*(\\w+)\\s*\\([^()]*\\)\\s*(?:const\\s*)?;`,'g'), '');
  s = s.replace(new RegExp(`${TYPES}\\s+\\*?\\s*(\\w+)\\s*=\\s*`,'g'), (m,n)=>{ names&&names.push(n); return n + ' = '; });
  s = s.replace(new RegExp(`(${TYPES})\\s+\\*?\\s*(\\w+)\\s*(?:\\[[^\\]]*\\])?\\s*;`,'g'),
    (m,ty,n)=>{ names&&names.push(n); return n + ' = ' + (/String|char/.test(ty) ? '""' : '0') + ';'; });
  return s;
}
function processClassBody(cls, body){
  const parts = []; let cur = '', depth = 0;
  for(let i=0;i<body.length;i++){
    const ch = body[i];
    if(ch === '{'){ if(depth===0){ parts.push({sig:cur, block:null}); cur=''; } depth++; cur += ch; }
    else if(ch === '}'){ depth--; cur += ch; if(depth===0){ parts[parts.length-1].block = cur; cur=''; } }
    else cur += ch;
  }
  if(cur.trim()) parts.push({sig:cur, block:null});

  const methods = [], fields = [];
  for(const p of parts){
    if(p.block === null) continue;
    const m = /([A-Za-z_~]\w*)\s*\(([^()]*)\)\s*$/.exec(p.sig);
    if(m) methods.push(m[1].replace('~',''));
  }

  let out = '';
  for(const p of parts){
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
    } else out += convFields(head, fields);

    let block = p.block;
    if(methods.length){
      const re = new RegExp(`(?<![\\w.$])(${methods.map(x=>x.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')).join('|')})\\s*\\(`,'g');
      block = block.replace(re, 'this.$1(');
    }
    if(fields.length){
      const re = new RegExp(`(?<![\\w.$])(${fields.map(x=>x.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')).join('|')})\\b(?!\\s*\\()`,'g');
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
    const bs = m.index + m[0].length;
    let depth = 1, j = bs;
    while(j < code.length && depth > 0){
      const ch = code[j];
      if(ch === '{') depth++; else if(ch === '}') depth--;
      j++;
    }
    found.push({start:m.index, end:j, name:m[2], body:code.slice(bs, j-1)});
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

/* Compile: ghi nhớ dòng gốc để báo lỗi */
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
      } else { out.push(`const ${p} = ${i};`); i++; }
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
    if(['if','for','while','switch','catch'].includes(name)) return m;
    fns.push(name);
    return ind + 'async function ' + name + '(' + cleanArgs(args) + '){';
  });

  const allClasses = [...new Set([...LIB_CLASSES, ...classNames])];
  if(allClasses.length){
    const N = allClasses.map(x=>x.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')).join('|');
    c = c.replace(new RegExp(`\\b(${N})\\s+(\\w+)\\s*\\(([^;()]*)\\)\\s*;`,'g'), 'let $2 = new $1($3);');
    c = c.replace(new RegExp(`\\b(${N})\\s+(\\w+)\\s*;`,'g'), 'let $2 = new $1();');
    c = c.replace(new RegExp(`\\b(${N})\\s+(\\w+)\\s*=`,'g'), 'let $2 =');
  }

  c = c.replace(new RegExp(`\\b${TYPES}\\b\\s*\\*?\\s*&?\\s*(?=[A-Za-z_]\\w*\\s*(?:=|;|,|\\[|\\)))`,'g'), 'let ');
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
    c = c.replace(new RegExp(`(?<!function\\s)(?<![\\w.$])(${N})\\s*\\(`,'g'), 'await $1(');
  }
  c = c.replace(/\bWiFi\.scanNetworks\s*\(/g, 'await WiFi.scanNetworks(');
  c = c.replace(/\bdelay\s*\(/g, 'await delay(');
  c = c.replace(/\bdelayMicroseconds\s*\(/g, 'await delayMicroseconds(');
  c = c.replace(/(?<![\w.$])yield\s*\(/g, 'await yieldFn(');
  c = c.replace(/\bconfigTime\s*\(/g, 'await configTime(');

  c = unstr(c);
  return new AsyncFunction('env', 'with(env){' + c + '\nreturn {setup: typeof setup==="function"?setup:null, loop: typeof loop==="function"?loop:null};}');
}

/* =========================================================================
   6. MÔI TRƯỜNG CHẠY
   ========================================================================= */
let B, pv={}, pm={}, pw={}, irq={}, ledc={};
let run=false, tok=0, wifi={on:false, ip:'0.0.0.0', hostname:'esp-emu'}, t0=Date.now(), loops=0;
let speed=1, hist=new Array(120).fill(0), plotData=[];
let uartRx = {ser:[], ser1:[], ser2:[]};
let uartBuf = {ser:'', ser1:'', ser2:''};
let curUart = 'ser';

const log = (m, c='') => {
  const ports = ['ser','ser1','ser2'];
  // ghi vào tất cả các cổng cùng lúc nếu không chỉ định
  const target = arguments[2] || null;
  const apply = (pid) => {
    const s = $(pid); if(!s) return;
    const d = document.createElement('div');
    d.className = c; d.textContent = m;
    s.appendChild(d);
    if(s.children.length > 400) s.firstChild.remove();
    s.scrollTop = 1e9;
  };
  if(target) apply(target);
  else ports.forEach(apply);
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
const mqttLog = (topic, msg) => {
  const d = document.createElement('div');
  d.innerHTML = '<span style="color:#35e0a1">' + topic + '</span> : ' + msg;
  const n = $('mqttlog');
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

/* Hàng đợi UART callback — khi user gửi dữ liệu thì sketch nhận */
function feedUart(port, data){
  uartRx[port].push(...data);
}
function readUartChar(port){
  return uartRx[port].length ? uartRx[port].shift() : -1;
}

/* BLE ngẫu nhiên */
const BLE_NAMES = ['iPhone','Galaxy Buds','Mi Band 7','ESP32-Beacon','Miband','JBL Flip','SmartTag','AirPods','Nordic_Beacon','ESP-BLE'];
function bleScan(){
  dev.ble.results = Array.from({length: 3 + Math.floor(Math.random()*4)}, () => ({
    name: BLE_NAMES[Math.floor(Math.random()*BLE_NAMES.length)] + '_' + Math.floor(Math.random()*100),
    addr: Array.from({length:6},()=>('0'+Math.floor(Math.random()*256).toString(16)).slice(-2)).join(':').toUpperCase(),
    rssi: -40 - Math.floor(Math.random()*50)
  }));
  renderBLE();
}

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
  const flush = (port) => {
    if(uartBuf[port]){ log(uartBuf[port], '', port); uartBuf[port] = ''; }
  };
  const setPinVal = (p, v) => {
    if(pm[p] === 1){ pv[p] = v ? 1 : 0; delete pw[p]; upd(p); }
  };
  const pwmWrite = (p, d, max) => {
    pw[p] = Math.max(0, Math.min(1, d / max));
    pv[p] = d > 0 ? 1 : 0;
    upd(p);
  };
  const buildSerial = (port) => ({
    begin: b => log('UART ' + port.toUpperCase() + ' @ ' + b + ' baud', 'sys'),
    print:(v, f) => { uartBuf[port] += fmt(v, f); },
    println:(v = '', f) => { uartBuf[port] += fmt(v, f) + '\n'; flush(port); },
    printf:(f, ...a) => {
      uartBuf[port] += cformat(f, a);
      if(uartBuf[port].endsWith('\n')){ uartBuf[port] = uartBuf[port].slice(0, -1); flush(port); }
    },
    write:(...a) => { a.forEach(x => { if(typeof x === 'number') uartBuf[port] += String.fromCharCode(x); else uartBuf[port] += String(x); }); },
    available:() => uartRx[port].length,
    read:() => readUartChar(port),
    peek:() => uartRx[port].length ? uartRx[port][0].charCodeAt(0) : -1,
    readString:() => { const s = uartRx[port].join('').trim(); uartRx[port] = []; return s; },
    readStringUntil:() => { const s = uartRx[port].join(''); uartRx[port] = []; return s; },
    parseInt:() => { const s = uartRx[port].join('').trim(); uartRx[port] = []; return parseInt(s,10) || 0; },
    flush:() => {}, setTimeout:() => {}, end:() => {}, availableForWrite:() => 128
  });

  /* I2C slave registers mô phỏng */
  const i2cRegs = {
    0x76: () => [0x60], // BME280 chip id
    0x68: () => [0x68],
    0x3C: () => [0x00],
    0x27: () => [0xFF]
  };

  const env = {
    ...M,
    ...B.alias,
    HIGH:1, LOW:0, OUTPUT:1, INPUT:0, INPUT_PULLUP:2, INPUT_PULLDOWN:3,
    ANALOG:3, RISING:1, FALLING:2, CHANGE:3, ONLOW:0, ONHIGH:1,
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
    HTTP_UPDATE_OK:1, HTTP_UPDATE_FAILED:0, HTTP_UPDATE_NO_UPDATES:2,
    portTICK_PERIOD_MS:1,
    ADC_0db:0, ADC_2_5db:1, ADC_6db:2, ADC_11db:3,
    ADC_ATTEN_DB_0:0, ADC_ATTEN_DB_2_5:1, ADC_ATTEN_DB_6:2, ADC_ATTEN_DB_11:3,
    ADC_WIDTH_BIT_9:9, ADC_WIDTH_BIT_10:10, ADC_WIDTH_BIT_11:11, ADC_WIDTH_BIT_12:12,
    RTC_DATA_ATTR:0,
    ESP_RST_POWERON:1, ESP_RST_DEEPSLEEP:4, ESP_RST_SW:3,
    ESP_SLEEP_WAKEUP_TIMER:4, ESP_SLEEP_WAKEUP_EXT0:2, ESP_SLEEP_WAKEUP_TOUCHPAD:5,

    /* --- GPIO --- */
    pinMode:(p, m) => {
      if(B.cap.inputOnly.includes(p) && (m === 1)){
        log('⚠ GPIO' + p + ' là INPUT-ONLY — bỏ qua pinMode(OUTPUT)', 'err');
        return;
      }
      pm[p] = m;
      if(m === 2 && pv[p] === undefined) pv[p] = 1;
      upd(p);
    },
    digitalWrite: setPinVal,
    digitalRead: p => pv[p] ?? (pm[p] === 2 ? 1 : 0),
    analogWrite:(p, v) => pwmWrite(p, v, B.pwmMax),
    dacWrite:(p, v) => {
      if(!B.cap.dac.includes(p)){ log('⚠ DAC chỉ trên GPIO ' + B.cap.dac.join(', '), 'err'); return; }
      dev.dac.pin = p; dev.dac.val = v;
      $('dacinfo').textContent = 'GPIO' + p + ' = ' + v;
      pwmWrite(p, v, 255);
    },
    analogRead: p => {
      if(p !== undefined && !B.cap.adc.includes(p) && !B.cap.adc.includes(p + 17) && p < 17){
        // trên ESP32, A0=36 mặc định, không kiểm tra chặt
      }
      let v = dev.adc;
      if(dev.noise) v += (Math.random()-0.5) * B.adcMax * 0.02;
      return Math.max(0, Math.min(B.adcMax, Math.round(v)));
    },
    analogReadResolution:() => {},
    analogWriteResolution:() => {},
    analogSetAttenuation:(a) => { dev.atten = a; },
    analogSetPinAttenuation:(p, a) => { dev.atten = a; },
    adcAttachPin:(p) => { dev.adcPin = p; return true; },
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
    dacDisable:() => {},

    /* --- LEDC --- */
    ledcSetup:(ch, f, bits) => { ledc[ch] = {bits, freq:f}; return f; },
    ledcAttachPin:(p, ch) => { (ledc[ch] = ledc[ch] || {bits:8}).pin = p; pm[p] = 1; },
    ledcAttach:(p, f, bits) => { ledc[p] = {pin:p, bits}; pm[p] = 1; return true; },
    ledcWrite:(ch, d) => { const l = ledc[ch] || {pin:ch, bits:8}; pwmWrite(l.pin ?? ch, d, Math.pow(2, l.bits) - 1); },
    ledcWriteTone:(ch, f) => { if(f) tone(ch, f); else noTone(ch); },
    ledcDetachPin: p => { delete ledc[p]; },
    ledcFade:() => {},

    /* --- Thời gian --- */
    delay: wait,
    delayMicroseconds: us => wait(us/1000),
    yieldFn: () => wait(0),
    millis: () => Date.now() - t0,
    micros: () => (Date.now() - t0) * 1000,
    tick,

    /* --- Toán --- */
    random:(a, b) => b === undefined ? Math.floor(Math.random()*a) : a + Math.floor(Math.random()*(b-a)),
    randomSeed:() => {},
    map:(x,a,b,c,d) => Math.trunc((x-a)*(d-c)/(b-a)+c),
    constrain:(x,a,b) => Math.min(b, Math.max(a,x)),
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
    strcpy:(a,b) => String(b),
    strlen: s => String(s).length,
    atoi: s => parseInt(s, 10) || 0,
    atof: s => parseFloat(s) || 0,
    dtostrf:(v, w, p) => Number(v).toFixed(p||2),
    sprintf:(buf, f, ...a) => cformat(f, a),
    snprintf:(buf, n, f, ...a) => cformat(f, a),
    F: x => x,

    /* --- Ngắt --- */
    attachInterrupt:(p, fn, m) => { irq[p] = {fn, m}; log('attachInterrupt GPIO' + p, 'sys'); },
    attachInterruptArg:(p, fn, arg, m) => { irq[p] = {fn, m, arg}; },
    detachInterrupt: p => { delete irq[p]; },
    digitalPinToInterrupt: p => p,
    interrupts:() => {}, noInterrupts:() => {},

    /* --- Serial --- */
    Serial: buildSerial('ser'),
    Serial1: buildSerial('ser1'),
    Serial2: buildSerial('ser2'),
    Serial0: buildSerial('ser'),

    /* --- Wire --- */
    Wire:{
      _a:0, _buf:[],
      begin:() => {}, setClock:() => {}, setTimeOut:() => {},
      beginTransmission(a){ this._a = a; },
      endTransmission(){ return dev.i2c.has(this._a) ? 0 : 2; },
      requestFrom:(a, n) => { this._a = a; this._readLen = n||1; this._readPos = 0; return dev.i2c.has(a) ? this._readLen : 0; },
      write:() => 1,
      available:() => { return dev.i2c.has(this._a) ? Math.max(0, (this._readLen||1) - (this._readPos||0)) : 0; },
      read:() => { this._readPos = (this._readPos||0) + 1; return Math.floor(Math.random()*256); },
      end:() => {}
    },

    /* --- SPI --- */
    SPI:{ begin:() => {}, end:() => {}, transfer: v => v, setFrequency:() => {}, setDataMode:() => {} },

    /* --- EEPROM --- */
    EEPROM:{
      begin:(n) => { dev.eeprom = new Uint8Array(n||512); },
      read: a => dev.eeprom[a] || 0,
      write:(a, v) => { dev.eeprom[a] = v & 255; renderEEPROM(); },
      update:(a, v) => { dev.eeprom[a] = v & 255; renderEEPROM(); },
      put:(a, s, len) => { s = String(s); for(let i=0;i<len;i++) dev.eeprom[a+i] = i<s.length ? s.charCodeAt(i) : 0; renderEEPROM(); },
      get:(a, len) => { let s=''; for(let i=0;i<len;i++){ const c = dev.eeprom[a+i]; if(c) s += String.fromCharCode(c); } return s; },
      commit:() => true, end:() => true, length:() => dev.eeprom.length
    },

    /* --- Filesystem --- */
    LittleFS:{
      begin:() => true, format:() => { dev.fs = {}; renderFS(); return true; },
      exists: p => dev.fs[p] !== undefined,
      open:(p, mode) => new FileSim(p, mode),
      remove: p => { delete dev.fs[p]; renderFS(); return true; },
      rename:(a,b) => { dev.fs[b] = dev.fs[a]; delete dev.fs[a]; renderFS(); return true; },
      mkdir:() => true, totalBytes:() => 1048576, usedBytes:() => Object.values(dev.fs).reduce((s,x)=>s+x.length,0)
    },
    SPIFFS:{
      begin:() => true, format:() => { dev.fs = {}; renderFS(); return true; },
      exists: p => dev.fs[p] !== undefined,
      open:(p, mode) => new FileSim(p, mode),
      remove: p => { delete dev.fs[p]; renderFS(); return true; },
      rename:(a,b) => { dev.fs[b] = dev.fs[a]; delete dev.fs[a]; renderFS(); return true; },
      mkdir:() => true, totalBytes:() => 1048576, usedBytes:() => Object.values(dev.fs).reduce((s,x)=>s+x.length,0)
    },

    /* --- WiFi --- */
    WiFi:{
      mode:() => {},
      disconnect:() => { wifi = {on:false, ip:'0.0.0.0', hostname:wifi.hostname}; ui(); },
      begin:(ssid, pass) => {
        if(ssid) log('Đang kết nối "' + ssid + '"…', 'sys');
        const t = tok;
        setTimeout(() => {
          if(t === tok){ wifi.on = true; wifi.ip = '192.168.1.' + (100 + Math.floor(Math.random()*60)); ui(); log('WiFi OK → ' + wifi.ip, 'sys'); }
        }, 1500/speed);
        return 3;
      },
      scanNetworks: async () => { await wait(1000); return NETS.length; },
      SSID: i => (NETS[i]||[])[0] || '',
      RSSI: i => (NETS[i]||[])[1] || 0,
      channel: i => (NETS[i]||[])[2] || 1,
      encryptionType: i => (NETS[i]||[])[3] || 'WPA2',
      status:() => wifi.on ? 3 : 6,
      localIP:() => wifi.ip,
      gatewayIP:() => '192.168.1.1',
      subnetMask:() => '255.255.255.0',
      dnsIP:() => '8.8.8.8',
      macAddress:() => '24:6F:28:AA:BB:CC',
      softAP: s => { wifi = {on:true, ip:'192.168.4.1', hostname:wifi.hostname}; ui(); log('AP: '+s, 'sys'); return true; },
      softAPConfig:() => true,
      setAutoReconnect:() => {}, setSleep:() => {},
      hostname: n => { if(n) wifi.hostname = n; return wifi.hostname; },
      setHostname: n => { wifi.hostname = n; return true; },
      client:() => new WiFiClientSim(),
      RSSI:() => -45,
      persistent:() => true
    },
    WiFiClient: WiFiClientSim,
    WiFiServer: class { constructor(p){ this.port = p; } begin(){ netLog('WiFiServer :' + this.port); return true; } available(){ return null; } stop(){} },

    /* --- MDNS --- */
    MDNS:{
      begin: h => { log('mDNS: ' + h + '.local', 'sys'); wifi.hostname = h; return true; },
      addService:() => true, end:() => {}
    },

    /* --- WebServer --- */
    WebServer: WebServerSim,

    /* --- HTTPClient --- */
    HTTPClient: HTTPClientSim,

    /* --- MQTT --- */
    PubSubClient: PubSubClientSim,

    /* --- NTP / Time --- */
    configTime: async (tz, dst, srv) => {
      log('NTP sync với ' + srv, 'sys');
      await wait(800);
      return true;
    },
    getLocalTime: (t) => {
      const d = new Date(Date.now() + 7*3600*1000);
      if(t && typeof t === 'object'){
        t.tm_year = d.getUTCFullYear() - 1900;
        t.tm_mon = d.getUTCMonth();
        t.tm_mday = d.getUTCDate();
        t.tm_hour = d.getUTCHours();
        t.tm_min = d.getUTCMinutes();
        t.tm_sec = d.getUTCSeconds();
        t.tm_wday = d.getUTCDay();
      }
      return true;
    },
    time: () => Math.floor(Date.now()/1000),
    now: () => Math.floor(Date.now()/1000),
    localtime: () => {
      const d = new Date(Date.now() + 7*3600*1000);
      return { tm_year: d.getUTCFullYear()-1900, tm_mon: d.getUTCMonth(), tm_mday: d.getUTCDate(),
               tm_hour: d.getUTCHours(), tm_min: d.getUTCMinutes(), tm_sec: d.getUTCSeconds() };
    },
    strftime:(buf, n, f, t) => {
      if(!t) return 0;
      const d = new Date(Date.UTC(t.tm_year+1900, t.tm_mon, t.tm_mday, t.tm_hour, t.tm_min, t.tm_sec));
      const pad = x => String(x).padStart(2, '0');
      return f.replace(/%Y/g, d.getUTCFullYear()).replace(/%m/g, pad(d.getUTCMonth()+1))
              .replace(/%d/g, pad(d.getUTCDate())).replace(/%H/g, pad(d.getUTCHours()))
              .replace(/%M/g, pad(d.getUTCMinutes())).replace(/%S/g, pad(d.getUTCSeconds()));
    },
    setenv:(n, v, o) => true,
    tzset: () => {},

    /* --- ESP --- */
    ESP:{
      getFreeHeap:() => B.heap - Math.floor(Math.random()*3000),
      getHeapSize:() => B.heap,
      getMinFreeHeap:() => B.heap - 8000,
      getChipId:() => 0x5CCF7F,
      getFlashChipSize:() => 4194304,
      getFlashChipSpeed:() => 40000000,
      getChipModel:() => B.name,
      getChipRevision:() => 1,
      getCpuFreqMHz:() => B.mhz,
      getSdkVersion:() => 'emulator-full-1.0',
      getSketchSize:() => 240000,
      restart:() => { log('↻ Khởi động lại…', 'sys'); setTimeout(() => { if(run) runSketch(); }, 400); throw STOP; },
      deepSleep: us => { log('😴 Deep sleep ' + (us/1e6).toFixed(2) + 's', 'sys'); throw STOP; },
      deepSleepEnable:() => {},
      lightSleep: us => wait(us/1000),
      getWakeupReason:() => 4,
      getWakeupPin:() => 0
    },
    esp_sleep_enable_timer_wakeup: us => {},
    esp_sleep_enable_ext0_wakeup: (p, lvl) => {},
    esp_sleep_enable_touchpad_wakeup:() => {},
    esp_deep_sleep_start:() => { log('😴 Deep sleep', 'sys'); throw STOP; },
    esp_restart:() => { throw STOP; },
    esp_get_free_heap_size:() => B.heap - 4096,
    esp_sleep_get_wakeup_cause:() => 4,
    esp_reset_reason:() => 1,

    /* --- FreeRTOS --- */
    xTaskCreate:(fn, name, stack, param, prio, handle) => {
      dev.tasks.push({name, prio:prio||1, stack:stack||2048});
      renderTasks();
      log('Tạo task: ' + name, 'sys');
      return 1;
    },
    xTaskCreatePinnedToCore:(fn, name, stack, param, prio, handle, core) => {
      dev.tasks.push({name, prio:prio||1, stack:stack||2048, core:core||0});
      renderTasks();
      log('Tạo task: ' + name + ' (core ' + (core||0) + ')', 'sys');
      return 1;
    },
    vTaskDelay: ms => wait(ms),
    vTaskDelete:() => {},
    xTaskGetTickCount:() => Math.floor((Date.now()-t0)),
    pdMS_TO_TICKS: ms => Math.round(ms),
    xPortGetCoreID:() => 0,
    xSemaphoreCreateMutex:() => ({}),
    xSemaphoreTake:() => true,
    xSemaphoreGive:() => true,

    /* --- Timers --- */
    esp_timer_create:(cfg, handle) => { return 0; },
    esp_timer_start_once:() => 0,
    esp_timer_start_periodic:() => 0,
    esp_timer_stop:() => 0,
    timerBegin:(n, div, up) => ({id:Math.random(), cb:null}),
    timerAttachInterrupt:(t, fn, edge) => { t.cb = fn; return true; },
    timerAlarmWrite:(t, us, reload) => { t.us = us; t.reload = reload; return true; },
    timerAlarmEnable:(t) => {
      if(!t.cb) return;
      dev.timers.push({interval: t.us/1000, cb: t.cb});
      renderTimers();
      const iv = setInterval(() => { if(run) try{ t.cb(); }catch(e){} }, Math.max(50, t.us/1000));
      setTimeout(() => { if(!t.reload) clearInterval(iv); }, t.us/1000);
    },
    timerAlarmDisable:() => {},
    timerEnd:() => {},

    /* --- Ticker --- */
    Ticker: TickerSim,

    /* --- OTA --- */
    httpUpdate:{
      update: url => {
        dev.ota = url;
        log('OTA đang tải ' + url + '…', 'sys');
        $('otalog').textContent = 'Đang cập nhật…';
        setTimeout(() => { $('otalog').textContent = '✔ Cập nhật thành công (mô phỏng)'; }, 1500);
        return 1; // HTTP_UPDATE_OK
      },
      getLastErrorString:() => 'OK',
      rebootOnUpdate:() => {}
    },
    HTTPUpdateResult:{},
    t_httpUpdate_return:0,

    /* --- BLE --- */
    BLEDevice: new BLEDeviceSim(),
    BLEScan: BLEScanSim,
    BLEServer: class { getAdvertising(){ return { setName(n){ log('BLE adv: '+n,'sys'); $('bleinfo').textContent = n; renderBLE(); } }; } start(){} },
    BLECharacteristic: class { constructor(){ } setValue(){ } addDescriptor(){ } },
    BLEAdvertisementData: class { },

    /* --- Thư viện cảm biến --- */
    Adafruit_NeoPixel: NeoPixelSim,
    Servo: ServoSim,
    ESP32Servo: ServoSim,
    DHT: DHTSim,
    Adafruit_SSD1306: OLEDSim,
    Adafruit_GFX: OLEDSim,
    LiquidCrystal_I2C: LCDSim,
    Preferences: PreferencesSim,
    File: FileSim,
    PubSubClient: PubSubClientSim,
    Ultrasonic: UltrasonicSim,
    Adafruit_BME280: BME280Sim,
    MPU6050: MPU6050Sim,
    OneWire: class { constructor(p){} reset(){ return true; } },
    DallasTemperature: class { constructor(w){} requestTemperatures(){} getTempCByIndex(){ return 25 + Math.random()*5; } },

    /* --- Âm thanh --- */
    tone:(p, f, d) => tone(p, f, d),
    noTone: p => noTone(p),

    /* --- Utilities --- */
    utoa:(v, b, r) => String(v),
    itoa:(v, b, r) => String(v),
    ltoa:(v, b, r) => String(v),
    strtol:(s, e, b) => parseInt(s, b||10) || 0,
    strtod:(s, e) => parseFloat(s) || 0,
    isnan: Number.isNaN,
    isinf: x => !isFinite(x),
    pgm_read_byte: p => 0,
    pgm_read_word: p => 0,
    pgm_read_dword: p => 0,
    pgm_read_ptr: p => null
  };

  return env;
}

/* =========================================================================
   7. ÂM THANH
   ========================================================================= */
let actx = null;
function tone(pin, freq, dur){
  try{
    if(dev.mute) return;
    actx = actx || new (window.AudioContext || window.webkitAudioContext)();
    if(dev.toneOsc){ try{ dev.toneOsc.stop(); }catch(e){} }
    const o = actx.createOscillator(), g = actx.createGain();
    o.type = 'square'; o.frequency.value = freq;
    g.gain.value = 0.02;
    o.connect(g); g.connect(actx.destination); o.start();
    dev.toneOsc = o;
    if(dur) setTimeout(() => { try{ o.stop(); }catch(e){} }, dur);
  }catch(e){}
}
function noTone(){
  if(dev.toneOsc){ try{ dev.toneOsc.stop(); }catch(e){} dev.toneOsc = null; }
}

/* =========================================================================
   8. VẼ GIAO DIỆN
   ========================================================================= */
function pinLabel(p){
  const a = Object.entries(B.alias).find(([k,v]) => v === p && /^D\d$/.test(k));
  return a ? a[0] : '';
}
function buildPins(){
  $('pins').innerHTML = B.pins.map(p => {
    const isADC = B.cap.adc.includes(p);
    const isTCH = B.cap.touch.includes(p);
    const isRO  = B.cap.inputOnly.includes(p);
    const isDAC = B.cap.dac.includes(p);
    const cls = ['pin'];
    if(isRO) cls.push('ro');
    if(isADC) cls.push('adc');
    if(isTCH) cls.push('tch');
    const cap = [isADC?'A':'', isTCH?'T':'', isDAC?'D':'', isRO?'RO':''].filter(Boolean).join('/');
    return `<div class="${cls.join(' ')}" id="p${p}" onclick="togglePin(${p})">
       <small>GPIO${p}${pinLabel(p)?' · '+pinLabel(p):''}</small>
       <b>0</b>
       <small>${cap || 'IN'}</small>
     </div>`;
  }).join('');
  const L = B.name === 'ESP32' ? [2,4,5,18] : [2,4,16];
  $('leds').innerHTML = L.map(p => `<div class="led"><i id="l${p}"></i>GPIO${p}</div>`).join('');
  B.leds = L;
}
function upd(p){
  const e = $('p'+p); if(!e) return;
  const v = pv[p] ?? (pm[p] === 2 ? 1 : 0);
  const cls = ['pin'];
  if(B.cap.inputOnly.includes(p)) cls.push('ro');
  if(B.cap.adc.includes(p)) cls.push('adc');
  if(B.cap.touch.includes(p)) cls.push('tch');
  if(pw[p] !== undefined) cls.push('pw'); else if(v) cls.push('hi');
  e.className = cls.join(' ');
  e.children[1].textContent = v;
  e.children[2].textContent = pw[p] !== undefined ? 'PWM ' + Math.round(pw[p]*100) + '%'
    : pm[p] === 1 ? 'OUT' : pm[p] === 2 ? 'IN↑' : 'IN';
  const l = $('l'+p);
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
    dev.irqCount++; $('v-irq').textContent = dev.irqCount;
    Promise.resolve().then(() => i.fn()).catch(e => log('ISR: ' + e.message, 'err'));
  }
};
function renderPixels(){
  const cv = $('npcv'); if(!cv) return;
  const n = dev.np.n;
  if(cv.width !== Math.max(320, n*30)) cv.width = Math.max(320, n*30);
  const ctx = cv.getContext('2d');
  ctx.clearRect(0,0,cv.width,cv.height);
  if(!n){ ctx.fillStyle='#1a2233'; ctx.font='12px system-ui'; ctx.fillText('Chưa có NeoPixel', 12, 34); return; }
  const step = cv.width/n;
  for(let i=0;i<n;i++){
    const c = dev.np.buf[i] || 0, b = dev.np.bright;
    const r = Math.round(((c>>16)&255)*b), g = Math.round(((c>>8)&255)*b), bl = Math.round((c&255)*b);
    const x = i*step + step/2, y = 30;
    ctx.beginPath(); ctx.arc(x, y, 11, 0, Math.PI*2);
    ctx.fillStyle = (r||g||bl) ? `rgb(${r},${g},${bl})` : '#222c40';
    if(r||g||bl){ ctx.shadowColor = `rgb(${r},${g},${bl})`; ctx.shadowBlur = 18; }
    ctx.fill(); ctx.shadowBlur = 0;
  }
}
function renderServos(){
  const cv = $('svcv'); if(!cv) return;
  const ctx = cv.getContext('2d');
  ctx.clearRect(0,0,cv.width,cv.height);
  const pins = Object.keys(dev.servos);
  if(!pins.length){ ctx.fillStyle='#1a2233'; ctx.font='12px system-ui';
    ctx.fillText('Chưa có Servo', 12, 58); return; }
  const w = cv.width/pins.length;
  pins.forEach((p, i) => {
    const cx = i*w + w/2, cy = 82, R = 42, deg = dev.servos[p].deg;
    ctx.strokeStyle = '#2b3a55'; ctx.lineWidth = 2;
    ctx.beginPath(); ctx.arc(cx, cy, R, Math.PI, 0); ctx.stroke();
    const rad = (180-deg)*Math.PI/180;
    ctx.beginPath(); ctx.moveTo(cx, cy);
    ctx.lineTo(cx + Math.cos(rad)*(R-4), cy - Math.sin(rad)*(R-4));
    ctx.strokeStyle = '#35e0a1'; ctx.lineWidth = 3; ctx.stroke();
    ctx.beginPath(); ctx.arc(cx, cy, 5, 0, Math.PI*2); ctx.fillStyle = '#35e0a1'; ctx.fill();
    ctx.fillStyle = '#8a99b5'; ctx.font = '11px monospace'; ctx.textAlign = 'center';
    ctx.fillText('GPIO'+p+' · '+Math.round(deg)+'°', cx, 102);
    ctx.textAlign = 'left';
  });
}
function renderOLED(){
  const o = dev.oled; if(!o) return;
  const cv = $('oledcv'); if(!cv) return;
  const ctx = cv.getContext('2d');
  ctx.imageSmoothingEnabled = false;
  ctx.clearRect(0,0,cv.width,cv.height);
  ctx.drawImage(o.cv, 0, 0, cv.width, cv.height);
}
function renderLCD(){
  const l = dev.lcd; if(!l) return;
  const cv = $('lcdcv'); if(!cv) return;
  const ctx = cv.getContext('2d');
  const cw=15, chh=30, W=l.cols*cw+18, H=l.rows*chh+14;
  if(cv.width!==W||cv.height!==H){ cv.width=W; cv.height=H; }
  ctx.fillStyle = l.on ? '#1b4d2e' : '#0d1f14';
  ctx.fillRect(0,0,W,H);
  ctx.fillStyle = l.on ? '#9dffbe' : '#33513c';
  ctx.font = '19px ui-monospace,monospace';
  ctx.textBaseline = 'middle';
  for(let r=0;r<l.rows;r++) for(let c=0;c<l.cols;c++)
    ctx.fillText(l.buf[r][c]||' ', 9+c*cw, 7+r*chh+chh/2);
}
function renderPlot(){
  const cv = $('plot'); if(!cv || cv.style.display === 'none') return;
  const ctx = cv.getContext('2d');
  const w = cv.width, h = cv.height;
  ctx.clearRect(0,0,w,h);
  ctx.strokeStyle = '#16202f';
  for(let i=0;i<=4;i++){ const y=h*i/4; ctx.beginPath(); ctx.moveTo(0,y); ctx.lineTo(w,y); ctx.stroke(); }
  if(plotData.length < 2) return;
  const cols = Math.max(...plotData.map(r=>r.length));
  const all = plotData.flat();
  let mn = Math.min(...all), mx = Math.max(...all);
  if(mx-mn < 1e-6) mx = mn + 1;
  const colors = ['#35e0a1','#4da3ff','#ffd166','#ff5d6c','#b388ff'];
  for(let c=0;c<cols;c++){
    ctx.beginPath(); ctx.strokeStyle = colors[c%colors.length]; ctx.lineWidth = 2;
    let started = false;
    plotData.forEach((row, i) => {
      if(row[c] === undefined) return;
      const x = i/(plotData.length-1)*w;
      const y = h - 6 - (row[c]-mn)/(mx-mn)*(h-12);
      started ? ctx.lineTo(x,y) : (ctx.moveTo(x,y), started = true);
    });
    ctx.stroke();
  }
  ctx.fillStyle = '#8a99b5'; ctx.font = '10px monospace';
  ctx.fillText(mx.toFixed(1), 4, 12);
  ctx.fillText(mn.toFixed(1), 4, h-4);
}
function renderRoutes(){
  const r = $('routes');
  if(!dev.routes.length){
    r.innerHTML = '<div style="opacity:.5">Chưa có server — gọi <code>server.on()</code> + <code>server.begin()</code></div>';
    return;
  }
  r.innerHTML = dev.routes.map(x =>
    `<div><span style="color:#35e0a1">${x.path}</span>
     <button class="mini" onclick="hitRoute('${x.path}')">Gọi</button></div>`).join('');
}
window.hitRoute = path => {
  const r = dev.routes.find(x => x.path === path);
  if(r){ netLog('GET ' + path); Promise.resolve().then(() => r.fn()).catch(e => log('Route: '+e.message,'err')); }
};
function renderFS(){
  const l = $('fslist');
  const keys = Object.keys(dev.fs);
  $('fsinfo').textContent = keys.length + ' tệp';
  if(!keys.length){ l.innerHTML = '<div style="opacity:.5;padding:6px">(trống)</div>'; return; }
  l.innerHTML = keys.map(k =>
    `<div onclick="viewFS('${k}')"><span>${k}</span><span style="color:var(--mu)">${dev.fs[k].length} B</span></div>`).join('');
}
window.viewFS = path => {
  $('fspath').value = path;
  const s = dev.fs[path] || '';
  log('── ' + path + ' ──\n' + s + '\n── end ──', 'sys');
};
function renderNVS(){
  const l = $('nvslist');
  const keys = Object.keys(dev.prefs);
  $('nvsinfo').textContent = keys.length + ' khóa';
  if(!keys.length){ l.innerHTML = '<div style="opacity:.5;padding:6px">(trống)</div>'; return; }
  l.innerHTML = keys.sort().map(k => {
    const v = dev.prefs[k];
    const t = typeof v === 'number' ? 'num' : typeof v === 'boolean' ? 'bool' : 'str';
    return `<div><span style="color:#4da3ff">[${t}]</span> <b>${k}</b> = ${JSON.stringify(v)}</div>`;
  }).join('');
}
function renderEEPROM(){
  const l = $('eeplist');
  let s = '';
  for(let i=0;i<64;i++){
    if(i % 16 === 0) s += '\n' + i.toString(16).padStart(4,'0') + ': ';
    s += dev.eeprom[i].toString(16).padStart(2,'0') + ' ';
  }
  l.textContent = s.trim();
}
function renderBLE(){
  const l = $('blelist');
  if(!dev.ble.results.length){ l.innerHTML = '<div style="opacity:.5">(chưa quét)</div>'; return; }
  l.innerHTML = dev.ble.results.map(x =>
    `<div style="padding:3px 0;border-bottom:1px solid #1a2438">
      <b style="color:#4da3ff">${x.name}</b> <span style="color:var(--mu)">${x.addr}</span>
      <span style="float:right;color:${x.rssi>-60?'#35e0a1':'#ffd166'}">${x.rssi} dBm</span>
    </div>`).join('');
}
function renderTimers(){
  const l = $('timers');
  if(!dev.timers.length){ l.innerHTML = '<div style="opacity:.5;padding:6px">Chưa có timer</div>'; return; }
  l.innerHTML = dev.timers.map((t, i) =>
    `<div style="padding:3px 0;border-bottom:1px solid #1a2438">
      #${i+1} · ${t.interval.toFixed(0)} ms ${t.once?'(once)':''}
    </div>`).join('');
}
function renderTasks(){
  const l = $('tasks');
  $('c-tk').textContent = dev.tasks.length;
  if(!dev.tasks.length){ l.innerHTML = '<div style="opacity:.5;padding:6px">Chưa có task</div>'; return; }
  l.innerHTML = dev.tasks.map((t, i) =>
    `<div style="padding:3px 0;border-bottom:1px solid #1a2438">
      <b style="color:#b388ff">${t.name}</b> · prio ${t.prio} · stack ${t.stack}${t.core!==undefined?' · core '+t.core:''}
    </div>`).join('');
}
function ui(){
  $('c-wifi').textContent = wifi.on ? 'ON' : 'OFF';
  $('c-wifi').style.color = wifi.on ? 'var(--ac)' : 'var(--mu)';
  $('c-ip').textContent = wifi.ip;
}

/* =========================================================================
   9. VÒNG ĐỜI SKETCH
   ========================================================================= */
function resetState(){
  pv={}; pm={}; pw={}; irq={}; ledc={};
  uartRx = {ser:[], ser1:[], ser2:[]};
  uartBuf = {ser:'', ser1:'', ser2:''};
  wifi = {on:false, ip:'0.0.0.0', hostname:'esp-emu'};
  dev.np = {n:0, buf:[], bright:1};
  dev.servos = {};
  dev.oled = null; dev.lcd = null;
  dev.toneOsc = null;
  dev.routes = [];
  dev.server = null;
  dev.mqtt = {connected:false, subs:[], cb:null};
  dev.ble.results = [];
  dev.timers.forEach(t => t._t && clearInterval(t._t));
  dev.timers = [];
  dev.tasks = [];
  dev.dac = {pin:null, val:128, hist:new Array(120).fill(128)};
  loops = 0;
  plotData = [];
  hist = new Array(120).fill(dev.adc);
  B.pins.forEach(upd);
  renderPixels(); renderServos(); renderLCD(); renderRoutes(); renderTimers(); renderTasks(); renderBLE();
  const oc = $('oledcv').getContext('2d');
  oc.fillStyle = '#000'; oc.fillRect(0,0,384,192);
  $('npinfo').textContent = 'chưa dùng';
  $('lcdinfo').textContent = 'chưa dùng';
  $('dacinfo').textContent = 'chưa dùng';
  $('netlog').innerHTML = '';
  $('mqttlog').innerHTML = '';
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
    // cố lấy số dòng nếu có
    let extra = '';
    const m = /(\d+)/.exec(e.message || '');
    log('❌ Lỗi biên dịch: ' + (e.message || e), 'err');
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
    if(e !== STOP) log('❌ Lỗi runtime: ' + (e.message || e), 'err');
  }
  if(my === tok){ run = false; setState(); }
}

function stopSketch(){
  tok++; run = false; setState();
  dev.timers.forEach(t => t._t && clearInterval(t._t));
  if(dev.toneOsc){ try{ dev.toneOsc.stop(); }catch(e){} dev.toneOsc = null; }
  log('■ Đã dừng', 'sys');
}
function setState(){
  $('state').textContent = run ? '● Đang chạy' : '● Dừng';
  $('state').style.color = run ? 'var(--ac)' : 'var(--mu)';
}

/* =========================================================================
   10. EDITOR
   ========================================================================= */
function gutter(){
  const n = $('src').value.split('\n').length;
  $('gut').textContent = Array.from({length:n}, (_,i)=>i+1).join('\n');
}
function currentKey(){ return 'esp_src_' + B.name + '_' + $('slot').value; }
function saveSrc(){
  localStorage.setItem('esp_src_' + B.name, $('src').value);
  localStorage.setItem(currentKey(), $('src').value);
}
function loadSrc(){
  return localStorage.getItem(currentKey())
      || localStorage.getItem('esp_src_' + B.name)
      || EX[0][2];
}
function clearSerial(){
  ['ser','ser1','ser2'].forEach(id => $(id).innerHTML = '');
  plotData = [];
}

/* =========================================================================
   11. KHỞI TẠO
   ========================================================================= */
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
  // Điền dropdown ADC pins
  $('adcpin').innerHTML = B.cap.adc.map(p => `<option value="${p}">GPIO${p}</option>`).join('') || '<option>—</option>';
  hist = new Array(120).fill(dev.adc);
  $('src').value = loadSrc();
  gutter();
  resetState();
  setState();
}

/* Ví dụ */
(function initEx(){
  const sel = $('ex');
  sel.innerHTML = '<option value="">— Chọn ví dụ —</option>' +
    EX.map(([k,name]) => `<option value="${k}">${name}</option>`).join('');
  sel.onchange = e => {
    const item = EX.find(x => x[0] === e.target.value);
    if(!item) return;
    $('src').value = item[2];
    gutter(); saveSrc();
    log('📖 Nạp ví dụ: ' + item[1], 'sys');
  };
})();

/* WiFi */
$('wl').innerHTML = NETS.map(n =>
  `<div onclick="connectWifi('${n[0]}')"><span>📶 ${n[0]}</span>
   <span style="color:var(--mu)">${n[1]} dBm · ch ${n[2]} · ${n[3]}</span></div>`).join('');
window.connectWifi = s => { wifi.on = true; wifi.ip = '192.168.1.100'; ui(); log('Kết nối: ' + s, 'sys'); };
$('wdis').onclick = () => { wifi.on = false; wifi.ip = '0.0.0.0'; ui(); log('Đã ngắt WiFi', 'sys'); };
$('wscan').onclick = () => log('Quét WiFi… thấy ' + NETS.length + ' mạng', 'sys');

/* I2C */
function renderI2C(){
  $('i2clist').innerHTML = I2C_DEVICES.map(d =>
    `<label class="sw"><input type="checkbox" data-a="${d.a}" ${dev.i2c.has(d.a)?'checked':''}>
     0x${d.a.toString(16).toUpperCase()} ${d.name}</label>`).join('');
}
renderI2C();
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

/* Serial tabs */
let plotMode = false;
function setSerTab(plot){
  plotMode = plot;
  ['ser','ser1','ser2'].forEach(id => { $(id).style.display = (plot || id !== curUart) ? 'none' : 'block'; });
  $('plot').style.display = plot ? 'block' : 'none';
  $('tabMon').classList.toggle('on', !plot);
  $('tabPlot').classList.toggle('on', plot);
  renderPlot();
}
$('tabMon').onclick = () => setSerTab(false);
$('tabPlot').onclick = () => setSerTab(true);
$('uport').onchange = e => {
  curUart = e.target.value;
  ['ser','ser1','ser2'].forEach(id => $(id).style.display = (plotMode || id !== curUart) ? 'none' : 'block');
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
$('save').onclick = () => { saveSrc(); log('💾 Đã lưu khe ' + $('slot').value.toUpperCase(), 'sys'); };
$('loadb').onclick = () => {
  const v = localStorage.getItem(currentKey());
  if(v){ $('src').value = v; gutter(); log('📂 Mở khe ' + $('slot').value.toUpperCase(), 'sys'); }
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
  r.onload = () => { $('src').value = r.result; gutter(); saveSrc(); log('⬆ Nạp ' + f.name, 'sys'); };
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
$('atten').onchange = e => { dev.atten = +e.target.value; };

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
$('s-mic').oninput = e => { dev.mic = +e.target.value; $('v-mic').textContent = dev.mic; };

$('btn0').onpointerdown = () => { pv[0] = 0; upd(0); fireIrq(0, 1, 0); };
$('btn0').onpointerup = $('btn0').onpointerleave = () => { pv[0] = 1; upd(0); fireIrq(0, 0, 1); };
$('btn-pir').onclick = () => { dev.pir = dev.pir ? 0 : 1; $('v-pir').textContent = dev.pir; };
$('btn-wake').onclick = () => { dev.irqCount++; $('v-irq').textContent = dev.irqCount; log('⚡ Wake interrupt', 'sys'); };
function fireIrq(p, old, nv){
  const i = irq[p];
  if(i && (i.m === 3 || (i.m === 2 && old && !nv) || (i.m === 1 && !old && nv))){
    dev.irqCount++; $('v-irq').textContent = dev.irqCount;
    Promise.resolve().then(() => i.fn()).catch(e => log('ISR: ' + e.message, 'err'));
  }
}
$('mute').onchange = e => { dev.mute = !e.target.checked; if(dev.mute) noTone(); };

/* UART input */
const sendRx = () => {
  const v = $('rx').value; if(!v) return;
  feedUart(curUart, v + '\n');
  const s = $(curUart);
  const d = document.createElement('div');
  d.className = 'tx'; d.textContent = '< ' + v;
  s.appendChild(d); s.scrollTop = 1e9;
  $('rx').value = '';
};
$('send').onclick = sendRx;
$('rx').onkeydown = e => { if(e.key === 'Enter') sendRx(); };

/* HTTP GET UI */
$('httpget').onclick = () => {
  const url = $('httpurl').value || 'http://example.com';
  netLog('GET ' + url + ' → 200 OK');
  $('httpidle').textContent = 'GET ' + url;
};

/* Routes UI */
$('reqgo').onclick = () => hitRoute($('reqpath').value || '/');

/* MQTT UI */
$('mqttpub').onclick = () => {
  const topic = $('mqtttopic').value || 'esp/cmd';
  const msg = $('mqttmsg').value || 'hello';
  if(dev.mqtt.cb){
    try{ dev.mqtt.cb(topic, msg, msg.length); mqttLog('pub ' + topic, msg); }
    catch(e){ log('MQTT callback: ' + e.message, 'err'); }
  } else {
    mqttLog('(không có callback)', topic + ' = ' + msg);
  }
};

/* BLE UI */
$('blescan').onclick = () => { bleScan(); log('BLE scan xong: ' + dev.ble.results.length + ' thiết bị', 'sys'); };
$('bleadv').onclick = () => { $('bleinfo').textContent = 'ESP-Emu advertising'; log('BLE advertising', 'sys'); };

/* OTA UI */
$('otago').onclick = () => {
  const url = $('otaurl').value;
  $('otalog').textContent = 'Đang tải ' + url + '…';
  setTimeout(() => { $('otalog').textContent = '✔ Cập nhật thành công (mô phỏng)'; }, 1500);
};

/* FS UI */
$('fsview').onclick = () => { const p = $('fspath').value; if(dev.fs[p]) viewFS(p); else log('Không có ' + p, 'err'); };
$('fsdel').onclick = () => { const p = $('fspath').value; delete dev.fs[p]; renderFS(); log('Xoá ' + p, 'sys'); };
$('fsformat').onclick = () => { dev.fs = {}; renderFS(); log('Format SPIFFS', 'sys'); };

/* NVS UI */
$('nvsformat').onclick = () => { dev.prefs = {}; renderNVS(); log('Xoá NVS', 'sys'); };

/* Vòng cập nhật UI */
setInterval(() => {
  let a = dev.adc;
  if(dev.noise) a += (Math.random()-0.5)*B.adcMax*0.02;
  a = Math.max(0, Math.min(B.adcMax, a));
  hist.push(a); hist.shift();
  const c = $('cv'), x = c.getContext('2d'), w = c.width, h = c.height;
  x.clearRect(0,0,w,h);
  x.strokeStyle = '#16202f';
  for(let i=0;i<=4;i++){ x.beginPath(); x.moveTo(0,h*i/4); x.lineTo(w,h*i/4); x.stroke(); }
  const grd = x.createLinearGradient(0,0,0,h);
  grd.addColorStop(0,'rgba(53,224,161,.35)'); grd.addColorStop(1,'rgba(53,224,161,0)');
  x.beginPath();
  hist.forEach((v, i) => {
    const px = i/(hist.length-1)*w, py = h - 4 - (v/B.adcMax)*(h-12);
    i ? x.lineTo(px, py) : x.moveTo(px, py);
  });
  x.strokeStyle = '#35e0a1'; x.lineWidth = 2; x.stroke();
  x.lineTo(w,h); x.lineTo(0,h); x.closePath(); x.fillStyle = grd; x.fill();
  $('adcv').textContent = Math.round(a) + ' / ' + B.adcMax;

  // DAC wave
  dev.dac.hist.push(dev.dac.val); dev.dac.hist.shift();
  const dc = $('daccv'), dx = dc.getContext('2d'), dw = dc.width, dh = dc.height;
  dx.clearRect(0,0,dw,dh);
  dx.strokeStyle = '#16202f';
  for(let i=0;i<=4;i++){ dx.beginPath(); dx.moveTo(0,dh*i/4); dx.lineTo(dw,dh*i/4); dx.stroke(); }
  if(dev.dac.pin !== null){
    dx.beginPath();
    dev.dac.hist.forEach((v, i) => {
      const px = i/(dev.dac.hist.length-1)*dw, py = dh - 4 - (v/255)*(dh-8);
      i ? dx.lineTo(px, py) : dx.moveTo(px, py);
    });
    dx.strokeStyle = '#ffd166'; dx.lineWidth = 2; dx.stroke();
  } else {
    dx.fillStyle = '#8a99b5'; dx.font = '11px monospace';
    dx.fillText('DAC chưa dùng (gọi dacWrite(pin, value))', 8, dh/2);
  }

  const s = Math.floor((Date.now()-t0)/1000);
  $('c-up').textContent = run ? s + 's' : '0s';
  $('c-lp').textContent = loops > 9999 ? (loops/1000).toFixed(1) + 'k' : loops;
  $('c-heap').textContent = Math.round((B.heap - (run ? 4200 + Math.random()*2500 : 0))/1024) + ' KB';

  renderPlot();
}, 120);

/* Tài liệu */
$('docbody').innerHTML = `
<h4>GPIO / Analog</h4>
<p><code>pinMode</code> <code>digitalWrite</code> <code>digitalRead</code> <code>analogWrite</code>
<code>analogRead</code> <code>analogReadResolution</code> <code>analogSetAttenuation</code>
<code>dacWrite</code> <code>touchRead</code> <code>pulseIn</code> <code>attachInterrupt</code>
<code>detachInterrupt</code> <code>ledcSetup</code> <code>ledcAttachPin</code> <code>ledcWrite</code></p>
<h4>Thời gian</h4>
<p><code>delay</code> <code>delayMicroseconds</code> <code>millis</code> <code>micros</code>
<code>yield</code> <code>configTime</code> <code>getLocalTime</code> <code>time</code> <code>now</code></p>
<h4>Serial (3 cổng)</h4>
<p><code>Serial</code> <code>Serial1</code> <code>Serial2</code> — mỗi cổng có buffer riêng, UI có tab UART</p>
<h4>WiFi</h4>
<p><code>WiFi.begin</code> <code>WiFi.status</code> <code>WiFi.localIP</code> <code>WiFi.macAddress</code>
<code>WiFi.scanNetworks</code> <code>WiFi.SSID</code> <code>WiFi.RSSI</code> <code>WiFi.channel</code>
<code>WiFi.softAP</code> <code>WiFi.disconnect</code> <code>WiFi.hostname</code></p>
<h4>Mạng / Web</h4>
<p><code>WebServer</code> — <code>.on()</code> tạo route, hiện trong UI, bấm để gọi. <code>HTTPClient</code> GET/POST.
<code>WiFiClient</code>. <code>MDNS.begin()</code></p>
<h4>MQTT</h4>
<p><code>PubSubClient</code> — từ UI tab Mạng, publish message tới sketch qua callback</p>
<h4>BLE</h4>
<p><code>BLEDevice::init</code> <code>getScan()</code> <code>.start()</code> <code>getResultsCount</code>
<code>getName</code> <code>getRSSI</code> <code>getAddress</code></p>
<h4>Task / Timer</h4>
<p><code>xTaskCreate</code> <code>xTaskCreatePinnedToCore</code> <code>vTaskDelay</code> <code>Ticker.attach</code>
<code>timerBegin</code> <code>timerAttachInterrupt</code> <code>timerAlarmWrite/Enable</code></p>
<h4>Bộ nhớ</h4>
<p><code>SPIFFS</code> / <code>LittleFS</code> với open/read/write/remove/rename · <code>Preferences</code> NVS kiểu
<code>getInt/putInt</code>, <code>getString/putString</code>, <code>getBool</code>, <code>getFloat</code> ·
<code>EEPROM</code></p>
<h4>OTA / ESP</h4>
<p><code>httpUpdate.update(url)</code> · <code>ESP.getFreeHeap</code> <code>ESP.getChipModel</code>
<code>ESP.restart</code> <code>ESP.deepSleep</code> <code>esp_sleep_get_wakeup_cause</code></p>
<h4>Thư viện mô phỏng</h4>
<p><code>Adafruit_NeoPixel</code> · <code>Servo</code> · <code>DHT</code> · <code>Adafruit_SSD1306</code> ·
<code>Adafruit_BME280</code> · <code>MPU6050</code> · <code>LiquidCrystal_I2C</code> ·
<code>Wire</code> · <code>SPI</code> · <code>Ultrasonic</code></p>
<h4>Pin capabilities</h4>
<p>ESP32: <b>A</b>=ADC (32-39) · <b>T</b>=Touch (T0-T9) · <b>D</b>=DAC (25,26) · <b>RO</b>=input-only.
Gọi <code>pinMode(34, OUTPUT)</code> sẽ báo lỗi như thật.</p>
<h4>Giới hạn</h4>
<p>Mô phỏng logic — không mô phỏng điện áp, timing tuyệt đối, đa luồng. <code>delay()</code> bất đồng bộ.</p>
`;

/* Bắt đầu */
renderFS(); renderNVS(); renderEEPROM(); renderTimers(); renderTasks();
setBoard(localStorage.getItem('esp_board') || 'esp8266');
log('Sẵn sàng. Chọn board + ví dụ → ▶ Chạy (Ctrl+Enter)', 'sys');
</script>
</body>
</html>
