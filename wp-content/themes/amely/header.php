<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Amely
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php echo Amely_Templates::favico(); ?>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php
echo Amely_Templates::mobile_menu();
echo Amely_Templates::header_offcanvas();
?>

<?php do_action( 'amely_site_before' ); ?>

<div id="page-container">

	<?php do_action( 'amely_page_container_top' ); ?>

	<?php

	if ( amely_get_option( 'topbar_on' ) ) {
		get_template_part( 'components/topbar/topbar-' . amely_get_option( 'topbar' ) );
	}

	if ( amely_get_option( 'search_on' ) ) {
		echo Amely_Templates::search_form();
	}

	$header = apply_filters( 'amely_header_layout', amely_get_option( 'header' ) );

	$header_classes   = array( 'site-header' );
	$header_classes[] = 'header-' . $header;

	if ( ! amely_get_option( 'breadcrumbs' ) && ! amely_get_option( 'page_title_on' ) ) {
		$header_classes[] = 'has-margin-bottom';
	}

	?>
	<!-- Header -->
	<header class="<?php echo implode( ' ', $header_classes ); ?>">
		<?php get_template_part( 'components/header/header-' . amely_get_option( 'header' ) ); ?>
	</header>
	<!-- End Header -->
	<?php
	$remove_whitespace = amely_get_option( 'remove_whitespace' );
	$page_title_on     = amely_get_option( 'page_title_on' );

	$container_class = array( 'main-container' );

	if ( $remove_whitespace && ! $page_title_on ) {
		$container_class[] = 'no-whitespace';
	}

	?>

	<div class="<?php echo implode( ' ', $container_class ); ?>">

		<?php
		do_action( 'amely_main_container_top' );
		echo Amely_Templates::page_title();
		?>
