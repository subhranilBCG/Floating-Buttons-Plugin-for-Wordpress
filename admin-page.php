<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$s      = fcb_get_settings();
$saved  = ( isset( $_GET['saved'] ) && $_GET['saved'] === '1' );

$positions = [ 'bottom-right'=>'Bottom Right', 'bottom-left'=>'Bottom Left', 'top-right'=>'Top Right', 'top-left'=>'Top Left' ];
$shapes    = [ 'pill'=>'Pill', 'circle'=>'Circle', 'rounded'=>'Rounded' ];
$btn_types = [ 'whatsapp'=>'💬 WhatsApp', 'tel'=>'📞 Phone Call', 'email'=>'📧 Email', 'custom'=>'🔗 Custom Link' ];

$wa_svg = '<svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';

// Available icons
$icons = [
    ''                       => [ 'label'=>'None',     'html'=>'<span style="font-size:14px;line-height:1;color:#aaa;">✕</span>' ],
    'fcb-whatsapp'           => [ 'label'=>'WhatsApp', 'html'=>$wa_svg ],
    'dashicons-phone'        => [ 'label'=>'Phone',    'html'=>'<span class="dashicons dashicons-phone"></span>' ],
    'dashicons-email'        => [ 'label'=>'Email',    'html'=>'<span class="dashicons dashicons-email"></span>' ],
    'dashicons-calendar-alt' => [ 'label'=>'Calendar', 'html'=>'<span class="dashicons dashicons-calendar-alt"></span>' ],
    'dashicons-location'     => [ 'label'=>'Location', 'html'=>'<span class="dashicons dashicons-location"></span>' ],
    'dashicons-format-chat'  => [ 'label'=>'Chat',     'html'=>'<span class="dashicons dashicons-format-chat"></span>' ],
    'dashicons-heart'        => [ 'label'=>'Heart',    'html'=>'<span class="dashicons dashicons-heart"></span>' ],
    'dashicons-admin-users'  => [ 'label'=>'Person',   'html'=>'<span class="dashicons dashicons-admin-users"></span>' ],
    'dashicons-clock'        => [ 'label'=>'Clock',    'html'=>'<span class="dashicons dashicons-clock"></span>' ],
    'dashicons-info'         => [ 'label'=>'Info',     'html'=>'<span class="dashicons dashicons-info"></span>' ],
    'dashicons-yes-alt'      => [ 'label'=>'Check',    'html'=>'<span class="dashicons dashicons-yes-alt"></span>' ],
    'dashicons-star-filled'  => [ 'label'=>'Star',     'html'=>'<span class="dashicons dashicons-star-filled"></span>' ],
    'dashicons-share'        => [ 'label'=>'Share',    'html'=>'<span class="dashicons dashicons-share"></span>' ],
    'dashicons-id'           => [ 'label'=>'ID Card',  'html'=>'<span class="dashicons dashicons-id"></span>' ],
    'dashicons-store'        => [ 'label'=>'Store',    'html'=>'<span class="dashicons dashicons-store"></span>' ],
];
?>
<div class="wrap fcb-modern-wrap">
    <div class="fcb-header-bar">
        <h1 class="fcb-page-title">
            <span class="dashicons dashicons-phone fcb-accent-icon"></span>
            Floating Contact Buttons <span class="fcb-badge">PRO</span>
        </h1>
        <button type="submit" form="fcb-main-form" class="button button-primary fcb-btn-save">Save Changes</button>
    </div>

    <?php if ( $saved ) : ?>
        <div class="fcb-notice-success"><span class="dashicons dashicons-yes"></span> Settings saved successfully.</div>
    <?php endif; ?>

    <div class="fcb-admin-wrap">
        <!-- LEFT COLUMN: Settings -->
        <div class="fcb-settings-col">
            <form id="fcb-main-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                <?php wp_nonce_field( 'fcb_save_settings', 'fcb_nonce' ); ?>
                <input type="hidden" name="action" value="fcb_save">

                <!-- General -->
                <div class="fcb-card">
                    <h2>⚙️ General Settings</h2>
                    <div class="fcb-toggle-row">
                        <input type="checkbox" id="fcb-enabled" name="fcb[enabled]" value="1" <?php checked( $s['enabled'], 1 ); ?>>
                        <label for="fcb-enabled">Enable floating buttons on the site</label>
                    </div>
                    <div class="fcb-form-row">
                        <label for="fcb-position">Button Position</label>
                        <select id="fcb-position" name="fcb[position]">
                            <?php foreach ( $positions as $v => $l ) : ?>
                                <option value="<?php echo esc_attr($v); ?>" <?php selected($s['position'],$v); ?>><?php echo esc_html($l); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="fcb-form-row">
                        <label for="fcb-orientation">Button Orientation</label>
                        <select id="fcb-orientation" name="fcb[orientation]">
                            <option value="vertical" <?php selected($s['orientation'] ?? 'vertical', 'vertical'); ?>>Vertical</option>
                            <option value="horizontal" <?php selected($s['orientation'] ?? 'vertical', 'horizontal'); ?>>Horizontal</option>
                        </select>
                    </div>

                    <div class="fcb-inline-row">
                        <div class="fcb-form-row">
                            <label>Horizontal Offset (px)</label>
                            <input type="number" name="fcb[offset_x]" value="<?php echo absint($s['offset_x']); ?>" min="0" max="200">
                        </div>
                        <div class="fcb-form-row">
                            <label>Vertical Offset (px)</label>
                            <input type="number" name="fcb[offset_y]" value="<?php echo absint($s['offset_y']); ?>" min="0" max="200">
                        </div>
                    </div>
                </div>

                <?php
                $btn_emojis = ['💬','📅','📞'];
                foreach ( $s['buttons'] as $i => $btn ) :
                    $btype      = $btn['type'] ?? 'custom';
                    $show_phone = in_array( $btype, ['whatsapp','tel'], true );
                    $show_email = ( $btype === 'email' );
                    $show_url   = ( $btype === 'custom' );
                    $cur_icon   = $btn['icon'] ?? '';
                ?>
                <div class="fcb-card">
                    <h2><?php echo $btn_emojis[$i] ?? '🔘'; ?> Button <?php echo $i+1; ?></h2>

                    <div class="fcb-toggle-row">
                        <input type="checkbox" id="fcb-b<?php echo $i; ?>-en" name="fcb[buttons][<?php echo $i; ?>][enabled]" value="1" <?php checked($btn['enabled'],1); ?>>
                        <label for="fcb-b<?php echo $i; ?>-en">Enable this button</label>
                    </div>

                    <div class="fcb-form-row">
                        <label>Button Label</label>
                        <input type="text" name="fcb[buttons][<?php echo $i; ?>][label]" value="<?php echo esc_attr($btn['label']); ?>" placeholder="e.g. Chat with us">
                    </div>

                    <div class="fcb-form-row">
                        <label>Button Type</label>
                        <select name="fcb[buttons][<?php echo $i; ?>][type]" class="fcb-btn-type" data-index="<?php echo $i; ?>">
                            <?php foreach ( $btn_types as $tv => $tl ) : ?>
                                <option value="<?php echo esc_attr($tv); ?>" <?php selected($btype,$tv); ?>><?php echo esc_html($tl); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Phone field (WhatsApp / Call) -->
                    <div class="fcb-form-row fcb-type-field fcb-phone-field-<?php echo $i; ?>" <?php echo $show_phone ? '' : 'style="display:none"'; ?>>
                        <label>Phone Number <small>(with country code, no + or spaces)</small></label>
                        <input type="text" name="fcb[buttons][<?php echo $i; ?>][phone]" value="<?php echo esc_attr($btn['phone'] ?? ''); ?>" placeholder="e.g. 919876543210">
                    </div>

                    <!-- Email field -->
                    <div class="fcb-form-row fcb-type-field fcb-email-field-<?php echo $i; ?>" <?php echo $show_email ? '' : 'style="display:none"'; ?>>
                        <label>Email Address</label>
                        <input type="text" name="fcb[buttons][<?php echo $i; ?>][email]" value="<?php echo esc_attr($btn['email'] ?? ''); ?>" placeholder="hello@example.com">
                    </div>

                    <!-- URL field -->
                    <div class="fcb-form-row fcb-type-field fcb-url-field-<?php echo $i; ?>" <?php echo $show_url ? '' : 'style="display:none"'; ?>>
                        <label>Custom URL</label>
                        <input type="text" name="fcb[buttons][<?php echo $i; ?>][url]" value="<?php echo esc_attr($btn['url'] ?? ''); ?>" placeholder="https:// or #section">
                    </div>

                    <!-- Icon picker -->
                    <div class="fcb-form-row">
                        <label>Icon</label>
                        <div class="fcb-icon-picker">
                            <input type="hidden" class="fcb-icon-val" name="fcb[buttons][<?php echo $i; ?>][icon]" value="<?php echo esc_attr($cur_icon); ?>">
                            <?php foreach ( $icons as $ival => $idata ) : ?>
                                <div class="fcb-icon-opt<?php echo ($ival === $cur_icon) ? ' fcb-icon-sel' : ''; ?>"
                                     data-val="<?php echo esc_attr($ival); ?>"
                                     title="<?php echo esc_attr($idata['label']); ?>">
                                    <?php echo $idata['html']; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Color pickers -->
                    <div class="fcb-color-row">
                        <div class="fcb-color-field">
                            <label>Background Color</label>
                            <div class="fcb-cp-wrap">
                                <div class="fcb-cp-swatch" style="background:<?php echo esc_attr($btn['bg']); ?>">
                                    <input type="color" name="fcb[buttons][<?php echo $i; ?>][bg]" value="<?php echo esc_attr($btn['bg']); ?>" class="fcb-color-native">
                                </div>
                                <input type="text" class="fcb-cp-hex" value="<?php echo esc_attr($btn['bg']); ?>" maxlength="7" placeholder="#000000" autocomplete="off" spellcheck="false">
                            </div>
                        </div>
                        <div class="fcb-color-field">
                            <label>Text / Icon Color</label>
                            <div class="fcb-cp-wrap">
                                <div class="fcb-cp-swatch" style="background:<?php echo esc_attr($btn['text']); ?>">
                                    <input type="color" name="fcb[buttons][<?php echo $i; ?>][text]" value="<?php echo esc_attr($btn['text']); ?>" class="fcb-color-native">
                                </div>
                                <input type="text" class="fcb-cp-hex" value="<?php echo esc_attr($btn['text']); ?>" maxlength="7" placeholder="#ffffff" autocomplete="off" spellcheck="false">
                            </div>
                        </div>
                    </div>

                    <div class="fcb-inline-row">
                        <div class="fcb-form-row">
                            <label>Shape</label>
                            <select name="fcb[buttons][<?php echo $i; ?>][shape]">
                                <?php foreach ( $shapes as $sv => $sl ) : ?>
                                    <option value="<?php echo esc_attr($sv); ?>" <?php selected($btn['shape'],$sv); ?>><?php echo esc_html($sl); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="fcb-form-row">
                            <label>Height (px)</label>
                            <input type="number" name="fcb[buttons][<?php echo $i; ?>][size]" value="<?php echo absint($btn['size']); ?>" min="32" max="80">
                        </div>
                    </div>

                    <div class="fcb-inline-row">
                        <div class="fcb-form-row">
                            <label>Icon Size (px)</label>
                            <input type="number" name="fcb[buttons][<?php echo $i; ?>][icon_size]" value="<?php echo absint($btn['icon_size'] ?? 20); ?>" min="12" max="40">
                        </div>
                        <div class="fcb-form-row">
                            <label>H. Padding (px)</label>
                            <input type="number" name="fcb[buttons][<?php echo $i; ?>][padding_x]" value="<?php echo absint($btn['padding_x'] ?? 20); ?>" min="0" max="60">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </form>
        </div>

        <!-- RIGHT COLUMN: Sticky Preview -->
        <div class="fcb-preview-col-wrapper">
            <div class="fcb-preview-sticky">
                <div class="fcb-preview-header">
                    <h3>Live Preview</h3>
                    <p>This is a rough representation. Exact layout depends on your theme.</p>
                </div>
                <div class="fcb-preview-box" id="fcb-preview-box">
                    <!-- JS injects buttons here -->
                </div>
            </div>
        </div>
    </div>
</div>