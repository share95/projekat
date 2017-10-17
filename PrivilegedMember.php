<?php
	require_once 'Member.php';
	
	class PrivilegedMember extends Member{
		private $roles;
		
		public function __construct(){
			parent::__construct();
		}
		
		public static function getByUsername($username){
			$result = qM("SELECT * FROM `members` WHERE `user`='$username'");
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if(!empty($row)){
				$privMember = new PrivilegedMember();
				$privMember->id = $row['id'];
				$privMember->user = $row['user'];
				$privMember->initRoles($row['id']);
				return $privMember;
			}
			else {
				return false;
			}
		}
		
		protected function initRoles($user_id){
			$this->roles = array();
			$sql = "SELECT t1.role_id, t2.role_name
					FROM member_role AS t1
					LEFT JOIN roles AS t2
					ON t1.role_id = t2.id
					WHERE t1.member_id = $user_id";
			$result = qM($sql);
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$this->roles[$row['role_name']] = Role::getRolePerm($row['role_id']);
			}
		}
		
		public function hasPrivilege($perm_desc){
			foreach($this->roles as $role){
				if($role->hasPerm($perm_desc)){
					return true;
				}
			}
			return false;
		}
	}