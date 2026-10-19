document.addEventListener('DOMContentLoaded',()=>{
 const toggle=document.querySelector('.menu-toggle'), nav=document.querySelector('.nav');
 if(toggle&&nav) toggle.addEventListener('click',()=>{const open=nav.classList.toggle('open');toggle.setAttribute('aria-expanded',open?'true':'false');});
 document.querySelectorAll('[data-search-target]').forEach(input=>{
   const target=document.querySelector(input.dataset.searchTarget);
   if(!target)return;
   input.addEventListener('input',()=>{const q=input.value.toLowerCase().trim();target.querySelectorAll('[data-searchable]').forEach(card=>{card.hidden=!card.dataset.searchable.toLowerCase().includes(q);});});
 });
 document.querySelectorAll('[data-size-select],[data-flavour-select]').forEach(el=>el.addEventListener('change',()=>{
   const form=el.closest('form');if(!form)return;
   const size=form.querySelector('[data-size-select]'),flavour=form.querySelector('[data-flavour-select]'),price=form.querySelector('[data-live-price]');
   if(!price)return;
   const sizePrice=Number(size?.selectedOptions[0]?.dataset.price||0),extra=Number(flavour?.selectedOptions[0]?.dataset.extra||0);
   price.textContent='₦'+(sizePrice+extra).toLocaleString('en-NG');
 }));
 document.querySelectorAll('[data-confirm]').forEach(el=>el.addEventListener('click',e=>{if(!confirm(el.dataset.confirm||'Are you sure?'))e.preventDefault();}));
 const slides=[...document.querySelectorAll('.hero-slides')];if(slides.length>1){let i=0;setInterval(()=>{slides[i].classList.remove('active');i=(i+1)%slides.length;slides[i].classList.add('active');},6500);}
});
