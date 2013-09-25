<?php

class Profiler {
	private $timers = [];

	private $results = [];

	private $enabled = true;

	// separator between values in toString method
	// <br /> for Web
	//   \n   for console app
	private $separator = '';

	public function __construct( $separator = "\n", $enabled = true ) {
		$this->separator = $separator;
		$this->enabled   = $enabled;
	}

	public function run( $name ) {
		if( $this->enabled ) {
			$this->timers[ $name ] = microtime(true);
		}
	}

	public function disable() {
		$this->enabled = false;
	}

	public function enable() {
		$this->enabled = true;
	}

	public function stop( $name ) {
		if( $this->enabled ) {

			$end = microtime(true) - $this->timers[ $name ];

			$result = isset($this->results[ $name ]) ? $this->results[ $name ] : [];

			if( !isset($result[ 'count' ]) ) {
				$result[ 'max' ] = $end;
				$result[ 'min' ] = $end;
				$result[ 'sum' ] = 0;
				$result[ 'count' ] = 0;
			}
			else {
				$result[ 'max' ] = max($result[ 'max' ], $end);
				$result[ 'min' ] = min($result[ 'min' ], $end);
			}

			++$result[ 'count' ];
			$result[ 'sum' ] += $end;

			$result[ 'avg' ] = $result[ 'sum' ] / $result['count'];

			$result[ 'items' ][] = $end;

			$this->results[ $name ] = $result;

			return $end;
		}
	}

	public function toString(  ) {
		$string = '';

		if( $this->enabled ) {
			foreach ($this->results as $key => $results) {
				foreach ($results AS $index => $value) {
					$string .= "$key\[$index\]: $value " . $this->separator;
				}
			}
		}

		return $string;
	}

	public function toArray() {
		return $this->enabled ? $this->results : null;
	}

	public function get( $name ) {
		return $this->enabled ? $this->results[ $name ] : null;
	}
}

?>