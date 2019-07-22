<?php



class RetaildetailsModel extends CommonModel{
    protected $pk   = 'retail_id';
    protected $tableName =  'retail_details';
    
    
    public function  getDetail($retail_id){
        $data= $this->find($retail_id);
        if(empty($data)){
            $data = array(
                'retail_id' => $retail_id,
            );
            $this->add($data);
        }
        return $data;
    }
}