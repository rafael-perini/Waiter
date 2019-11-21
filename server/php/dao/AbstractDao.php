<?php
	abstract class AbstractDao {

		private $baseString = "mongodb://127.0.0.1/";
		
		private $baseName = "waiterDB";
		
		private $collectionName;
		
		public $id;
		
		public function __construct($collectionName, $id = "") {
			$this->collectionName = $collectionName;
			$this->id = $id;
		}
		
		public function getCollection() {
			$client = new MongoDB\Client($this->baseString);
			
			$baseName = $this->baseName;
			$className = $this->collectionName;
	
			return $client->$baseName->$className;
		}
		
		public function save($abstractBean){
			$collection = $this->getCollection();
			
			$abstractBean = $this->getObjectToSave($abstractBean);
			
			if ($this->id == "") {
				$result = $collection->insertOne((array) $abstractBean);
				
				$this->id = $result->getInsertedId()->__toString();
			} else {
				$objectDao = $this->findById($this->id);
				
				$result = $collection->updateOne(["_id" => $objectDao->_id], ['$set' => (array) $abstractBean]);
			}
			
			return $this->getPretyObject($this->id);
		}
		
		public function delete($id) {
			$collection = $this->getCollection();
			
			$object = $this->findById($id);
			
			if (!is_null($object)) {
				$collection->deleteOne(["_id" => $object->_id]);
			}
			
			return true;
		}
		
		public function findById($id) {
			$id = $this->getObjectId($id);
			
			return $this->findOne("_id", $id);
		}
		
		public function getObjectId($id) {
			return new MongoDB\BSON\ObjectID($id);
		}
		
		public function find($key, $value) {
			$collection = $this->getCollection();
			
			$object = null;
			
			if (($value != "")&&(!is_null(($value)))) {
				try {
					$object = $collection->find([$key => $value]);
				} catch (InvalidArgumentException $ex) {
					throw new InvalidArgumentException("Filtro ($key) inválido!");
				}
			} else if ($value == "") {
				throw new InvalidArgumentException("Filtro não foi informado!");
			}
			
			if (is_null($object)) {
				throw new InvalidArgumentException("Informação não foi encontrada!");
			}
			
			return $object;
		}
		
		public function findOne($key, $value) {
			$collection = $this->getCollection();
			$object = null;
			
			if (($value != "")&&(!is_null(($value)))) {
				try {
					$object = $collection->findOne([$key => $value]);
				} catch (InvalidArgumentException $ex) {
					throw new InvalidArgumentException("Filtro ($key) inválido!");
				}
			} else if ($value == "") {
				throw new InvalidArgumentException("Filtro não foi informado!");
			}
			
			if (is_null($object)) {
				throw new InvalidArgumentException("Informação não foi encontrada!");
			}
			
			return $object;
		}
		
		abstract public function getPretyObject($id);
		
		abstract public function getObjectToSave($abstractBean);
		
	}
?>