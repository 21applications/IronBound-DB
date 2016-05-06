<?php
/**
 * TableWithAllForeign
 *
 * @author    Iron Bound Designs
 * @since     2.0
 * @license   MIT
 * @copyright Iron Bound Designs, 2016.
 */

namespace IronBound\DB\Tests\Stub\Tables;

use IronBound\DB\Saver\CommentSaver;
use IronBound\DB\Saver\ModelSaver;
use IronBound\DB\Saver\TermSaver;
use IronBound\DB\Saver\UserSaver;
use IronBound\DB\Table\BaseTable;
use IronBound\DB\Table\Column\ForeignComment;
use IronBound\DB\Table\Column\ForeignModel;
use IronBound\DB\Table\Column\ForeignPost;
use IronBound\DB\Table\Column\ForeignTerm;
use IronBound\DB\Table\Column\ForeignUser;
use IronBound\DB\Table\Column\IntegerBased;
use IronBound\DB\Tests\Stub\Models\Book;
use IronBound\DB\Saver\PostSaver;

/**
 * Class TableWithAllForeign
 * @package IronBound\DB\Tests\Stub\Tables
 */
class TableWithAllForeign extends BaseTable {

	/**
	 * @inheritDoc
	 */
	public function get_table_name( \wpdb $wpdb ) {
		return "{$wpdb->prefix}with_all_foreign";
	}

	/**
	 * @inheritDoc
	 */
	public function get_slug() {
		return 'with-all-foreign';
	}

	/**
	 * @inheritDoc
	 */
	public function get_columns() {
		return array(
			'id'      => new IntegerBased( 'BIGINT', 'id', array( 'unsigned', 'auto_increment' ), array( 20 ) ),
			'post'    => new ForeignPost( 'post', new PostSaver() ),
			'user'    => new ForeignUser( 'user', new UserSaver() ),
			'term'    => new ForeignTerm( 'term', new TermSaver() ),
			'comment' => new ForeignComment( 'comment', new CommentSaver() ),
			'model'   => new ForeignModel( 'model', get_class( new Book() ), new Books(), new ModelSaver() )
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_column_defaults() {
		return array(
			'id'      => 0,
			'post'    => 0,
			'user'    => 0,
			'term'    => 0,
			'comment' => 0,
			'model'   => 0
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_primary_key() {
		return 'id';
	}

	/**
	 * @inheritDoc
	 */
	public function get_version() {
		return 1;
	}
}