<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="vi"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>ESP Emulator — ESP8266 &amp; ESP32</title>
<style>
:root{--bg:#0b0f1a;--p:#121a2b;--p2:#182238;--bd:#26344f;--tx:#e6edf7;--mu:#8a99b5;--ac:#35e0a1;--er:#ff5d6c;--bl:#4da3ff}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--tx);font:14px/1.5 system-ui,'Segoe UI',sans-serif}
header{display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;padding:12px 20px;background:var(--p);border-bottom:1px solid var(--bd);position:sticky;top:0;z-index:5}
h1{font-size:18px}h1 b{color:var(--ac)}
.chips{display:flex;gap:8px;flex-wrap:wrap}
.chip{background:var(--p2);border:1px solid var(--bd);border-radius:99px;padding:2px 12px;font-size:12px;color:var(--mu)}.chip b{color:var(--ac)}
main{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(0,1fr);gap:16px;padding:16px 20px;max-width:1500px;margin:auto}
@media(max-width:900px){main{grid-template-columns:1fr}}
.card{background:var(--p);border:1px solid var(--bd);border-radius:12px;padding:14px;margin-bottom:16px}
.card h3{font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--mu);margin-bottom:10px;display:flex;justify-content:space-between;align-items:center}
.bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:10px}
button,select,input[type=text]{font:inherit;color:var(--tx);background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:7px 12px}
button{cursor:pointer;transition:.15s}button:hover{border-color:var(--ac)}
button.run{background:var(--ac);color:#04251a;border-color:var(--ac);font-weight:700}
button.stop{background:var(--er);border-color:var(--er);color:#fff;font-weight:700}
.ed{display:flex;border:1px solid var(--bd);border-radius:8px;background:#080c15;height:400px;overflow:hidden}
.ed pre,.ed textarea{font:13px/1.55 ui-monospace,Consolas,monospace;padding:10px 8px;border:0;white-space:pre;tab-size:2}
.ed pre{color:#4a5a78;text-align:right;user-select:none;background:#0a101c;overflow:hidden;min-width:42px}
.ed textarea{flex:1;background:transparent;color:#bdf5de;resize:none;outline:none;overflow:auto;border-radius:0}
#ser{height:190px;overflow:auto;background:#080c15;border:1px solid var(--bd);border-radius:8px;padding:8px 10px;font:13px/1.5 ui-monospace,Consolas,monospace;margin-bottom:8px}
#ser div{white-space:pre-wrap;color:#bdf5de}#ser .sys{color:var(--mu)}#ser .err{color:var(--er)}
.row{display:flex;gap:8px}.row input{flex:1}
.pins{display:grid;grid-template-columns:repeat(auto-fill,minmax(66px,1fr));gap:8px}
.pin{background:var(--p2);border:1px solid var(--bd);border-radius:8px;padding:6px 4px;text-align:center;cursor:pointer;user-select:none;transition:.15s}
.pin:hover{border-color:var(--ac)}.pin small{display:block;color:var(--mu);font-size:10px}
.pin b{font-size:17px}.pin.hi{background:var(--ac);color:#04251a;border-color:var(--ac)}.pin.hi small{color:#06402c}
.pin.pw{background:linear-gradient(0deg,var(--ac) var(--d,0%),var(--p2) var(--d,0%))}
.leds{display:flex;gap:22px;justify-content:center;margin-top:14px}
.led{text-align:center;font-size:11px;color:var(--mu)}.led i{display:block;width:22px;height:22px;border-radius:50%;background:#2a3550;margin:0 auto 4px;transition:.1s}
canvas{width:100%;height:90px;background:#080c15;border-radius:8px;display:block}
input[type=range]{width:100%;margin:10px 0;accent-color:var(--ac)}
.wifi div{display:flex;justify-content:space-between;padding:6px 8px;border-bottom:1px solid var(--bd);cursor:pointer}.wifi div:hover{background:var(--p2)}
</style></head>
<body>
<header>
  <h1>⚡ ESP<b>Emulator</b></h1>
  <div class="bar" style="margin:0"><select id="board"><option value="esp8266">ESP8266</option><option value="esp32">ESP32</option></select></div>
  <div class="chips"><span class="chip">CPU <b id="c-cpu"></b></span><span class="chip">WiFi <b id="c-wifi">OFF</b></span><span class="chip">IP <b id="c-ip">0.0.0.0</b></span><span class="chip">Heap <b id="c-heap"></b></span><span class="chip">Uptime <b id="c-up">0s</b></span></div>
</header>
<main>
<section>
  <div class="card">
    <h3>Sketch <span id="state">● Dừng</span></h3>
    <div class="bar">
      <button class="run" id="run">▶ Chạy (Ctrl+Enter)</button><button class="stop" id="stop">■ Dừng</button>
      <select id="ex"><option value="blink">💡 Blink</option><option value="fade">🎚️ PWM Fade</option><option value="button">🔘 Nút nhấn</option><option value="irq">⚡ Interrupt</option><option value="wifi">📶 WiFi Scan</option><option value="i2c">🔌 I2C Scan</option><option value="touch">👆 Touch (ESP32)</option></select>
    </div>
    <div class="ed"><pre id="gut">1</pre><textarea id="src" spellcheck="false"></textarea></div>
  </div>
  <div class="card"><h3>Serial Monitor <button onclick="ser.innerHTML=''" style="padding:2px 10px">Xoá</button></h3>
    <div id="ser"></div>
    <div class="row"><input type="text" id="rx" placeholder="Gửi dữ liệu tới Serial rồi Enter…"><button id="send">Gửi</button></div>
  </div>
</section>
<section>
  <div class="card"><h3>GPIO — bấm để đảo mức chân INPUT</h3><div class="pins" id="pins"></div>
    <div class="leds" id="leds"></div></div>
  <div class="card"><h3>ADC <span id="adcv"></span></h3><canvas id="cv" width="400" height="90"></canvas>
    <input type="range" id="adc"><div class="bar"><button id="rnd">🎲 Ngẫu nhiên</button><button id="tch">👆 Giữ Touch</button></div></div>
  <div class="card"><h3>WiFi xung quanh</h3><div class="wifi" id="wl"></div></div>
</section>
</main>
<script>
const $=id=>document.getElementById(id),STOP={};
const BOARDS={
 esp8266:{name:'ESP8266',mhz:160,heap:81920,adcMax:1023,pwmBits:10,pins:[0,1,2,3,4,5,12,13,14,15,16],
  alias:{D0:16,D1:5,D2:4,D3:0,D4:2,D5:14,D6:12,D7:13,D8:15,A0:17,SDA:4,SCL:5,LED_BUILTIN:2}},
 esp32:{name:'ESP32',mhz:240,heap:327680,adcMax:4095,pwmBits:8,pins:[0,2,4,5,12,13,14,15,16,17,18,19,21,22,23,25,26,27,32,33,34,35,36,39],
  alias:{LED_BUILTIN:2,SDA:21,SCL:22,A0:36,A3:39,A4:32,A5:33,A6:34,A7:35,T0:4,T1:0,T2:2,T3:15,T4:13,T5:12,T6:14,T7:27,DAC1:25,DAC2:26}}};
const NETS=[['ELECTRONICSTREE',-45,6],['Viettel 5G',-58,1],['FPT Telecom',-55,1],['iPhone 15',-48,6],['Free WiFi',-72,3]];
const EX={
blink:`void setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  digitalWrite(LED_BUILTIN, HIGH);\n  Serial.println("LED ON");\n  delay(1000);\n  digitalWrite(LED_BUILTIN, LOW);\n  Serial.println("LED OFF");\n  delay(1000);\n}`,
fade:`int brightness = 0;\nint amount = 5;\n\nvoid setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n}\n\nvoid loop() {\n  analogWrite(LED_BUILTIN, brightness);\n  brightness += amount;\n  if (brightness <= 0 || brightness >= 255) {\n    amount = -amount;\n  }\n  delay(20);\n}`,
button:`const int BTN = 0;\n\nvoid setup() {\n  pinMode(LED_BUILTIN, OUTPUT);\n  pinMode(BTN, INPUT_PULLUP);\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  if (digitalRead(BTN) == LOW) {\n    digitalWrite(LED_BUILTIN, HIGH);\n    Serial.println("Nhấn!");\n  } else {\n    digitalWrite(LED_BUILTIN, LOW);\n  }\n  delay(100);\n}`,
irq:`volatile int count = 0;\n\nvoid IRAM_ATTR onPress() {\n  count++;\n}\n\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(0, INPUT_PULLUP);\n  attachInterrupt(digitalPinToInterrupt(0), onPress, FALLING);\n}\n\nvoid loop() {\n  if (count > 0) {\n    Serial.print("Ngắt lần: ");\n    Serial.println(count);\n    count = 0;\n  }\n  delay(50);\n}`,
wifi:`void setup() {\n  Serial.begin(115200);\n  WiFi.mode(WIFI_STA);\n}\n\nvoid loop() {\n  int n = WiFi.scanNetworks();\n  Serial.printf("Tìm thấy %d mạng\\n", n);\n  for (int i = 0; i < n; i++) {\n    Serial.print(WiFi.SSID(i));\n    Serial.print("  ");\n    Serial.print(WiFi.RSSI(i));\n    Serial.println(" dBm");\n  }\n  delay(5000);\n}`,
i2c:`void setup() {\n  Wire.begin();\n  Serial.begin(115200);\n}\n\nvoid loop() {\n  int found = 0;\n  for (int addr = 1; addr < 127; addr++) {\n    Wire.beginTransmission(addr);\n    if (Wire.endTransmission() == 0) {\n      Serial.print("Thiết bị tại 0x");\n      Serial.println(addr, HEX);\n      found++;\n    }\n  }\n  Serial.printf("Tổng: %d\\n", found);\n  delay(5000);\n}`,
touch:`// Chỉ ESP32 — giữ nút "Giữ Touch"\nvoid setup() {\n  Serial.begin(115200);\n  pinMode(LED_BUILTIN, OUTPUT);\n}\n\nvoid loop() {\n  int v = touchRead(T0);\n  Serial.println(v);\n  digitalWrite(LED_BUILTIN, v < 40);\n  delay(200);\n}`};

let B,pv,pm,pw,run=false,tok=0,adc=0,wifi,irq,rx,sb,t0,ticks=0,touch=false,ledc,hist=new Array(100).fill(0);
const AsyncFunction=Object.getPrototypeOf(async function(){}).constructor;
const save=(k,v)=>{try{localStorage.setItem(k,v)}catch(e){}},load=k=>{try{return localStorage.getItem(k)}catch(e){return null}};
const log=(m,c='')=>{const d=document.createElement('div');d.className=c;d.textContent=m;$('ser').appendChild(d);if($('ser').children.length>300)$('ser').firstChild.remove();$('ser').scrollTop=1e9};
const wait=ms=>{const t=tok;return new Promise((r,j)=>setTimeout(()=>t===tok&&run?r():j(STOP),Math.max(ms,0)))};
const tick=()=>++ticks%300?0:new Promise(r=>setTimeout(r));
const ratio=()=>adc/B.adcMax;

function makeEnv(){
 const M={};Object.getOwnPropertyNames(Math).forEach(k=>{if(typeof Math[k]=='function')M[k]=Math[k]});
 const flush=()=>{log(sb);sb=''};
 const fmt=(v,f)=>typeof v=='number'?(f>1&&f!=10?v.toString(f).toUpperCase():(Number.isInteger(v)?String(v):v.toFixed(f&&f<10?f:2))):String(v);
 const num=p=>typeof p=='number'?p:+p;
 const w=(p,v)=>{if(pm[p]===1){pv[p]=v?1:0;delete pw[p];upd(p)}};
 const pwmW=(p,d,max)=>{pw[p]=Math.min(1,d/max);pv[p]=d>0?1:0;upd(p)};
 return{...M,...B.alias,HIGH:1,LOW:0,OUTPUT:1,INPUT:0,INPUT_PULLUP:2,RISING:1,FALLING:2,CHANGE:3,HEX:16,DEC:10,BIN:2,OCT:8,
  WIFI_STA:1,WIFI_AP:2,WL_CONNECTED:3,WL_DISCONNECTED:6,tick,
  pinMode:(p,m)=>{pm[p]=m;if(m===2&&pv[p]===undefined)pv[p]=1;upd(p)},
  digitalWrite:w,digitalRead:p=>pv[p]??(pm[p]===2?1:0),
  analogWrite:(p,v)=>pwmW(p,v,B.name=='ESP32'?255:1023),
  ledcSetup:(c,f,b)=>{ledc[c]={b}},ledcAttachPin:(p,c)=>{(ledc[c]=ledc[c]||{b:8}).pin=p;pm[p]=1},
  ledcAttach:(p,f,b)=>{ledc[p]={pin:p,b};pm[p]=1},
  ledcWrite:(c,d)=>{const l=ledc[c]||{pin:c,b:8};pwmW(l.pin??c,d,2**l.b-1)},
  dacWrite:(p,v)=>pwmW(p,v,255),
  analogRead:()=>Math.round(adc),touchRead:()=>touch?12+Math.floor(Math.random()*8):65+Math.floor(Math.random()*10),
  hallRead:()=>Math.floor(Math.random()*20)-10,temperatureRead:()=>40+Math.random()*3,
  analogReadResolution:()=>{},analogWriteResolution:()=>{},
  delay:ms=>wait(ms),delayMicroseconds:us=>wait(us/1000),yield:()=>wait(0),
  millis:()=>Date.now()-t0,micros:()=>(Date.now()-t0)*1000,
  random:(a,b)=>b===undefined?Math.floor(Math.random()*a):a+Math.floor(Math.random()*(b-a)),randomSeed:()=>{},
  map:(x,a,b,c,d)=>Math.trunc((x-a)*(d-c)/(b-a)+c),constrain:(x,a,b)=>Math.min(b,Math.max(a,x)),
  attachInterrupt:(p,fn,m)=>{irq[p]={fn,m};log('attachInterrupt GPIO'+p,'sys')},detachInterrupt:p=>{delete irq[p]},digitalPinToInterrupt:p=>p,
  Serial:{begin:b=>log('Serial @ '+b+' baud','sys'),print:(v,f)=>{sb+=fmt(v,f)},println:(v='',f)=>{sb+=fmt(v,f);flush()},
   printf:(f,...a)=>{sb+=f.replace(/%(\d*\.?\d*)([dilufsxXc%])/g,(m,p,t)=>t=='%'?'%':t=='x'||t=='X'?(+a.shift()).toString(16):t=='f'?(+a.shift()).toFixed(p.includes('.')?+p.split('.')[1]:6):t=='c'?String.fromCharCode(a.shift()):String(a.shift()));if(sb.endsWith('\n')){sb=sb.slice(0,-1);flush()}},
   available:()=>rx.length,read:()=>rx.length?rx.shift().charCodeAt(0):-1,readString:()=>{const s=rx.join('').trim();rx=[];return s},flush:()=>{},setTimeout:()=>{}},
  Wire:{_a:0,begin:()=>{},setClock:()=>{},beginTransmission(a){this._a=a},endTransmission(){return[0x3C,0x27].includes(this._a)?0:2},write:()=>1,requestFrom:()=>0,available:()=>0,read:()=>0},
  WiFi:{mode:()=>{},disconnect:()=>{wifi={on:false,ip:'0.0.0.0'};ui()},
   begin:s=>{log('Đang kết nối '+s+'…','sys');const t=tok;setTimeout(()=>{if(t==tok){wifi={on:true,ip:'192.168.1.100'};ui();log('WiFi đã kết nối, IP '+wifi.ip,'sys')}},1500);return 3},
   scanNetworks:async()=>{await wait(1200);return NETS.length},SSID:i=>NETS[i]?.[0]||'',RSSI:i=>NETS[i]?.[1]||0,channel:i=>NETS[i]?.[2]||0,
   status:()=>wifi.on?3:6,localIP:()=>wifi.ip,macAddress:()=>'24:6F:28:AA:BB:CC',softAP:s=>{wifi={on:true,ip:'192.168.4.1'};ui();log('AP: '+s,'sys');return true}},
  ESP:{getFreeHeap:()=>B.heap-Math.floor(Math.random()*2000),getChipId:()=>0x5CCF7F,getChipModel:()=>B.name,getCpuFreqMHz:()=>B.mhz,restart:()=>{log('Khởi động lại…','sys');setTimeout(runSketch,300);throw STOP},deepSleep:us=>{log('Deep sleep '+us/1e6+'s','sys');throw STOP}}};
}
function transpile(src){
 let c=src.replace(/("(?:\\.|[^"\\])*")|\/\*[\s\S]*?\*\/|\/\/.*$/gm,(m,s)=>s||'')
  .replace(/^\s*#include.*$/gm,'').replace(/^\s*#define\s+(\w+)\s+(.+)$/gm,'let $1 = $2;').replace(/^\s*#(?:if|ifdef|ifndef|endif|else|pragma).*$/gm,'')
  .replace(/\b(?:IRAM_ATTR|ICACHE_RAM_ATTR|volatile|static|const|extern|inline)\b\s*/g,'');
 const fns=[],T='(?:unsigned\\s+)?(?:int|long|short|float|double|bool|boolean|byte|char|word|size_t|String|auto|uint\\d+_t|int\\d+_t)';
 c=c.replace(new RegExp('^[ \\t]*(?:void|'+T+')\\s+(\\w+)\\s*\\(([^)]*)\\)\\s*\\{','gm'),(m,n,a)=>{fns.push(n);
  return'async function '+n+'('+a.split(',').map(x=>x.trim().split(/[\s*&]+/).pop()).filter(x=>x&&x!='void').join(',')+'){'});
 c=c.replace(new RegExp('\\b'+T+'\\b(?:\\s*\\*)?\\s+(?=[A-Za-z_]\\w*\\s*[=;,\\[])','g'),'let ')
  .replace(/let (\w+)\s*\[[^\]]*\]\s*=\s*\{([^}]*)\}/g,'let $1 = [$2]').replace(/let (\w+)\s*\[\s*(\d+)\s*\]\s*;/g,'let $1 = new Array($2).fill(0);')
  .replace(/\((?:int|long|byte|uint\d+_t)\)\s*/g,'~~').replace(/\((?:float|double)\)\s*/g,'')
  .replace(/\.length\(\)/g,'.length').replace(/(\w+)\.toInt\(\)/g,'parseInt($1)').replace(/\bwhile\s*\(/g,'while(await tick(),');
 const names=[...fns,'delay','delayMicroseconds','yield','WiFi.scanNetworks'].map(s=>s.replace('.','\\.'));
 c=c.replace(new RegExp('(?<![\\w.])(?<!async function )(?:'+names.join('|')+')\\s*\\(','g'),'await $&');
 return new AsyncFunction('env','with(env){'+c+'\nreturn{setup:typeof setup=="function"?setup:null,loop:typeof loop=="function"?loop:null}}');
}
function resetState(){pv={};pm={};pw={};irq={};ledc={};rx=[];sb='';wifi={on:false,ip:'0.0.0.0'};touch=false;t0=Date.now();B.pins.forEach(upd);ui()}
async function runSketch(){
 tok++;const my=tok;run=false;await new Promise(r=>setTimeout(r,20));resetState();run=true;setState();
 let api;try{api=await transpile($('src').value)(makeEnv())}catch(e){log('Lỗi biên dịch: '+e.message,'err');run=false;setState();return}
 log('Biên dịch OK → '+B.name,'sys');
 try{if(api.setup)await api.setup();while(run&&my===tok){if(api.loop)await api.loop();await wait(0)}}
 catch(e){if(e!==STOP)log('Lỗi runtime: '+e.message,'err')}
 if(my===tok){run=false;setState()}
}
function stop(){tok++;run=false;setState();log('Đã dừng','sys')}
function setState(){$('state').textContent=run?'● Đang chạy':'● Dừng';$('state').style.color=run?'var(--ac)':'var(--mu)'}
function pinLabel(p){const a=Object.entries(B.alias).find(([k,v])=>v===p&&/^D\d$/.test(k));return a?a[0]:''}
function buildPins(){
 $('pins').innerHTML=B.pins.map(p=>`<div class="pin" id="p${p}" onclick="toggle(${p})"><small>GPIO${p}${pinLabel(p)?' · '+pinLabel(p):''}</small><b>0</b><small>IN</small></div>`).join('');
 const L=B.name=='ESP32'?[2,4,5]:[2,4,16];$('leds').innerHTML=L.map(p=>`<div class="led"><i id="l${p}"></i>GPIO${p}</div>`).join('');B.leds=L;
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
 $('adc').max=B.adcMax;adc=Math.round(B.adcMax/2);$('adc').value=adc;$('c-cpu').textContent=B.mhz+' MHz';
 $('tch').style.display=k=='esp32'?'':'none';$('src').value=load('esp_src_'+B.name)||EX.blink;gutter();
 $('wl').innerHTML=NETS.map(n=>`<div onclick="WIFIC('${n[0]}')"><span>📶 ${n[0]}</span><span style="color:var(--mu)">${n[1]} dBm · ch ${n[2]}</span></div>`).join('');
}
window.WIFIC=s=>{wifi={on:true,ip:'192.168.1.100'};ui();log('Kết nối thủ công: '+s,'sys')};
function gutter(){const n=$('src').value.split('\n').length;$('gut').textContent=Array.from({length:n},(_,i)=>i+1).join('\n')}
$('src').addEventListener('input',()=>{gutter();save('esp_src_'+B.name,$('src').value)});
$('src').addEventListener('scroll',()=>{$('gut').scrollTop=$('src').scrollTop});
$('src').addEventListener('keydown',e=>{
 if(e.key=='Tab'){e.preventDefault();const t=e.target,s=t.selectionStart;t.setRangeText('  ',s,t.selectionEnd,'end');t.dispatchEvent(new Event('input'))}
 if(e.key=='Enter'&&(e.ctrlKey||e.metaKey)){e.preventDefault();runSketch()}});
$('run').onclick=runSketch;$('stop').onclick=stop;$('board').onchange=e=>setBoard(e.target.value);
$('ex').onchange=e=>{$('src').value=EX[e.target.value];gutter();save('esp_src_'+B.name,$('src').value)};
$('adc').oninput=e=>{adc=+e.target.value};$('rnd').onclick=()=>{adc=Math.floor(Math.random()*(B.adcMax+1));$('adc').value=adc};
$('tch').onpointerdown=()=>{touch=true};$('tch').onpointerup=$('tch').onpointerleave=()=>{touch=false};
const sendRx=()=>{const v=$('rx').value;if(!v)return;rx.push(...(v+'\n'));log('> '+v,'sys');$('rx').value=''};
$('send').onclick=sendRx;$('rx').onkeydown=e=>{if(e.key=='Enter')sendRx()};
setInterval(()=>{
 hist.push(adc);hist.shift();const c=$('cv'),x=c.getContext('2d'),w=c.width,h=c.height;x.clearRect(0,0,w,h);x.strokeStyle='#35e0a1';x.lineWidth=2;x.beginPath();
 hist.forEach((v,i)=>{const px=i/99*w,py=h-4-(v/B.adcMax)*(h-8);i?x.lineTo(px,py):x.moveTo(px,py)});x.stroke();$('adcv').textContent=Math.round(adc)+' / '+B.adcMax;
 const s=Math.floor((Date.now()-t0)/1000);$('c-up').textContent=run?s+'s':'0s';$('c-heap').textContent=Math.round((B.heap-(run?3000+Math.random()*1500:0))/1024)+' KB';
},200);
setBoard(load('esp_board')||'esp8266');log('Sẵn sàng. Chọn board, chọn ví dụ rồi bấm Chạy.','sys');
</script>
</body></html>
