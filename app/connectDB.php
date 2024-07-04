<?php
class connectDB {
    protected $conex;
    private $usuario;
    private $password;
    private $local;
    private $nameDB;

    public function __construct(){
        $this->usuario = 'root';
        $this->password = '';
        $this->local = 'localhost';
        $this->nameDB = 'sistema_ventas';
        $this->conectarDB();
    }

    protected function conectarDB(){
        try{
            $this->conex = new PDO("mysql:host={$this->local};dbname={$this->nameDB}", $this->usuario , $this->password);
            $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function getConnection() {
        return $this->conex;
    }
}
?>
