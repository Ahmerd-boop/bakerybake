<?php require __DIR__.'/bootstrap.php'; site_header('Shop cakes'); $all=array_values(array_filter(read_json('products.json',[]),fn($p)=>!empty($p['available']))); $categories=array_values(array_unique(array_map(fn($p)=>$p['category']??'Cakes',$all))); $cat=(string)($_GET['category']??''); ?>
<style>
/* ---------- Shop page: responsive product grid ---------- */
.content{padding-bottom:0}
.filters{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:28px}
.filters .search{flex:1 1 260px;min-width:0}
.filters select{flex:0 1 200px;min-width:0}

.product-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
  gap:26px;
  align-items:stretch;
}
.product-card{
  display:flex;
  flex-direction:column;
  height:100%;
  overflow:hidden;
  border-radius:16px;
  background:#fff;
  border:1px solid var(--line);
  transition:transform .25s ease,box-shadow .25s ease;
}
.product-card:hover{transform:translateY(-4px);box-shadow:0 18px 40px -18px rgba(80,45,20,.28)}

/* Uniform square image — every product same size, cropped consistently */
.product-image{
  display:block;
  width:100%;
  aspect-ratio:1 / 1;
  overflow:hidden;
  background:#f6efe9;
}
.product-image img{
  width:100%;
  height:100%;
  object-fit:cover;
  object-position:center;
  display:block;
  transition:transform .4s ease;
}
.product-card:hover .product-image img{transform:scale(1.04)}

.product-info{
  display:flex;
  flex-direction:column;
  flex:1;
  padding:16px 18px 18px;
  gap:6px;
}
.product-info .category{
  font-size:11px;
  letter-spacing:.14em;
  text-transform:uppercase;
  color:#b0724a;
  font-weight:600;
}
.product-info h3{margin:0;font-size:19px;line-height:1.3}
.product-info h3 a{color:inherit;text-decoration:none}
.product-info h3 a:hover{color:#b0724a}
.product-info p{
  margin:0 0 10px;
  color:#6b5548;
  line-height:1.55;
  font-size:14px;
  display:-webkit-box;
  -webkit-line-clamp:3;
  -webkit-box-orient:vertical;
  overflow:hidden;
}
.product-bottom{
  margin-top:auto;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:10px;
  flex-wrap:wrap;
}
.product-bottom .price{font-weight:600;white-space:nowrap}
.product-bottom .button{white-space:nowrap}

/* ---------- Closing section before footer ---------- */
.shop-closing{
  position:relative;
  margin:72px 0 0;
  padding:64px 24px;
  border-radius:24px;
  overflow:hidden;
  background:linear-gradient(135deg,#fff8f2 0%,#fdeee4 55%,#f8e2d3 100%);
  border:1px solid var(--line);
  text-align:center;
  isolation:isolate;
}
.shop-closing::before,.shop-closing::after{
  content:"";position:absolute;border-radius:50%;opacity:.55;z-index:-1;
}
.shop-closing::before{width:220px;height:220px;background:radial-gradient(circle,#ffd9c2,transparent 70%);top:-80px;left:-60px}
.shop-closing::after{width:260px;height:260px;background:radial-gradient(circle,#ffe9d6,transparent 70%);bottom:-110px;right:-80px}
.shop-closing .eyebrow{color:#b0724a;letter-spacing:.18em;text-transform:uppercase;font-size:12px;font-weight:600;margin-bottom:10px}
.shop-closing h2{font:34px/1.2 'Playfair Display',serif;margin:0 0 12px;color:#3b2a20}
.shop-closing p{max-width:560px;margin:0 auto 26px;color:#6b5548;line-height:1.65}
.shop-closing .divider{width:64px;height:3px;border-radius:3px;background:#c98a5e;margin:0 auto 22px}
.shop-closing .closing-actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
.shop-spacer{height:56px}

/* ---------- Responsive tuning ---------- */
@media(max-width:900px){
  .product-grid{grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:20px}
}
@media(max-width:600px){
  .filters{gap:10px}
  .filters .search,.filters select{flex:1 1 100%}
  .product-grid{grid-template-columns:1fr;gap:18px}
  .product-info{padding:14px}
  .product-bottom{flex-direction:column;align-items:stretch}
  .product-bottom .button{width:100%;text-align:center}
  .shop-closing{margin-top:48px;padding:44px 18px;border-radius:18px}
  .shop-closing h2{font:26px/1.25 'Playfair Display',serif}
  .shop-spacer{height:32px}
}
</style>
<section class="page-hero"><div class="eyebrow">The collection</div><h1>Find your perfect cake.</h1><p>Explore signature bakes, celebration cakes, desserts, and thoughtful gifts. Every cake is made with care and a little extra magic.</p></section><section class="content"><div class="filters"><input class="search" type="search" placeholder="Search cakes by name or flavour…" data-search-target="#product-list" aria-label="Search cakes"><select id="category-filter" aria-label="Filter category" onchange="document.querySelectorAll('[data-category]').forEach(c=>c.hidden=this.value&&c.dataset.category!==this.value)"><option value="">All categories</option><?php foreach($categories as $c): ?><option value="<?= e($c) ?>" <?= $cat===$c?'selected':'' ?>><?= e($c) ?></option><?php endforeach; ?></select><select id="sort-products" aria-label="Sort products" onchange="const g=document.getElementById('product-list');[...g.children].sort((a,b)=>this.value==='price-asc'?+a.dataset.price-+b.dataset.price:this.value==='price-desc'?+b.dataset.price-+a.dataset.price:this.value==='name'?a.dataset.name.localeCompare(b.dataset.name):0).forEach(x=>g.appendChild(x))"><option value="">Featured order</option><option value="price-asc">Price: low to high</option><option value="price-desc">Price: high to low</option><option value="name">Name: A–Z</option></select></div><div class="product-grid" id="product-list"><?php foreach($all as $p): ?><article class="product-card" data-category="<?= e($p['category']??'Cakes') ?>" data-price="<?= (float)$p['price'] ?>" data-name="<?= e($p['name']) ?>" data-searchable="<?= e($p['name'].' '.$p['category'].' '.$p['description'].' '.implode(' ',array_map(fn($f)=>$f['label'],$p['flavours']??[]))) ?>"><a class="product-image" href="product.php?id=<?= e($p['id']) ?>"><img loading="lazy" src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>"></a><div class="product-info"><span class="category"><?= e($p['category']) ?></span><h3><a href="product.php?id=<?= e($p['id']) ?>"><?= e($p['name']) ?></a></h3><p><?= e($p['description']) ?></p><div class="product-bottom"><span class="price">From <?= money((float)$p['price']) ?></span><a class="button button-small" href="product.php?id=<?= e($p['id']) ?>">Choose options</a></div></div></article><?php endforeach; ?></div><?php if(!$all): ?><div class="empty-state"><h2>Our collection is being refreshed.</h2><p>Please check back soon or contact us for a bespoke creation.</p></div><?php endif; ?><div class="shop-closing"><div class="divider"></div><div class="eyebrow">Made for your moment</div><h2>Can't find exactly what you're dreaming of?</h2><p>Every celebration is different. Tell us your theme, flavours, and date, and we'll design a bespoke cake made just for you — from intimate gatherings to grand celebrations.</p><div class="closing-actions"><a class="button" href="custom-request.php">Request a custom cake</a><a class="button button-outline" href="contact.php">Talk to us</a></div></div><div class="shop-spacer"></div></section><?php site_footer(); ?>