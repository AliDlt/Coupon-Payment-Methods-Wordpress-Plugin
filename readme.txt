=== Coupon Payment Methods ===
Plugin URI: https://github.com/search?q=coupon-payment-methods&type=repositories
Contributors: alidol
Tags: woocommerce, coupons, payment methods, discounts
Requires at least: 5.8
Requires PHP: 7.4
Stable tag: 1.4.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Choose eligible payment methods for each WooCommerce coupon and customize the notice shown for an ineligible payment method.

== Description ==

Coupon Payment Methods adds payment method restrictions to the Usage restriction tab on each WooCommerce coupon. It reads registered gateways from WooCommerce, so it works with gateways such as Zarinpal, DigiPay, and SnappPay without depending on fixed gateway IDs.

When a customer changes the payment method at checkout, WooCommerce recalculates the cart. A coupon discount is excluded for an ineligible method and is restored when an eligible method is selected again.

Payment method eligibility is configured separately on each coupon. The global settings page only controls the ineligible payment method notice. The default notice is: “This coupon is only valid for cash payments.”

The admin interface follows the WordPress locale. English is used by default, and a Persian (`fa_IR`) translation is included.

== Installation ==

1. Copy the `coupon-payment-methods` folder to `/wp-content/plugins/`, or upload a ZIP archive from the Plugins screen.
2. Activate the plugin. WooCommerce must be installed and active.
3. Edit a coupon from WooCommerce → Coupons.
4. In the Usage restriction tab, enable payment method restrictions and choose the eligible methods.
5. To change the notice, open WooCommerce → Coupon settings.

== Frequently Asked Questions ==

= Does this plugin require Zarinpal, DigiPay, or SnappPay? =

No. It reads gateway names and IDs from WooCommerce and works with any gateway registered by its WooCommerce extension.

= Are existing coupons restricted automatically? =

No. Restrictions are off by default for existing coupons.

= Where do I set the eligible payment methods? =

On each coupon, in its Usage restriction tab. The global settings page only controls the notice text.

== Persian ==

افزونه محدودیت روش پرداخت کد تخفیف ووکامرس.

این افزونه برای هر کد تخفیف، در تب «محدودیت استفاده» امکان انتخاب روش‌های پرداخت مجاز را فراهم می‌کند. روش‌ها از خود ووکامرس خوانده می‌شوند و درگاه‌هایی مانند زرین‌پال، دیجی‌پی و اسنپ‌پی را پشتیبانی می‌کند.

با تغییر روش پرداخت در صفحه تسویه‌حساب، مبلغ سفارش و تخفیف دوباره محاسبه می‌شود. تخفیف در روش پرداخت غیرمجاز حذف و با انتخاب روش مجاز دوباره اعمال می‌شود.

تنظیم روش‌های پرداخت برای هر کوپن جداگانه است. صفحه تنظیمات افزونه فقط متن پیام روش پرداخت نامجاز را کنترل می‌کند. متن پیش‌فرض: «این کد تخفیف فقط برای پرداخت نقدی معتبر می‌باشد.»

رابط مدیریت افزونه بر اساس زبان وردپرس فارسی یا انگلیسی نمایش داده می‌شود. ترجمه فارسی افزونه همراه آن ارائه شده است.

=== نصب ===

1. پوشه `coupon-payment-methods` را در مسیر `/wp-content/plugins/` قرار دهید یا ZIP افزونه را از پیشخوان بارگذاری کنید.
2. افزونه و ووکامرس را فعال کنید.
3. کوپن را ویرایش کنید و در تب «محدودیت استفاده» روش‌های مجاز را انتخاب کنید.
4. متن پیام را از مسیر ووکامرس ← تنظیمات کد تخفیف تغییر دهید.

=== پرسش‌های متداول ===

= آیا افزونه به زرین‌پال، دیجی‌پی یا اسنپ‌پی وابسته است؟ =

خیر. افزونه روش‌های ثبت‌شده در ووکامرس را می‌خواند و به افزونه درگاه خاصی وابسته نیست.

= تنظیم روش‌های پرداخت در کجا انجام می‌شود؟ =

در صفحه خود هر کد تخفیف و در تب «محدودیت استفاده». صفحه تنظیمات سراسری فقط متن پیام را تغییر می‌دهد.

== Changelog ==

= 1.4.0 =
* Add English and Persian translations selected from the WordPress locale.
* Put the English plugin description before the Persian description.

= 1.3.0 =
* Rename the plugin slug and main file to coupon-payment-methods.
* Split bootstrap, admin, coupon logic, and admin styles into separate files.
* Add English and Persian interface translations.

= 1.2.0 =
* Recheck applied coupons when the checkout payment method changes.
* Show a custom notice and remove the discount for an ineligible payment method.
