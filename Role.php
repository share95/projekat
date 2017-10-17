<?php
	class Role{
	    const ADMIN = 1;
	    const USER = 2;
	    const MANAGER = 3;
		protected $permissions;
		
		//konstruktor
		public function __construct(){ 
			$this->permissions = array();
		}
		/* konstruktor sa jednim parametrom
		public function  __construct($perm_desc){
			if (!isset($this->permissions($perm_desc))){
				$this->permissions($perm_desc) = true;
			}
		}*/
		
		//destruktor
		public function __destruct(){
			
		}
		

		public function __toString(){
			$result = "";
			foreach ($this->permissions as $perm){
				$result .= key($perm)."<br>";
			}
			return $result;
		}
		
		
		
		public static function getRolePerm($role_id){
			$role = new Role(); //instaciranje objekta klase role
			//$role = new Role('Run SQL'); poziva konstruktor sa jednim parametrom
			$sql = "SELECT t2.perm_desc FROM role_perm AS t1 
					LEFT JOIN permissions AS t2 
					ON t1.perm_id = t2.id
					WHERE t1.role_id = $role_id";
			$result = qM($sql);
			while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
				$role->permissions[$row['perm_desc']] = true; 
			}
			return $role;
		}
		
		//check if permission is set
		public function hasPerm($perm_desc){
			return isset($this->permissions[$perm_desc]);
		}
	}
?>