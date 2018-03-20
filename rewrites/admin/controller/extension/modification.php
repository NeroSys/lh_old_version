<?php

class ControllerExtensionModification extends Controller {
	private $error = array();

	public function index() {
		$this->thisFunctionalHasBeenDisabled();
	}

	public function delete() {
        $this->thisFunctionalHasBeenDisabled();
	}

	public function refresh() {
        $this->thisFunctionalHasBeenDisabled();
	}

	public function clear() {
        $this->thisFunctionalHasBeenDisabled();
	}

	public function enable() {
        $this->thisFunctionalHasBeenDisabled();
	}

	public function disable() {
        $this->thisFunctionalHasBeenDisabled();
	}

	public function clearlog() {
        $this->thisFunctionalHasBeenDisabled();
	}

	protected function getList() {
        $this->thisFunctionalHasBeenDisabled();
	}

	protected function thisFunctionalHasBeenDisabled(){
	    throw new \Exception("Мы отключили этот функционал из этический сображений. Не включайте его чтобы текущая система не сломалась. Вы можете перезаписывать все что вам нужно в папке rewrites вручную");
    }
}
