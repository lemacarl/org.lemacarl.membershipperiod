<?php
/**
* This class contains the core code that implements the new functionality
*
**/

class CRM_Membershipperiod_Core {

	public function insertMembershipPeriod( $op, $object ) {
		if( 'create' == $op ) {
			$this->createNewMembershipPeriod( $object );
		}
		elseif( 'edit' == $op ) {
			$membership_id = $object->id;
			$result = CRM_Core_DAO::executeQuery( "SELECT count(*) FROM civicrm_membershipperiod WHERE membership_id = $membership_id" );
			if( $result ) {
				$this->editMembershipPeriod( $object );
			}
			else {
				$this->createNewMembershipPeriod( $object );
			}
		}
	}

	private function createNewMembershipPeriod( $object ) {
		if( $object->contribution_recur_id ){
			$params = array(
				1 => array( $object->id, 'Integer' ),
				2 => array( $object->contact_id, 'Integer' ),		
				3 => array( $object->start_date, 'Date' ),
				4 => array( $object->end_date, 'Date' ),
				5 => array( $object->contribution_recur_id, 'Integer' )
			);
			CRM_Core_DAO::executeQuery( 'INSERT INTO civicrm_membershipperiod ( membership_id, contact_id, start_date, end_date, contribution_id ) VALUES ( %1, %2, %3, %4, %5 )', $params );
		}
		else{
			$params = array(
				1 => array( $object->id, 'Integer' ),
				2 => array( $object->contact_id, 'Integer' ),		
				3 => array( $object->start_date, 'Date' ),
				4 => array( $object->end_date, 'Date' ),		
			);
			CRM_Core_DAO::executeQuery( 'INSERT INTO civicrm_membershipperiod ( membership_id, contact_id, start_date, end_date ) VALUES ( %1, %2, %3, %4 )', $params );
		}
	}

	private function editMembershipPeriod( $object ) {
		CRM_Core_DAO::executeQuery( "UPDATE civicrm_membershipperiod SET start_date = {$object->start_date}, end_date = {$object->end_date}" . $object->contribution_recur_id ? ", contribution_id = {$object->contribution_recur_id}" : "" . " WHERE membership_id = {$object->id}" );
	}
}