# Floating Contact Buttons Pro

A modern, highly customizable WordPress plugin that adds floating, fixed-position contact buttons to your site. Connect with your users through WhatsApp, Phone Calls, Emails, or Custom Links directly from any page.

## 🌟 Features

*   **Multiple Contact Methods**: Add up to 3 distinct buttons for WhatsApp, direct phone calls (`tel:`), email (`mailto:`), or custom URLs.
*   **Live Admin Preview**: See exactly how your buttons will look and behave in real-time as you tweak the settings in the WordPress dashboard.
*   **Deep Customization**:
    *   **Custom Colors**: Advanced color picker with hex input and color swatches for both background and text.
    *   **Shapes & Sizes**: Choose between Pill, Circle, or Rounded Square. Control the overall height (32px - 80px).
    *   **Granular Sizing**: Adjust specific icon sizes (12px - 40px) and left/right button padding separately.
    *   **Icons**: Pick from a curated list of Dashicons or the official WhatsApp SVG.
*   **Flexible Positioning**: 
    *   Snap to 6 different anchor points (Top Left, Top Right, Middle Left, Middle Right, Bottom Left, Bottom Right).
    *   Adjust horizontal and vertical offsets (px).
    *   **Orientation Control**: Stack buttons vertically or lay them out horizontally.
*   **Elementor & Theme Compatible**: Uses robust `z-index` and fixed positioning to ensure buttons always stay visible above builder content and site headers/footers.
*   **Smooth Animations**: Buttons slide in gracefully on page load.
*   **Secure & Optimized**: Built with strict WordPress security standards (nonces, sanitization, escaping) and lightweight inline styles to minimize frontend load.

## 🚀 Installation

1. Download the plugin folder `floating-contact-buttons-pro`.
2. Upload the folder to your `wp-content/plugins/` directory, or upload the zip file directly via the WordPress Admin (Plugins > Add New > Upload Plugin).
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. A new menu item "Contact Buttons" will appear in your WordPress sidebar.

## ⚙️ Configuration

Navigate to **Contact Buttons** in the WordPress admin panel.

### General Settings
*   **Enable/Disable**: Toggle the global visibility of the floating buttons.
*   **Button Position**: Choose which corner or edge of the screen the buttons anchor to.
*   **Button Orientation**: Choose whether multiple buttons stack **Vertically** or flow **Horizontally** from the anchor point.
*   **Offsets**: Nudge the button container inward from the edge of the screen (in pixels).

### Individual Button Settings (Up to 3)
*   **Enable**: Toggle individual buttons on or off.
*   **Label**: The text displayed next to the icon (hidden if the shape is set to "Circle").
*   **Action Type**: Select WhatsApp, Phone Call, Email, or Custom Link. The form will dynamically update to ask for the correct input (Phone Number, Email Address, or URL).
*   **Colors**: Set the Background and Text color using the visual swatch or direct HEX input.
*   **Icon**: Select a matching icon from the grid.
*   **Shape**: Pill (rounded edges), Rounded (slight border radius), or Circle (icon only).
*   **Sizes & Spacing**:
    *   *Height*: Total height of the button.
    *   *Icon Size*: Size of the inner SVG or Dashicon.
    *   *H. Padding*: Left and right inner spacing of the button.

## 🛠️ Requirements
*   WordPress 5.0 or higher.
*   PHP 7.4 or higher.

## 📝 License
This project is licensed under the GPL v2 or later, standard for WordPress plugins.
