=== Moo Elements ===
Contributors: josesotelocohen
Donate link: https://compras.inboundlatino.com/moo-elements/
Tags: moosend, elementor, forms, newsletters, email marketing, subscription form, marketing automation
Requires at least: 4.7
Tested up to: 5.4
Requires PHP: 5.4
Stable tag: 2.0.2
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires [Elementor Pro](https://elementor.com) 2.5 or greater

Simple plugin that integrates Elementor Pro form widget with Moosend via API.


== Description ==


Simple solution for users of Moosend and Elementor that do not wish to modify the functions.php file of their theme. This plugin will allow you to send subscriptions made via Elementor's Pro form widget to your Moosend list.


== Installation ==

= Minimum Requirements =

* WordPress 4.7 or greater
* PHP version 5.4 or greater
* MySQL version 5.0 or greater
* [Elementor Pro](https://elementor.com) 2.5 or greater

= We recommend your host supports: =

* PHP version 7.0 or greater
* MySQL version 5.6 or greater
* WordPress Memory limit of 64 MB or greater (128 MB or higher is preferred)


= Installation =

1. Install using the WordPress built-in Plugin installer, or Extract the zip file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Pages > Add New
4. Press the 'Edit with Elementor' button.
5. Now you can drag and drop the form widget of Elementor Pro from the left panel onto the content area, and find the Moosend action in the "Actions after submit" dropdown.
6. Fill your Moosend List and API Key details and all your subscribers will be sent to that list.
7. Add as many custom fields as you want, you just need to do it with this format: customfieldname=value,customfieldname2=value2. Don't use spaces and separate each custom field with a comma.
8. Name Field ID and Email Field ID are a MUST and you can configure them like this:

[Click here to watch the tutorial](https://storyxpress.co/video/k8o0t57qmuj210biz)



== Frequently Asked Questions ==

**Why do I need this plugin?**

Because there's no native way to send subscribers from Elementor Pro form widget to Moosend, so if you want to avoid modifying your Functions.php to achieve this, you can just install Moo Elements with a couple of clicks.

**Why is Elementor Pro required?**

Because this integration works with the Form Widget, which is a Elementor Pro unique feature not available in the free plugin.

**Can I still use other integrations if I install Moo Elements?**

Yes, all the other form widget integrations will be available. You can even use more than one at the same time per form.

**Do I need to know how to code to use Moo Elements?**

No, you don't and that's the main reason that I created this plugin, so you can integrate both Moosend and Elementor without knowing how to code.


== Screenshots ==

1. **Select from the Dropdown.** Just select Moosend from the "Actions After Submit" dropdown in the form widget.
2. **Moosend List ID.** You can find the list ID in your Moosend List URL.
3. **Moosend API Key.** This is your API Key.
4. **Custom fields.** You need to get the Name of your Moosend Custom field and match it with the ID of a Elementor Form field.

== Changelog ==

= 2.0.2 - 2019-12-20 =
* Solved a bug in which it caused a fatal error when Elementor Pro wasn't active or installed.

= 2.0.0 - 2019-08-19 =
* **Improvement:** Now you can add dynamic custom fields using the name of the Moosend custom field and the ID of the Elementor field. Right now you can use 5 custom fields, need more? Feel free to ping me at soporte@inboundlatino.com and let me know.

= 1.1.0 - 2019-07-08 =
* **New Feature:** You can add custom fields.
* Added a new step to the installation process to show the new feature.

= 1.0.0 - 2019-06-19 =
* Initial Release
