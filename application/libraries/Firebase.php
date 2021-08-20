<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 

require_once './vendor/autoload.php';
 
use Google\Cloud\Firestore\FirestoreClient;

class Firebase {
 

	/**
	 * @var CI_Controller
	 */
	private $CI;

	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance(); 
	}


		
	/**
	 * db()
	 * 
	 * Retourne la connexion à 
	 * la base de données Cloud Firestore Client
	 *
	 * @return void
	 */
	private function db() : FirestoreClient
	{
		# Create the Cloud Firestore client
		$db = new FirestoreClient([
			'projectId' => 'dim-crowfounding-backend',
			'keyFile' => json_decode(file_get_contents(__DIR__ . '/../config/dim-crowfounding-backend-firebase-adminsdk-l2795-974cce6f00.json'), true)
		]);

		return $db;
	}


	public function get_all()
	{
		
		# [START fs_get_all]
		$projectsRef = $this->db()->collection('users'); 
		$snapshot = $projectsRef->documents();

		foreach ($snapshot as $user) {
			
			if ($user->exists()) {
				echo '<pre>';
				printf('Document data for document %s:' . PHP_EOL, $user->id());
				print_r($user->data());
				printf(PHP_EOL);
				echo '</pre>';

			} else {
				printf('Document %s does not exist!' . PHP_EOL, $snapshot->id());
			}
			// printf('User: %s' . PHP_EOL, $user->name());
			// echo '<br>';
			// printf('First: %s' . PHP_EOL, $user['first']);
			// if (!empty($user['middle'])) {
			// 	printf('Middle: %s' . PHP_EOL, $user['middle']);
			// }
			// printf('Last: %s' . PHP_EOL, $user['last']);
			// printf('Born: %d' . PHP_EOL, $user['born']);
			// printf(PHP_EOL);
		}
		printf('Retrieved and printed out all documents from the users collection.' . PHP_EOL);
		# [END fs_get_all]
	}


	
	/**
	 * get(string $collection)
	 *
	 * Retourne une collection
	 * de la base de données Firestore
	 * 
	 * @param string $collection
	 * @return void
	 */
	public function get(string $collection)
	{
		$docRef = $this->db()->collection($collection);
		return $docRef->documents();
	}



	/**
	 * add(array $data, string $collection)
	 *
	 * Ajoute une donnée à une collection Firestore
	 * 
	 * @param array $data
	 * @param string $collection
	 * @return void
	 */
	public function add(array $data, string $collection)
	{
		$this->db()->collection($collection)->add($data);
		echo 'Added';
	}

	/**
	 * delete(string $ID, string $collection)
	 *
	 * Supprime une donnée d'une collection Firestore
	 * 
	 * @param string $ID
	 * @param string $collection
	 * @return void
	 */
	public function delete(string $ID, string $collection)
	{
		$this->db()->collection($collection)->document($ID)->delete();
		echo 'Delete';
	}

	/**
	 * update(string $ID, array $data, string $collection)
	 *
	 * Mise à jour des données d'un champs à la clé $ID
	 * 
	 * @param string $ID
	 * @param array $data
	 * @param string $collection
	 * @return void
	 */
	public function update(array $data, string $collection)
	{
		
	}
}
