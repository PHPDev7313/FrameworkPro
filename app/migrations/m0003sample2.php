<?php

return new class
{
	public function up():void
	{
		// table create / modification code goes here

		echo get_class($this) . ' "up" method called' . PHP_EOL;
	}
	public function down(): void
	{
		// table drop / modification code goes here
		
		echo get_class($this) . ' "down" method called' . PHP_EOL;
	}

};


