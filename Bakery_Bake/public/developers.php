<?php require __DIR__.'/bootstrap.php'; site_header('Our Developers'); ?>
<style>
/* ============================================================
   Developers — premium editorial (v2)
   ============================================================ */
.dev-page{
  --ink:#2b1d14;
  --ink-soft:#5c4638;
  --muted:#8a7364;
  --accent:#b0724a;
  --accent-deep:#8a5530;
  --gold:#c99a5b;
  --line:#efe4da;
  --shadow:0 40px 80px -40px rgba(80,45,20,.35);
}

/* ---------- Hero ---------- */
.dev-hero{
  position:relative;padding:128px 24px 112px;text-align:center;
  overflow:hidden;isolation:isolate;
  background:
    radial-gradient(circle at 12% 18%, #fdeee4 0%, transparent 42%),
    radial-gradient(circle at 88% 82%, #f8e2d3 0%, transparent 42%),
    linear-gradient(160deg,#fffaf6 0%,#fdf3ec 100%);
  border-bottom:1px solid var(--line);
}
.dev-hero::before{
  content:"";position:absolute;inset:0;z-index:-1;opacity:.4;
  background-image:radial-gradient(#e8d5c4 1px,transparent 1px);
  background-size:26px 26px;
  mask-image:radial-gradient(circle at center,black 0%,transparent 75%);
}
.dev-hero .eyebrow{
  display:inline-flex;align-items:center;gap:12px;
  color:var(--accent);letter-spacing:.24em;text-transform:uppercase;
  font-size:11.5px;font-weight:700;margin-bottom:24px;
}
.dev-hero .eyebrow::before,.dev-hero .eyebrow::after{
  content:"";width:28px;height:1px;background:var(--accent);opacity:.45;
}
.dev-hero h1{
  font:600 clamp(36px,6vw,64px)/1.06 'Playfair Display',serif;
  margin:0 auto 24px;max-width:900px;color:var(--ink);
  letter-spacing:-.018em;
}
.dev-hero h1 em{font-style:italic;color:var(--accent-deep)}
.dev-hero p{
  max-width:620px;margin:0 auto;color:var(--ink-soft);
  line-height:1.78;font-size:clamp(15.5px,2vw,17.5px);
}
.dev-hero .divider{
  width:64px;height:2px;border-radius:2px;
  background:linear-gradient(90deg,transparent,var(--gold),transparent);
  margin:38px auto 0;
}

/* ---------- Section scaffold ---------- */
.dev-section{padding:104px 24px;position:relative}
.dev-section--tight{padding:84px 24px}
.dev-section .section-head{
  display:flex;flex-direction:column;align-items:center;
  text-align:center;max-width:680px;margin:0 auto 64px;
}
.dev-section .section-head > *{display:block;width:100%}
.dev-section .section-head .eyebrow{
  display:inline-flex;align-items:center;justify-content:center;gap:10px;
  width:auto;margin:0 auto 14px;
  color:var(--accent);letter-spacing:.2em;text-transform:uppercase;
  font-size:11.5px;font-weight:700;
}
.dev-section .section-head h2{
  font:600 clamp(26px,4vw,38px)/1.2 'Playfair Display',serif;
  margin:0 0 16px;color:var(--ink);letter-spacing:-.01em;
}
.dev-section .section-head p{
  color:var(--ink-soft);line-height:1.75;margin:0;
  font-size:clamp(14.5px,1.6vw,16px);
}

/* ---------- Developer cards ---------- */
.dev-grid{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
  gap:40px;max-width:980px;margin:0 auto;
}
.dev-card{
  position:relative;display:flex;flex-direction:column;
  background:#fff;border:1px solid var(--line);border-radius:28px;
  overflow:hidden;box-shadow:0 1px 2px rgba(80,45,20,.04);
  transition:transform .5s cubic-bezier(.22,.61,.36,1),
             box-shadow .5s ease,border-color .3s;
}
.dev-card:hover{
  transform:translateY(-10px);
  box-shadow:var(--shadow);
  border-color:#e6d3c2;
}
.dev-photo{
  position:relative;width:100%;aspect-ratio:1/1;
  overflow:hidden;background:#f4ebe2;
}
.dev-photo img{
  width:100%;height:100%;object-fit:cover;display:block;
  transition:transform .8s cubic-bezier(.22,.61,.36,1);
}
.dev-card:hover .dev-photo img{transform:scale(1.07)}
.dev-photo::after{
  content:"";position:absolute;inset:0;pointer-events:none;
  background:linear-gradient(180deg,transparent 55%,rgba(43,29,20,.3) 100%);
  opacity:0;transition:opacity .5s ease;
}
.dev-card:hover .dev-photo::after{opacity:1}
.dev-photo .badge{
  position:absolute;top:18px;left:18px;z-index:2;
  display:inline-flex;align-items:center;gap:6px;
  padding:7px 13px;border-radius:999px;
  background:rgba(255,255,255,.94);backdrop-filter:blur(6px);
  font-size:10.5px;font-weight:700;letter-spacing:.14em;
  text-transform:uppercase;color:var(--accent-deep);
  box-shadow:0 6px 18px -6px rgba(0,0,0,.2);
}
.dev-body{padding:34px 32px 36px;display:flex;flex-direction:column;flex:1}
.dev-role{
  display:inline-flex;align-items:center;gap:8px;
  font-size:10.5px;letter-spacing:.18em;text-transform:uppercase;
  color:var(--accent-deep);font-weight:700;margin-bottom:12px;
}
.dev-role::before{content:"";width:18px;height:1.5px;background:var(--accent)}
.dev-body h3{
  font:600 27px/1.18 'Playfair Display',serif;
  margin:0 0 6px;color:var(--ink);
}
.dev-title{font-size:13px;color:var(--muted);margin:0 0 18px;font-weight:500}
.dev-bio{
  color:var(--ink-soft);line-height:1.72;font-size:14.5px;
  margin:0 0 22px;
}
.dev-tags{display:flex;flex-wrap:wrap;gap:8px;margin-top:auto}
.dev-tag{
  font-size:11px;padding:6px 12px;border-radius:999px;
  background:#fdf5ee;color:var(--accent-deep);
  border:1px solid #f0ddc9;font-weight:600;
  transition:background .2s,transform .2s;
}
.dev-card:hover .dev-tag{background:#fbeee0}
.dev-socials{
  display:flex;gap:10px;margin-top:22px;padding-top:20px;
  border-top:1px solid var(--line);
}
.dev-socials a{
  display:inline-flex;align-items:center;justify-content:center;
  width:40px;height:40px;border-radius:13px;
  background:#f8f1ea;color:var(--accent-deep);text-decoration:none;
  font-size:13px;font-weight:700;
  transition:background .22s,color .22s,transform .22s,box-shadow .22s;
}
.dev-socials a:hover{
  background:var(--accent);color:#fff;transform:translateY(-3px);
  box-shadow:0 12px 24px -10px rgba(176,114,74,.6);
}

/* ---------- Tech stack band ---------- */
.dev-stack-band{
  position:relative;overflow:hidden;
  background:linear-gradient(160deg,#2b1d14 0%,#1a110b 100%);
  color:#f4ece2;border-top:1px solid #3a2718;border-bottom:1px solid #3a2718;
}
.dev-stack-band::before{
  content:"";position:absolute;inset:0;opacity:.07;
  background-image:radial-gradient(#c99a5b 1px,transparent 1px);
  background-size:30px 30px;
}
.dev-stack-band .section-head{position:relative}
.dev-stack-band .section-head h2{color:#f4ece2}
.dev-stack-band .section-head p{color:rgba(244,236,226,.7)}
.dev-stack-band .section-head .eyebrow{color:var(--gold)}
.dev-stack{
  position:relative;max-width:980px;margin:0 auto;
  display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));
  gap:1px;background:#3a2718;border:1px solid #3a2718;
  border-radius:22px;overflow:hidden;
}
.stack-item{
  background:#241811;padding:36px 22px;text-align:center;
  transition:background .3s,transform .3s;
}
.stack-item:hover{background:#2f2016;transform:translateY(-2px)}
.stack-item .icon{
  display:block;font-size:24px;margin-bottom:14px;
  color:var(--gold);
}
.stack-item strong{
  display:block;font-size:14.5px;color:#f4ece2;
  margin-bottom:6px;font-weight:600;
}
.stack-item small{font-size:12px;color:rgba(244,236,226,.55)}

/* ---------- CTA ---------- */
.dev-cta-wrap{padding:104px 24px}
.dev-cta{
  position:relative;overflow:hidden;max-width:880px;margin:0 auto;
  text-align:center;padding:80px 48px;border-radius:32px;
  background:linear-gradient(150deg,#4f2869 0%,#331545 100%);
  color:#fff;box-shadow:0 50px 90px -45px rgba(79,40,105,.65);
}
.dev-cta::before{
  content:"";position:absolute;top:-140px;right:-90px;
  width:340px;height:340px;border-radius:50%;
  background:radial-gradient(circle,rgba(201,154,91,.32),transparent 70%);
}
.dev-cta::after{
  content:"";position:absolute;bottom:-160px;left:-100px;
  width:360px;height:360px;border-radius:50%;
  background:radial-gradient(circle,rgba(255,255,255,.09),transparent 70%);
}
.dev-cta .eyebrow{
  position:relative;color:var(--gold);
  letter-spacing:.22em;text-transform:uppercase;
  font-size:11.5px;font-weight:700;margin-bottom:18px;
}
.dev-cta h2{
  position:relative;
  font:600 clamp(27px,4vw,38px)/1.2 'Playfair Display',serif;
  margin:0 0 18px;color:#fff;letter-spacing:-.01em;
}
.dev-cta p{
  position:relative;color:rgba(255,255,255,.8);
  line-height:1.75;max-width:540px;margin:0 auto 34px;
  font-size:clamp(15px,1.7vw,16.5px);
}
.dev-cta .button-light{
  position:relative;display:inline-block;
  background:#fff;color:#331545;padding:15px 34px;border-radius:13px;
  font-weight:600;text-decoration:none;
  box-shadow:0 12px 28px -10px rgba(0,0,0,.4);
  transition:transform .25s,box-shadow .25s,background .25s;
}
.dev-cta .button-light:hover{
  transform:translateY(-3px);
  box-shadow:0 18px 36px -10px rgba(0,0,0,.5);
  background:#fdeee4;
}

/* ---------- Responsive ---------- */
@media(max-width:820px){
  .dev-hero{padding:88px 20px 72px}
  .dev-section{padding:72px 20px}
  .dev-section--tight{padding:64px 20px}
  .dev-grid{gap:28px}
  .dev-cta{padding:64px 32px}
}
@media(max-width:600px){
  .dev-hero{padding:68px 18px 58px}
  .dev-hero .eyebrow{font-size:10.5px;gap:8px}
  .dev-hero .eyebrow::before,.dev-hero .eyebrow::after{width:16px}
  .dev-section{padding:56px 18px}
  .dev-section .section-head{margin-bottom:44px}
  .dev-body{padding:24px 22px 26px}
  .dev-body h3{font-size:23px}
  .stack-item{padding:28px 18px}
  .dev-cta-wrap{padding:64px 18px}
  .dev-cta{padding:50px 24px;border-radius:24px}
}
</style>

<div class="dev-page">
  <section class="dev-hero">
    <div class="eyebrow">The people behind the bake</div>
    <h1>Crafted with <em>care</em>, built to <em>last</em>.</h1>
    <p>Bakery Bake is powered by a small, dedicated team of developers who built this platform from the ground up — combining thoughtful design, reliable engineering, and a shared love for beautiful things.</p>
    <div class="divider"></div>
  </section>

  <section class="dev-section">
    <div class="section-head">
      <div class="eyebrow">Meet the developers</div>
      <h2>The minds behind Bakery Bake</h2>
      <p>Two developers, one shared vision: a bakery experience that feels as good as it tastes.</p>
    </div>
    <div class="dev-grid">

      <!-- Developer 1: Ahmad Hussaini -->
      <article class="dev-card">
        <div class="dev-photo">
          <span class="badge">Lead Developer</span>
          <!-- TODO: Replace with Ahmad's real photo, e.g. uploads/ahmad.jpg -->
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=900&q=85" alt="Ahmad Hussaini" loading="lazy">
        </div>
        <div class="dev-body">
          <div class="dev-role">Lead Developer</div>
          <h3>Ahmad Hussaini</h3>
          <p class="dev-title">Full-Stack Engineer &amp; Architect</p>
          <p class="dev-bio">Ahmad designed and built the core of Bakery Bake — from the storefront and admin dashboard to the order pipeline and delivery logic. He cares deeply about clean code, fast load times, and making complex things feel simple for the people using them.</p>
          <div class="dev-tags">
            <span class="dev-tag">PHP</span>
            <span class="dev-tag">JavaScript</span>
            <span class="dev-tag">MySQL</span>
            <span class="dev-tag">UI Engineering</span>
            <span class="dev-tag">System Design</span>
          </div>
          <div class="dev-socials">
            <!-- TODO: Replace with Ahmad's real links -->
            <a href="#" aria-label="Ahmad on GitHub" title="GitHub">⌘</a>
            <a href="#" aria-label="Ahmad on LinkedIn" title="LinkedIn">in</a>
            <a href="#" aria-label="Ahmad on X" title="X">✕</a>
            <a href="mailto:ahmad@example.com" aria-label="Email Ahmad" title="Email">✉</a>
          </div>
        </div>
      </article>

      <!-- Developer 2: Ameer Yusuf -->
      <article class="dev-card">
        <div class="dev-photo">
          <span class="badge">Developer</span>
          <!-- TODO: Replace with Ameer's real photo, e.g. uploads/ameer.jpg -->
          <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=900&q=85" alt="Ameer Yusuf" loading="lazy">
        </div>
        <div class="dev-body">
          <div class="dev-role">Developer</div>
          <h3>Ameer Yusuf</h3>
          <p class="dev-title">Frontend &amp; Experience Engineer</p>
          <p class="dev-bio">Ameer shaped the look and feel of Bakery Bake — the gallery, product cards, checkout flow, and the little details that make browsing feel effortless. He focuses on responsive design, accessibility, and interfaces that work beautifully on every screen.</p>
          <div class="dev-tags">
            <span class="dev-tag">HTML &amp; CSS</span>
            <span class="dev-tag">JavaScript</span>
            <span class="dev-tag">Responsive Design</span>
            <span class="dev-tag">Accessibility</span>
            <span class="dev-tag">Animation</span>
          </div>
          <div class="dev-socials">
            <!-- TODO: Replace with Ameer's real links -->
            <a href="#" aria-label="Ameer on GitHub" title="GitHub">⌘</a>
            <a href="#" aria-label="Ameer on LinkedIn" title="LinkedIn">in</a>
            <a href="#" aria-label="Ameer on X" title="X">✕</a>
            <a href="mailto:ameer@example.com" aria-label="Email Ameer" title="Email">✉</a>
          </div>
        </div>
      </article>

    </div>
  </section>

  <section class="dev-section dev-section--tight dev-stack-band">
    <div class="section-head">
      <div class="eyebrow">Under the hood</div>
      <h2>Built on a solid foundation</h2>
      <p>Simple, dependable technology chosen for speed, security, and ease of maintenance.</p>
    </div>
    <div class="dev-stack">
      <div class="stack-item"><span class="icon">⚙</span><strong>PHP</strong><small>Server-side logic</small></div>
      <div class="stack-item"><span class="icon">◆</span><strong>JSON Storage</strong><small>Lightweight data layer</small></div>
      <div class="stack-item"><span class="icon">◇</span><strong>HTML5 &amp; CSS3</strong><small>Responsive interfaces</small></div>
      <div class="stack-item"><span class="icon">✦</span><strong>Vanilla JS</strong><small>Fast, no dependencies</small></div>
      <div class="stack-item"><span class="icon">🔒</span><strong>CSRF &amp; Sessions</strong><small>Secure by default</small></div>
      <div class="stack-item"><span class="icon">✉</span><strong>Email Notifications</strong><small>Order alerts &amp; receipts</small></div>
    </div>
  </section>

  <section class="dev-cta-wrap">
    <div class="dev-cta">
      <div class="eyebrow">Let's talk</div>
      <h2>Want to build something beautiful too?</h2>
      <p>We love thoughtful projects and good conversations. Reach out if you'd like to work with us or just say hello.</p>
      <a class="button button-light" href="contact.php">Get in touch</a>
    </div>
  </section>
</div>

<?php site_footer(); ?>