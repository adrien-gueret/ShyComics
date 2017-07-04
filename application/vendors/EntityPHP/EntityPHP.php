<?php

namespace EntityPHP;

require_once 'Entity.php';
require_once 'EntityArray.php';
require_once 'EntityRequest.php';

abstract class Core
{
	const	UNDEFINED			=	'_EntityPHP_undefined_',
			TYPE_STRING			=	'string',
			TYPE_INTEGER		=	'integer',
			TYPE_FLOAT			=	'float',
			TYPE_BOOLEAN		=	'boolean',
			TYPE_DATETIME		=	'datetime',
			TYPE_TIMESTAMP		=	'timestamp',
			TYPE_DATE			=	'date',
			TYPE_TIME			=	'time',
			TYPE_YEAR			=	'year',
			TYPE_CLASS			=	'class',
			TYPE_ARRAY			=	'array',
			TYPE_ASSOC_ARRAY		=	'associative_array';

	protected static $all_dbs			=	array();
	public static $current_db			=	null;
	public static $current_db_is_utf8	=	false;

	/**
	 * Create a connection to the database
	 * @static
	 * @access public
	 * @param string $host Host of database
	 * @param string $user Username for connection
	 * @param string $password Password for connection
	 * @param string $database Database you want to connect to
	 * @param bool $utf8 Do we have to use UTF-8 encoding ?
	 */
	final public static function connectToDB($host, $user, $password, $database, $utf8 = true)
	{
		//TODO: make this connection more customisable and allow other drivers and not only MySQL
		$newDb	=	new \PDO('mysql:host='.$host.';dbname='.$database, $user, $password);

		if($utf8)
			$newDb->exec('SET NAMES UTF8');

		self::$all_dbs[$database]	=	array('db' => $newDb, 'utf8' => $utf8);
		self::switchToDB($database);
	}

	/**
	 * Switch database to use
	 * @static
	 * @access public
	 * @param string $database Database you want use
	 * @throws \Exception
	 */
	final public static function switchToDB($database)
	{
		if(isset(self::$all_dbs[$database]))
		{
			self::$current_db			=	self::$all_dbs[$database]['db'];
			self::$current_db_is_utf8	=	self::$all_dbs[$database]['utf8'];
		}
		else
			throw new \Exception('Try to switch to non-connected database "'.$database.'".');
	}

	/**
	 * Get the classes inherited from Entity
	 * @static
	 * @access public
	 * @return array An array of classes as strings
	 */
	final public static function getEntities()
	{
		$entities           =   array();
		$classDependencies  =   array();

		foreach(get_declared_classes() as $class)
			if(is_subclass_of($class,'EntityPHP\Entity'))
			{
				$classDependencies[$class] = $class::getDependencies();
			}

		$nbOfClasses    =   count($classDependencies);
		$maxIterations  =   $nbOfClasses * $nbOfClasses;
		$iteration      =   0;

		// Try to order entities according to their dependencies
		while(count($entities) < $nbOfClasses)
		{
			$iteration++;

			// We failed to find a correct order, give up
			if($iteration > $maxIterations)
			{
				// Try and find circular dependencies
				$circularDependencies = array();

				foreach($classDependencies as $class => $dependencies)
				{
					// Already added, can't be the cause
					if(in_array($class, $entities))
						continue;

					// Check each dependency of the current class to see if it has the current class as a dependency
					foreach($dependencies as $dependency)
					{
						if(in_array($class, $classDependencies[$dependency]))
						{
							$circularDependencies[] = $class . ' -> ' . $dependency;
						}
					}
				}

				throw new \Exception('Failed to establish dependencies list. The following circular dependencies were found: ' . implode(' & ', $circularDependencies));
			}

			foreach($classDependencies as $class => $dependencies)
			{
				// Entity was already added
				if(in_array($class, $entities))
					continue;

				// No dependencies
				if(count($dependencies) === 0)
				{
					$entities[] = $class;
					continue;
				}

				// Check if all dependencies are fulfilled
				$fulfilled = true;
				foreach($dependencies as $dependency)
				{
					if( ! in_array($dependency, $entities))
						$fulfilled = false;
				}

				if($fulfilled)
				{
					$entities[] = $class;
				}
			}
		}

		return $entities;
	}

	/**
	 * Return the PHP type corresponding to given SQL type
	 * @static
	 * @access public
	 * @param string $sqlType SQL type to check
	 * @return array An array of classes as strings
	 */
	final public static function getPHPType($sqlType)
	{
		if(is_array($sqlType))
		{
			// Check if it's an associative array
			if(empty($sqlType) || is_int(key($sqlType)))
				return self::TYPE_ARRAY;
			else
				return self::TYPE_ASSOC_ARRAY;
		}

		if((class_exists($sqlType) || class_exists('\\'.$sqlType)) && is_subclass_of($sqlType, 'EntityPHP\Entity'))
			return self::TYPE_CLASS;

		$sqlType	=	strtoupper($sqlType);

		if(preg_match('/CHAR|TEXT|ENUM|SET/', $sqlType))
			return self::TYPE_STRING;

		if(preg_match('/INT/', $sqlType))
			return self::TYPE_INTEGER;

		if(preg_match('/DECIMAL|FLOAT|DOUBLE|REAL/', $sqlType))
			return self::TYPE_FLOAT;

		if(preg_match('/BOOLEAN/', $sqlType))
			return self::TYPE_BOOLEAN;

		if(preg_match('/DATETIME/', $sqlType))
			return self::TYPE_DATETIME;

		if(preg_match('/TIMESTAMP/', $sqlType))
			return self::TYPE_TIMESTAMP;

		if(preg_match('/DATE/', $sqlType))
			return self::TYPE_DATE;

		if(preg_match('/TIME/', $sqlType))
			return self::TYPE_TIME;

		if(preg_match('/YEAR/', $sqlType))
			return self::TYPE_YEAR;

		return null;
	}

	/**
	 * Return the value after making it suitable to the correct SQL type
	 * @static
	 * @access public
	 * @param string $type The PHP type of the value to convert
	 * @param string $value The value to convert
	 * @return string The converted value
	 */
	final public static function convertValueForSql($type, $value)
	{
		switch($type)
		{
			case Core::TYPE_INTEGER:
				return intval($value);

			case Core::TYPE_FLOAT:
				return floatval($value);
				break;

			case Core::TYPE_BOOLEAN:
				return $value ? 1 : 0;

			case Core::TYPE_STRING:
				$temp			=	htmlspecialchars_decode($value, ENT_QUOTES);
				$temp			=	htmlspecialchars($temp, ENT_QUOTES, Core::$current_db_is_utf8 ? 'UTF-8' : 'ISO-8859-1');
				return '"'.$temp.'"';

			case Core::TYPE_DATE:
			case Core::TYPE_TIME:
			case Core::TYPE_DATETIME:
			case Core::TYPE_TIMESTAMP:
			case Core::TYPE_YEAR:
				$format			=	null;

				if(empty($value)) {
					return 'NULL';
				}

				switch($type)
				{
					case Core::TYPE_TIME:		$format	=	'H:i:s'; break;
					case Core::TYPE_DATETIME:	$format	=	'Y-m-d H:i:s'; break;
					case Core::TYPE_TIMESTAMP:	$format	=	'YmdHis'; break;
					case Core::TYPE_YEAR:		$format	=	'Y'; break;
					case Core::TYPE_DATE:		$format	=	'Y-m-d'; break;
				}

				return	'"'.(is_numeric($value)
						? @date($format, $value)
						: (
						$value instanceof \DateTime
							? $value->format($format)
							: $value
						)).'"';

			default:
				return $value;
		}
	}

	/**
	 * Create the database according to your Entities classes definition
	 * @static
	 * @access public
	 * @throws \Exception
	 */
	public static function generateDatabase()
	{
		$entities	=	self::getEntities();
		$query		=	self::$current_db->query('SHOW TABLES');
		$tables		=	array();

		while($table = $query->fetch(\PDO::FETCH_NUM))
			$tables[]	=	strtolower($table[0]);

		foreach($entities as $entity)
		{
			if( ! in_array(strtolower($entity::getTableName()), $tables))
				$entity::createTable();
			else
				$entity::updateTable();
		}
	}

	/**
	 * Return the SQL request for creating a junction table
	 * @static
	 * @access public
	 * @param string $tableName Name of the first table
	 * @param string $refTableName Name of the second table
	 * @param string $idName Name of the ID field for the first table
	 * @param string $refIdName Name of the ID field for the second table
	 * @param string $field Name of the field in the model representing the junction
	 * @param array $supplementaryFields Optional, creates a junction table with properties
	 * @return string The SQL request
	 */
	final public static function generateRequestForForeignFields($tableName, $refTableName, $idName, $refIdName, $field, $supplementaryFields = array())
	{
		// Check if we need to add supplementary fields
		$supplementaryFieldsSql = "";

		if( ! empty($supplementaryFields) )
		{
			foreach($supplementaryFields as $field_name => $sql_type)
			{
				$php_type		=	Core::getPHPType($sql_type);
				$supplementaryFieldsSql	.=	$field_name.' '.$sql_type.', ';
			}
		}

		$request	=	'CREATE TABLE '.$tableName.'2'.$field.' (id_'.$tableName.' INT(11) UNSIGNED NOT NULL,';
		$request	.=	'id_'.$field.' INT(11) UNSIGNED NOT NULL, '.$supplementaryFieldsSql;
		$request	.=	'CONSTRAINT FOREIGN KEY fk_'.$tableName.'2'.$field;
		$request	.=	'_'.$tableName.'$'.$tableName.'2'.$refTableName.' (id_'.$tableName.')  REFERENCES '.$tableName;
		$request	.=	'('.$idName.') ON DELETE CASCADE, CONSTRAINT FOREIGN KEY fk_'.$tableName.'2'.$field.'_'.$field.'$';
		$request	.=	$tableName.'2'.$refTableName.' (id_'.$field.') REFERENCES '.$refTableName.'('.$refIdName.') ON DELETE CASCADE) ';
		$request	.=	(self::$current_db_is_utf8 ? 'DEFAULT CHARSET=utf8 ' : '').'ENGINE=InnoDB';

		return $request;
	}

}