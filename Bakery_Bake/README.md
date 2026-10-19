# Bakery Bake — Complete PHP + JSON Website

Premium, responsive bakery ordering website for Bakery Bake, Abuja.

## Included
- Responsive storefront, cake catalogue, product detail, gallery, bespoke cake request form, cart, checkout, order tracking, contact/about/policy pages.
- PHP backend with JSON file storage (no MySQL).
- Secure admin setup/login, product CRUD, order status management, delivery zone settings, gallery management, newsletter subscribers, notification log.
- Paystack test-mode checkout initialization and server-side transaction verification.
- Web3Forms form integration configuration; customer and bakery email workflows via PHP mail where configured.
- In-app admin notifications, order lookup by reference, printable receipt, custom message per cart item.
- Sample catalogue records and image URL placeholders that can be replaced in admin.
- Setup and deployment instructions.

## Requirements
- PHP 8.1+ recommended; cURL and OpenSSL enabled.
- Apache hosting/XAMPP with HTTPS for production.
- Writable `private/storage/` directory.
- A real domain and valid TLS certificate for production payments and email.
- Paystack account and Web3Forms configured with your own credentials.

## Local setup (XAMPP)
1. Extract the folder into `C:\xampp\htdocs\Bakery_Bake_Complete`.
2. Keep `private/` outside the public web root on production. For local testing this bundled layout works, but access is denied by `.htaccess` where Apache supports it.
3. Visit `http://localhost/Bakery_Bake_Complete/public/install.php`.
4. Create your own administrator email and password. Do not use a default password.
5. Open `http://localhost/Bakery_Bake_Complete/public/`.
6. Edit `private/config.php` to set your business details and API credentials.
7. Test the complete flow with Paystack test mode before switching to live credentials.

## Hosting deployment (recommended)
- Upload the `public/` folder contents to your hosting document root (often `public_html/`).
- Upload the `private/` folder to a location **outside** `public_html`, for example `/home/USERNAME/bakery-bake-private/`.
- Edit `public/bootstrap.php` and update `PRIVATE_DIR` to the absolute path of that private folder.
- Ensure the private folder is writable by PHP but not publicly accessible.
- Configure HTTPS, PHP 8.1+, cURL, and outbound HTTPS access.
- Configure Paystack callback URL to the deployed `public/paystack-callback.php` URL if you change the routing or domain.
- Delete/disable `install.php` after setup, or restrict it to localhost. It self-disables after successful installation.

## Credentials and security
- The Paystack keys supplied for this project are test keys. The secret key is stored server-side only in `private/config.php`; never move it into JavaScript, public HTML, or a public repository.
- The Web3Forms access key is configured server-side for form workflows. Access keys are not a substitute for server-side validation.
- **Do not put your Gmail account password in this project.** Use a Gmail App Password with SMTP, or a proper mail provider. The Gmail login password is not an SMTP credential.
- The Gmail and Paystack account passwords shared in chat are not embedded in this ZIP. Change them before handing the project to a client because they were disclosed in a conversation.
- Default order references are unpredictable. Order tracking displays limited order details because lookups use the order reference only, as requested. Anyone who obtains a reference may be able to see the order summary; do not share references publicly.
- JSON storage is suitable for a small launch, but it is not a transactional database. Use file locks and backups, keep storage outside public webroot, and move to a database if traffic grows.
- This is a complete starter implementation, but no ZIP can be truthfully guaranteed “100% ready” without testing on your actual hosting, live Paystack account, email configuration, and notification provider.

## Default business settings
- Bakery Bake
- No. 12 Aminu Kano Crescent, Wuse 2, Abuja, FCT, Nigeria
- Call: +234 800 000 0000
- Business email: bakerybakestore@gmail.com
- Instagram: https://www.instagram.com/bakerybake_/
- WhatsApp ordering/notifications were removed as requested.
- Currency: NGN only
- Payment: Paystack (test mode initially)
- Storage: JSON; no MySQL

## Features that require configuration before production
- SMTP / PHP mail deliverability.
- Web3Forms account and key.
- Live Paystack keys and live account activation.
- Real product photography, prices, delivery zone fees, opening hours and preparation lead time.
- Domain, HTTPS and hosting permissions.
