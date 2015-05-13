<?php
namespace library;

class cssfile{
    const WRITE = 'w';
    const READ  = 'r';
    const WINDOWS = 'b';
    
    public function __construct(){
        
    }
    
    public function action(){
        
    }
    
    
    public function read_cssfile($archivo){
        
        if(!$fp = @fopen($archivo, self::READ.self::WINDOWS)){
            throw new \Exception("no can read file #1 ($archivo)");
        }
        $content = fread($fp, filesize($archivo));
        if($content === false){
            throw new \Exception("no can read file #2 ($archivo)");
        }
        fclose($fp);
        return $content;
    }
    
    public function write_cssfile($archivo,$data){

        if (!$fp = @fopen($archivo, self::WRITE)) {
             //echo "No se puede abrir el archivo ($archivo)";
             throw new \Exception("no can open file ($archivo)");
        }
        if(fwrite($fp, $data) === false){
            throw new \Exception("no can open file ($archivo)");
        }
        fclose($fp);
    }
    
    public function create_cssfile(){
        
    }
    
    public function delete_cssfile(){
        
    }
    
}