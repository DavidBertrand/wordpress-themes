<?php
/**
 * Customer new account email
 *
 * This template has been overriden to change account creation text.
 *
 * @see			https://docs.woocommerce.com/document/template-structure/
 * @author		WooThemes
 * @package		WooCommerce/Templates/Emails
 * @version		1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

	<p><?php printf( __( 'An account has been created for you on %1$s.', 'woocommerce' ), esc_html( $blogname ) ); ?></p>

	<p><?php printf( __( 'You can log in with your email address: %1$s', 'woocommerce' ), '<strong>' . esc_html( $email->user_email ) . '</strong>' ); ?></p>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>

	<p><?php printf( __( 'Your password has been automatically generated: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?></p>

<?php endif; ?>

	<p><?php printf( __( 'You can access your account area to view your orders and change your password here: %s.', 'woocommerce' ), make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); ?></p>

<?php do_action( 'woocommerce_email_footer', $email );