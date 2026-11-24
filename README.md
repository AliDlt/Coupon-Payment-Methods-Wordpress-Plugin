# Coupon Payment Methods

A free WooCommerce extension that lets you choose which payment methods are eligible for each coupon. It also lets you customize the notice shown when a customer selects an ineligible payment method.

## Features

- Read payment methods registered with WooCommerce, including gateways such as Zarinpal, DigiPay, and SnappPay.
- Set eligible methods separately for every coupon.
- Recalculate coupon discounts when the customer changes the payment method at checkout.
- Customize the ineligible payment method notice.
- Show the admin interface in English or Persian based on the WordPress locale.

## Installation

Copy the `coupon-payment-methods` folder into `wp-content/plugins/` and activate it from WordPress. Open a coupon and configure its allowed payment methods in the **Usage restriction** tab. Edit the notice under **WooCommerce → Coupon settings**.

The interface follows the WordPress locale. English is the default, and a Persian (`fa_IR`) translation is included.

Payment method eligibility is configured on each coupon. The global settings page only controls the notice text.

## GitHub

[Search for the repository on GitHub](https://github.com/search?q=coupon-payment-methods&type=repositories). This is a temporary link until the official repository URL is available.

## Development

- Main plugin file: `coupon-payment-methods.php`
- License: GPL-2.0-or-later
- Author: علی دولت آبادی

## فارسی

افزونه‌ای رایگان برای ووکامرس که مشخص می‌کند هر کد تخفیف با کدام روش‌های پرداخت قابل استفاده است. همچنین می‌توانید متن پیام روش پرداخت غیرمجاز را سفارشی کنید.

### امکانات

- دریافت روش‌های پرداخت ثبت‌شده در ووکامرس، از جمله زرین‌پال، دیجی‌پی و اسنپ‌پی
- تعیین روش‌های مجاز به‌صورت جداگانه برای هر کد تخفیف
- محاسبه دوباره تخفیف پس از تغییر روش پرداخت در صفحه تسویه‌حساب
- تنظیم متن پیام روش پرداخت غیرمجاز
- نمایش پنل افزونه به فارسی یا انگلیسی بر اساس زبان رابط وردپرس

### نصب

پوشه `coupon-payment-methods` را در مسیر `wp-content/plugins/` قرار دهید و افزونه را از پیشخوان فعال کنید. روش‌های مجاز را در تب «محدودیت استفاده» خود هر کد تخفیف انتخاب کنید. متن پیام را از مسیر «ووکامرس ← تنظیمات کد تخفیف» تغییر دهید.

تنظیم روش‌های پرداخت برای هر کوپن جداگانه انجام می‌شود؛ صفحه تنظیمات سراسری افزونه فقط متن پیام را کنترل می‌کند.

### گیت‌هاب

[جستجوی مخزن در GitHub](https://github.com/search?q=coupon-payment-methods&type=repositories). این پیوند تا زمان مشخص‌شدن نشانی مخزن اصلی موقت است.
