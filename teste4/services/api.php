<?php
 	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data = "";
		
		const DB_SERVER = "127.0.0.1";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "tarefas";

		private $db = NULL;
		private $mysqli = NULL;
		public function __construct(){
			parent::__construct();				
			$this->dbConnect();					
		}
		
		private function dbConnect(){
			$this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
		}
		
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);
		}
				
				
		// Listar Tarefas
				
		private function tarefas(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct c.id, c.titulo, c.descricao, c.prioridade FROM tarefas c order by c.prioridade asc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200);
			}
			$this->response('',204);
		}
		
		// Mostrar Tarefas
		
		private function tarefa(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){	
				$query="SELECT distinct c.id, c.titulo, c.descricao, c.prioridade FROM tarefas c where c.id=$id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();	
					$this->response($this->json($result), 200);
				}
			}
			$this->response('',204);	
		}
		
		// Incluir Tarefas
		
		private function insertTarefa(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$tarefa = json_decode(file_get_contents("php://input"),true);
			$column_names = array('titulo', 'descricao', 'prioridade');
			$keys = array_keys($tarefa);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ 
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $tarefa[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO tarefas(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($tarefa)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Tarefa Incluida com Sucesso.", "data" => $tarefa);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	
		}
		
		// Alterar Tarefas
		
		private function updateTarefa(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$tarefa = json_decode(file_get_contents("php://input"),true);
			$id = (int)$tarefa['id'];
			$column_names = array('titulo', 'descricao', 'prioridade');
			$keys = array_keys($tarefa['tarefa']);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ 
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $tarefa['tarefa'][$desired_key];
				}
				$columns = $columns.$desired_key."='".$$desired_key."',";
			}
			$query = "UPDATE tarefas SET ".trim($columns,',')." WHERE id=$id";
			if(!empty($tarefa)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Tarefa ".$id." Alterada com Sucesso.", "data" => $tarefa);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);
		}
		
		// Excluir Tarefas
		
		private function deleteTarefa(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){				
				$query="DELETE FROM tarefas WHERE id = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Tarefa Excluida com Sucesso.");
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	
		}
		
	
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	
	$api = new API;
	$api->processApi();
?>