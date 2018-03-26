<?php
class DB {
	private $adaptor;

	public function __construct($adaptor, $hostname, $username, $password, $database, $port = NULL) {
		$class = 'DB\\' . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($hostname, $username, $password, $database, $port);
		} else {
			throw new \Exception('Error: Could not load database adaptor ' . $adaptor . '!');
		}

        \ActiveRecord\Config::initialize(function($cfg) use ($hostname, $username, $password, $database, $port)
        {
            $cfg->set_model_directory(LOCAL_DIR_OPENCART.'/src/Entity');
            $cfg->set_connections(
                array(
                    'production' => 'mysql://'.$username.':'.$password.'@'.$hostname.'/'.$database
                )
            );
        });
	}

	public function query($sql, $params = array()) {
		return $this->adaptor->query($sql, $params);
	}

	public function escape($value) {
		return $this->adaptor->escape($value);
	}

	public function countAffected() {
		return $this->adaptor->countAffected();
	}

	public function getLastId() {
		return $this->adaptor->getLastId();
	}
	
	public function connected() {
		return $this->adaptor->connected();
	}
}