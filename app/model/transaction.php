<?php 
    class transaction extends Database{

        private $table = 'transaction';

        function listTransaction( $id ){
            $data = null;
            $sql = "SELECT * FROM $this->table WHERE id_head = '$id' OR id_tail = '$id' ORDER BY id DESC";
            $result = $this->conn->query( $sql );
            
            if( $result ) {
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                $sql = "SELECT id , `name` FROM `user` ";
                $result1 = $this->conn->query( $sql );
                if( $result1 ){
                    $data1 = $result1->fetchAll(PDO::FETCH_ASSOC);
                }

                foreach( $data as $key => $value ){
                    $name_head = $this->search( $value['id_head'] , $data1 );
                    $name_tail = $this->search( $value['id_tail'] , $data1 );
                    $data[$key]['id_head'] = $name_head;
                    $data[$key]['id_tail'] = $name_tail;
                }
            }
            return $data;
        }
        private function search( $id , $array ){
            foreach( $array as $key => $value ){
                if( $id == $value['id']){
                    return $value['name'];
                }
            }
            return '';
        }

        // function add( $id_feed , $content = '' ){
        //     $date = date('Y-m-d H:i:s');
        //     $sql = "INSERT INTO $this->table (id_feedName , date , content ) VALUES( '$id_feed' , '$date'  , '$content' ) ";
        //     $result = $this->conn->query( $sql );
        //     if( $result ){
        //         return true;
        //     }
        //     return false;
        // }
    }
?>