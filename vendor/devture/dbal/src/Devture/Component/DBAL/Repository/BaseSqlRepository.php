<?php
namespace Devture\Component\DBAL\Repository;

use Doctrine\DBAL\Connection;
use Devture\Component\DBAL\Model\BaseModel;
use Devture\Component\DBAL\Exception\NotFound;

abstract class BaseSqlRepository extends BaseRepository {

	protected $db;

	abstract protected function getTableName();

	public function __construct(Connection $db) {
		$this->db = $db;
	}

	public function find($id) {
		$stringId = (string) $id;
		if (isset($this->models[$stringId])) {
			return $this->models[$stringId];
		}

		return $this->findOneByQuery("SELECT * FROM " . $this->getTableName() . " WHERE _id = ? LIMIT 1", array($id));
	}

	public function findAll() {
		return $this->findAllByQuery("SELECT * FROM " . $this->getTableName());
	}

	/**
	 * @param string $query
	 * @param array $params
	 * @return BaseModel
	 * @throws NotFound
	 */
	public function findOneByQuery($query, array $params = array()) {
		$data = $this->db->fetchAssoc($query, $params);
		if ($data === false) {
			throw new NotFound('Missing object of class ' . $this->getModelClass() . ' for: `' . $query . '` with: ' . json_encode($params));
		}
		return $this->loadModel($data);
	}

	public function findAllByQuery($query, array $params = array()) {
		$results = array();
		foreach ($this->db->fetchAll($query, $params) as $data) {
			$results[] = $this->loadModel($data);
		}
		return $results;
	}

	public function add($entity) {
		$this->validateModelClass($entity);

		$hasIdBeforeInsert = ($entity->getId() !== null);

		$this->db->insert($this->getTableName(), $this->exportModel($entity));

		if ($this->db->errorCode() == 0) {
			if (!$hasIdBeforeInsert) {
				//Relying on auto-increment from the database
				$entity->setId($this->db->lastInsertId());
			}
			return;
		}

		throw new \RuntimeException('Could not perform insert');
	}

	public function update($entity) {
		$this->validateModelClass($entity);
		if ($entity->getId() === null) {
			throw new \LogicException('Cannot update a non-identifiable object.');
		}
		$this->db->update($this->getTableName(), $this->exportModel($entity), array('_id' => $entity->getId()));
	}

	public function delete($entity) {
		$this->validateModelClass($entity);
		if ($entity->getId() === null) {
			throw new \LogicException('Cannot delete a non-identifiable object.');
		}
		$this->db->delete($this->getTableName(), array('_id' => $entity->getId()));
		unset($this->models[(string) $entity->getId()]);
		$entity->setId(null);
	}

}
