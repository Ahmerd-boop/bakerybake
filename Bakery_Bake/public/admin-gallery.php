<?php require __DIR__.'/bootstrap.php';require_admin();$items=read_json('gallery.json',[]);$message='';if($_SERVER['REQUEST_METHOD']==='POST'){csrf_check();if(($_POST['action']??'')==='delete'){$id=(string)($_POST['id']??'');$items=array_values(array_filter($items,fn($g)=>$g['id']!==$id));write_json('gallery.json',$items);$message='Gallery item deleted.';}elseif(($_POST['action']??'')==='save'){$title=trim((string)($_POST['title']??''));$category=trim((string)($_POST['category']??''));$image='';
// --- IMAGE UPLOAD HANDLING (replaces Image URL) ---
if(isset($_FILES['image_file']) && is_array($_FILES['image_file']) && ($_FILES['image_file']['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_NO_FILE){
    if($_FILES['image_file']['error']!==UPLOAD_ERR_OK){$message='Image upload failed (error '.$_FILES['image_file']['error'].').';}
    else{
        $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
        $finfo=finfo_open(FILEINFO_MIME_TYPE);
        $mime=finfo_file($finfo,$_FILES['image_file']['tmp_name']);
        finfo_close($finfo);
        if(!isset($allowed[$mime])){$message='Unsupported image type. Use JPG, PNG, WEBP or GIF.';}
        elseif($_FILES['image_file']['size']>5*1024*1024){$message='Image too large (max 5MB).';}
        else{
            $uploadDir=__DIR__.'/uploads';
            if(!is_dir($uploadDir))@mkdir($uploadDir,0755,true);
            $filename='gallery-'.bin2hex(random_bytes(6)).'.'.$allowed[$mime];
            if(move_uploaded_file($_FILES['image_file']['tmp_name'],$uploadDir.'/'.$filename)){
                $image='uploads/'.$filename;
            }else{$message='Could not save uploaded image.';}
        }
    }
}
// --- END IMAGE UPLOAD ---
if($title&&$category&&$image){$items[]=['id'=>'gallery-'.bin2hex(random_bytes(5)),'title'=>$title,'category'=>$category,'image'=>$image,'product_id'=>trim((string)($_POST['product_id']??'')),'active'=>isset($_POST['active'])];write_json('gallery.json',$items);$message='Gallery item added.';}elseif($message==='')$message='Complete all required fields.';}}site_header('Manage gallery'); ?>
<div class="admin-shell"><h1 style="font:42px 'Playfair Display',serif">Gallery management</h1><nav class="admin-nav"><a href="admin.php">Overview</a><a href="admin-products.php">Products</a><a href="admin-orders.php">Orders</a><a href="admin-settings.php">Settings</a><a href="admin-gallery.php">Gallery</a><a href="admin-notifications.php">Notifications</a><a href="admin-subscribers.php">Newsletter</a><a href="admin-requests.php">Custom requests</a><a href="admin-logout.php">Sign out</a></nav><?php if($message)echo '<div class="alert success">'.e($message).'</div>'; ?><div class="cart-layout"><form class="card-panel" method="post" enctype="multipart/form-data"><h2>Add gallery image</h2><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><div class="field"><label>Title</label><input name="title" required></div><div class="field"><label>Category</label><input name="category" placeholder="e.g. Birthday cakes" required></div><div class="field"><label>Image</label><input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif" required><small>JPG, PNG, WEBP or GIF — max 5MB.</small></div><div class="field"><label>Related product ID (optional)</label><input name="product_id"></div><label><input type="checkbox" name="active" checked> Active</label><p><button class="button" type="submit">Add image</button></p></form><div class="card-panel"><h2>Gallery items</h2><?php foreach($items as $g): ?><div style="display:flex;gap:14px;align-items:center;padding:12px 0;border-bottom:1px solid var(--line)"><img src="<?= e($g['image']) ?>" alt="" style="width:80px;height:80px;object-fit:cover"><div style="flex:1"><strong><?= e($g['title']) ?></strong><br><small><?= e($g['category']) ?></small></div><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($g['id']) ?>"><button class="text-link" data-confirm="Delete this gallery item?" type="submit">Delete</button></form></div><?php endforeach; ?></div></div></div><?php site_footer(); ?>