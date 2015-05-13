<?php
namespace library;

class csv_create{
    private $url_folder='';
    private $name_file='subscribers';
    private $datalist = array();
    private $columns = array();
    public function __construct($data){
        $this->url_folder = $data['url_folder'];
        $this->datalist   = $data['list'];
        $this->columns    = $data['columns'];
    }
    
    public function download(){
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$this->name_file);
        $this->create();
    }
    
    public function create(){
        /*$list = array (
            array('aaa', 'bbb', 'ccc', 'dddd'),
            array('123', '456', '789',''),
            array('"aaa"', '"bbb"')
        );*/
        $list = $this->datalist;
        
        //open the output file for writing
        $fp = fopen('php://output', 'w');
        
        //fputcsv($fp, array('Column 1', 'Column 2', 'Column 3','Column 4'));
        fputcsv($fp, $this->columns);
        //write to the csv file (comma separated, double quote enclosed)
        foreach ($list as $fields) {
            fputcsv($fp, $fields);//,',','"'
        }
        //close the file
        fclose($fp);
    }
    
    public function read(){
        
    }
    
    public function delete(){
        
    }
}

