<?php
/**
 * Contains the class for the ForeignModel column type.
 *
 * @author    Iron Bound Designs
 * @since     2.0
 * @license   MIT
 * @copyright Iron Bound Designs, 2016.
 */

namespace IronBound\DB\Table\Column;

use IronBound\DB\Model;
use IronBound\DB\Saver\ModelSaver;
use IronBound\DB\Table\Column\Contracts\Savable;
use IronBound\DB\Table\Table;

/**
 * Class ForeignModel
 * @package IronBound\DB\Table\Column
 */
class ForeignModel extends BaseColumn implements Savable {

	/**
	 * @var Table
	 */
	protected $foreign_table;

	/**
	 * @var string
	 */
	protected $model_class;

	/**
	 * @var ModelSaver
	 */
	private $saver;

	/**
	 * ForeignModel constructor.
	 *
	 * @param string     $name          Column name.
	 * @param string     $model_class   FQCN for the model.
	 * @param Table      $foreign_table Table the foreign key resides in.
	 * @param ModelSaver $saver
	 */
	public function __construct( $name, $model_class, Table $foreign_table, ModelSaver $saver ) {
		parent::__construct( $name );

		$this->foreign_table = $foreign_table;
		$this->model_class   = $model_class;
		$this->saver         = $saver;

		$this->saver->set_model_class( $model_class );
	}

	/**
	 * Get the referenced column.
	 *
	 * @since 2.0
	 *
	 * @return BaseColumn
	 */
	protected function get_column() {

		$column  = $this->foreign_table->get_primary_key();
		$columns = $this->foreign_table->get_columns();

		return $columns[ $column ];
	}

	/**
	 * @inheritDoc
	 */
	public function get_definition() {
		return "{$this->name} {$this->get_column()->get_definition_without_column_name( array( 'auto_increment' ) )}";
	}

	/**
	 * @inheritDoc
	 */
	public function get_mysql_type() {
		return $this->get_column()->get_mysql_type();
	}

	/**
	 * @inheritDoc
	 */
	public function convert_raw_to_value( $raw, \stdClass $row = null ) {
		return call_user_func( array( $this->model_class, 'get' ), $raw );
	}

	/**
	 * @inheritDoc
	 */
	public function prepare_for_storage( $value ) {

		if ( $value instanceof $this->model_class ) {
			return $value->get_pk();
		}

		return $this->get_column()->prepare_for_storage( $value );
	}

	/**
	 * @inheritDoc
	 */
	public function save( $value ) {
		return $this->saver->save( $value );
	}
}