<?php
class Usuario {
    public $id;
    public $nombre;
    public $email;

    public function __construct($id, $nombre, $email) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
    }

    public function __toString() {
        return "ID: {$this->id}, Nombre: {$this->nombre}, Email: {$this->email}";
    }
}
