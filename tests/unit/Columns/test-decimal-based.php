<?php
/**
 * Test the DECIMAL column.
 *
 * @author    Iron Bound Designs
 * @since     2.0
 * @license   MIT
 * @copyright Iron Bound Designs, 2016.
 */

namespace IronBound\DB\Tests\Unit\Columns;

use IronBound\DB\Table\Column\DecimalBased;

class Test_DecimalBased extends \IronBound\DB\Tests\TestCase {

	public function test_convert_raw_to_value_casts_to_float() {

		$column = new DecimalBased( 'DECIMAL', 'price' );
		$value  = $column->convert_raw_to_value( '5.50' );

		$this->assertInternalType( 'float', $value );
		$this->assertSame( 5.50, $value );
	}

	public function test_prepare_for_storage_passes_null_through() {

		$column = new DecimalBased( 'DECIMAL', 'price' );
		$this->assertNull( $column->prepare_for_storage( null ) );
	}

	/**
	 * @expectedException \IronBound\DB\Exception\InvalidDataForColumnException
	 */
	public function test_exception_thrown_if_non_scalar_value_given() {

		$column = new DecimalBased( 'DECIMAL', 'price' );
		$column->prepare_for_storage( new \stdClass() );
	}

	public function test_prepare_for_storage_casts_to_float() {

		$column = new DecimalBased( 'DECIMAL', 'price' );
		$value  = $column->prepare_for_storage( '5.50' );

		$this->assertInternalType( 'float', $value );
		$this->assertSame( 5.50, $value );
	}
}