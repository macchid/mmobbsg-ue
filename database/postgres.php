<?php

	class db {
		public static $connection;

		private static $host;
		private static $port;
		private static $dbname;
		private static $username;
		private static $password;

		private static function connect() {
			self::$connection = @pg_connect("host=".self::$host." port=".self::$port." dbname=".self::$dbname." user=".self::$username." password=".self::$password);

		    if (self::$connection === FALSE) {
		        throw(new DatabaseException("Can't connect to database server."));
		    }
		}
	   
		public static function init($host, $port, $dbname, $username, $password)
		{
			self::$host = $host;
			self::$port = $port;
			self::$dbname = $dbname;
			self::$username = $username;
			self::$password = $password;
		}

		private static function exec($sql)
		{
			if (!isset(self::$connection)){
				self::connect();
			}

			if (!isset(self::$connection)) {
		        self::connect();
		    }
		   
		    $result = @pg_query(self::$connection, $sql);
		    if ($result === FALSE) {
		        $error = pg_last_error(self::$connection);
		        throw(new DatabaseException($error.':'.$sql));
		    }

			return $result;		   
		}

		# Throws exceptions for pg_errors, no_data_found (0 rows retrieved), 
		# and too_many_rows (number of rows > $maxRowsExpected)
		public static function select($sql, $maxRowsExpected = null) 
		{
			if (stripos($sql, 'select') === false)
				return array();

			$result = self::exec($sql);

			if (@pg_num_rows($result) === 0)
					throw(new NoDataFoundException($sql));
			else if ( isset($maxRowsExpected) && @pg_num_rows($result) > $maxRowsExpected )
					throw(new TooManyRowsException($sql));

		    $out = array();
		    while ( ($d = pg_fetch_assoc($result)) !== FALSE) {
		        $out[] = $d;
		    }

		    return $out;
		}

		# 
		public static function insert($sql)
		{
			if (stripos($sql, 'insert') === false)
				return 0;

			return @pg_rows_affected(self::exec($sql));
		}

		# 
		public static function update($sql)
		{
			if (stripos($sql, 'update') === false)
				return 0;

			return @pg_rows_affected(self::exec($sql));
		}

		# 
		public static function delete($sql)
		{
			if (stripos($sql, 'delete') === false)
				return 0;

			return @pg_rows_affected(self::exec($sql));
		}

		#	
		public static function escape_string($string)
		{
			return pg_escape_string($string);
		}

	} db::init($host, $port, $dbname, $username, $password);

?>

