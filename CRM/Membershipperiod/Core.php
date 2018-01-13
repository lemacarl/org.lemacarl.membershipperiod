<?php
/**
* This class contains the core code that implements the new functionality
*
**/

class CRM_Membershipperiod_Core {
	// TODO Handle edit operation
	public function insertMembershipPeriod( $object ) {
		if( $object->contribution_recur_id ){
			$params = array(
				1 => array( $object->id, 'Integer' ),
				2 => array( $object->contribution_recur_id, 'Integer' ),
				3 => array( $object->start_date, 'Date' ),
				4 => array( $object->end_date, 'Date' ),		
			);
			CRM_Core_DAO::executeQuery( 'INSERT INTO civicrm_membershipperiod ( membership_id, contribution_id, start_date, end_date ) VALUES ( %1, %2, %3, %4 )', $params );
		}
		else{
			$params = array(
				1 => array( $object->id, 'Integer' ),
				2 => array( $object->start_date, 'Date' ),
				3 => array( $object->end_date, 'Date' ),		
			);
			CRM_Core_DAO::executeQuery( 'INSERT INTO civicrm_membershipperiod ( membership_id, start_date, end_date ) VALUES ( %1, %2, %3 )', $params );
		}

	}
}