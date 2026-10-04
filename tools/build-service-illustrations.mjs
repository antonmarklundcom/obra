// Repo-native SVG illustrations. These are explanatory drawings, never portfolio evidence.
import { execFileSync } from 'node:child_process';
import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const php = process.env.PHP || 'php';
const content = JSON.parse(execFileSync(php, ['-r', "require 'app/helpers.php'; $c=require 'app/content.php'; echo json_encode(['services'=>$c['services'],'children'=>$c['children']], JSON_UNESCAPED_UNICODE);"], { cwd: root, encoding: 'utf8' }));
const dir = join(root, 'assets', 'illustrations'); mkdirSync(dir, { recursive: true });
const esc = s => s.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&apos;'}[c]));
const poly = (points, fill, stroke='#393c32') => `<polygon points="${points}" fill="${fill}" stroke="${stroke}" stroke-width="2" stroke-linejoin="round"/>`;
const rect = (x,y,w,h,fill,extra='') => `<rect x="${x}" y="${y}" width="${w}" height="${h}" fill="${fill}" ${extra}/>`;
const line = (x,y,x2,y2,color='#393c32',width=3,extra='') => `<path d="M${x} ${y}L${x2} ${y2}" stroke="${color}" stroke-width="${width}" fill="none" ${extra}/>`;
const roof = kind => {
  let s=poly('125,397 490,470 699,341 336,270','#dcd6c9','#c1b9a7');
  for(const [x,y] of [[167,380],[477,443],[658,332],[347,276]]) s+=rect(x,y-132,13,137,'#556056');
  const structure=kind==='estructuras';
  if(!structure) s+=poly('110,225 492,302 702,177 323,101',kind==='tejas'?'#b85a3b':kind==='losa'?'#a5aaa0':'#5a6a60');
  if(kind==='tejas') {
    for(let i=0;i<12;i++) s+=line(125+i*30,224+i*6,328+i*30,106+i*6,'#efbd9f',3);
    for(let i=0;i<7;i++) s+=line(120+i*29,221-i*17,490+i*29,297-i*17,'#7c3f2c',3);
  } else if(!structure && kind!=='losa') {
    for(let i=0;i<16;i++) s+=line(123+i*23,224+i*4.6,326+i*23,105+i*4.6,'#acb7a6',2);
  }
  s+=poly('110,225 492,302 492,321 110,244','#36463e')+poly('492,302 702,177 702,196 492,321','#778277');
  if(structure){for(let i=0;i<6;i++) s+=line(128+i*65,228+i*13,331+i*65,105+i*13,'#9c4b30',9);s+=line(128,240,490,310,'#455c4c',9)+line(330,113,692,186,'#455c4c',9);}
  if(kind==='termoacusticos') s+=poly('110,244 492,321 492,335 110,258','#ead4a6')+poly('492,321 702,196 702,209 492,335','#d6b67d');
  if(['canaletas','goteras','impermeabilizar'].includes(kind)){
    s+=line(110,241,489,318,'#bb633b',9)+line(489,318,489,444,'#bb633b',9)+line(489,444,550,456,'#bb633b',9);
    for(let i=0;i<5;i++)s+=`<path d="M${290+i*58} ${65+i*6}q-16 24 0 27q16-3 0-27" fill="#77989b"/>`;
  }
  if(kind==='impermeabilizar') s+=line(326,114,680,184,'#d2a364',10);
  return s;
};
const house = child => {
  const tall=['duplex','planta-alta'].includes(child); const top=tall?156:258;
  let s=poly('91,439 505,515 716,377 302,302','#ded7c6','#c5bda8');
  s+=poly(`147,${top} 458,${top+48} 458,447 147,395`,'#efe8d8')+poly(`458,${top+48} 663,${top-65} 663,331 458,447`,'#c6bba5');
  s+=poly(`125,${top-21} 459,${top+31} 685,${top-83} 349,${top-135}`,'#66735f');
  s+=rect(175,top+42,95,88,'#bdc9ba')+rect(307,top+66,105,90,'#7a8a7f');
  s+=line(222,top+42,222,top+130,'#f3efe3',5)+line(354,top+66,354,top+156,'#e5ddca',5);
  if(tall)s+=rect(175,top+156,95,82,'#bdc9ba')+rect(309,top+180,104,87,'#7a8a7f');
  if(['etapas','dormitorio'].includes(child))s+=`<path d="M540 130L709 200V369L543 454V248L375 210Z" fill="none" stroke="#a85534" stroke-width="4" stroke-dasharray="10 8"/>`;
  for(const [x,y]of [[105,377],[692,299]])s+=`<ellipse cx="${x}" cy="${y+39}" rx="31" ry="8" fill="#c8c8af"/><path d="M${x} ${y+34}v-82" stroke="#7e7860" stroke-width="6"/><circle cx="${x}" cy="${y-50}" r="35" fill="#919f79"/><circle cx="${x+15}" cy="${y-70}" r="28" fill="#b5bd96"/>`;
  return s;
};
const pool = child => {
 let s=poly('88,360 439,477 708,295 358,180','#e2d7c3');
 s+=poly('156,350 434,438 637,298 360,211','#8ca6a0');
 s+=poly('175,343 433,424 616,299 360,226','#87bdbe','#a9d7d0');
 for(let i=0;i<6;i++)s+=`<path d="M${200+i*25} ${335-i*15}q80-4 158 36" fill="none" stroke="#c7e1d5" stroke-width="2"/>`;
 s+=line(200,304,200,270,'#eee9d7',6)+line(227,310,227,275,'#eee9d7',6)+line(200,274,227,280,'#eee9d7',6);
 if(child==='desbordante')s+=poly('434,438 637,298 637,355 434,494','#67969c','#67969c');
 if(child==='renovacion')s+=`<path d="M160 350L130 337L141 323" stroke="#b25d37" stroke-width="6" fill="none"/>`;
 s+=rect(574,176,72,14,'#ad8262', 'transform="rotate(-30 574 176)"')+line(581,180,581,235,'#826b4d')+line(639,145,639,205,'#826b4d');
 return s;
};
const kitchen = () => {
 let s=poly('104,416 498,493 714,348 319,272','#d9d2c1');
 s+=poly('158,251 464,308 464,442 158,385','#ad7956')+poly('464,308 646,197 646,329 464,442','#8b644b');
 s+=poly('144,233 466,294 661,176 339,116','#e4ddcc');
 for(let i=0;i<4;i++)s+=line(173+i*72,266+i*14,173+i*72,383+i*14,'#e2c4a1',2);
 s+=poly('194,232 283,248 334,216 245,200','#7f8980');
 s+=line(270,208,270,178,'#354b41',6)+line(270,178,294,183,'#354b41',6);
 s+=poly('413,257 500,274 559,239 472,223','#3e4c44');
 for(let i=0;i<2;i++)s+=`<ellipse cx="${454+i*38}" cy="${252-i*7}" rx="13" ry="5" fill="none" stroke="#b6bba8" stroke-width="2"/>`;
 s+=rect(160,133,138,57,'#c5b69b');return s;
};
const bath=()=>poly('113,420 477,495 690,353 326,276','#d4d6c9')+poly('134,146 476,215 476,459 134,390','#eeeadc')+poly('476,215 655,102 655,339 476,459','#bac5b3')+poly('366,241 469,264 585,191 482,169','#cedcd2')+poly('366,241 469,264 469,438 366,413','#c5d8d1','#869e96')+line(398,250,398,413,'#f7f7e8',3)+line(571,214,571,277,'#657d72',5)+`<ellipse cx="572" cy="218" rx="17" ry="6" fill="#687f74"/>`+rect(162,274,133,97,'#bd946f')+`<ellipse cx="229" cy="266" rx="73" ry="23" fill="#faf5e5" stroke="#9e9f90" stroke-width="2"/><ellipse cx="229" cy="266" rx="41" ry="12" fill="#c7d6cd"/>`+rect(168,178,125,61,'#a6bcb0');
const fence=()=>{
 let s=poly('83,436 483,515 720,373 322,295','#d8d4c3');
 s+=poly('127,217 451,279 451,459 127,396','#c0a990')+poly('451,279 658,156 658,336 451,459','#89775f');
 s+=poly('240,256 400,286 400,445 240,415','#4f6357');
 for(let i=0;i<10;i++)s+=line(251+i*15,258+i*3,251+i*15,413+i*3,'#9aaa8f',3);
 return s+line(125,214,449,276,'#9d583a',8)+line(451,276,659,153,'#9d583a',8);
};
const office=()=>poly('99,423 510,509 725,358 315,272','#dfd8c7')+poly('130,136 509,215 509,469 130,390','#eee7d7')+poly('509,215 683,109 683,357 509,469','#b8c3ad')+rect(165,184,170,97,'#98b1a0')+poly('205,343 363,375 448,320 290,288','#b38b60')+line(215,347,215,408,'#665d49',8)+line(361,379,361,438,'#665d49',8)+rect(297,252,69,51,'#526657')+rect(280,370,56,73,'#617762')+poly('525,336 614,282 642,293 551,348','#aa8862')+line(548,347,548,401,'#655c47',7);
const report=slug=>{
 let s=`<g transform="rotate(-8 380 300)">`+rect(150,90,415,440,'#e9dfc6')+rect(175,67,415,440,'#fff9e8', 'stroke="#bcb5a1" stroke-width="2" rx="4"')+rect(205,100,78,9,'#a95734')+rect(205,140,249,18,'#526654');
 for(let i=0;i<5;i++)s+=rect(208,205+i*47,240-i*20,4,'#c1c7ad')+rect(492,196+i*47,49,17,'#e6dfcc');
 s+=`</g>`;
 if(slug==='supervision')s+=`<circle cx="558" cy="391" r="78" fill="#edf1df" stroke="#526654" stroke-width="12"/><path d="M526 391l23 24l42-50" fill="none" stroke="#a95734" stroke-width="8"/><path d="M615 449l71 65" stroke="#526654" stroke-width="22" stroke-linecap="round"/>`;
 else s+=rect(540,322,128,182,'#4d6354','rx="10"')+rect(556,340,96,32,'#b4c9a5')+Array.from({length:9},(_,i)=>rect(558+(i%3)*32,391+Math.floor(i/3)*31,22,20,i===8?'#bd7149':'#d5d1b7','rx="3"')).join('');return s;
};
const pergola = child => {
 let s=roof('estructuras');
 if(child==='decks'||child==='veredas'){
  s=poly('111,328 486,405 701,280 326,204',child==='decks'?'#b88960':'#c7c8b5');
  for(let i=0;i<12;i++)s+=line(127+i*30,331+i*6,338+i*30,207+i*6,'#efe0ba',3);
  s+=poly('111,328 486,405 486,426 111,349','#947254')+poly('486,405 701,280 701,301 486,426','#a68e6b');
 }return s;
};
function drawing(slug, child){
 if(slug==='techos') return roof(child||'chapa');
 if(slug==='tinglados')return roof(child==='galpones'?'losa':'chapa');
 if(slug==='piscinas')return pool(child);
 if(slug==='muros')return fence();
 if(slug==='supervision'||slug==='presupuesto')return report(slug);
 if(slug==='comerciales')return office();
 if(slug==='patios')return pergola(child);
 if(slug==='reformas'&&child==='banos')return bath();
 if(slug==='reformas'&&child==='cocinas')return kitchen();
 if(slug==='reformas'&&child==='techos')return roof('goteras');
 if(slug==='quinchos')return child==='parrillas'?kitchen():roof(child==='techo-madera'?'estructuras':'tejas')+rect(254,292,110,122,'#b5744e')+rect(272,312,77,45,'#3c4538')+rect(254,280,110,12,'#e0cdab');
 return house(child);
}
let count=0;
for(const [slug,parent]of Object.entries(content.services)){
 for(const [child,page]of [['',parent],...Object.entries(content.children[slug]||{})]){
  const name=slug+(child?'-'+child:'');
  const svg=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" width="800" height="600"><title>${esc(page.name)}</title><desc>Ilustración arquitectónica del servicio. No representa una obra realizada ni un plano técnico.</desc><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M40 0H0V40" fill="none" stroke="#d4d5bc" stroke-width=".6"/></pattern></defs><rect width="800" height="600" fill="#e8ebd9"/><rect x="35" y="35" width="730" height="530" fill="url(#grid)"/><circle cx="636" cy="102" r="41" fill="#d2d7b9"/><ellipse cx="399" cy="467" rx="259" ry="33" fill="#cdd1b7" opacity=".55"/>${drawing(slug,child)}<path d="M51 67h42M72 46v42M707 532h42M728 511v42" stroke="#a2ab8c" stroke-width="1.5"/></svg>\n`;
  writeFileSync(join(dir,name+'.svg'),svg);count++;
 }
}
console.log(`Generated ${count} service illustrations.`);
