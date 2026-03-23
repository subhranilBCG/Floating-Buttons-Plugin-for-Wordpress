<?php
/**
 * Plugin Name: Floating Contact Buttons Pro
 * Description: Advanced floating contact buttons with admin interface.
 * Version: 1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;
define( 'FCB_VERSION', '1.2' );

function fcb_default_settings() {
    return [
        'enabled'     => 1,
        'position'    => 'bottom-right',
        'orientation' => 'vertical',
        'offset_x'    => 24,
        'offset_y'    => 24,
        'buttons'  => [
            [ 'enabled'=>1, 'label'=>'WhatsApp',        'type'=>'whatsapp', 'phone'=>'919876543210', 'email'=>'', 'url'=>'https://wa.me/919876543210', 'bg'=>'#25D366', 'text'=>'#ffffff', 'icon'=>'fcb-whatsapp',        'shape'=>'pill', 'size'=>'48', 'icon_size'=>'20', 'padding_x'=>'20' ],
            [ 'enabled'=>1, 'label'=>'Book Appointment', 'type'=>'custom',   'phone'=>'',            'email'=>'', 'url'=>'#appointment',               'bg'=>'#0BDADA', 'text'=>'#102222', 'icon'=>'dashicons-calendar-alt', 'shape'=>'pill', 'size'=>'48', 'icon_size'=>'20', 'padding_x'=>'20' ],
            [ 'enabled'=>0, 'label'=>'Call Now',         'type'=>'tel',      'phone'=>'919876543210', 'email'=>'', 'url'=>'tel:+919876543210',         'bg'=>'#102222', 'text'=>'#ffffff', 'icon'=>'dashicons-phone',        'shape'=>'pill', 'size'=>'48', 'icon_size'=>'20', 'padding_x'=>'20' ],
        ],
    ];
}

function fcb_get_settings() {
    $saved = get_option( 'fcb_settings' );
    return $saved ? $saved : fcb_default_settings();
}

function fcb_build_url( $type, $phone, $email, $url ) {
    switch ( $type ) {
        case 'whatsapp': return 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $phone );
        case 'tel':      return 'tel:+' . ltrim( preg_replace( '/[^0-9+]/', '', $phone ), '+' );
        case 'email':    return 'mailto:' . sanitize_email( $email );
        default:         return esc_url_raw( $url );
    }
}

function fcb_whatsapp_svg( $w = 20, $h = 20 ) {
    return '<svg class="fcb-icon-svg" viewBox="0 0 24 24" fill="currentColor" width="'.$w.'" height="'.$h.'" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
}

// Admin menu
add_action( 'admin_menu', function () {
    add_menu_page( 'Floating Contact Buttons', 'Floating Buttons', 'manage_options', 'fcb-settings', 'fcb_admin_page', 'dashicons-phone', 80 );
} );
function fcb_admin_page() {
    include plugin_dir_path( __FILE__ ) . 'admin-page.php';
}

// Save
add_action( 'admin_post_fcb_save', function () {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
    check_admin_referer( 'fcb_save_settings', 'fcb_nonce' );

    $raw     = isset( $_POST['fcb'] ) ? $_POST['fcb'] : [];
    $types   = [ 'whatsapp','tel','email','custom' ];
    $shapes  = [ 'circle','pill','rounded' ];

    $settings = [
        'enabled'     => isset( $raw['enabled'] ) ? 1 : 0,
        'position'    => sanitize_text_field( $raw['position'] ?? 'bottom-right' ),
        'orientation' => in_array( $raw['orientation'] ?? '', ['vertical','horizontal'], true ) ? $raw['orientation'] : 'vertical',
        'offset_x'    => absint( $raw['offset_x'] ?? 24 ),
        'offset_y'    => absint( $raw['offset_y'] ?? 24 ),
        'buttons'  => [],
    ];

    $count = count( fcb_default_settings()['buttons'] );
    for ( $i = 0; $i < $count; $i++ ) {
        $b    = $raw['buttons'][ $i ] ?? [];
        $type = in_array( $b['type'] ?? '', $types, true ) ? $b['type'] : 'custom';

        $settings['buttons'][] = [
            'enabled' => isset( $b['enabled'] ) ? 1 : 0,
            'label'   => sanitize_text_field( $b['label'] ?? '' ),
            'type'    => $type,
            'phone'   => sanitize_text_field( $b['phone'] ?? '' ),
            'email'   => sanitize_email( $b['email'] ?? '' ),
            'url'     => fcb_build_url( $type, $b['phone'] ?? '', $b['email'] ?? '', $b['url'] ?? '' ),
            'bg'      => sanitize_hex_color( $b['bg']   ?? '#000000' ),
            'text'    => sanitize_hex_color( $b['text'] ?? '#ffffff' ),
            'icon'      => sanitize_html_class( $b['icon'] ?? '' ),
            'shape'     => in_array( $b['shape'] ?? '', $shapes, true ) ? $b['shape'] : 'pill',
            'size'      => absint( $b['size']      ?? 48 ),
            'icon_size' => absint( $b['icon_size'] ?? 20 ),
            'padding_x' => absint( $b['padding_x'] ?? 20 ),
        ];
    }

    update_option( 'fcb_settings', $settings );
    wp_redirect( admin_url( 'admin.php?page=fcb-settings&saved=1' ) );
    exit;
} );

// Frontend output
add_action( 'wp_footer', function () {
    $s = fcb_get_settings();
    if ( empty( $s['enabled'] ) ) return;

    $pos    = esc_attr( $s['position'] );
    $x      = absint( $s['offset_x'] );
    $y      = absint( $s['offset_y'] );
    $orient = esc_attr( $s['orientation'] ?? 'vertical' );
    $v_prop = strpos( $pos, 'bottom' ) !== false ? 'bottom' : 'top';
    $h_prop = strpos( $pos, 'right' )  !== false ? 'right'  : 'left';
    ?>
    <div class="fcb-container <?php echo $pos; ?> orientation-<?php echo $orient; ?>" style="<?php echo "{$v_prop}:{$y}px;{$h_prop}:{$x}px;"; ?>">
        <?php foreach ( $s['buttons'] as $btn ) :
            if ( empty( $btn['enabled'] ) ) continue;
            $bg        = esc_attr( $btn['bg'] );
            $color     = esc_attr( $btn['text'] );
            $size      = absint( $btn['size'] );
            $shape     = esc_attr( $btn['shape'] );
            $url       = esc_url( $btn['url'] );
            $label     = esc_html( $btn['label'] );
            $icon      = $btn['icon'] ?? '';
            $icon_size = absint( $btn['icon_size'] ?? 20 );
            $padding_x = absint( $btn['padding_x'] ?? 20 );
            $is_circle = ( $shape === 'circle' );
            $btn_style = "background:{$bg};color:{$color};height:{$size}px;padding:0 {$padding_x}px;" . ( $is_circle ? "width:{$size}px;padding:0;" : '' );
        ?>
            <a href="<?php echo $url; ?>" class="fcb-btn <?php echo $shape; ?>"
               style="<?php echo $btn_style; ?>" target="_blank" rel="noopener noreferrer">
                <?php if ( $icon === 'fcb-whatsapp' ) : ?>
                    <?php echo fcb_whatsapp_svg($icon_size,$icon_size); ?>
                <?php elseif ( $icon ) : ?>
                    <span class="dashicons <?php echo esc_attr($icon); ?> fcb-dashicon" style="font-size:<?php echo $icon_size; ?>px;width:<?php echo $icon_size; ?>px;height:<?php echo $icon_size; ?>px;"></span>
                <?php endif; ?>
                <?php if ( ! $is_circle ) : ?>
                    <span class="fcb-btn-label"><?php echo $label; ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
} );

// Enqueue frontend
add_action( 'wp_enqueue_scripts', function () {
    $s = fcb_get_settings();
    $needs_dashicons = false;
    foreach ( $s['buttons'] as $b ) {
        if ( ! empty($b['enabled']) && ! empty($b['icon']) && $b['icon'] !== 'fcb-whatsapp' ) {
            $needs_dashicons = true; break;
        }
    }
    if ( $needs_dashicons ) wp_enqueue_style( 'dashicons' );
    wp_enqueue_style( 'fcb-style', plugin_dir_url(__FILE__).'styles.css', [], FCB_VERSION );
} );

// Enqueue admin
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( $hook !== 'toplevel_page_fcb-settings' ) return;
    wp_enqueue_script( 'fcb-admin-script', plugin_dir_url(__FILE__).'script.js', [], FCB_VERSION, true );
    wp_enqueue_style( 'fcb-admin-style', plugin_dir_url(__FILE__).'styles.css', [], FCB_VERSION );
} );
