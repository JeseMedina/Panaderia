<?php 
class Vehiculo{
	protected $gasolina = 100;
	}

class Nissan extends Vehiculo{
	public function avanzar(){
	echo "Ahora el Nissan tiene".$this->gasolina -= 20;		
	}
}

class Suzuki extends Vehiculo{
	public function avanzar(){
	echo "Ahora el Suzuki tiene".$this->gasolina -= 8;		
	}
}

class Honda extends Vehiculo{
	public function avanzar(){
	echo "Ahora el Honda tiene".$this->gasolina -= 15;		
	}
}

class Usuario {
	private $vehiculo;
	public function __construct($objeto){
		$this->Vehiculo = $objeto;	
	}

	public function avanzarVehiculo(){
		$this->Vehiculo->avanzar();	
	}
	
}
?>