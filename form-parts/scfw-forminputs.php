<?php
defined( 'ABSPATH' ) || exit; 
?>

<div class="scfw-container">
    <?php if(get_option('scfw_name_enabled')) { ?>
        <div class="scfw-field<?= !is_null(get_option('scfw_name_order')) ? " flex-order-" . get_option('scfw_name_order') : '' ?><?= get_option('scfw_name_required') ? " scfw-required" : '' ?>" id="scfw-name">
            <label for="visitor_name" id="scfw-name"><?= !is_null(get_option('scfw_name_name')) ? get_option('scfw_name_name') : 'Name' ?>:<?= get_option('scfw_name_required') ? "<span>*</span>" : '' ?></label>
            <input id="visitor_name" name="visitor_name" placeholder="<?= !is_null(get_option('scfw_name_placeholder')) ? get_option('scfw_name_placeholder') : 'Name' ?>" />
        </div>
    <?php } ?>
    <?php if(get_option('scfw_email_enabled')) { ?>
        <div class="scfw-field<?= !is_null(get_option('scfw_email_order')) ? " flex-order-" . get_option('scfw_email_order') : '' ?><?= get_option('scfw_email_required') ? " scfw-required" : '' ?>" id="scfw-email">
            <label for="visitor_email" id="scfw-email"><?= !is_null(get_option('scfw_email_name')) ? get_option('scfw_email_name') : 'Email' ?>:<?= get_option('scfw_email_required') ? "<span>*</span>" : '' ?></label>
            <input id="visitor_email" name="visitor_email" placeholder="<?= !is_null(get_option('scfw_email_placeholder')) ? get_option('scfw_email_placeholder') : 'Email' ?>" />
        </div>
    <?php } ?>
    <?php if(get_option('scfw_phone_enabled')) { ?>
        <div class="scfw-field<?= !is_null(get_option('scfw_phone_order')) ? " flex-order-" . get_option('scfw_phone_order') : '' ?><?= get_option('scfw_phone_required') ? " scfw-required" : '' ?>" id="scfw-phone">
            <label for="visitor_phone"><?= !is_null(get_option('scfw_phone_name')) ? get_option('scfw_phone_name') : 'Phone' ?>:<?= get_option('scfw_phone_required') ? "<span>*</span>" : '' ?></label>
            <input id="visitor_phone" name="visitor_phone" placeholder="<?= !is_null(get_option('scfw_phone_placeholder')) ? get_option('scfw_phone_placeholder') : 'Phone' ?>" />
        </div>
    <?php } ?>
    <?php if(get_option('scfw_business_name_enabled')) { ?>
        <div class="scfw-field<?= !is_null(get_option('scfw_business_name_order')) ? " flex-order-" . get_option('scfw_business_name_order') : '' ?><?= get_option('scfw_business_name_required') ? " scfw-required" : '' ?>" id="scfw-business">
            <label for="visitor_business"><?= !is_null(get_option('scfw_business_name_name')) ? get_option('scfw_business_name_name') : 'Business Name' ?>:<?= get_option('scfw_business_name_required') ? "<span>*</span>" : '' ?></label>
            <input id="visitor_business" name="visitor_business" placeholder="<?= !is_null(get_option('scfw_business_name_placeholder')) ? get_option('scfw_business_name_placeholder') : 'Business Name' ?>" />
        </div>
    <?php } ?>
    <?php if(get_option('scfw_subject_line_enabled')) { ?>
        <div class="scfw-field<?= !is_null(get_option('scfw_subject_line_order')) ? " flex-order-" . get_option('scfw_subject_line_order') : '' ?><?= get_option('scfw_subject_line_required') ? " scfw-required" : '' ?>" id="scfw-subject">
            <label for="visitor_subject"><?= !is_null(get_option('scfw_subject_line_name')) ? get_option('scfw_subject_line_name') : 'Subject Line' ?>:<?= get_option('scfw_subject_line_required') ? "<span>*</span>" : '' ?></label>
            <input id="visitor_subject" name="visitor_subject" placeholder="<?= !is_null(get_option('scfw_subject_line_placeholder')) ? get_option('scfw_subject_line_placeholder') : 'Subject Line' ?>" />
        </div>
    <?php } ?>
    <?php if(get_option('scfw_real_person_test_enabled')) { ?>
        <div class="scfw-field<?= !is_null(get_option('scfw_real_person_test_order')) ? " flex-order-" . get_option('scfw_real_person_test_order') : '' ?><?= get_option('scfw_real_person_test_required') ? " scfw-required" : '' ?>" id="scfw-visitorimages">
            <label for="visitor_images"><?= !is_null(get_option('scfw_real_person_test_name')) ? get_option('scfw_real_person_test_name') : 'Real Person Test' ?>:<?= get_option('scfw_real_person_test_required') ? "<span>*</span>" : '' ?></label>
            <?php $scfw_color = get_option('scfw_securityimage_color') ? get_option('scfw_securityimage_color') : '#FFFFFF'; ?>
            <div class="scfw-img-container flex-row">
                <div class="scfw-img-lg">
                    <img width="120" src="<?php echo plugin_dir_url(dirname(__FILE__)) . '/media/img-' . $img_category . '-option' . $img_option . 'a.jpg'; ?>" alt="" loading="lazy">
                    <div class="scfw-overlay" style="background-color: <?php echo $scfw_color; ?>;"></div>
                </div>
                <div class="scfw-img-sm">
                    <img width="50" src="<?php echo plugin_dir_url(dirname(__FILE__)) . '/media/img-sm-1.jpg'; ?>" alt="" loading="lazy">
                    <div class="scfw-overlay" style="background-color: <?php echo $scfw_color; ?>;"></div>
                </div>
                <div class="scfw-img-lg">
                    <img width="120" src="<?php echo plugin_dir_url(dirname(__FILE__)) . '/media/img-' . $img_category . '-option' . $img_option . 'b.jpg'; ?>" alt="" loading="lazy">
                    <div class="scfw-overlay" style="background-color: <?php echo $scfw_color; ?>;"></div>
                </div>
                <div class="scfw-img-sm">
                    <img width="120" src="<?php echo plugin_dir_url(dirname(__FILE__)) . '/media/img-sm-2.jpg'; ?>" alt="" loading="lazy">
                    <div class="scfw-overlay" style="background-color: <?php echo $scfw_color; ?>;"></div>
                </div>
                <input id="visitor_images" name="visitor_images" placeholder="<?= !is_null(get_option('scfw_real_person_test_placeholder')) ? get_option('scfw_real_person_test_placeholder') : 'Answer' ?>" />
            </div>
        </div>
    <?php } ?>
    <div class="scfw-field scfw-antispam">
        <label for="visitor_url">Leave this empty:</label>
        <input id="visitor_url" name="visitor_url" placeholder="URL" />
    </div>
    <div class="scfw-field scfw-antispam">
        <label for="visitor_option">Leave this empty:</label>
        <input id="visitor_option" name="visitor_option" placeholder="Option" value="<?php echo $img_category; ?>, <?php echo $img_option; ?>" />
    </div>
    <?php if(get_option('scfw_message_enabled')) { ?>
        <div class="scfw-field scfw-message<?= !is_null(get_option('scfw_message_order')) ? " flex-order-" . get_option('scfw_message_order') : '' ?><?= get_option('scfw_message_required') ? " scfw-required" : '' ?>" id="scfw-message">
            <label for="visitor_message"><?= !is_null(get_option('scfw_message_name')) ? get_option('scfw_message_name') : 'Message' ?>:<?= get_option('scfw_message_required') ? "<span>*</span>" : '' ?></label>
            <textarea id="visitor_message" name="visitor_message" rows="10" cols="50" placeholder="<?= !is_null(get_option('scfw_message_placeholder')) ? get_option('scfw_message_placeholder') : 'Message' ?>"></textarea>
        </div>
    <?php } ?>
</div>
<?php 
    $scfw_color = get_option('scfw_sendbutton_color') ? get_option('scfw_sendbutton_color') : '#FFFFFF';
    $scfw_text_color = get_option('scfw_sendbutton_text_color') ? get_option('scfw_sendbutton_text_color') : '#000000';
    $scfw_width = get_option('scfw_sendbutton_width') ? get_option('scfw_sendbutton_width') : '';
?>

<div class="scfw-submit" id="scfw-submit" role="button" onclick="validateContactFormFields();" style="<?= !empty($scfw_width) ? 'max-width: ' . $scfw_width . 'px; ' : ''  ?>background-color: <?php echo $scfw_color; ?>; color: <?php echo $scfw_text_color; ?>"><span><?= !is_null(get_option('scfw_sendbutton_text')) ? get_option('scfw_sendbutton_text') : 'Send Message' ?></span></div>
<button id="scfw-submit-actual" type="submit" name="submit"></button>

<?php