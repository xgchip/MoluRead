/* MoluRead sidebar ordering. Native Typecho input remains the saved value. */
(function(){'use strict';
function init(){
 const input=document.querySelector('input[name="sidebarOrder"]');if(!input||input.dataset.sorted)return;input.dataset.sorted='1';
 const names={ShowAboutMe:'博主信息',ShowSidebarYiyan:'一言',ShowHotPosts:'热门文章',ShowSidebarComments:'最新评论',ShowBlogSignage:'博客路牌',ShowDevilEyes:'恶魔之眼',ShowTags:'标签'};
 const keys=[...new Set(input.value.split(',').map(s=>s.trim()).concat(Object.keys(names)))].filter(k=>names[k]);
 const list=document.createElement('ol');list.className='mlr-sidebar-sort';list.setAttribute('aria-label','侧边栏模块顺序');
 const status=document.createElement('p');status.className='mlr-sort-status';status.setAttribute('aria-live','polite');
 input.hidden=true;input.insertAdjacentElement('afterend',list);list.insertAdjacentElement('afterend',status);
 function sync(){input.value=[...list.children].map(row=>row.dataset.key).join(',');input.dispatchEvent(new Event('input',{bubbles:true}));status.textContent='当前顺序：'+[...list.children].map(row=>names[row.dataset.key]).join(' → ');[...list.children].forEach((row,i)=>{row.querySelector('[data-move="up"]').disabled=i===0;row.querySelector('[data-move="down"]').disabled=i===list.children.length-1})}
 let dragged=null;
 keys.forEach(key=>{const row=document.createElement('li');row.dataset.key=key;row.draggable=true;
 const handle=document.createElement('span');handle.className='mlr-sort-handle';handle.textContent='⠿';handle.setAttribute('aria-hidden','true');
 const title=document.createElement('span');title.className='mlr-sort-name';title.textContent=names[key];row.append(handle,title);
 [['up','上移'],['down','下移']].forEach(([dir,label])=>{const button=document.createElement('button');button.type='button';button.dataset.move=dir;button.textContent=dir==='up'?'↑':'↓';button.setAttribute('aria-label',names[key]+label);button.addEventListener('click',()=>{const sibling=dir==='up'?row.previousElementSibling:row.nextElementSibling;if(!sibling)return;if(dir==='up')list.insertBefore(row,sibling);else list.insertBefore(sibling,row);sync();button.focus()});row.appendChild(button)});
 row.addEventListener('dragstart',event=>{dragged=row;row.classList.add('is-dragging');event.dataTransfer.effectAllowed='move';event.dataTransfer.setData('text/plain',key)});
 row.addEventListener('dragover',event=>{if(!dragged||dragged===row)return;event.preventDefault();event.dataTransfer.dropEffect='move';const bounds=row.getBoundingClientRect();list.insertBefore(dragged,event.clientY<bounds.top+bounds.height/2?row:row.nextElementSibling)});
 row.addEventListener('drop',event=>{event.preventDefault();sync()});row.addEventListener('dragend',()=>{row.classList.remove('is-dragging');dragged=null;sync()});list.appendChild(row)});
 // DOM order must not depend on the checked/unchecked state.
 sync();
}
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
