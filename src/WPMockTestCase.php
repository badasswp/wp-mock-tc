<?php
/**
 * WPMockTestCase Class.
 *
 * Base class for defining popular WP functions
 * we intend to mock.
 *
 * @package WPMockTC
 */

namespace Badasswp\WPMockTC;

use WP_Mock;
use WP_Mock\Tools\TestCase;

class WPMockTestCase extends TestCase {
	/**
	 * Setup Method.
	 *
	 * Define basic WP mocks for test
	 * cases to inherit.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setUp(): void {
		WP_Mock::setUp();

		static::i18n();
		static::esc();
		static::esc_i18n();
	}

	/**
	 * TearDown Method.
	 *
	 * Clear all mocks in readiness for
	 * new mock definitions.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function tearDown(): void {
		WP_Mock::tearDown();
	}

	/**
	 * Internalization mocks.
	 *
	 * Define all i18n mocks here.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function i18n(): void {
		WP_Mock::userFunction( '__' )
			->andReturnUsing( fn( $arg ) => $arg );

		WP_Mock::userFunction( '_x' )
			->andReturnUsing( fn( $arg ) => $arg );

		WP_Mock::userFunction( '_e' )
			->andReturnUsing( function( $arg ) {
				echo $arg;
			} );

		WP_Mock::userFunction( '_n' )
			->andReturnUsing( function( $single, $plural, $number ) {
				return $number == 1 ? $single : $plural;
			} );
	}

	/**
	 * Escape mocks.
	 *
	 * Define all escape mocks here.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function esc(): void {
		$pass_through = fn( $arg ) => $arg;

		WP_Mock::userFunction( 'esc_html' )->andReturnUsing( $pass_through );
		WP_Mock::userFunction( 'esc_attr' )->andReturnUsing( $pass_through );
		WP_Mock::userFunction( 'esc_url' )->andReturnUsing( $pass_through );
	}

	/**
	 * Escape + i18n mocks.
	 *
	 * Define all esc_i18n mocks here.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function esc_i18n(): void {
		$pass_through = fn( $arg1, $arg2 ) => $arg1;

		WP_Mock::userFunction( 'esc_html__' )->andReturnUsing( $pass_through );
		WP_Mock::userFunction( 'esc_attr__' )->andReturnUsing( $pass_through );
		WP_Mock::userFunction( 'esc_html_e' )
			->andReturnUsing( function( $arg ) {
				echo $arg;
			} );
	}
}
