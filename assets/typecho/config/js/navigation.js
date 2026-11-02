/* Progressive menu editor. The native textarea remains the saved field. */
(() => {
 'use strict';
 function init(){
  const field=document.querySelector('textarea[name="navbarInfo"]'); if(!field||field.dataset.editorReady)return;
  field.dataset.editorReady='1';
  const root=document.createElement('div');root.className='hh-menu-editor';field.before(root);
  const status=document.createElement('p');status.className='hh-menu-status';status.setAttribute('role','status');
  const advanced=document.createElement('details');advanced.className='hh-menu-advanced';const summary=document.createElement('summary');summary.textContent='高级：查看或导入JSON';advanced.append(summary);field.before(advanced);advanced.append(field);
  const load=document.createElement('button');load.type='button';load.textContent='从JSON更新编辑器';advanced.append(load,status);
  let items=[];
  function decode(raw){if(!raw.trim())return [];let data;try{data=JSON.parse(raw);}catch(_){data=JSON.parse('['+raw+']');}if(data&&typeof data==='object'&&!Array.isArray(data)&&data.name)data=[data];if(!Array.isArray(data))throw Error('请输入菜单数组或旧版菜单对象');return data.map(normalize);}
  function normalize(row){if(!row||typeof row!=='object')throw Error('菜单项必须是对象');return {name:String(row.name||''),link:String(row.link||''),target:row.target==='_blank'?'_blank':'_self',...(Array.isArray(row.sub)&&row.sub.length?{sub:row.sub.map(normalize)}:{})};}
  function save(){field.value=JSON.stringify(items,null,2);field.dispatchEvent(new Event('input',{bubbles:true}));status.textContent='菜单修改将在点击页面“保存设置”后生效。';}
  function button(text,action){const el=document.createElement('button');el.type='button';el.textContent=text;el.addEventListener('click',action);return el;}
  function draw(){
   root.replaceChildren();
   const hint=document.createElement('p');hint.textContent='在上方选择“完全自定义导航”可替换全部菜单。使用↑↓调整顺序；支持二级菜单。';root.append(hint);
   const list=document.createElement('div');root.append(list);
   function rowEditor(row,group,index,isChild){
    const box=document.createElement(isChild?'div':'details');box.className=isChild?'hh-menu-child':'hh-menu-group';let heading;
    if(!isChild){heading=document.createElement('summary');heading.textContent=(index+1)+'. '+(row.name||'未命名菜单')+(row.sub?.length?' · '+row.sub.length+'个子菜单':'');box.append(heading);box.open=index===0;}
    const body=document.createElement('div');body.className='hh-menu-row';box.append(body);
    function input(label,key){const wrap=document.createElement('label');wrap.textContent=label;const input=document.createElement('input');input.type='text';input.value=row[key];input.required=key==='name'||(key==='link'&&!row.sub?.length);input.addEventListener('invalid',()=>{const parent=input.closest('details');if(parent)parent.open=true;});input.placeholder=key==='link'?'/category/example/ 或 https://…':'菜单名称';input.setAttribute('aria-label',label+'：'+(row.name||'新菜单'));input.addEventListener('input',()=>{row[key]=input.value;if(heading)heading.textContent=(index+1)+'. '+(row.name||'未命名菜单')+(row.sub?.length?' · '+row.sub.length+'个子菜单':'');save();});wrap.append(input);body.append(wrap);}
    input('名称','name');input('链接','link');
    const target=document.createElement('label');target.className='hh-menu-target';const check=document.createElement('input');check.type='checkbox';check.checked=row.target==='_blank';check.addEventListener('change',()=>{row.target=check.checked?'_blank':'_self';save();});target.append(check,document.createTextNode('新窗口'));body.append(target);
    const actions=document.createElement('div');actions.className='hh-menu-actions';body.append(actions);
    [-1,1].forEach(delta=>{const move=button(delta<0?'↑':'↓',()=>{[group[index],group[index+delta]]=[group[index+delta],group[index]];save();draw();});move.disabled=index+delta<0||index+delta>=group.length;move.setAttribute('aria-label',(delta<0?'上移':'下移')+' '+(row.name||'菜单'));actions.append(move);});
    actions.append(button('删除',()=>{group.splice(index,1);save();draw();}));
    if(!isChild){const children=document.createElement('div');children.className='hh-menu-children';(row.sub||[]).forEach((child,i)=>children.append(rowEditor(child,row.sub,i,true)));box.append(children,button('＋ 添加子菜单',()=>{row.sub=row.sub||[];row.sub.push({name:'',link:'',target:'_self'});save();draw();const details=root.querySelectorAll('.hh-menu-group')[index];if(details)details.open=true;}));}
    return box;
   }
   items.forEach((row,index)=>list.append(rowEditor(row,items,index,false)));
   root.append(button('＋ 添加一级菜单',()=>{items.push({name:'',link:'',target:'_self'});save();draw();const all=root.querySelectorAll('.hh-menu-group');if(all.length)all[all.length-1].open=true;}));
   if(!items.length){const empty=document.createElement('p');empty.textContent='还没有自定义菜单。';list.append(empty);}
  }
  load.addEventListener('click',()=>{try{items=decode(field.value);draw();save();status.textContent='JSON已载入，请点击页面“保存设置”。';}catch(error){status.textContent='格式错误：'+error.message;advanced.open=true;}});
  try{items=decode(field.value);draw();}catch(error){status.textContent='原配置无法解析，请在高级JSON中修正：'+error.message;advanced.open=true;root.hidden=true;}
 }
 if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
