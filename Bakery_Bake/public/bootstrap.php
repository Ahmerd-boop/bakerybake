<?php
declare(strict_types=1);
ob_start();
define('PRIVATE_DIR', dirname(__DIR__) . '/private'); // Change to an absolute path outside public_html on production.
$configPath = PRIVATE_DIR . '/config.php';
$config = is_file($configPath) ? require $configPath : [];
date_default_timezone_set($config['timezone'] ?? 'Africa/Lagos');

// --- Start session ONCE, before any output is sent (fixes "headers already sent") ---
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_name('BAKERYBAKE_SESS');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
// --- end session start ---

function cfg(string $key, mixed $default = null): mixed {
    global $config;
    return $config[$key] ?? $default;
}
function storage_dir(): string { return PRIVATE_DIR . '/storage'; }
function ensure_storage(): void {
    if (!is_dir(storage_dir())) mkdir(storage_dir(), 0750, true);
    $seed = [
      'products.json' => [],
      'orders.json' => [],
      'notifications.json' => [],
      'gallery.json' => [],
      'delivery-zones.json' => [
        ['id'=>'zone-wuse','name'=>'Wuse 2 & nearby','fee'=>1500,'enabled'=>true],
        ['id'=>'zone-central','name'=>'Central Abuja','fee'=>2500,'enabled'=>true],
        ['id'=>'zone-outer','name'=>'Other approved Abuja areas','fee'=>4000,'enabled'=>true]
      ],
      'subscribers.json' => [],
      'custom-requests.json' => [],
      'settings.json' => ['min_lead_hours'=>48,'opening_hours'=>'Monday–Saturday, 9:00 AM–6:00 PM','free_delivery_threshold'=>0],
      'admin.json' => ['installed'=>false,'email'=>'','password_hash'=>'']
    ];
    foreach ($seed as $file=>$data) {
      $path = storage_dir() . '/' . $file;
      if (!is_file($path)) {
        if ($file === 'products.json') $data = sample_products();
        if ($file === 'gallery.json') $data = sample_gallery();
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES), LOCK_EX);
      }
    }
}
function sample_products(): array {
    return [
      ['id'=>'cake-velvet','name'=>'Velvet Celebration Cake','category'=>'Birthday Cakes','description'=>'Soft, rich red velvet layers finished with smooth cream cheese frosting.','price'=>28000,'image'=>'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?auto=format&fit=crop&w=1000&q=85','sizes'=>[['label'=>'6 inch','price'=>28000],['label'=>'8 inch','price'=>38000],['label'=>'10 inch','price'=>52000]],'flavours'=>[['label'=>'Red velvet','extra'=>0],['label'=>'Vanilla','extra'=>0],['label'=>'Chocolate','extra'=>2500]],'available'=>true,'featured'=>true],
      ['id'=>'cake-chocolate','name'=>'Chocolate Dream Cake','category'=>'Chocolate Cakes','description'=>'Deep chocolate sponge, silky ganache and a polished premium finish.','price'=>32000,'image'=>'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=1000&q=85','sizes'=>[['label'=>'6 inch','price'=>32000],['label'=>'8 inch','price'=>44000]],'flavours'=>[['label'=>'Chocolate','extra'=>0],['label'=>'Mocha','extra'=>2000]],'available'=>true,'featured'=>true],
      ['id'=>'cake-wedding','name'=>'Ivory Wedding Cake','category'=>'Wedding Cakes','description'=>'Elegant ivory finish with delicate details for your most memorable celebration.','price'=>95000,'image'=>'https://images.unsplash.com/photo-1535254973040-607b474cb50d?auto=format&fit=crop&w=1000&q=85','sizes'=>[['label'=>'2 tiers','price'=>95000],['label'=>'3 tiers','price'=>145000]],'flavours'=>[['label'=>'Vanilla','extra'=>0],['label'=>'Fruit cake','extra'=>5000]],'available'=>true,'featured'=>true],
      ['id'=>'cake-cheesecake','name'=>'Classic Berry Cheesecake','category'=>'Cheesecakes','description'=>'Creamy baked cheesecake with a bright berry topping and buttery base.','price'=>24000,'image'=>'https://images.unsplash.com/photo-1524351199678-941a58a3df50?auto=format&fit=crop&w=1000&q=85','sizes'=>[['label'=>'Small','price'=>24000],['label'=>'Large','price'=>36000]],'flavours'=>[['label'=>'Berry','extra'=>0],['label'=>'Caramel','extra'=>1500]],'available'=>true,'featured'=>true],
      ['id'=>'brownies-box','name'=>'Fudgy Brownie Box','category'=>'Brownies & Desserts','description'=>'Rich, fudgy chocolate brownies baked for sharing or gifting.','price'=>12000,'image'=>'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&w=1000&q=85','sizes'=>[['label'=>'Box of 6','price'=>12000],['label'=>'Box of 12','price'=>22000]],'flavours'=>[['label'=>'Classic chocolate','extra'=>0],['label'=>'Walnut','extra'=>1500]],'available'=>true,'featured'=>false],
      ['id'=>'cupcake-box','name'=>'Signature Cupcakes','category'=>'Cupcakes & Mini Cakes','description'=>'Beautifully piped cupcakes for celebrations, gifts and sweet moments.','price'=>9500,'image'=>'https://images.unsplash.com/photo-1486427944299-d1955d23e34d?auto=format&fit=crop&w=1000&q=85','sizes'=>[['label'=>'Box of 6','price'=>9500],['label'=>'Box of 12','price'=>18000]],'flavours'=>[['label'=>'Vanilla','extra'=>0],['label'=>'Chocolate','extra'=>0],['label'=>'Red velvet','extra'=>500]],'available'=>true,'featured'=>false],
    ];
}
function sample_gallery(): array {
    $products = sample_products(); $items = [];
    foreach ($products as $p) $items[] = ['id'=>'gallery-'.$p['id'],'title'=>$p['name'],'category'=>$p['category'],'image'=>$p['image'],'product_id'=>$p['id'],'active'=>true];
    return $items;
}
function read_json(string $file, mixed $fallback = []): mixed {
    ensure_storage(); $path = storage_dir() . '/' . basename($file);
    if (!is_file($path)) return $fallback;
    $raw = file_get_contents($path); $data = json_decode($raw ?: '', true);
    return is_array($data) ? $data : $fallback;
}
function write_json(string $file, mixed $data): bool {
    ensure_storage(); $path = storage_dir() . '/' . basename($file);
    $fp = fopen($path, 'c+'); if (!$fp) return false;
    if (!flock($fp, LOCK_EX)) { fclose($fp); return false; }
    ftruncate($fp, 0); rewind($fp);
    $ok = fwrite($fp, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)) !== false;
    fflush($fp); flock($fp, LOCK_UN); fclose($fp); return $ok;
}
function e(mixed $value): string { return htmlspecialchars((string)$value, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'); }
function money(float|int $amount): string { return '₦' . number_format((float)$amount, 0); }
function redirect(string $url): never { header('Location: '.$url); exit; }
function csrf_token(): string { if (session_status() !== PHP_SESSION_ACTIVE) session_start(); if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function csrf_check(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $given = (string)($_POST['csrf'] ?? '');
    if (!$given || !hash_equals($_SESSION['csrf'] ?? '', $given)) { http_response_code(419); exit('Your session expired. Please go back and try again.'); }
}
function order_ref(): string { return 'BB-' . strtoupper(bin2hex(random_bytes(5))); }
function admin_logged_in(): bool { if (session_status() !== PHP_SESSION_ACTIVE) session_start(); return !empty($_SESSION['admin_email']); }
function require_admin(): void { if (!admin_logged_in()) redirect('admin-login.php'); }
function add_notification(string $title, string $message, string $type='info', ?string $orderRef=null): void {
    $items=read_json('notifications.json',[]); array_unshift($items,['id'=>bin2hex(random_bytes(6)),'title'=>$title,'message'=>$message,'type'=>$type,'order_ref'=>$orderRef,'created_at'=>date(DATE_ATOM),'read'=>false]); write_json('notifications.json',array_slice($items,0,500));
}
function send_order_email(array $order, bool $toCustomer=true): bool {
    $to = $toCustomer ? ($order['customer']['email'] ?? '') : (string)cfg('business_email','');
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) return false;
    $subject = $toCustomer ? 'Your Bakery Bake order '.$order['reference'] : 'New Bakery Bake order '.$order['reference'];
    $rows = '';
    foreach (($order['items'] ?? []) as $item) {
      $rows .= '<tr><td style="padding:10px;border-bottom:1px solid #eee">'.e($item['name']).'<br><small>'.e($item['size']??''). ' · '.e($item['flavour']??'').'</small><br><small>Message: '.e($item['custom_message']??'').'</small></td><td style="padding:10px;text-align:center">'.(int)$item['qty'].'</td><td style="padding:10px;text-align:right">'.money((float)$item['line_total']).'</td></tr>';
    }
    $address = ($order['fulfilment']==='delivery') ? e($order['delivery']['address']??'') . ', ' . e($order['delivery']['area']??'') : e(cfg('address'));
    $body = '<div style="font-family:Arial,sans-serif;color:#302438;max-width:680px;margin:auto"><div style="background:#4f2869;padding:28px;color:#fff;text-align:center"><h1 style="margin:0;font-family:Georgia,serif">Bakery Bake</h1><p style="margin:8px 0 0">Made for your sweetest moments</p></div><div style="padding:28px"><h2>'.($toCustomer?'Thank you for your order!':'A new order has arrived').'</h2><p>Order reference: <strong>'.e($order['reference']).'</strong></p><p>Payment status: <strong>'.e(strtoupper($order['payment_status'])).'</strong></p><table style="width:100%;border-collapse:collapse"><thead><tr><th align="left">Item</th><th>Qty</th><th align="right">Amount</th></tr></thead><tbody>'.$rows.'</tbody></table><div style="text-align:right;margin-top:18px"><p>Subtotal: '.money((float)$order['subtotal']).'</p><p>Delivery: '.money((float)$order['delivery_fee']).'</p><h2>Total: '.money((float)$order['total']).'</h2></div><h3>'.($order['fulfilment']==='delivery'?'Delivery details':'Pickup details').'</h3><p>'.e($order['customer']['name']??'').'<br>'.e($order['customer']['phone']??'').'<br>'.$address.'<br>Scheduled: '.e($order['scheduled_at']??'To be arranged').'</p><p>Order status: '.e($order['status']).'</p><p>Track your order by visiting the website and entering your order reference.</p><hr><p style="font-size:12px;color:#777">Bakery Bake · '.e(cfg('address')).' · '.e(cfg('business_phone')).'</p></div></div>';
    $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
    $from = (string)cfg('mail_from_email',cfg('business_email',''));
    if ($from && filter_var($from,FILTER_VALIDATE_EMAIL)) $headers .= "From: ".cfg('mail_from_name','Bakery Bake')." <".$from.">\r\n";
    // PHP mail is a fallback. Configure SMTP or a transactional mail provider for reliable production delivery.
    return @mail($to, $subject, $body, $headers);
}
function notify_order(array $order): void {
    add_notification('New order '.$order['reference'],'Order received from '.($order['customer']['name']??'customer').' for '.money((float)$order['total']).'.','order',$order['reference']);
    $customerSent=send_order_email($order,true);
    $bakerySent=send_order_email($order,false);
    $logs=read_json('notifications.json',[]);
    array_unshift($logs,['id'=>bin2hex(random_bytes(6)),'title'=>'Email delivery result','message'=>'Customer email: '.($customerSent?'submitted to mail transport':'failed/not configured').'; bakery email: '.($bakerySent?'submitted to mail transport':'failed/not configured'),'type'=>'email','order_ref'=>$order['reference'],'created_at'=>date(DATE_ATOM),'read'=>false]);
    write_json('notifications.json',array_slice($logs,0,500));
}
function site_header(string $title='Bakery Bake'): void {
    $brand=e(cfg('site_name','Bakery Bake'));
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#4f2869"><title>'.e($title).' | '.$brand.'</title><link rel="preconnect" href="https://images.unsplash.com"><link rel="stylesheet" href="assets/css/style.css"><script defer src="assets/js/app.js"></script></head><body><div class="announcement">Handcrafted cakes for life’s sweetest moments <span>·</span> Abuja, Nigeria</div><header class="site-header"><a class="brand" href="index.php"><span class="brand-mark">b</span><span><strong>Bakery Bake</strong></span></a><button class="menu-toggle" aria-label="Open menu" aria-expanded="false">☰</button><nav class="nav"><a href="cakes.php">Shop cakes</a><a href="gallery.php">Gallery</a><a href="custom-cake.php">Custom cakes</a><a href="about.php">Our story</a><a href="contact.php">Contact</a><a href="track.php">Track order</a></nav><a class="cart-link" href="cart.php" aria-label="Shopping cart">♧ <span>Cart</span></a></header><main>';
}
function site_footer(): void {
    echo '</main><footer class="site-footer"><div class="footer-grid"><div><a class="brand brand-light" href="index.php"><span class="brand-mark">b</span><span><strong>Bakery Bake</strong><small>Made with love, baked with care</small></span></a><p>Beautiful cakes, thoughtful details, and sweet memories made in Abuja.</p><a href="'.e(cfg('instagram_url','https://www.instagram.com/bakerybake_/')).'" target="_blank" rel="noopener">◎ Instagram</a></div><div><h4>Explore</h4><a href="cakes.php">Shop cakes</a><a href="gallery.php">Cake gallery</a><a href="custom-cake.php">Request a custom cake</a><a href="track.php">Track an order</a><a href="developers.php">Developers</a></div><div><h4>Visit us</h4><p>'.e(cfg('address')).'</p><p>'.e(cfg('business_phone')).'<br>'.e(cfg('business_email')).'</p><p>'.e(cfg('opening_hours','Monday–Saturday, 9 AM–6 PM')).'</p></div><div><h4>Stay in the loop</h4><p>Occasional bakery news and sweet inspiration.</p><form class="newsletter-form" action="newsletter.php" method="post"><input type="email" name="email" placeholder="Your email address" required aria-label="Email address"><input type="hidden" name="csrf" value="'.e(csrf_token()).'"><button class="button button-light" type="submit">Subscribe</button></form><small>By subscribing, you agree to receive email updates. Unsubscribe any time.</small></div></div><div class="footer-bottom"><span>© '.date('Y').' Bakery Bake. All rights reserved.</span><span><a href="privacy.php">Privacy</a> · <a href="terms.php">Terms</a> · <a href="admin-login.php">Admin</a></span><span>Payments securely processed by Paystack</span></div></footer></body></html>';
}
ensure_storage();