<?php
namespace Devture\Component\DBAL\IdGenerator;

use Devture\Component\DBAL\Repository\BaseMongoRepository;
use Devture\Component\DBAL\Model\BaseModel;
use Doctrine\MongoDB\Database;

class IncrementGenerator implements GeneratorInterface {

	private $db;
	private $purpose;
	private $trackerCollection;

	public function __construct(Database $db, $purpose, $trackerCollection = 'devture_dbal_increment_ids') {
		$this->db = $db;
		$this->purpose = $purpose;
		$this->trackerCollection = $trackerCollection;
	}

	public function generate(BaseModel $entity) {
		$find = array('_id' => $this->purpose);
		$update = array('$inc' => array('current_id' => 1));
		$options = array('upsert' => true, 'new' => true);

		$collection = $this->db->selectCollection($this->trackerCollection);
		$result = $collection->findAndUpdate($find, $update, $options);
		return $result['current_id'];
	}

}
