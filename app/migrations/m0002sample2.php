<?php

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;

return new class
{
	public function up(Schema $schema):void
	{
		$table = $schema->createTable('users');
		$table->addColumn('user_id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
		$table->addColumn('fname', Types::STRING, ['length' => 30]);
		$table->addColumn('lname', Types::STRING, ['length' => 30]);
		$table->addColumn('email', Types::STRING, ['length' => 50]);
		$table->addColumn('password', Types::STRING, ['length' => 255]);
		
		// table create / modification code goes here

		echo get_class($this) . ' "up" method called' . PHP_EOL;
	}
	public function down(): void
	{
		// table drop / modification code goes here
		
		echo get_class($this) . ' "down" method called' . PHP_EOL;
	}

};


